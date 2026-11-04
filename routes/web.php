<?php

use App\Http\Controllers\Admin\CalendarController as AdminCalendarController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HeroController as AdminHeroController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WebsiteSettingController as AdminWebsiteSettingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProgramController;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Route;

// Selalu buka beranda publik, termasuk saat admin sedang login.
Route::redirect('/', '/dashboard')->name('home');

Route::get('/profil', function () {
    return view('profil', ['settings' => WebsiteSetting::allAsArray()]);
})->name('profil');

Route::get('/program', [ProgramController::class, 'programs'])->name('programs.index');

// Keep previously shared links working while the catalog uses one canonical URL.
Route::redirect('/program1', '/program')->name('program1');
Route::redirect('/program2', '/program')->name('program2');
Route::redirect('/program/nasional', '/program')->name('program.nasional');
Route::redirect('/program/internasional', '/program')->name('program.internasional');
Route::get('/program/detail/{program}', [ProgramController::class, 'show'])->name('program.show');

Route::get('/kalender-program', [CalendarController::class, 'index'])->name('kalender-program');
Route::get('/pencarian/program', [ProgramController::class, 'search'])->name('search.programs');
Route::get('/csrf-token', fn () => response()
    ->json(['token' => csrf_token()])
    ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0'))
    ->name('csrf.refresh');

Route::get('/pendaftaran', [ProgramController::class, 'registration'])->name('pendaftaran');
Route::post('/pendaftaran', [ProgramController::class, 'storeRegistration'])->name('pendaftaran.store');

Route::get('/pendaftaran/{registration}/pembayaran', [ProgramController::class, 'payment'])->name('pendaftaran.payment');
Route::post('/pendaftaran/{registration}/notifikasi', [\App\Http\Controllers\PaymentPushController::class, 'store'])
    ->middleware(['signed', 'throttle:15,1'])->name('pendaftaran.push');
Route::post('/pendaftaran/{registration}/pembayaran', [ProgramController::class, 'storePayment'])->name('pendaftaran.payment.store');
Route::post('/pendaftaran/{registration}/batal', [ProgramController::class, 'cancelPayment'])->name('pendaftaran.cancel');

Route::get('dashboard', [ProgramController::class, 'index'])
    ->name('dashboard');

Route::redirect('/cms', '/admin')->name('cms');

Route::get('/testimoni/{token}', [\App\Http\Controllers\TestimonialFormController::class, 'show'])->name('testimoni.show');
Route::post('/testimoni/{token}', [\App\Http\Controllers\TestimonialFormController::class, 'store'])->name('testimoni.store');
Route::redirect('/login', '/cms/login');

Route::post('/pendaftaran/kurangi-kuota', [ProgramController::class, 'decrementQuota'])
    ->name('pendaftaran.decrement-quota');

Route::get('/fakultas/{slug}', [ProgramController::class, 'faculty'])
    ->name('faculty.show');

Route::middleware(['auth', 'verified'])
    ->middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/analytics', AnalyticsController::class)->name('analytics');
        Route::get('/analytics/export/excel', [AnalyticsController::class, 'exportExcel'])->name('analytics.export');
        Route::get('/dashboard-analitik', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/hero', [AdminHeroController::class, 'edit'])->name('hero.edit');
        Route::put('/hero', [AdminHeroController::class, 'update'])->name('hero.update');
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/missions', [AdminProfileController::class, 'updateMissions'])->name('profile.missions.update');
        Route::post('/programs/{program}/duplicate', [AdminProgramController::class, 'duplicate'])->name('programs.duplicate');
        Route::post('/programs/{program}/send-testimonials', [AdminProgramController::class, 'sendTestimonialEmails'])->name('programs.send-testimonials');
        Route::resource('programs', AdminProgramController::class);
        Route::resource('testimonials', TestimonialController::class)->except('show');
        Route::put('/testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
        Route::put('/testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
        Route::get('/registrations/export/excel', [AdminRegistrationController::class, 'exportExcel'])->name('registrations.export.excel');
        Route::get('/registrations/export/pdf', [AdminRegistrationController::class, 'exportPdf'])->name('registrations.export.pdf');
        Route::put('/registrations/{registration}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
        Route::put('/registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
        Route::resource('registrations', AdminRegistrationController::class)->only(['index', 'show', 'edit', 'update']);
        Route::get('/settings', [AdminWebsiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminWebsiteSettingController::class, 'update'])->name('settings.update');
        Route::get('/calendar', [AdminCalendarController::class, 'index'])->name('calendar.index');
        Route::resource('trainers', \App\Http\Controllers\Admin\TrainerController::class);
        Route::patch('partner-discounts/{partnerDiscount}/toggle', [\App\Http\Controllers\Admin\PartnerDiscountController::class, 'toggle'])->name('partner-discounts.toggle');
        Route::resource('partner-discounts', \App\Http\Controllers\Admin\PartnerDiscountController::class);
    });

require __DIR__.'/settings.php';

// Public feedback route
Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/admin/feedbacks', [\App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('admin.feedbacks.index')->middleware(['auth', 'verified', 'admin']);
Route::get('/admin/feedbacks/{feedback}/attachment', [\App\Http\Controllers\Admin\FeedbackController::class, 'attachment'])->name('admin.feedbacks.attachment')->middleware(['auth', 'verified', 'admin']);
Route::delete('/admin/feedbacks/{feedback}', [\App\Http\Controllers\Admin\FeedbackController::class, 'destroy'])->name('admin.feedbacks.destroy')->middleware(['auth', 'verified', 'admin']);

Route::get('/storage/{path}', function (string $path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    $normalizedPath = ltrim($path, '/\\');

    if (str_contains($normalizedPath, '..') || ! $disk->exists($normalizedPath)) {
        abort(404);
    }

    return response()->file($disk->path($normalizedPath));
})->where('path', '.*')->name('storage.local');
