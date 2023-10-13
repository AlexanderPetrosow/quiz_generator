<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Обрабатывает входящий запрос.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->status == 'disabled' || Auth::user()->status == 'pending')) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['status' => 'Your account has been disabled or is still pending.']);
        }

        return $next($request);
    }
}
