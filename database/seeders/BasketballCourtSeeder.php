<?php

namespace Database\Seeders;

use App\Model\BasketballCourt;
use App\Model\PlaceCode;
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
        $placeCodes = PlaceCode::all();
        $courts = config('seeder.basketball_courts');
        foreach ($courts as $court) {
            BasketballCourt::create(
                [
                    'name' => $court['name'],
                    'place_code_id' => $placeCodes->where('code', $court['place_code'])->first()->id,
                    'description' => $court['description'],
                    'city' => $court['city'],
                    'address' => $court['address'],
                    'image_path' => $court['image_path'],
                ]
            );
        }
    }
}
