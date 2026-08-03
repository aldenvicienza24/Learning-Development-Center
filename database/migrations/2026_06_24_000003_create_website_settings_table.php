<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            'hero_title' => 'Tingkatkan Kompetensi Bersama UISI',
            'hero_description' => 'Temukan program pelatihan, sertifikasi, dan pengembangan profesional yang sesuai dengan kebutuhan karier dan institusi Anda.',
            'hero_banner' => 'images/hero-bg.jpg',
            'hero_calendar_link' => '/kalender-program',
            'logo' => 'images/LogoUISI.png',
            'email' => 'info@uisi.ac.id',
            'whatsapp' => '+62 858-0069-5077',
            'address' => 'Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro, Kecamatan Kebomas, Kabupaten Gresik, Jawa Timur, Indonesia',
            'instagram' => '#',
            'facebook' => '#',
            'youtube' => '#',
            'linkedin' => '#',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('website_settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
