<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin {
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $user = auth()->user();
        if (empty($user) || ($user && $user->is_super_admin !== 1)) {
            abort(403);
        }

        return $next($request);
    }
}
