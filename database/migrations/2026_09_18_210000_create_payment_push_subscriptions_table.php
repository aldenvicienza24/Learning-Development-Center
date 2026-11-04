<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->string('endpoint_hash', 64);
            $table->text('subscription');
            $table->timestamps();
            $table->unique(['registration_id', 'endpoint_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_push_subscriptions');
    }
};
