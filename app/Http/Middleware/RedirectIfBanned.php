<?php

namespace App\Http\Middleware;

use App\Traits\SendsAlerts;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfBanned
{
    use SendsAlerts;

    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned) {
            $this->error('Errors you banned');

            Auth::logout();

            return to_route('home');
        }

        return $next($request);
    }
}
