<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (! Schema::hasColumn('registrations', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('institution');
            }

            if (! Schema::hasColumn('registrations', 'participant_status')) {
                $table->string('participant_status')->default('menunggu_verifikasi')->after('payment_proof');
            }

            if (! Schema::hasColumn('registrations', 'payment_status')) {
                $table->string('payment_status')->default('menunggu_verifikasi')->after('participant_status');
            }
        });

        DB::table('registrations')
            ->whereNull('participant_status')
            ->orWhere('participant_status', '')
            ->update(['participant_status' => DB::raw("COALESCE(status, 'menunggu_verifikasi')")]);
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            foreach (['payment_proof', 'participant_status', 'payment_status'] as $column) {
                if (Schema::hasColumn('registrations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
