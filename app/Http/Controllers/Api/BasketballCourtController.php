<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasketballCourtsCollection;
use App\Model\BasketballCourt;
use App\WeatherChecker\Manager\WeatherCheckManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

/**
 * Class BasketballCourtController
 * @package App\Http\Controllers\Api
 */
class BasketballCourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  WeatherCheckManager  $weatherCheckManager
     * @return BasketballCourtsCollection
     */
    public function index(Request $request, WeatherCheckManager $weatherCheckManager): BasketballCourtsCollection
    {
        $builder = BasketballCourt::query();

        if ($city = $request->get('city')) {
            $builder->where('city', $city);
        }
        if ($name = $request->get('name')) {
            $builder->where('name', 'like', '%' . $name . '%');
        }

        $key = sprintf('basketball_courts_%s_%s_%s', $city, $name, $request->get('page'));
        $courts = Cache::remember($key, 600, function () use ($builder) {
                return $builder->paginate(4);
            }
        );

        return new BasketballCourtsCollection($courts, $weatherCheckManager);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  BasketballCourt  $basketballCourt
     * @return BasketballCourt|\Illuminate\Http\Response
     */
    public function show(BasketballCourt $basketballCourt)
    {
        return $basketballCourt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
