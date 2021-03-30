<?php

namespace Database\Seeders;

use App\Model\PlaceCode;
use Illuminate\Database\Seeder;

/**
 * Class PlaceCodeSeeder
 * @package Database\Seeders
 */
class PlaceCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = config('weather.available_places');
        foreach ($places as $key => $value) {
            PlaceCode::create(
                [
                    'code' => $key,
                ]
            );
        }
    }
}
