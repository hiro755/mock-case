<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && (! $user->full_name || ! $user->address || ! $user->phone_number)) {
            if (! $request->is('profile/setup*')) {
                return redirect()->route('profile.setup');
            }
        }

        return $next($request);
    }
}
