<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('author_name', 100);
            $table->string('author_role', 150)->nullable();
            $table->text('body');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->index(['is_published', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
