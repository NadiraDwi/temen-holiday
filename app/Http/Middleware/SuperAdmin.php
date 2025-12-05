<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        if (!$user || $user->role !== 'superadmin') {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
