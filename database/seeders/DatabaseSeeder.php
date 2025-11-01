<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SociosTableSeeder::class,
            AdminsTableSeeder::class,
        ]);
        \App\Models\Socio::factory(10)->create();
    }
}
