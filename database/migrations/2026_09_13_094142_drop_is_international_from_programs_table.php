<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->hasInternationalColumn()) {
            return;
        }

        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('is_international');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->hasInternationalColumn()) {
            return;
        }

        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('is_international')->default(false);
        });
    }

    private function hasInternationalColumn(): bool
    {
        $connection = DB::connection();

        if (in_array($connection->getDriverName(), ['mysql', 'mariadb'], true)) {
            // MariaDB 5.5 has basic column metadata, but no generation_expression.
            // Avoid Laravel's full column inspection for this existence check.
            $result = $connection->selectOne(
                'select count(*) as column_count from information_schema.columns where table_schema = ? and table_name = ? and column_name = ?',
                [$connection->getDatabaseName(), $connection->getTablePrefix().'programs', 'is_international']
            );

            return (int) $result->column_count > 0;
        }

        return Schema::hasColumn('programs', 'is_international');
    }
};
