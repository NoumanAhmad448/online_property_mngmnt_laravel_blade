<?php

namespace App\Policies;

use App\Models\CreateLand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LandPolicy {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function update(User $user, CreateLand $land) {
        debug_logs($user->id);
        debug_logs($land->id);
        debug_logs('condition for land & user id');
        debug_logs($user->id == $land->user_id);

        return $user->id == $land->user_id;
    }

    public function create(): bool {
        return is_normal_user();
    }
}
