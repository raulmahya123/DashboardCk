<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Log;
class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
