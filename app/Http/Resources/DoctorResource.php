<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'user_id' => $this->profile->user_id,
            'first_name' => $this->profile->first_name,
            'middle_name' => $this->profile->middle_name,
            'last_name' => $this->profile->last_name,
            'specialty' => new DoctorSpecialtyResource($this->specialty),
            'license_number' => $this->license_number,
            'room_number' => $this->room_number,
        ];
    }
}
