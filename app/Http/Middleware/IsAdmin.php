<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Проверяем, авторизован ли пользователь и является ли он администратором
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // В противном случае редиректим с ошибкой
        return redirect()->route('home')->withErrors('You do not have access to this resource!');
    }
}