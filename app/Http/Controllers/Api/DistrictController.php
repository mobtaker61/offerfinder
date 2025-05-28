<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emirate;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    // GET /api/emirates/{emirate}/districts
    public function getDistrictsByEmirate(Emirate $emirate)
    {
        $districts = $emirate->districts()->orderBy('name')->get();
        return response()->json(['districts' => $districts], 200);
    }
} 