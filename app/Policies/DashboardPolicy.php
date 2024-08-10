<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class DashboardPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function view(): bool {
        return isAdmin(false);
    }

    public function viewUser(): bool {
        return is_normal_user();
    }

    public function isSuperAdmin(): bool {
        return isSuperAdmin(false);
    }

    public function viewLand(): bool {
        return isSuperAdmin(false);
    }

    public function isAdmin(): bool {
        return isAdmin(false);
    }

    public function hasNotId(): bool {
        return ! $this->hasId();
    }

    public function hasId(): bool {
        return request()->has(config('table.primary_key'));
    }

    public function viewSetting(): bool {
        return isNotSuperAdmin();
    }
}
