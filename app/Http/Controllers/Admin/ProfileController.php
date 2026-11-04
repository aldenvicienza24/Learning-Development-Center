<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile', [
            'settings' => WebsiteSetting::allAsArray(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'profile_hero_image' => ['nullable', 'image', 'max:4096'],
            'profile_hero_title' => ['nullable', 'string', 'max:180'],
            'profile_hero_description_mobile' => ['nullable', 'string', 'max:300'],
            'profile_hero_description' => ['nullable', 'string', 'max:600'],
            'profile_vision' => ['required', 'string', 'max:1000'],
            'profile_missions' => ['nullable', 'array', 'max:10'],
            'profile_missions.*' => ['nullable', 'string', 'max:600'],
            'profile_missions_json' => ['nullable', 'string'],
            'profile_mission_1' => ['nullable', 'string', 'max:600'],
            'profile_mission_2' => ['nullable', 'string', 'max:600'],
            'profile_mission_3' => ['nullable', 'string', 'max:600'],
            'profile_mission_4' => ['nullable', 'string', 'max:600'],
            'profile_mission_5' => ['nullable', 'string', 'max:600'],
            'profile_mission_6' => ['nullable', 'string', 'max:600'],
            'profile_mission_7' => ['nullable', 'string', 'max:600'],
            'profile_mission_8' => ['nullable', 'string', 'max:600'],
            'profile_mission_9' => ['nullable', 'string', 'max:600'],
            'profile_mission_10' => ['nullable', 'string', 'max:600'],
            'profile_calendar_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('profile_hero_image')) {
            $data['profile_hero_image'] = $request->file('profile_hero_image')->store('cms/profile', 'public');
        } else {
            unset($data['profile_hero_image']);
        }

        if ($request->hasFile('profile_calendar_file')) {
            $calendarPath = $request->file('profile_calendar_file')->store('cms/profile/calendar', 'public');
            $data['profile_calendar_link'] = '/storage/'.$calendarPath;
        }

        unset($data['profile_calendar_file']);

        $missionsFromJson = json_decode($request->input('profile_missions_json', ''), true);
        $missionsInput = is_array($missionsFromJson)
            ? $missionsFromJson
            : ($data['profile_missions'] ?? collect(range(1, 10))
                ->map(fn ($number) => $request->input('profile_mission_'.$number))
                ->all());

        $missions = collect($missionsInput)
            ->map(fn ($mission) => trim($mission))
            ->filter(fn ($mission) => filled($mission))
            ->values()
            ->all();

        if (count($missions) === 0) {
            return back()
                ->withErrors(['profile_missions' => 'Minimal isi 1 misi.'])
                ->withInput();
        }

        unset($data['profile_missions']);
        unset($data['profile_missions_json']);
        foreach (range(1, 10) as $missionNumber) {
            unset($data['profile_mission_'.$missionNumber]);
        }
        $data['profile_missions'] = json_encode($missions, JSON_UNESCAPED_UNICODE);

        foreach ($data as $key => $value) {
            WebsiteSetting::setValue($key, $value);
        }

        foreach (range(1, 10) as $legacyMissionNumber) {
            WebsiteSetting::forgetValue('profile_mission_'.$legacyMissionNumber);
        }

        return back()->with('status', 'Halaman profil berhasil diperbarui.');
    }

    public function updateMissions(Request $request)
    {
        $data = $request->validate([
            'profile_vision' => ['required', 'string', 'max:1000'],
            'profile_missions' => ['nullable', 'array', 'max:10'],
            'profile_missions.*' => ['nullable', 'string', 'max:600'],
            'profile_missions_json' => ['nullable', 'string'],
            'profile_mission_1' => ['nullable', 'string', 'max:600'],
            'profile_mission_2' => ['nullable', 'string', 'max:600'],
            'profile_mission_3' => ['nullable', 'string', 'max:600'],
            'profile_mission_4' => ['nullable', 'string', 'max:600'],
            'profile_mission_5' => ['nullable', 'string', 'max:600'],
            'profile_mission_6' => ['nullable', 'string', 'max:600'],
            'profile_mission_7' => ['nullable', 'string', 'max:600'],
            'profile_mission_8' => ['nullable', 'string', 'max:600'],
            'profile_mission_9' => ['nullable', 'string', 'max:600'],
            'profile_mission_10' => ['nullable', 'string', 'max:600'],
        ]);

        $missions = $this->missionsFromRequest($request, $data);

        if (count($missions) === 0) {
            return back()
                ->withErrors(['profile_missions' => 'Minimal isi 1 misi.'])
                ->withInput();
        }

        WebsiteSetting::setValue('profile_vision', $data['profile_vision']);
        WebsiteSetting::setValue('profile_missions', json_encode($missions, JSON_UNESCAPED_UNICODE));

        foreach (range(1, 10) as $legacyMissionNumber) {
            WebsiteSetting::forgetValue('profile_mission_'.$legacyMissionNumber);
        }

        return back()->with('status', 'Visi dan misi berhasil diperbarui.');
    }

    private function missionsFromRequest(Request $request, array $data): array
    {
        $missionsFromJson = json_decode($request->input('profile_missions_json', ''), true);
        $missionsInput = is_array($missionsFromJson)
            ? $missionsFromJson
            : ($data['profile_missions'] ?? collect(range(1, 10))
                ->map(fn ($number) => $request->input('profile_mission_'.$number))
                ->all());

        return collect($missionsInput)
            ->map(fn ($mission) => trim((string) $mission))
            ->filter(fn ($mission) => filled($mission))
            ->values()
            ->all();
    }
}
