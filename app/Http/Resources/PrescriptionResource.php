<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
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
            'patient_name' => $this->patient
            ? ($this->patient->profile->first_name . ' ' . $this->patient->profile->last_name)
            : null,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $this->doctor
            ? ($this->doctor->profile->first_name . ' ' . $this->doctor->profile->last_name)
            : null,
            'items' => PrescriptionItemResource::collection($this->whenLoaded('items')),
            'remarks' => PrescriptionRemarkResource::collection($this->whenLoaded('remarks')),
            'date_issued' => $this->created_at?->format('F d, Y'),
            'valid_until' => $this->valid_until?->format('F d, Y'),
        ];
    }
}
