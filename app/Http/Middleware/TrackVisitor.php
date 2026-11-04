<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('visitor_id')) {
            $request->session()->put('visitor_id', (string) Str::uuid());
        }

        $trackablePage = $request->isMethod('GET')
            && ! $request->expectsJson()
            && $request->routeIs([
                'dashboard',
                'profil',
                'programs.index',
                'program.show',
                'kalender-program',
                'pendaftaran',
                'faculty.show',
            ]);

        if (! $trackablePage) {
            return $next($request);
        }

        $programId = null;
        if ($request->routeIs('program.show')) {
            $program = $request->route('program');
            $programId = is_object($program) ? $program->id : $program;
        }

        PageView::create([
            'session_id' => $request->session()->get('visitor_id'),
            'ip_address' => $request->ip(),
            'url' => $request->url(),
            'program_id' => $programId,
            'user_agent' => $request->userAgent(),
        ]);

        return $next($request);
    }
}
