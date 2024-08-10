<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SpecificDomainsOnly implements Rule {
    private $domain;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $domain = strtolower(substr($value, strpos($value, '@') + 1));
        $this->domain = $domain;
        $domains = config('domains');

        return in_array($domain, $domains);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return __('messages.invalid_domain', [config('vars.domain') => $this->domain]);
    }
}
