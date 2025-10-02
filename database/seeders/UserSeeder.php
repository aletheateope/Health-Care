<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('testtest'),
            'role' => 'admin',
        ]);

        $user->profile()->firstOrCreate([
            'first_name' => 'Admin',
            'middle_name' => 'Admin',
            'last_name' => '1',
            'date_of_birth' => '2000-01-01',
            'gender' => 'male',
            'phone' => '(+63) 123 123 1231',
            'contact_email' => 'admin@gmail.com',
        ]);

        $user = User::firstOrCreate([
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('testtest'),
            'role' => 'doctor',
        ]);

        $user->profile()->firstOrCreate([
            'first_name' => 'Doctor',
            'middle_name' => 'Doctor',
            'last_name' => '1',
            'date_of_birth' => '2000-01-01',
            'gender' => 'male',
            'phone' => '(+63) 123 123 1231',
            'contact_email' => 'doctor@gmail.com',
        ]);

        $user = User::firstOrCreate([
            'email' => 'patient@gmail.com',
            'password' => bcrypt('testtest'),
            'role' => 'patient',
        ]);

        $user->profile()->firstOrCreate([
            'first_name' => 'Patient',
            'middle_name' => 'Patient',
            'last_name' => '1',
            'date_of_birth' => '2000-01-01',
            'gender' => 'male',
            'phone' => '(+63) 123 123 1231',
            'contact_email' => 'patient@gmail.com',
        ]);
    }
}
