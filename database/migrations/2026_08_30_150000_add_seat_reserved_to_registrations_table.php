<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('ALTER TABLE registrations ADD COLUMN seat_reserved INTEGER NOT NULL DEFAULT 0');
        } else {
            Schema::table('registrations', function (Blueprint $table): void {
                $table->boolean('seat_reserved')->default(false)->after('status');
            });
        }

        DB::transaction(function (): void {
            $reservedStatuses = ['menunggu_verifikasi', 'diproses', 'diterima'];

            DB::table('registrations')
                ->where(function ($query) use ($reservedStatuses): void {
                    $query->whereIn('participant_status', $reservedStatuses)
                        ->orWhereIn('status', $reservedStatuses);
                })
                ->update(['seat_reserved' => true]);

            $pendingRegistrations = DB::table('registrations')
                ->where('status', 'menunggu_pembayaran')
                ->orderBy('created_at')
                ->get();

            foreach ($pendingRegistrations as $registration) {
                if ($registration->created_at < now()->subMinutes(15)->toDateTimeString()) {
                    DB::table('registrations')->where('id', $registration->id)->update([
                        'status' => 'ditolak',
                        'participant_status' => 'ditolak',
                        'payment_status' => 'ditolak',
                        'seat_reserved' => false,
                        'updated_at' => now(),
                    ]);

                    continue;
                }

                $program = DB::table('programs')->where('id', $registration->program_id)->first();

                if (! $program || (int) $program->quota <= 0) {
                    DB::table('registrations')->where('id', $registration->id)->update([
                        'status' => 'ditolak',
                        'participant_status' => 'ditolak',
                        'payment_status' => 'ditolak',
                        'seat_reserved' => false,
                        'updated_at' => now(),
                    ]);

                    continue;
                }

                $remainingQuota = (int) $program->quota - 1;
                $programUpdates = [
                    'quota' => $remainingQuota,
                    'updated_at' => now(),
                ];

                if ($remainingQuota <= 0) {
                    $programUpdates['status'] = 'closed';
                    $programUpdates['is_registration_closed'] = true;
                }

                DB::table('programs')->where('id', $program->id)->update($programUpdates);
                DB::table('registrations')->where('id', $registration->id)->update([
                    'seat_reserved' => true,
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('registrations', function (Blueprint $table): void {
                $table->dropColumn('seat_reserved');
            });
        }
    }
};
