<?php

use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('the public home remains public while an admin is authenticated', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get(route('home'))
        ->assertRedirect(route('dashboard'));
});

test('the cms logo and website button point to the public dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('dashboard').'"', false)
        ->assertSee('Lihat Situs Web');
});

test('an admin can upload a separate image for each homepage service card', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

    $response = $this->actingAs($admin)->put(route('admin.hero.update'), [
        'service_training_image' => UploadedFile::fake()->createWithContent('training.png', $png),
        'service_certification_image' => UploadedFile::fake()->createWithContent('certification.png', $png),
        'service_language_image' => UploadedFile::fake()->createWithContent('language.png', $png),
    ]);

    $response->assertRedirect()->assertSessionHasNoErrors();

    foreach (['service_training_image', 'service_certification_image', 'service_language_image'] as $key) {
        $path = WebsiteSetting::getValue($key);

        expect($path)->toStartWith('cms/homepage/');
        Storage::disk('public')->assertExists($path);
    }

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Kegiatan Unit Layanan Pelatihan')
        ->assertSee('Kegiatan Unit Layanan Sertifikasi')
        ->assertSee('Kegiatan Unit Layanan Bahasa');
});
