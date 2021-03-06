<?php

namespace Database\Seeders;

use App\Model\BasketballCourt;
use Illuminate\Database\Seeder;

class BasketballCourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BasketballCourt::create(
            [
                'name' => config('seeder.basketball_court.name'),
                'description' => config('seeder.basketball_court.description'),
                'city' => config('seeder.basketball_court.city'),
                'address' => config('seeder.basketball_court.address'),
            ]
        );
    }
}
