<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $titleCorrections = [
            'Perpajakan & Asuransi' => 'Perpajakan dan Asuransi',
            'UI/UX Design Fundamental' => 'Dasar-Dasar Desain UI/UX',
            'Digital Marketing Specialist' => 'Spesialis Pemasaran Digital',
            'AutoCAD for Professional' => 'AutoCAD untuk Profesional',
            'TOEFL Preparation Program' => 'Program Persiapan TOEFL',
            'IELTS Intensive Coaching' => 'Pelatihan Intensif IELTS',
            'Corporate Tax & Risk Management' => 'Corporate Tax and Risk Management',
            'UI/UX Design Fundamental (Intl)' => 'UI/UX Design Fundamentals (International)',
            'contoh' => 'Contoh Program',
            'Javascript' => 'JavaScript',
        ];

        $descriptionCorrections = [
            ['title' => 'Perpajakan & Asuransi', 'from' => 'mm', 'to' => 'Program Perpajakan dan Asuransi.'],
            ['title' => 'UI/UX Design Fundamental', 'from' => 'tes', 'to' => 'Program dasar desain UI/UX.'],
            ['title' => 'Digital Marketing Specialist', 'from' => 'tes', 'to' => 'Program spesialis pemasaran digital.'],
            ['title' => 'contoh', 'from' => ',,', 'to' => 'Contoh program.'],
            ['title' => 'Javascript', 'from' => 'Alden yg buat contoh', 'to' => 'Contoh program yang dibuat oleh Alden.'],
            ['title' => 'Gaming', 'from' => 'Gaming 1 test', 'to' => 'Program uji coba Gaming 1.'],
        ];

        foreach ($descriptionCorrections as $correction) {
            DB::table('programs')
                ->where('title', $correction['title'])
                ->where('description', $correction['from'])
                ->update(['description' => $correction['to']]);
        }

        DB::table('programs')
            ->whereIn('title', ['Corporate Tax & Risk Management', 'UI/UX Design Fundamental (Intl)'])
            ->whereNotNull('registration_date')
            ->update(['registration_date' => DB::raw("replace(registration_date, ' - ', ' to ')")]);

        foreach ($titleCorrections as $currentTitle => $correctedTitle) {
            DB::table('programs')->where('title', $currentTitle)->update(['title' => $correctedTitle]);
        }

        DB::table('programs')
            ->whereNotNull('registration_date')
            ->where('registration_date', 'like', '% - %')
            ->update(['registration_date' => DB::raw("replace(registration_date, ' - ', ' sampai ')")]);

        DB::table('programs')
            ->whereNotNull('registration_date')
            ->where('registration_date', 'like', '%Agt%')
            ->update(['registration_date' => DB::raw("replace(registration_date, 'Agt', 'Agu')")]);
    }

    public function down(): void
    {
        // Copy corrections are intentionally retained when rolling back.
    }
};
