<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;

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
            'timezone' => ['nullable', 'string'],
        ])->validate();

        $userTimezone = $input['timezone'] ?? 'UTC';
        $dateOfBirth = Carbon::parse($input['date_of_birth'])
            ->setTimezone($userTimezone)
            ->toDateString();
        $gender = strtolower($input['gender']);
        $first_name = Str::title(strtolower($input['first_name']));
        $middle_name = Str::title(strtolower($input['middle_name']));
        $last_name = Str::title(strtolower($input['last_name']));


        $existingProfile = Profile::where([
               ['first_name', $first_name],
               ['middle_name', $middle_name],
               ['last_name', $last_name],
               ['date_of_birth', $dateOfBirth],
               ['gender', $gender],
           ])->first();

        if ($existingProfile) {
            if ($existingProfile->user_id === null) {
                // Profile exists but not linked — create user and link it
                $user = User::create([
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'role' => $input['role'] ?? 'patient',
                ]);

                $existingProfile->update([
                    'user_id' => $user->id,
                    'phone_number' => $input['phone_number'],
                    'contact_email' => $input['email'],
                ]);

                if (in_array($input['role'], ['doctor', 'staff', 'patient'])) {
                    $relation = $input['role'];
                    $existingProfile->{$relation}()->create([]);
                }

                return $user;
            } else {
                // Profile already linked to another user — reject
                abort(422, 'A user with this profile already exists.');
            }
        }


        $user =  User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'] ?? 'patient',
        ]);

        $profile = $user->profile()->create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'date_of_birth' => $dateOfBirth,
            'gender' => $gender,
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
