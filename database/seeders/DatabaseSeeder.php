<?php

declare(strict_types=1);

use Database\Seeders\BasketballCourtsSeeder;
use Database\Seeders\PlaceCodeSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            [
                PlaceCodeSeeder::class,
                UserSeeder::class,
                RoleSeeder::class,
                UserRoleSeeder::class,
                BasketballCourtsSeeder::class,
            ]
        );
    }
}
