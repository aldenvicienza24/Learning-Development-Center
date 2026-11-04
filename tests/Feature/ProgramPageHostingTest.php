<?php

use App\Models\Program;
use App\Models\Trainer;

test('program details and both faculty language views work after the scope column is removed', function () {
    $program = Program::create([
        'title' => 'Program halaman hosting', 'slug' => 'hosting-page',
        'category' => 'pelatihan', 'faculty' => 'teknologi-kreatif',
        'image_url' => '/images/hero-bg.jpg', 'registration_date' => 'Segera',
        'price' => 250000, 'quota' => 10, 'total_quota' => 10,
        'detail_url' => 'hosting-page', 'status' => 'open_registration',
    ]);
    $trainer = Trainer::create([
        'name' => 'Trainer Halaman Program',
        'photo' => 'trainers/photos/halaman-program.jpg',
        'scopes' => ['pelatihan'],
    ]);
    $program->trainers()->attach($trainer);

    $this->get(route('program.show', $program))->assertOk()->assertSee($program->title);
    foreach (['nasional', 'internasional'] as $type) {
        $this->get(route('faculty.show', ['slug' => 'teknologi-kreatif', 'type' => $type]))
            ->assertOk()->assertSee($program->title);
    }

    foreach (['program.nasional', 'program.internasional'] as $routeName) {
        $this->get(route($routeName))
            ->assertOk()
            ->assertSee('data-program-trainers', false)
            ->assertSee('Trainer Halaman Program')
            ->assertSee('/storage/trainers/photos/halaman-program.jpg', false);
    }
});
