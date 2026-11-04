<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('email_domain')->index();
            $table->unsignedTinyInteger('discount_percentage');
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->boolean('is_active')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_discounts');
    }
};
