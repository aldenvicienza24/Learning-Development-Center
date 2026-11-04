<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class CalendarController extends Controller
{
    public function index()
    {
        // Tanggal pelaksanaan diprioritaskan; program lama memakai akhir periode pendaftaran.
        $eventsCount = Program::query()->get()->filter(fn (Program $program) => $program->calendarDate())->count();
        $title = 'Kalender Program';
        $subtitle = 'Kalender akan terisi otomatis berdasarkan tanggal pelaksanaan program dari menu Program.';
        return view('admin.calendar.index', compact('eventsCount', 'title', 'subtitle'));
    }
}
