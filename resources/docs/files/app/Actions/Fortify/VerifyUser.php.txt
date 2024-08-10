<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerifyUser {
    use PasswordValidationRules;

    public function verifyUser($data, $check_admin = false) {
        // return false if password is invalid
        $user = User::where(config('form.email'), $data[config('form.email')]);
        if ($check_admin) {
            $user->where(function ($query) {
                $query->where(config('table.is_super_admin'), '=', 1)
                    ->orWhere(config('table.is_admin'), 1);
            });
        }
        $user = $user->first();
        if (! $user || ! $this->verifyPass($data, $user)) {
            return false;
        }

        return $user;
    }

    public function verifyPass($data, $user): bool {
        return Hash::check($data[config('form.password')], $user->password);
    }

    public function logout($request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return true;

    }
}
