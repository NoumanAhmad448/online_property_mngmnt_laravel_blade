<?php

namespace App\Providers;

use App\Policies\DashboardPolicy;
use App\Policies\LandPolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Gate::define(config('policy.update_land'), [LandPolicy::class, 'update']);
        Gate::define(config('policy.create_land'), [LandPolicy::class, 'create']);
        Gate::define(config('policy.update_profile'), [ProfilePolicy::class, 'update']);
        Gate::define(config('policy.view_admin_dashboard'), [DashboardPolicy::class, 'view']);
        Gate::define(config('policy.view_dashboard'), [DashboardPolicy::class, 'viewUser']);
        Gate::define(config('policy.is_super_admin'), [DashboardPolicy::class, 'isSuperAdmin']);
        Gate::define(config('policy.view_land_comment'), [DashboardPolicy::class, 'viewLand']);
        Gate::define(config('policy.can_be_admin'), [DashboardPolicy::class, 'isAdmin']);
        Gate::define(config('policy.has_not_id'), [DashboardPolicy::class, 'hasNotId']);
        Gate::define(config('policy.has_id'), [DashboardPolicy::class, 'hasId']);
        Gate::define(config('policy.view_setting'), [DashboardPolicy::class, 'viewSetting']);

    }
}
