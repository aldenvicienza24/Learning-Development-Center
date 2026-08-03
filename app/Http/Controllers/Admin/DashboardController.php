<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $programs = Program::query()->withCount('registrations')->latest()->get();

        return view('admin.dashboard', [
            'totalPrograms' => $programs->count(),
            'totalRegistrations' => Registration::query()->count(),
            'activePrograms' => $programs->where('computed_status', 'open_registration')->count(),
            'comingSoonPrograms' => $programs->where('computed_status', 'coming_soon')->count(),
            'latestRegistrations' => Registration::query()->with('program')->latest()->limit(5)->get(),
            'latestPrograms' => $programs->take(5),
            'upcomingPrograms' => Program::query()
                ->withCount('registrations')
                ->whereNotNull('event_date')
                ->whereDate('event_date', '>=', today())
                ->orderBy('event_date')
                ->limit(5)
                ->get(),
        ]);
    }
}
