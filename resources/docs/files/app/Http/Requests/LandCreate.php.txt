<?php

namespace App\Http\Requests;

use App\Rules\NameRules;
use Illuminate\Support\Facades\Auth;

class LandCreate extends CustomRequest {
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
        $is_allowed = true;
        if (isAdmin(false)) {
            $is_allowed = false;
        }

        return $is_allowed;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        $rules = [];
        if (! Auth::user()) {
            $rules = $this->nameRules->userValidationRules();
        }
        $rules = array_merge($rules, $this->nameRules->landRegVal());

        return $rules;
    }

    /**
     * Get the validation messages
     *
     * @return array
     */
    public function messages() {
        $messages = [];
        if (! Auth::user()) {
            $messages = $this->nameRules->userValidationMsg();
        }
        $messages = array_merge($messages, $this->nameRules->landRegValMsg(),
            $this->nameRules->captchaValidation()
        );

        return $messages;
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
