<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\WebsiteSetting;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Program::query()->get()->map(function (Program $program) {
            if ($program->computed_status === 'coming_soon') {
                return null;
            }

            $calendarDate = $program->calendarDate();

            if (! $calendarDate) {
                return null;
            }

            return [
                'title' => $program->title,
                'start' => $calendarDate->format('Y-m-d'),
                'description' => strip_tags($program->description),
                'category_faculty' => $program->categoryFacultyLabel(),
                'schedule_label' => $program->calendarDateLabel(),
                'url' => route('program.show', $program->slug),
                'color' => '#C3110C',
            ];
        })->filter()->sortBy('start')->values();

        $today = today()->format('Y-m-d');
        $firstEvent = $events->first(fn (array $event) => $event['start'] >= $today) ?? $events->first();
        $initialDate = $firstEvent ? $firstEvent['start'] : null;

        $settings = WebsiteSetting::allAsArray();

        return view('calendar', compact('events', 'initialDate', 'settings'));
    }
}
