<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourtArrivalStoreRequest;

/**
 * Class CourtArrivalsController
 * @package App\Http\Controllers\Api
 */
class CourtArrivalsController extends Controller
{
    public function store(CourtArrivalStoreRequest $request)
    {
        return auth()->user()->courtArrivals()->create($request->validated());
    }
}
