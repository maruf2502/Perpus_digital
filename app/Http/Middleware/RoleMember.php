<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMember
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::guard('member')->user();

        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
