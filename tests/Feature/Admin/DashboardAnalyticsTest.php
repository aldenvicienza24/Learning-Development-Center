<?php

use App\Models\PageView;
use App\Models\Program;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function analyticsProgram(array $overrides = []): Program
{
    return Program::query()->create(array_merge([
        'title' => 'Sertifikasi Data', 'category' => 'sertifikasi',
        'image_url' => '/test.jpg', 'registration_date' => 'September',
        'price' => 250000, 'quota' => 8, 'total_quota' => 10, 'detail_url' => 'data',
    ], $overrides));
}

function analyticsRegistration(Program $program, string $date, string $payment, ?string $visitorId = null): Registration
{
    $registration = Registration::query()->create([
        'program_id' => $program->id, 'full_name' => 'Private Person',
        'visitor_id' => $visitorId,
        'email' => 'private@example.com', 'phone' => '08123456789', 'institution' => 'Private Institution',
        'participant_status' => 'menunggu_verifikasi', 'payment_status' => $payment,
        'payment_amount' => $payment === 'disetujui' ? $program->price : null,
        'payment_received_at' => $payment === 'disetujui' ? substr($date, 0, 10) : null,
    ]);
    $registration->forceFill(['created_at' => $date])->save();

    return $registration;
}

function analyticsQuery(array $overrides = []): array
{
    return array_merge(['start_date' => '2026-01-01', 'end_date' => '2026-03-31', 'interval' => 'month'], $overrides);
}

test('analytics requires an authenticated admin', function () {
    $this->getJson(route('admin.analytics', analyticsQuery()))->assertRedirect('/cms/login');
    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->getJson(route('admin.analytics', analyticsQuery()))->assertForbidden();
});

test('visitor tracking records public pages and ignores the admin area', function () {
    $this->get(route('dashboard'))->assertOk();

    expect(PageView::query()->count())->toBe(1)
        ->and(PageView::query()->firstOrFail()->program_id)->toBeNull();

    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->get(route('admin.analytics.index'))
        ->assertOk();

    expect(PageView::query()->count())->toBe(1);
});

test('analytics respects inclusive dates and combines program and category filters', function () {
    $this->travelTo(now()->setDate(2026, 9, 13));
    $program = analyticsProgram();
    $other = analyticsProgram(['title' => 'Pelatihan Desain', 'category' => 'pelatihan']);
    analyticsRegistration($program, '2025-12-31 23:59:59', 'disetujui');
    analyticsRegistration($program, '2026-01-01 00:00:00', 'disetujui');
    analyticsRegistration($program, '2026-03-31 23:59:59', 'menunggu_verifikasi');
    analyticsRegistration($program, '2026-04-01 00:00:00', 'disetujui');
    analyticsRegistration($other, '2026-02-01 12:00:00', 'disetujui');

    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $response = $this->getJson(route('admin.analytics', analyticsQuery([
        'program_id' => $program->id, 'category' => 'sertifikasi',
    ])))->assertOk()->assertJsonPath('summary.registrations', 2)
        ->assertJsonPath('summary.approved', 1)->assertJsonPath('summary.actual_revenue', 250000)
        ->assertJsonPath('summary.occupancy_rate', 20)->assertJsonCount(1, 'programs')
        ->assertJsonPath('charts.revenue_trend.data.0.x', ['2026-01', '2026-02', '2026-03'])
        ->assertJsonPath('periods.0.registrations', 1)->assertJsonPath('periods.1.registrations', 0)->assertJsonPath('periods.2.registrations', 1)
        ->assertJsonPath('charts.revenue_trend.data.0.y', [250000, 0, 0]);
    expect($response->getContent())->not->toContain('Private Person', 'private@example.com', '08123456789');
    expect($response->headers->get('Cache-Control'))->toContain('no-store', 'private');

    $this->getJson(route('admin.analytics', analyticsQuery(['category' => 'pelatihan'])))
        ->assertOk()->assertJsonPath('summary.registrations', 1)->assertJsonPath('programs.0.id', $other->id);
    $this->getJson(route('admin.analytics', analyticsQuery(['program_id' => $program->id, 'category' => 'pelatihan'])))
        ->assertUnprocessable()->assertJsonValidationErrors('program_id');
});

test('analytics handles empty periods and keeps quota as a current snapshot', function () {
    $program = analyticsProgram();
    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->getJson(route('admin.analytics', analyticsQuery(['program_id' => $program->id])))
        ->assertOk()->assertJsonPath('empty', true)->assertJsonPath('summary.registrations', 0)
        ->assertJsonPath('summary.approval_rate', null)->assertJsonPath('summary.occupancy_rate', 20)
        ->assertJsonPath('charts.popular_programs.data', [])->assertJsonCount(5, 'charts')
        ->assertJsonPath('charts.visitor_activity.data.0.x', [0, 0, 0])
        ->assertJsonPath('snapshot.occupied', 2);
});

test('analytics reports conducted training from execution dates in the selected period', function () {
    analyticsProgram(['title' => 'Pelatihan Dalam Periode', 'execution_date' => '2026-02-15']);
    analyticsProgram(['title' => 'Pelatihan Di Luar Periode', 'execution_date' => '2026-04-01']);
    analyticsProgram(['title' => 'Pelatihan Tanpa Jadwal', 'execution_date' => null]);

    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->getJson(route('admin.analytics', analyticsQuery()))
        ->assertOk()
        ->assertJsonPath('summary.conducted_programs', 1)
        ->assertJsonPath('empty', false);

    $this->get(route('admin.analytics.index'))
        ->assertOk()
        ->assertSee('Aktivitas')
        ->assertSee('Keuangan')
        ->assertSee('Jumlah pelatihan dilaksanakan')
        ->assertSee('Jumlah pendaftar per pelatihan')
        ->assertSee('Pelatihan dengan pendapatan tertinggi')
        ->assertSee('Lihat data aktivitas')
        ->assertSee('Lihat data keuangan')
        ->assertSee('Kinerja trafik situs web')
        ->assertSee('Pendaftar dari situs web')
        ->assertSee('Tingkat konversi')
        ->assertSee('Pelatihan paling sering dilihat')
        ->assertSee('Volume interaksi')
        ->assertSee('Lihat data pengunjung')
        ->assertSee('Oranye = melebihi kapasitas')
        ->assertDontSee('Corong Konversi')
        ->assertDontSee('Pembayaran &amp; Peserta', false)
        ->assertDontSee('Kapasitas seluruh program');
});

test('visitor analytics attributes website registrations and calculates conversion', function () {
    $first = analyticsProgram(['title' => 'Pelatihan Analitik']);
    $second = analyticsProgram(['title' => 'Pelatihan Desain']);
    analyticsRegistration($first, '2026-01-12 09:00:00', 'menunggu_verifikasi', 'session-one');
    analyticsRegistration($second, '2026-01-14 09:00:00', 'menunggu_verifikasi');

    DB::table('page_views')->insert([
        ['session_id' => 'session-one', 'url' => '/', 'program_id' => null, 'created_at' => '2026-01-05 08:00:00', 'updated_at' => '2026-01-05 08:00:00'],
        ['session_id' => 'session-one', 'url' => '/program/analitik', 'program_id' => $first->id, 'created_at' => '2026-01-10 08:00:00', 'updated_at' => '2026-01-10 08:00:00'],
        ['session_id' => 'session-two', 'url' => '/program/analitik', 'program_id' => $first->id, 'created_at' => '2026-02-10 08:00:00', 'updated_at' => '2026-02-10 08:00:00'],
        ['session_id' => 'session-three', 'url' => '/program/desain', 'program_id' => $second->id, 'created_at' => '2026-01-20 08:00:00', 'updated_at' => '2026-01-20 08:00:00'],
        ['session_id' => 'session-admin', 'url' => '/admin/dashboard-analitik', 'program_id' => null, 'created_at' => '2026-01-22 08:00:00', 'updated_at' => '2026-01-22 08:00:00'],
    ]);

    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $response = $this->getJson(route('admin.analytics', analyticsQuery()))
        ->assertOk()
        ->assertJsonPath('visitors.total_visitors', 3)
        ->assertJsonPath('visitors.training_page_views', 3)
        ->assertJsonPath('visitors.total_registrants', 2)
        ->assertJsonPath('visitors.website_registrants', 1)
        ->assertJsonPath('visitors.converted_visitors', 1)
        ->assertJsonPath('visitors.conversion_rate', 33.33)
        ->assertJsonPath('visitors.attribution_available', true)
        ->assertJsonPath('visitors.scope', 'all_website_pages')
        ->assertJsonPath('visitors.periods.0.unique_visitors', 2)
        ->assertJsonPath('visitors.periods.0.registrations', 2)
        ->assertJsonPath('visitors.periods.0.website_registrants', 1)
        ->assertJsonPath('visitors.periods.0.conversion_rate', 50)
        ->assertJsonPath('visitors.popular_training_views.0.program_id', $first->id)
        ->assertJsonPath('visitors.popular_training_views.0.views', 2)
        ->assertJsonPath('charts.visitor_activity.data.0.x', [3, 3, 1]);
    $this->getJson(route('admin.analytics', analyticsQuery(['program_id' => $first->id])))
        ->assertOk()
        ->assertJsonPath('visitors.total_visitors', 2)
        ->assertJsonPath('visitors.training_page_views', 2)
        ->assertJsonPath('visitors.website_registrants', 1)
        ->assertJsonPath('visitors.conversion_rate', 50)
        ->assertJsonPath('visitors.scope', 'filtered_program_pages')
        ->assertJsonCount(1, 'visitors.popular_training_views');
});

test('analytics excel export contains native charts and filtered data sheets', function () {
    $program = analyticsProgram(['execution_date' => '2026-02-15']);
    analyticsRegistration($program, '2026-02-10 09:00:00', 'disetujui');

    $response = $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->get(route('admin.analytics.export', analyticsQuery()))
        ->assertOk()
        ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
        ->assertDownload('dashboard-uisi-2026-01-01-2026-03-31.xlsx');

    $path = tempnam(sys_get_temp_dir(), 'dashboard-xlsx-');
    file_put_contents($path, $response->streamedContent());
    $archive = new ZipArchive;
    expect($archive->open($path))->toBeTrue();
    expect($archive->locateName('xl/charts/chart1.xml'))->not->toBeFalse();
    expect($archive->locateName('xl/charts/chart4.xml'))->not->toBeFalse();
    expect($archive->getFromName('xl/workbook.xml'))->toContain('Dasbor Grafik', 'Per Pelatihan', 'Tren Bulanan');
    expect($archive->getFromName('xl/workbook.xml'))->toContain('ProgramList');
    expect($archive->getFromName('xl/worksheets/sheet1.xml'))->toContain('dataValidations', 'ProgramList');
    expect($archive->getFromName('xl/worksheets/sheet2.xml'))->toContain('MATCH(', 'SUMIFS(');
    $archive->close();
    unlink($path);
});

test('status filters reconcile with program and period details and participant links', function () {
    $program = analyticsProgram(['is_international' => true]);
    $national = analyticsProgram(['title' => 'Program Nasional', 'is_international' => false]);
    $accepted = analyticsRegistration($program, '2026-02-01 08:00:00', 'disetujui');
    $accepted->update(['participant_status' => '', 'status' => 'diterima']);
    analyticsRegistration($program, '2026-02-02 08:00:00', 'menunggu_verifikasi');
    analyticsRegistration($program, '2026-02-03 08:00:00', 'disetujui');
    analyticsRegistration($national, '2026-02-01 08:00:00', 'disetujui');
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $response = $this->getJson(route('admin.analytics', analyticsQuery([
        'program_id' => $program->id, 'payment_status' => 'disetujui', 'participant_status' => 'diterima',
        'interval' => 'week', 'start_date' => '2026-01-31', 'end_date' => '2026-02-09',
    ])))->assertOk()->assertJsonPath('summary.registrations', 1)->assertJsonPath('summary.accepted', 1)
        ->assertJsonPath('summary.pending', 0)->assertJsonPath('summary.actual_revenue', 250000)
        ->assertJsonPath('programs.0.payments.disetujui', 1)->assertJsonPath('programs.0.participants.diterima', 1)
        ->assertJsonPath('periods.0.start_date', '2026-01-31')->assertJsonPath('periods.0.end_date', '2026-02-01')
        ->assertJsonPath('periods.2.end_date', '2026-02-09')->assertJsonCount(1, 'snapshot.programs');
    expect(collect($response->json('periods'))->sum('registrations'))->toBe(1);
    expect(collect($response->json('payment_breakdown'))->sum('count'))->toBe(1);
    expect(collect($response->json('participant_breakdown'))->sum('count'))->toBe(1);
    parse_str(parse_url($response->json('programs.0.participants_url'), PHP_URL_QUERY), $query);
    expect($query)->toMatchArray([
        'program_id' => (string) $program->id, 'date_from' => '2026-01-31', 'date_to' => '2026-02-09',
        'payment_status' => 'disetujui', 'participant_status' => 'diterima',
    ]);
    $this->get($response->json('programs.0.participants_url'))->assertOk()->assertViewHas('registrations', fn ($rows) => $rows->total() === 1);
    // Old bookmarked scope filters must no longer exclude programs.
    $this->getJson(route('admin.analytics', analyticsQuery(['scope' => 'national'])))
        ->assertOk()->assertJsonPath('summary.registrations', 4)->assertJsonCount(2, 'snapshot.programs');
});

test('analytics validates dates and filter values before calculation', function () {
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    foreach ([
        ['start_date' => '2026-04-01'], ['start_date' => '2026-02-30'], ['end_date' => '2999-01-01'],
        ['interval' => 'invalid'], ['program_id' => 99999], ['category' => 'invalid'],
        ['payment_status' => 'invalid'], ['participant_status' => 'invalid'],
    ] as $invalid) {
        $this->getJson(route('admin.analytics', analyticsQuery($invalid)))->assertUnprocessable();
    }
    $this->getJson(route('admin.analytics', analyticsQuery(['start_date' => '2000-01-01'])))
        ->assertUnprocessable();
});

test('analytics failure is recoverable without exposing server details', function () {
    config(['analytics.engine' => 'python', 'analytics.python_binary' => base_path('missing-private-runtime/python')]);
    $response = $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->getJson(route('admin.analytics', analyticsQuery()))->assertStatus(503);
    expect($response->getContent())->not->toContain('missing-private-runtime', base_path());
    $this->get(route('admin.analytics.index'))->assertOk()->assertSee('Filter lainnya');
});

test('hosting analytics works without an available python executable', function () {
    // A cached pre-update config has no engine key; PHP must still be the default.
    config(['analytics' => ['python_binary' => base_path('missing-private-runtime/python'), 'timeout' => 20]]);
    $program = analyticsProgram();
    analyticsRegistration($program, '2026-02-01 10:00:00', 'disetujui');
    $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->getJson(route('admin.analytics', analyticsQuery()))->assertOk()
        ->assertJsonPath('summary.actual_revenue', 250000)
        ->assertJsonPath('charts.revenue_trend.data.0.y', [0, 250000, 0]);
});

test('analytics combines different timestamps and fallback statuses into the same daily totals', function () {
    $program = analyticsProgram();
    $first = analyticsRegistration($program, '2026-01-15 09:00:00', 'disetujui');
    $second = analyticsRegistration($program, '2026-01-15 17:30:00', 'disetujui');
    $first->update(['payment_amount' => 100000, 'payment_received_at' => '2026-02-01', 'participant_status' => '', 'status' => 'diterima']);
    $second->update(['payment_amount' => 200000, 'payment_received_at' => '2026-02-01', 'participant_status' => 'diterima']);
    analyticsRegistration($program, '2026-01-15 20:00:00', 'menunggu_verifikasi');
    $response = $this->actingAs(User::factory()->create(['is_admin' => true]))
        ->getJson(route('admin.analytics', analyticsQuery(['interval' => 'day', 'start_date' => '2026-01-15', 'end_date' => '2026-02-01'])))
        ->assertOk()->assertJsonPath('summary.registrations', 3)
        ->assertJsonPath('summary.accepted', 2)->assertJsonPath('summary.pending', 1)
        ->assertJsonPath('summary.actual_revenue', 300000)->assertJsonPath('summary.receipt_count', 2)
        ->assertJsonPath('periods.0.registrations', 3)->assertJsonPath('periods.0.actual_revenue', 0);
    expect(collect($response->json('periods'))->last())->toMatchArray(['actual_revenue' => 300000, 'receipt_count' => 2]);
});

test('approved income follows receipt date and stays fixed when program prices change', function () {
    $program = analyticsProgram();
    $registration = analyticsRegistration($program, '2025-12-10 10:00:00', 'disetujui');
    $registration->update(['payment_amount' => 175000, 'payment_received_at' => '2026-02-15']);
    $program->update(['price' => 990000]);
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $query = analyticsQuery(['program_id' => $program->id]);
    $this->getJson(route('admin.analytics', $query))->assertOk()
        ->assertJsonPath('summary.actual_revenue', 175000)->assertJsonPath('summary.registrations', 0)
        ->assertJsonPath('summary.receipt_count', 1)->assertJsonPath('periods.1.actual_revenue', 175000)
        ->assertJsonPath('charts.revenue_trend.data.0.y', [0, 175000, 0]);
    $registration->update(['payment_status' => 'ditolak', 'participant_status' => 'ditolak']);
    $this->getJson(route('admin.analytics', $query))->assertOk()->assertJsonPath('summary.actual_revenue', 0);
});

test('legacy approved payments are included at a frozen tariff without inventing a receipt date', function () {
    $program = analyticsProgram();
    $registration = analyticsRegistration($program, '2026-01-10 10:00:00', 'disetujui');
    DB::table('registrations')->where('id', $registration->id)
        ->update(['payment_amount' => null, 'payment_received_at' => null]);
    $migration = require database_path('migrations/2026_09_14_000002_record_approved_program_tariffs.php');
    $migration->up();
    expect($registration->fresh()->payment_amount)->toBe(250000)
        ->and($registration->fresh()->payment_received_at)->toBeNull();
    $program->update(['price' => 900000]);
    $migration->up();
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $query = analyticsQuery(['program_id' => $program->id]);
    $this->getJson(route('admin.analytics', $query))->assertOk()
        ->assertJsonPath('summary.actual_revenue', 250000)->assertJsonPath('summary.missing_receipts', 0)
        ->assertJsonPath('summary.legacy_receipt_dates', 1)->assertJsonPath('periods.0.actual_revenue', 250000);
    $registration->refresh()->update(['payment_amount' => 0, 'payment_received_at' => '2026-01-10']);
    $migration->up();
    $this->getJson(route('admin.analytics', $query))->assertOk()->assertJsonPath('summary.actual_revenue', 0)
        ->assertJsonPath('summary.legacy_receipt_dates', 0)->assertJsonPath('summary.receipt_count', 1);
});

test('payment approval records the tariff automatically and does not double count retries', function () {
    $program = analyticsProgram();
    $registration = analyticsRegistration($program, '2026-01-10 10:00:00', 'menunggu_verifikasi');
    $this->actingAs(User::factory()->create(['is_admin' => true]));
    $url = route('admin.registrations.approve', $registration);
    $this->put($url, [])->assertSessionHasNoErrors()->assertSessionHas('status', 'Peserta berhasil disetujui.');
    expect($registration->fresh()->payment_amount)->toBe(250000)
        ->and($registration->fresh()->payment_received_at->toDateString())->toBe(today()->toDateString());
    $this->putJson($url, ['payment_amount' => -1, 'payment_received_at' => '2999-01-01'])
        ->assertUnprocessable()->assertJsonValidationErrors(['payment_amount', 'payment_received_at']);
    expect($registration->fresh()->payment_amount)->toBe(250000);
    foreach ([1, 2] as $attempt) {
        $this->put($url, ['payment_amount' => 180000, 'payment_received_at' => '2026-02-01'])
            ->assertSessionHasNoErrors()->assertSessionHas('status', 'Peserta berhasil disetujui.');
    }
    $this->getJson(route('admin.analytics', analyticsQuery()))->assertOk()
        ->assertJsonPath('summary.actual_revenue', 180000)->assertJsonPath('summary.receipt_count', 1);
    $this->get(route('admin.registrations.edit', $registration))->assertOk()->assertSee('180000');
});
