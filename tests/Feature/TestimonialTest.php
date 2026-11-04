<?php

use App\Models\Program;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake('public'));

function testimonialProgram(string $title): Program
{
    return Program::create([
        'title' => $title, 'category' => 'sertifikasi', 'price' => 250000,
        'image_url' => '/test.jpg', 'registration_date' => 'September',
        'quota' => 30, 'total_quota' => 30, 'detail_url' => $title,
    ]);
}

test('only admins can manage program documentation', function () {
    $this->get(route('admin.testimonials.index'))->assertRedirect('/cms/login');
    $testimonial = testimonialProgram('Program uji')->testimonials()->create(['body' => 'Kegiatan program']);
    $this->actingAs(User::factory()->create(['is_admin' => false]));
    $this->get(route('admin.testimonials.index'))->assertForbidden();
    $this->post(route('admin.testimonials.store'), [])->assertForbidden();
    $this->put(route('admin.testimonials.update', $testimonial), [])->assertForbidden();
    $this->delete(route('admin.testimonials.destroy', $testimonial))->assertForbidden();
});

test('admins publish photos description and comments without author fields and preserve photos on edit', function () {
    $program = testimonialProgram('Sertifikasi Data');
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $this->get(route('admin.testimonials.create'))->assertOk()->assertDontSee('name="author_name"', false)->assertDontSee('name="author_role"', false);
    $data = ['program_id' => $program->id, 'body' => 'Pelaksanaan pelatihan dan praktik bersama.', 'comments' => ['Sesi praktik membantu.', 'Diskusi berjalan aktif.', ' '], 'is_published' => 1];
    $this->post(route('admin.testimonials.store'), $data + ['photos' => [UploadedFile::fake()->image('kegiatan.jpg'), UploadedFile::fake()->image('diskusi.png')]])->assertRedirect(route('admin.testimonials.index'));
    $testimonial = Testimonial::firstOrFail();
    expect($testimonial->author_name)->toBeNull();
    expect($testimonial->comments)->toBe(['Sesi praktik membantu.', 'Diskusi berjalan aktif.']);
    expect($testimonial->photos)->toHaveCount(2);
    foreach ($testimonial->photos as $path) Storage::disk('public')->assertExists($path);
    $this->get(route('dashboard'))->assertOk()->assertSee($data['body'])->assertSee('Sesi praktik membantu.')->assertSee($testimonial->photos[0]);
    $photos = $testimonial->photos;
    $data['comments'] = ['Komentar diperbarui'];
    $this->put(route('admin.testimonials.update', $testimonial), $data)->assertRedirect();
    expect($testimonial->fresh()->photos)->toBe($photos);
    $data['is_published'] = 0;
    $this->put(route('admin.testimonials.update', $testimonial), $data + ['remove_photos' => [$photos[0]]])->assertRedirect();
    Storage::disk('public')->assertMissing($photos[0]);
    Storage::disk('public')->assertExists($photos[1]);
    $this->get(route('dashboard'))->assertDontSee($data['body']);
    $this->delete(route('admin.testimonials.destroy', $testimonial))->assertRedirect(route('admin.testimonials.index'));
    Storage::disk('public')->assertMissing($photos[1]);
    $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
});

test('documentation validates photos and comments and cannot delete photos belonging to another record', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $program = testimonialProgram('Program validasi');
    $data = ['program_id' => $program->id, 'body' => 'Dokumentasi kegiatan', 'is_published' => 1];
    $this->post(route('admin.testimonials.store'), $data)->assertSessionHasErrors('photos');
    $this->post(route('admin.testimonials.store'), $data + ['photos' => [UploadedFile::fake()->create('berkas.pdf', 10, 'application/pdf')]])->assertSessionHasErrors('photos.0');
    $this->post(route('admin.testimonials.store'), $data + ['comments' => [str_repeat('x', 401)]])->assertSessionHasErrors('comments.0');
    $this->post(route('admin.testimonials.store'), ['program_id' => 99999, 'body' => ''])->assertSessionHasErrors(['program_id', 'body']);
    $this->assertDatabaseCount('testimonials', 0);
    $otherPhoto = UploadedFile::fake()->image('other.jpg')->store('program-documentation', 'public');
    $other = $program->testimonials()->create(['body' => 'Dokumentasi lain', 'photos' => [$otherPhoto]]);
    $draft = $program->testimonials()->create(['body' => 'Draf tanpa foto']);
    $this->put(route('admin.testimonials.update', $draft), ['program_id' => $program->id, 'body' => 'Ubah', 'remove_photos' => [$otherPhoto]])->assertSessionHasErrors('remove_photos.0');
    Storage::disk('public')->assertExists($otherPhoto);
    expect($other->fresh()->photos)->toBe([$otherPhoto]);
});

test('drafts may have no photos but combined old and new photos cannot exceed six', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $program = testimonialProgram('Program foto');
    $data = ['program_id' => $program->id, 'body' => 'Draf kegiatan'];
    $this->post(route('admin.testimonials.store'), $data)->assertRedirect();
    $draft = Testimonial::firstOrFail();
    expect($draft->is_published)->toBeFalse();
    $draft->update(['photos' => array_fill(0, 6, 'program-documentation/existing.jpg')]);
    $this->put(route('admin.testimonials.update', $draft), $data + ['photos' => [UploadedFile::fake()->image('extra.jpg')]])->assertSessionHasErrors('photos');
    expect(Storage::disk('public')->allFiles())->toBe([]);
});

test('public documentation includes all published cards in the slider and filters with safe comments', function () {
    $first = testimonialProgram('Program Pertama');
    $second = testimonialProgram('Program Kedua');
    $first->testimonials()->create(['body' => 'Konten belum dipublikasikan', 'is_published' => false]);
    $first->testimonials()->create(['body' => 'Cerita program pertama', 'is_published' => true]);
    for ($i = 1; $i <= 7; $i++) {
        $second->testimonials()->create(['body' => 'Kegiatan kedua '.$i, 'comments' => ['<script>alert("test")</script>'], 'is_published' => true]);
    }
    $this->get(route('dashboard', ['testimonial_program' => $second->id]))->assertOk()
        ->assertDontSee('Konten belum dipublikasikan')->assertDontSee('Cerita program pertama')
        ->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert("test")</script>', false)
        ->assertSeeInOrder(['id="programPendaftaran"', 'id="testimoni"', 'id="fakultasKelas"'], false)
        ->assertSee('data-documentation-slider', false)
        ->assertSee('Kegiatan kedua 1')->assertSee('Kegiatan kedua 7')
        ->assertViewHas('testimonials', fn ($rows) => $rows->count() === 7);
    $this->get(route('dashboard'))
        ->assertOk()->assertSee('Cerita program pertama')
        ->assertDontSee('Konten belum dipublikasikan')
        ->assertViewHas('testimonials', fn ($rows) => $rows->count() === 8);
});

test('documentation images use the current website host instead of a stale storage host', function () {
    config(['filesystems.disks.public.url' => 'http://unreachable-old-site.test/storage']);
    $program = testimonialProgram('Program gambar');
    $item = $program->testimonials()->create(['body' => 'Dokumentasi foto', 'photos' => ['program-documentation/photo.jpg'], 'is_published' => true]);
    $this->get('http://localhost/dashboard')->assertOk()
        ->assertSee('http://localhost/storage/program-documentation/photo.jpg', false)
        ->assertDontSee('unreachable-old-site.test');
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $this->get('http://localhost/admin/testimonials/'.$item->id.'/edit')->assertOk()
        ->assertSee('http://localhost/storage/program-documentation/photo.jpg', false)
        ->assertDontSee('unreachable-old-site.test');
});

test('public storage route serves files correctly and prevents traversal', function () {
    \Illuminate\Support\Facades\Storage::fake('public');
    \Illuminate\Support\Facades\Storage::disk('public')->put('program-documentation/sample.jpg', 'fake-image-content');

    $this->get('/storage/program-documentation/sample.jpg')
        ->assertOk();

    $this->get('/storage/nonexistent.jpg')
        ->assertNotFound();

    $this->get('/storage/../secret.txt')
        ->assertNotFound();
});
