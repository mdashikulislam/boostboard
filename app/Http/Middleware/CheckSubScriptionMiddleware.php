<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;

class CheckSubScriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        return $next($request);
    }
}
