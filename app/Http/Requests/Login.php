<?php

namespace App\Http\Requests;

use App\Rules\NameRules;
use Illuminate\Contracts\Validation\Validator;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class Login extends FortifyLoginRequest {
    private $nameRules;

    public function __construct() {
        $this->nameRules = new NameRules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {

        $rules = [
            config('form.email') => NameRules::emailRules(false),
            config('form.password') => $this->nameRules->passRules(),
        ];
        if (config('setting.en_gc')) {
            $rules[config('form.g-recaptcha-response')] = NameRules::gCaptchaRules();
        }

        return $rules;
    }

    /**
     * Get the validation messages
     *
     * @return array
     */
    public function messages() {
        $messages = [];

        $messages = $this->nameRules->userValidationMsg();
        $messages = array_merge($messages,
            $this->nameRules->captchaValidation()
        );

        return $messages;
    }

    protected function failedValidation(Validator $validator) {
        failValidation($validator);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array {
        return __('attributes');
    }
}
