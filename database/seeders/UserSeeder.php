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
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'password' => bcrypt('testtest'),
                'role' => 'admin',
            ]
        );

        $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'Admin',
                'middle_name' => 'Admin',
                'last_name' => '1',
                'date_of_birth' => '2000-01-01',
                'gender' => 'male',
                'phone_number' => '(+63) 123 123 1231',
                'contact_email' => 'admin@gmail.com',
            ]
        );

    }
}
