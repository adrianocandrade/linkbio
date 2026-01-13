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
        $this->call(BlogTableSeeder::class);
        $this->call(DocsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
    }
}
