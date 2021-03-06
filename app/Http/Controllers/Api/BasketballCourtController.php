<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasketballCourtResource;
use App\Model\BasketballCourt;
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
     * @return BasketballCourtResource
     */
    public function index(Request $request): BasketballCourtResource
    {
        $builder = BasketballCourt::query();

        if ($city = $request->get('city')) {
            $builder->where('city', $city);
        }
        if ($name = $request->get('name')) {
            $builder->where('name', $name);
        }

        $key = sprintf('basketball_courts_%s_%s', $city, $name);
        $courts = Cache::remember($key, 60, function () use ($builder) {
                return $builder->paginate(10);
            }
        );

        return new BasketballCourtResource($courts);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
