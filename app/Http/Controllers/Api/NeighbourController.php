<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Neighbour;
use Illuminate\Http\Request;

class NeighbourController extends Controller
{
    // GET /api/districts/{id}/neighbours
    public function getNeighboursByDistrict($districtId)
    {
        $neighbours = Neighbour::where('district_id', $districtId)->orderBy('name')->get();
        return response()->json(['neighbours' => $neighbours], 200);
    }
} 