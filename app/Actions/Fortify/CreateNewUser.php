<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => ['sometimes', Rule::in(['admin', 'doctor', 'staff', 'patient'])],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'phone_number' => ['required', 'string', 'max:20'],
        ])->validate();

        $user =  User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'] ?? 'patient',
        ]);

        $profile = $user->profile()->create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'] ?? null,
            'last_name' => $input['last_name'],
            'date_of_birth' => $input['date_of_birth'],
            'gender' => $input['gender'],
            'phone_number' => $input['phone_number'],
            'contact_email'=> $input['email'],
        ]);

        if (in_array($input['role'], ['doctor', 'staff', 'patient'])) {
            $relation = $input['role'];
            $profile->{$relation}()->create([]);
        }

        return $user;
    }
}
