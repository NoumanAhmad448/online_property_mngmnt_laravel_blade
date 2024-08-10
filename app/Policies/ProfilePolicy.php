<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function update() {
        return is_auth_user();
    }
}
