<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BasketballCourtResource;
use App\Model\BasketballCourt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BasketballCourtController
 * @package App\Http\Controllers\Api
 */
class BasketballCourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BasketballCourtResource
     */
    public function index(): BasketballCourtResource
    {
        return new BasketballCourtResource(BasketballCourt::all());
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
