<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DoctorAvailability;
use App\Http\Resources\DoctorAvailabilityResource;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function mySchedule()
    {
        $doctor = Auth::user()->profile->doctor;

        if (!$doctor) {
            return response()->json(['message' => 'Doctor profile not found.'], 404);
        }

        $availability = $doctor->availabilities()
        ->orderByRaw("CASE day_of_week
            WHEN 'monday' THEN 1
            WHEN 'tuesday' THEN 2
            WHEN 'wednesday' THEN 3
            WHEN 'thursday' THEN 4
            WHEN 'friday' THEN 5
            WHEN 'saturday' THEN 6
            WHEN 'sunday' THEN 7
        END")
        ->orderBy('start_time')
        ->get();

        return DoctorAvailabilityResource::collection($availability);
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.selectedDays' => 'required|array|min:1',
            'schedules.*.timeSlots' => 'required|array|min:1',
        ]);

        $user = Auth::user();
        $doctor = $user->profile->doctor;

        if (!$doctor) {
            return response()->json(['message' => 'Doctor profile not found.'], 404);
        }

        $doctor->availabilities()->exists() && $doctor->availabilities()->delete();

        $weekDaysOrder = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($weekDaysOrder as $day) { // loop days in order
            foreach ($request->schedules as $scheduleData) {
                if (!in_array($day, array_map('strtolower', $scheduleData['selectedDays']))) {
                    continue; // skip if day not selected
                }

                // Remove empty and duplicate time slots, parse with Carbon, sort
                $timeSlots = collect($scheduleData['timeSlots'])
                    ->filter(fn ($t) => trim($t) !== '')
                    ->unique()
                    ->map(fn ($t) => Carbon::parse($t))
                    ->sort()
                    ->values();

                // Create availability records
                foreach ($timeSlots as $i => $start) {
                    $end = $timeSlots[$i + 1] ?? $start->copy()->addHours(1)->addMinutes(30);

                    DoctorAvailability::create([
                        'doctor_id'   => $doctor->id,
                        'day_of_week' => $day,
                        'start_time'  => $start->format('H:i:s'),
                        'end_time'    => $end->format('H:i:s'),
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Schedule added successfully.'], 200);
    }
}
