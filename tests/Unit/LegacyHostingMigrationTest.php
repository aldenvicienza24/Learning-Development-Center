<?php

use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

uses(Tests\TestCase::class);

// Compile the real migrations with the MySQL grammar while simulating only
// metadata reads. This is not a substitute for a MariaDB server integration test.
class LegacyHostingConnection extends MySqlConnection
{
    public bool $internationalColumn = true;

    public array $reads = [];

    public array $writes = [];

    public function select($query, $bindings = [], $useReadPdo = true, array $fetchUsing = [])
    {
        if (str_contains($query, 'generation_expression')) {
            throw new RuntimeException('MariaDB 5.5 does not have generation_expression');
        }
        if (! str_starts_with($query, 'select count(*) as column_count from information_schema.columns')) {
            throw new RuntimeException('Unexpected query in isolated migration test');
        }
        $this->reads[] = [$query, $bindings];

        return [(object) ['column_count' => (int) $this->internationalColumn]];
    }

    public function statement($query, $bindings = [])
    {
        $this->writes[] = $query;
        if (str_contains($query, 'drop `is_international`')) {
            $this->internationalColumn = false;
        } elseif (str_contains($query, 'add `is_international`')) {
            $this->internationalColumn = true;
        }

        return true;
    }

    public function getServerVersion(): string
    {
        return '5.5.68';
    }

    public function isMaria()
    {
        return true;
    }
}

beforeEach(function () {
    $this->legacy = new LegacyHostingConnection(null, 'hosting_fixture', 'uisi_', ['driver' => 'mysql']);
    DB::extend('legacy_fixture', fn () => $this->legacy);
    config(['database.connections.legacy_fixture' => ['driver' => 'legacy_fixture']]);
    DB::setDefaultConnection('legacy_fixture');
    Schema::clearResolvedInstance('db.schema');
});

test('legacy column removal uses basic metadata and tolerates a retry', function () {
    $migration = require database_path('migrations/2026_09_13_094142_drop_is_international_from_programs_table.php');
    $migration->up();
    $migration->up();

    expect($this->legacy->writes)->toBe(['alter table `uisi_programs` drop `is_international`']);
    expect($this->legacy->reads[0][1])->toBe(['hosting_fixture', 'uisi_programs', 'is_international']);

    $migration->down();
    $migration->down();
    expect($this->legacy->writes)->toHaveCount(2);
    expect($this->legacy->writes[1])->toContain('add `is_international` tinyint(1)');
});

test('documentation and push migrations compile without native json or generated column metadata', function () {
    foreach ([
        '2026_09_14_000001_add_confirmed_receipts_to_registrations.php',
        '2026_09_14_000003_create_testimonials_table.php',
        '2026_09_14_000004_add_program_documentation_to_testimonials.php',
        '2026_09_18_210000_create_payment_push_subscriptions_table.php',
    ] as $file) {
        (require database_path('migrations/'.$file))->up();
    }

    $sql = implode("\n", $this->legacy->writes);
    expect($sql)->toContain('`photos` longtext null', '`comments` longtext null');
    expect($sql)->toContain('modify `author_name` varchar(100) null');
    expect($sql)->toContain('`payment_amount` bigint unsigned null');
    expect($sql)->toContain('foreign key (`registration_id`) references `uisi_registrations` (`id`) on delete cascade');
    expect($sql)->not->toContain(' json', 'generation_expression');
    expect($this->legacy->reads)->toBe([]);
});
