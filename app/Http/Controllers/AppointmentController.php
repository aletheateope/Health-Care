<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientHmo;
use App\Models\Insurance;
use App\Models\PatientInsurance;

class AppointmentController extends Controller
{
    public function getAvailableTimes(Request $request)
    {

        $validated=$request->validate([
            'date' => 'required|date',
            'service_id' => 'required|integer|exists:services,id',
            'hmo_id' => 'nullable|integer',
        ]);

        $date = Carbon::parse($validated['date'])
            ->setTimezone('Asia/Manila')
            ->format('Y-m-d');
        $service_id = $validated['service_id'];
        $hmo_id = $validated['hmo_id'];
        $dayOfWeek = strtolower(Carbon::parse($date)->setTimezone('Asia/Manila')->format('l'));

        // Services that do not require doctors
        $nonDoctorServices = [2,3,4,5,6,7,8,9,10,11];
        if (in_array($service_id, $nonDoctorServices)) {
            return response()->json([]);
        }

        // Map service to specialty
        $serviceToSpecialty = [
            1  => 1,
            12 => 4,
            13 => 3,
            14 => 5,
        ];

        if (!isset($serviceToSpecialty[$service_id])) {
            return response()->json(['error' => 'Service not found']);
        }

        $specialty_id = $serviceToSpecialty[$service_id];

        $doctorQuery = Doctor::where('doctor_specialty_id', $specialty_id);

        if ($hmo_id != 0) {
            $doctorQuery->whereHas('hmos', fn ($q) => $q->where('hmo_id', $hmo_id));
        }

        $doctorIds = $doctorQuery->pluck('id');

        $availabilities = DoctorAvailability::whereIn('doctor_id', $doctorIds)
        ->where('day_of_week', $dayOfWeek)
        ->get(['doctor_id', 'start_time']);


        if ($availabilities->isEmpty()) {
            return response()->json([]);
        }

        $doctorSlots = $availabilities->map(function ($slot) use ($date) {
            $startDateTime = Carbon::parse("{$date} {$slot->start_time}")->format('Y-m-d H:i:s');
            return [
                'doctor_id' => $slot->doctor_id,
                'start_date' => $startDateTime,
                'display' => Carbon::parse($startDateTime)->format('g:i a')
            ];
        });

        // Get booked appointments for these doctors on this date
        $bookedAppointments = Appointment::whereIn('doctor_id', $doctorIds)
            ->whereDate('start_date', $date)
            ->get(['doctor_id', 'start_date']);


        // Filter out booked slots
        $availableSlots = $doctorSlots->filter(function ($slot) use ($bookedAppointments) {
            return !$bookedAppointments->contains(function ($appointment) use ($slot) {
                // Compare as Carbon objects to avoid string mismatch
                return $appointment->doctor_id == $slot['doctor_id']
                    && Carbon::parse($appointment->start_date, 'Asia/Manila')->equalTo($slot['start_date']);
            });
        })
        ->sortBy('start_date')
        ->pluck('display')
        ->unique()
        ->values();
        return response()->json($availableSlots);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated=$request->validate([
            'appointment_type' => 'required|boolean',
            'service_id' => 'required|integer|exists:services,id',
            'hmo_id' => 'nullable|integer',
            'hmo_number' => 'nullable|string',
            'insurance' => 'nullable|string|exists:insurances,name',
            'insurance_number' => 'nullable|string',
            'date' => 'required|date',
            'time_start' => 'required|string',
        ]);

        $date = Carbon::parse($validated['date'])->setTimezone('Asia/Manila')->format('Y-m-d');
        $dayOfWeek = strtolower(
            Carbon::parse($validated['date'])->setTimezone('Asia/Manila')->format('l')
        );
        $start_time = Carbon::createFromFormat('g:i a', $validated['time_start'])->format('H:i:s');
        $start_date = Carbon::parse("{$date} {$start_time}")->format('Y-m-d H:i:s');
        $appointment_type = $validated['appointment_type'] ? 'online' : 'walk-in';
        $service_id = $validated['service_id'];
        $hmo_id = $validated['hmo_id'];
        $hmo_number = $validated['hmo_number'];
        $insurance = $validated['insurance'];
        $insurance_number = $validated['insurance_number'];

        $serviceToSpecialty = [
            1  => 1,
            12 => 4,
            13 => 3,
            14 => 5,
        ];

        if (!isset($serviceToSpecialty[$service_id])) {
            return response()->json(['error' => 'Service not supported for booking'], 422);
        }

        $specialty_id = $serviceToSpecialty[$service_id];

        $doctorQuery = Doctor::where('doctor_specialty_id', $specialty_id);

        if ($hmo_id != 0) {
            $doctorQuery->whereHas('hmos', fn ($q) => $q->where('hmo_id', $hmo_id));
        }

        $doctorIds = $doctorQuery->pluck('id');

        // Doctors who are available at that start time
        $availableDoctorIds = DoctorAvailability::whereIn('doctor_id', $doctorIds)
        ->where('day_of_week', $dayOfWeek)
        ->where('start_time', $start_time)
        ->pluck('doctor_id');

        $bookedDoctorIds = Appointment::whereIn('doctor_id', $availableDoctorIds)
        ->where('start_date', $start_date)
        ->pluck('doctor_id');

        $freeDoctorIds = $availableDoctorIds->diff($bookedDoctorIds);

        if ($freeDoctorIds->isEmpty()) {
            return response()->json(['error' => 'No available doctors for this time'], 422);
        }

        $doctor_id = $freeDoctorIds->first();

        $end_time = DoctorAvailability::where('doctor_id', $doctor_id)
        ->where('day_of_week', $dayOfWeek)
        ->where('start_time', $start_time)
        ->first();

        if (!$end_time) {
            return response()->json(['error' => 'Doctor availability not found for this day/time'], 422);
        }

        $end_time = $end_time->end_time;
        $end_date = Carbon::parse("{$date} {$end_time}")->format('Y-m-d H:i:s');

        $appointment = Appointment::create([
            'patient_id' => $user->profile->patient->id,
            'doctor_id' => $doctor_id,
            'service_id' => $service_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status'=> 'upcoming',
            'appointment_type' => $appointment_type,
            'date_booked' => now(),
        ]);

        return response()->json($appointment);

    }
}
