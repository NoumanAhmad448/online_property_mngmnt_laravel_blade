<?php

namespace App\Rules;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Validation\Rule;

class NameRules {
    use PasswordValidationRules;

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    public static function nameRules($is_required = true) {
        $rules = [];
        if ($is_required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        add_array($rules, ['string', new IsScriptAttack]);

        return $rules;
    }

    public static function emailRules($should_unique = true) {
        $rules = ['required', 'string', 'email', new IsScriptAttack, new SpecificDomainsOnly];
        if ($should_unique) {
            $rules[] = Rule::unique(User::class);
        }

        return $rules;
    }

    public static function gCaptchaRules() {
        return ['required', 'captcha'];
    }

    public function passRules($verifyReq = false) {
        return $this->passwordRules();
    }

    public function fileRules($is_required = false) {
        $allowed_fuas = config('setting.fuas');
        $allowed_fuas = (int) $allowed_fuas * 1000;
        $img_val_rules_str = config('form.img_val_rules_str');
        $rules = '';
        if ($is_required) {
            $rules .= 'required |';
        } else {
            $rules .= 'nullable|';
        }
        $rules .= "file|max:{$allowed_fuas}|mimetypes:{$img_val_rules_str}";

        return $rules;
    }

    public function landUpdates(): array {
        return [
            config('table.comment') => self::nameRules(),
            config('table.land_create_id') => self::nameRules(),
            config('table.land_ops_id') => self::nameRules(),
        ];
    }

    public function myProfile(): array {
        return [
            config('table.name') => self::nameRules(),
            config('table.mobile') => self::nameRules(false),
            config('table.age') => self::nameRules(false),
            config('table.gender') => self::nameRules(false),
            config('table.address') => self::nameRules(false),
            config('table.job_id') => self::nameRules(false),
        ];
    }

    public function adminDelete(): array {
        return [
            config('table.primary_key') => self::nameRules(),
        ];
    }

    public function adminUpdate(): array {
        return [
            config('table.primary_key') => self::nameRules(),
            config('form.password') => $this->passRules(),
        ];
    }

    public function userValidationRules(): array {
        return [
            config('form.first_name') => self::nameRules(),
            config('form.lastname') => self::nameRules(),
            config('form.email') => self::emailRules(),
            config('form.c_password') => $this->passRules($verifyReq = true),
            config('form.password') => $this->passRules(),
        ];
    }

    public function isAdminRules(): array {
        return [
            config('table.is_admin') => self::nameRules(),
        ];
    }

    public function landRegVal(): array {
        $rules = [
            config('setting.title') => self::nameRules(),
            config('setting.description') => self::nameRules(),
            config('setting.location') => self::nameRules(),
            config('setting.size') => self::nameRules(),
            config('setting.city') => $this->nameRules(),
        ];
        if (config('setting.en_land_reg_file')) {
            $rule = config('setting.land_reg_file_upload');
            if (config('setting.landreg_multiple')) {
                $rule .= '.*';
            }
            $rules[$rule] = $this->fileRules();
        }
        if (config('setting.en_country')) {
            $rules[config('setting.country')] = self::nameRules();
        }
        if (config('setting.en_gc')) {
            $rules[config('form.g-recaptcha-response')] = self::gCaptchaRules();
        }

        return $rules;
    }

    public function userValidationMsg(): array {
        return [
            config('form.first_name').'.required' => __('validation.required'),
            config('form.lastname').'.required' => __('validation.required'),
            config('form.email').'.required' => __('validation.required'),
            config('form.c_password').'.required' => __('validation.required'),
            config('form.password').'.required' => __('validation.required'),
        ];
    }

    public function captchaValidation(): array {
        return [
            config('form.g-recaptcha-response').'.required' => __('validation.required'),
            config('form.g-recaptcha-response').'.captcha' => __('validation.required'),
        ];
    }

    public function landRegValMsg(): array {
        return [
            config('setting.title').'.required' => __('validation.required'),
            config('setting.description').'.required' => __('validation.required'),
            config('setting.location').'.required' => __('validation.required'),
            config('setting.size').'.required' => __('validation.required'),
            config('setting.city').'.required' => __('validation.required'),
        ];
    }
}
