<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
{
    // aко НЕ Е админ -> вън!
    if ($request->user()->role !== 'admin') {
        abort(403, 'НЯМАТЕ ПРАВО ДА БЪДЕТЕ ТУК!'); // връща грешка "forbidden"
    }

    // ако е админ -> продължи напред
    return $next($request);
}

}
