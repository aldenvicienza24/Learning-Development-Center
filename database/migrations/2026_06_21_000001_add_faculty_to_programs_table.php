<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('programs', 'faculty')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->string('faculty')->default('teknologi-kreatif')->after('category');
            });
        }

        DB::table('programs')
            ->whereIn('detail_url', ['detail1', 'detaila', 'detailb'])
            ->update(['faculty' => 'ekonomi-bisnis']);

        DB::table('programs')
            ->whereIn('detail_url', ['detail3', 'detail4'])
            ->update(['faculty' => 'teknik-industri']);

        DB::table('programs')
            ->whereIn('detail_url', ['detail5', 'detail7'])
            ->update(['faculty' => 'bahasa']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('programs', 'faculty')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropColumn('faculty');
            });
        }
    }
};
