<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenresTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        User::factory(100)->create();
        $this->call(AreasTableSeeder::class);
        Review::factory(100)->create();
    }
}
