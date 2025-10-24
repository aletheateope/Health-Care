<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'doctor' => [
                'id' => $this->doctor?->id,
                'room_number' => $this->doctor?->room_number,
                'first_name' => $this->doctor?->profile?->first_name,
                'last_name' => $this->doctor?->profile?->last_name,
            ],
            'service' => [
                'id' => $this->service?->id,
                'name' => $this->service?->name,
            ],
            'start_date' => $this->start_date
                ? Carbon::parse($this->start_date)->format('F d, Y g:i a')
                : null,
            'end_date' => $this->end_date
                ? Carbon::parse($this->end_date)->format('F d, Y g:i a')
                : null,
            'patient_hmo' => [
                'id' => $this->patientHmo?->id,
                'name' => $this->patientHmo?->name,
            ],
            'status' => $this->status,
            'appointment_type' => $this->appointment_type,
        ];
    }
}
