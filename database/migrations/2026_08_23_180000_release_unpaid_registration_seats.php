<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            $pendingByProgram = DB::table('registrations')
                ->select('program_id', DB::raw('COUNT(*) as pending_count'))
                ->where('status', 'menunggu_pembayaran')
                ->groupBy('program_id')
                ->get();

            foreach ($pendingByProgram as $pending) {
                $program = DB::table('programs')->where('id', $pending->program_id)->first();

                if (! $program) {
                    continue;
                }

                $available = (int) $program->quota + (int) $pending->pending_count;
                $total = max((int) $program->total_quota, $available);
                $available = min($available, $total);

                $updates = [
                    'quota' => $available,
                    'total_quota' => $total,
                    'updated_at' => now(),
                ];

                if ($available > 0 && $program->status === 'closed' && $program->is_registration_closed) {
                    $updates['status'] = 'open_registration';
                    $updates['is_registration_closed'] = false;
                }

                DB::table('programs')->where('id', $program->id)->update($updates);
            }
        });
    }

    public function down(): void
    {
        // Data corrections are intentionally not reversed.
    }
};
