<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate([
            'email' => 'admin@uisi.ac.id',
        ], [
            'name' => 'Admin UISI',
            'password' => 'Admin@12345!',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->call([
            ProgramSeeder::class,
        ]);
    }
}
