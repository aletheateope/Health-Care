<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $age = $this->profile->date_of_birth
                   ? Carbon::parse($this->profile->date_of_birth)->age
                   : null;


        return [
            'id' => $this->id,
            'first_name' => $this->profile->first_name,
            'middle_name' => $this->profile->middle_name,
            'last_name' => $this->profile->last_name,
            'age' => $age,
            'medical_history'=> $this->medical_history,
            'full_name' => trim($this->profile->first_name . ' ' .
                            ($this->profile->middle_name ? $this->profile->middle_name . ' ' : '') .
                            $this->profile->last_name),
        ];
    }
}
