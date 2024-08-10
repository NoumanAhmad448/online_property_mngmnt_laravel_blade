<?php

namespace App\Http\Requests;

use App\Rules\IsScriptAttack;

class IProfileRequest extends CustomRequest {
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
     * @return array
     */
    public function rules() {
        return [
            'name' => ['required', 'string', new IsScriptAttack],
        ];
    }

    /**
     * Get the validation messages
     *
     * @return array
     */
    public function messages() {
        return [
            'headline.required' => 'Professional title must be provided',
        ];
    }
}
