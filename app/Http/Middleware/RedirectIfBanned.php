<?php

namespace App\Http\Middleware;

use App\Traits\SendsAlerts;
use Closure;

class RedirectIfBanned
{
    use SendsAlerts;

    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_banned) {
            $this->error('Errors you banned');

            auth()->logout();

            return to_route('home');
        }

        return $next($request);
    }
}
