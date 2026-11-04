<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProgramSeatService
{
    private ?bool $tracksReservationState = null;

    public function tracksReservationState(): bool
    {
        if ($this->tracksReservationState !== null) {
            return $this->tracksReservationState;
        }

        try {
            $connection = DB::connection();
            $driver = $connection->getDriverName();

            $exists = match ($driver) {
                'mysql' => $connection->selectOne(
                    'select 1 as column_exists from information_schema.columns where table_schema = database() and table_name = ? and column_name = ? limit 1',
                    ['registrations', 'seat_reserved']
                ) !== null,
                'sqlite' => collect($connection->select("PRAGMA table_info('registrations')"))
                    ->contains(fn (object $column): bool => ($column->name ?? null) === 'seat_reserved'),
                'pgsql' => $connection->selectOne(
                    'select 1 as column_exists from information_schema.columns where table_schema = current_schema() and table_name = ? and column_name = ? limit 1',
                    ['registrations', 'seat_reserved']
                ) !== null,
                default => false,
            };
        } catch (Throwable) {
            // Skema produksi lama tetap dapat menerima pendaftaran tanpa kolom opsional ini.
            $exists = false;
        }

        return $this->tracksReservationState = $exists;
    }

    public function releaseExpired(): int
    {
        $expiredIds = Registration::query()
            ->where('status', 'menunggu_pembayaran')
            ->where('created_at', '<', now()->subMinutes(15))
            ->pluck('id');
        $released = 0;

        foreach ($expiredIds as $registrationId) {
            $wasReleased = DB::transaction(function () use ($registrationId): bool {
                $registration = Registration::query()
                    ->whereKey($registrationId)
                    ->lockForUpdate()
                    ->first();

                if (! $registration
                    || $registration->status !== 'menunggu_pembayaran'
                    || $registration->created_at->greaterThanOrEqualTo(now()->subMinutes(15))) {
                    return false;
                }

                $this->syncForStatus($registration, 'ditolak');
                $registration->update([
                    'status' => 'ditolak',
                    'participant_status' => 'ditolak',
                    'payment_status' => 'ditolak',
                ]);

                return true;
            });

            if ($wasReleased) {
                $released++;
            }
        }

        return $released;
    }

    public function reserve(Program $program): bool
    {
        if ((int) $program->quota <= 0) {
            return false;
        }

        $program->forceFill([
            'quota' => (int) $program->quota - 1,
        ]);

        if ($program->quota <= 0) {
            $program->forceFill([
                'status' => 'closed',
                'is_registration_closed' => true,
            ]);
        }

        $program->save();

        return true;
    }

    public function syncForStatus(Registration $registration, string $newStatus): bool
    {
        $willReserve = $this->statusUsesSeat($newStatus);

        $isReserved = $this->tracksReservationState()
            ? (bool) $registration->seat_reserved
            : $this->statusUsesSeat((string) $registration->status);

        if ($isReserved === $willReserve) {
            return true;
        }

        $program = Program::query()
            ->whereKey($registration->program_id)
            ->lockForUpdate()
            ->first();

        if (! $program) {
            if ($this->tracksReservationState()) {
                $registration->forceFill(['seat_reserved' => false])->save();
            }

            return ! $willReserve;
        }

        if ($willReserve) {
            if (! $this->reserve($program)) {
                return false;
            }

            if ($this->tracksReservationState()) {
                $registration->forceFill(['seat_reserved' => true])->save();
            }

            return true;
        }

        $wasFull = (int) $program->quota <= 0;

        $program->forceFill([
            'quota' => min((int) $program->total_quota, (int) $program->quota + 1),
        ]);

        if ($wasFull && $program->quota > 0 && $program->status === 'closed' && $program->is_registration_closed) {
            $program->forceFill([
                'status' => 'open_registration',
                'is_registration_closed' => false,
            ]);
        }

        $program->save();
        if ($this->tracksReservationState()) {
            $registration->forceFill(['seat_reserved' => false])->save();
        }

        return true;
    }

    public function statusUsesSeat(string $status): bool
    {
        return in_array($status, [
            'menunggu_pembayaran',
            'menunggu_verifikasi',
            'diproses',
            'diterima',
        ], true);
    }
}
