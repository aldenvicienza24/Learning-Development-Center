<?php

use App\Models\Program;

test('the public navbar exposes the global search interface', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('data-site-search-open', false)
        ->assertSee('id="siteSearchDialog"', false)
        ->assertSee('id="siteSearchInput"', false)
        ->assertSee('__siteSearchInitialized', false);
});

test('global search returns matching public programs and excludes closed programs', function () {
    Program::query()->create([
        'title' => 'Pelatihan Analisis Data',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/data.jpg',
        'registration_date' => '1 - 30 September',
        'description' => 'Belajar analisis data untuk kebutuhan profesional.',
        'price' => 500000,
        'quota' => 12,
        'total_quota' => 12,
        'detail_url' => 'pelatihan-analisis-data',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    Program::query()->create([
        'title' => 'Pelatihan Data Lama',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/closed-data.jpg',
        'registration_date' => 'Selesai',
        'description' => 'Program yang sudah ditutup.',
        'price' => 500000,
        'quota' => 0,
        'total_quota' => 12,
        'detail_url' => 'pelatihan-data-lama',
        'status' => 'closed',
        'is_registration_closed' => true,
        'is_international' => false,
    ]);

    $this->getJson(route('search.programs', ['q' => 'analisis data', 'lang' => 'id']))
        ->assertOk()
        ->assertJsonCount(1, 'programs')
        ->assertJsonPath('programs.0.title', 'Pelatihan Analisis Data')
        ->assertJsonPath('programs.0.status', 'Pendaftaran dibuka')
        ->assertJsonStructure([
            'programs' => [[
                'title', 'meta', 'status', 'url', 'international',
            ]],
        ]);

    $this->getJson(route('search.programs', ['q' => 'a']))
        ->assertOk()
        ->assertExactJson(['programs' => []]);
});
