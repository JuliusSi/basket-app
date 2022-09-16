<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BasketballCourtsCollection;
use App\Http\Service\BasketballCourtsService;
use App\Model\BasketballCourt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class BasketballCourtController.
 */
class BasketballCourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BasketballCourtsService $courtsService): BasketballCourtsCollection
    {
        $builder = BasketballCourt::query();

        if ($city = $request->get('city')) {
            $builder->where('city', $city);
        }
        if ($name = $request->get('name')) {
            $builder->where('name', 'like', '%'.$name.'%');
        }

        $key = sprintf('basketball_courts_%s_%s_%s', $city, $name, $request->get('page'));
        $courts = Cache::remember(
            $key,
            1200,
            static function () use ($builder) {
                return $builder->paginate(4);
            }
        );

        return $courtsService->getCollection($courts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return BasketballCourt|\Illuminate\Http\Response
     */
    public function show(BasketballCourt $basketballCourt)
    {
        return $basketballCourt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
