<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Business rule: disetujui confirms payment. Preserve explicit amounts,
        // including zero; snapshot the current tariff only for unrecorded legacy payments.
        // Do not invent a historical receipt date or modify updated_at.
        DB::table('registrations')->join('programs', 'programs.id', '=', 'registrations.program_id')
            ->where('payment_status', 'disetujui')->whereNull('payment_amount')
            ->select('registrations.id', 'programs.price')
            ->chunkById(200, function ($rows): void {
                foreach ($rows as $row) {
                    DB::table('registrations')->where('id', $row->id)
                        ->where('payment_status', 'disetujui')->whereNull('payment_amount')
                        ->update(['payment_amount' => max(0, (int) $row->price)]);
                }
            }, 'registrations.id', 'id');
    }

    public function down(): void
    {
        // Keep financial values: a rollback must not erase recorded payments.
    }
};
