<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin {
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $user = Auth::user();
        if (! $user || (! $user->is_admin && ! $user->is_super_admin)) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
