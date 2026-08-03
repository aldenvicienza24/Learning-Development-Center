<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not authenticated at all, redirect to CMS login
        if (! auth()->check()) {
            return redirect('/cms/login');
        }

        // If authenticated but not admin, show 403
        abort_unless($request->user()->is_admin, 403);

        return $next($request);
    }
}
