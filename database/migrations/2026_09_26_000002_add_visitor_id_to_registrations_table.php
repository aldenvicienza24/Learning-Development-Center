<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! $this->hasVisitorColumn()) {
            Schema::table('registrations', function (Blueprint $table): void {
                $table->string('visitor_id', 191)->nullable()->after('program_id')->index();
            });
        }
    }

    public function down(): void
    {
        if ($this->hasVisitorColumn()) {
            Schema::table('registrations', function (Blueprint $table): void {
                $table->dropColumn('visitor_id');
            });
        }
    }

    private function hasVisitorColumn(): bool
    {
        $connection = DB::connection();

        if (in_array($connection->getDriverName(), ['mysql', 'mariadb'], true)) {
            // MariaDB 5.5 lacks the generated-column metadata queried by hasColumn.
            $result = $connection->selectOne(
                'select count(*) as column_count from information_schema.columns where table_schema = ? and table_name = ? and column_name = ?',
                [$connection->getDatabaseName(), $connection->getTablePrefix().'registrations', 'visitor_id']
            );

            return (int) $result->column_count > 0;
        }

        return Schema::hasColumn('registrations', 'visitor_id');
    }
};