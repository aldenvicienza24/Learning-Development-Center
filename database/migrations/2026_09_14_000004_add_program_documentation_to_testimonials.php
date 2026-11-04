<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('author_name', 100)->nullable()->change();
            // Stored as JSON strings by the model's array casts. LONGTEXT also
            // works on the existing MariaDB 5.5 host, which has no JSON type.
            $table->longText('photos')->nullable();
            $table->longText('comments')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['photos', 'comments']);
        });
    }
};
