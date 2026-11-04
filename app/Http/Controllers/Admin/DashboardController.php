<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $activeRegistrationClosure = function ($query) {
            $query->whereRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') != 'ditolak'");
        };

        $programs = Program::query()->withCount(['registrations' => $activeRegistrationClosure])->latest()->get();

        return view('admin.dashboard', [
            'totalPrograms' => $programs->count(),
            'totalRegistrations' => Registration::query()
                ->whereRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') != 'ditolak'")
                ->count(),
            'activePrograms' => $programs->where('computed_status', 'open_registration')->count(),
            'comingSoonPrograms' => $programs->where('computed_status', 'coming_soon')->count(),
            'latestRegistrations' => Registration::query()->with('program')->latest()->limit(5)->get(),
            'latestPrograms' => $programs->take(5),
            'upcomingPrograms' => Program::query()
                ->withCount(['registrations' => $activeRegistrationClosure])
                ->whereNotNull('event_date')
                ->whereDate('event_date', '>=', today())
                ->orderBy('event_date')
                ->limit(5)
                ->get(),
        ]);
    }
}
