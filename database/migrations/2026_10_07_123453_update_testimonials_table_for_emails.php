<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->string('token')->nullable()->unique();
            $table->integer('rating')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('is_submitted')->default(false);
            
            // Make original fields nullable if not already
            $table->string('author_name', 100)->nullable()->change();
            $table->text('body')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->dropColumn(['registration_id', 'token', 'rating', 'status', 'is_submitted']);
            $table->string('author_name', 100)->nullable(false)->change();
            $table->text('body')->nullable(false)->change();
        });
    }
};
