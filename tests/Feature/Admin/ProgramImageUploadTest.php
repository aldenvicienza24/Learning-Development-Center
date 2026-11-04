<?php

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function programImageUploadPayload(): array
{
    return [
        'title' => 'Pelatihan Poster',
        'category' => 'sertifikasi',
        'faculty' => 'ekonomi-bisnis',
        'registration_date' => 'Belum dijadwalkan',
        'description' => 'Program dengan poster kegiatan.',
        'syllabus' => '/silabus/poster.pdf',
        'price' => 600000,
        'quota' => 30,
        'detail_url' => 'pelatihan-poster',
    ];
}

test('admins can save portrait and landscape program images', function (string $action, int $width, int $height) {
    Storage::fake('public');
    $admin = User::factory()->create(['is_admin' => true]);
    $payload = programImageUploadPayload();
    $image = UploadedFile::fake()->image('poster.png', $width, $height);

    if ($action === 'update') {
        $program = Program::create($payload + ['image_url' => '/images/old.jpg']);
        $response = $this->actingAs($admin)->put(route('admin.programs.update', $program), $payload + ['thumbnail' => $image]);
    } else {
        $response = $this->actingAs($admin)->post(route('admin.programs.store'), $payload + ['thumbnail' => $image]);
    }

    $response->assertRedirect(route('admin.programs.index'))->assertSessionHasNoErrors();
    $program = Program::where('detail_url', $payload['detail_url'])->firstOrFail();
    Storage::disk('public')->assertExists($program->thumbnail);
    expect($program->image_url)->toBe('/storage/'.$program->thumbnail);
})->with(['create', 'update'])->with([
    'portrait 1080 x 1350' => [1080, 1350],
    'portrait maximum 2400 x 3000' => [2400, 3000],
    'existing landscape 2400 x 1200' => [2400, 1200],
]);

test('invalid program images show clear errors and preserve the saved image', function (int $width, int $height, int $size, string $message) {
    app()->setLocale('id');
    Storage::fake('public');
    $admin = User::factory()->create(['is_admin' => true]);
    $payload = programImageUploadPayload();
    $program = Program::create($payload + ['image_url' => '/images/old.jpg']);
    $image = UploadedFile::fake()->image('poster.png', $width, $height)->size($size);

    $this->actingAs($admin)
        ->put(route('admin.programs.update', $program), $payload + ['thumbnail' => $image])
        ->assertSessionHasErrors(['thumbnail' => $message]);

    expect($program->fresh()->image_url)->toBe('/images/old.jpg');
    expect(Storage::disk('public')->allFiles('programs'))->toBeEmpty();
})->with([
    'too wide' => [2401, 1350, 100, 'Lebar gambar program maksimal 2400 piksel dan tinggi maksimal 3000 piksel.'],
    'too tall' => [1080, 3001, 100, 'Lebar gambar program maksimal 2400 piksel dan tinggi maksimal 3000 piksel.'],
    'over 2 MB' => [1080, 1350, 2049, 'Ukuran gambar program maksimal 2 MB.'],
]);

test('the admin program form explains portrait uploads and contains an uncropped preview', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->get(route('admin.programs.create'))
        ->assertOk()
        ->assertSee('1080 × 1350 piksel')
        ->assertSee('tinggi maksimal 3000 piksel')
        ->assertSee('aspect-[4/5]', false)
        ->assertSee('object-contain', false)
        ->assertDontSee('1200 × 600 piksel');
});
