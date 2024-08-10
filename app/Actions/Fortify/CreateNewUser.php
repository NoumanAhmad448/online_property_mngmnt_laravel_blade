<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers {
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return $this->CreateUser($input = $input);
    }

    public function createUser(array $input): User {
        $data = [];

        logs($input);
        if (! is_key_exists(config('form.name'), $input)) {
            if (is_key_exists(config('form.first_name'), $input) &&
                $input[config('form.first_name')]) {
                $data[config('form.name')] = $input[config('form.first_name')].' ';

                if (is_key_exists(config('form.lastname'), $input) &&
                    $input[config('form.lastname')]) {
                    $data[config('form.name')] .= $input[config('form.lastname')];
                }
                if (is_key_exists(config('table.is_admin'), $input)) {
                    $data[config('table.is_admin')] = $input[config('table.is_admin')];
                }
                if (! $data[config('form.name')]) {
                    $data[config('form.name')] = config('setting.suname');
                }
            }
        } else {
            $data[config('form.name')] = $input[config('form.name')];
        }
        $data[config('form.password')] = Hash::make($input[config('form.password')]);
        $data[config('form.email')] = $input[config('form.email')];

        return User::create($data);
    }
}
