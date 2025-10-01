<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            "profile" => $this->whenLoaded('profile', function () {
                return [
                    'first_name' => $this->profile->first_name,
                    'middle_name' => $this->profile->middle_name,
                    'last_name' => $this->profile->last_name,
                    "date_of_birth" => $this->profile->date_of_birth,
                    "gender" => $this->profile->gender,
                    "phone" => $this->profile->phone,
                    "contact_email" => $this->profile->contact_email,
                ];
            }),
        ];
    }
}
