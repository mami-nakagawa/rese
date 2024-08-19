<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reservation;
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
        $this->call(AreasTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ShopRepresentativesTableSeeder::class);
        User::factory(97)->create();
        Reservation::factory(150)->create();
        Review::factory(150)->create();
    }
}
