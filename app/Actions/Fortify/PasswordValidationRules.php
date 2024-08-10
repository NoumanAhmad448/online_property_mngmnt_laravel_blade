<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules {
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules($verifyReq = false): array {
        $pass = new Password(config('setting.min_pass'));
        if (config('setting.pass_ltr_req')) {
            $pass = $pass->letters();
        }
        if (config('setting.pass_no_req')) {
            $pass = $pass->numbers();
        }
        if (config('setting.pass_no_req')) {
            $pass = $pass->symbols();
        }
        $pass = $pass->rules(['string', 'required']);
        $rules = [$pass];

        if ($verifyReq) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }
}
