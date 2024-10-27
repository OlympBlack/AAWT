<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\NewParentRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
        $this->validateInput($input);

        return DB::transaction(function () use ($input) {
            $user = $this->createUser($input);
            $this->notifyAdmins($user);
            return $user;
        });
    }

    private function validateInput(array $input): void
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
    }

    private function createUser(array $input): User
    {
        return User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => 2, // Attribue automatiquement le rôle de parent 
        ]);
    }

    private function notifyAdmins(User $user): void
    {
        $admins = User::where('role_id', 1)->get(['id', 'email']);
        Notification::send($admins, new NewParentRegistration($user));
    }
}
