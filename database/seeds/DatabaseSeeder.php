<?php

use Database\Seeders\BasketballCourtSeeder;
use Database\Seeders\PlaceCodeSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                PlaceCodeSeeder::class,
                UserSeeder::class,
                RoleSeeder::class,
                UserRoleSeeder::class,
                BasketballCourtSeeder::class,
            ]
        );
    }
}
