<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Historical amounts cannot be inferred from current program prices.
            $table->unsignedBigInteger('payment_amount')->nullable();
            $table->date('payment_received_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['payment_received_at']);
            $table->dropColumn(['payment_amount', 'payment_received_at']);
        });
    }
};
