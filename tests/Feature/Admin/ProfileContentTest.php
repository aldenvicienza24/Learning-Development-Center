<?php

use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can update profile page content', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)->put(route('admin.profile.update'), [
        'profile_hero_title' => 'Profil Layanan Terbaru',
        'profile_hero_description_mobile' => 'Deskripsi singkat.',
        'profile_hero_description' => 'Deskripsi lengkap halaman profil.',
        'profile_vision' => 'Visi terbaru.',
        'profile_missions' => [
            'Misi pertama.',
            'Misi kedua.',
            'Misi ketiga.',
            'Misi keempat.',
        ],
        'profile_calendar_file' => UploadedFile::fake()->create('kalender.pdf', 100, 'application/pdf'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
    expect(WebsiteSetting::getValue('profile_hero_title'))->toBe('Profil Layanan Terbaru');
    expect(WebsiteSetting::getValue('profile_calendar_link'))->toStartWith('/storage/cms/profile/calendar/');

    $this->get(route('profil'))
        ->assertOk()
        ->assertSee('Profil Layanan Terbaru')
        ->assertSee('Misi keempat.');
});
