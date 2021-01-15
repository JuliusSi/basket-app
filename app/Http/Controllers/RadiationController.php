<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class RadiationController
 * @package App\Http\Controllers
 */
class RadiationController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('radiation');
    }
}
