<?php

namespace App\Http\Requests;

use App\Rules\NameRules;
use Illuminate\Contracts\Validation\Validator;

class MyProfilePatch extends CustomRequest {
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

        return $this->nameRules->myProfile();
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
}
