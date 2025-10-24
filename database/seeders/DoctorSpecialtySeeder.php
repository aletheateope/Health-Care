<?php

namespace Database\Seeders;

use App\Models\DoctorSpecialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
         'General Practitioner',
         'OB-GYN',
         'Occupational Therapist',
         'Physical Therapist',
         'Speech-Language Pathologist',
        ];

        foreach ($specialties as $specialty) {
            DoctorSpecialty::firstOrCreate([
                'name' => $specialty,
            ]);
        }
    }
}
