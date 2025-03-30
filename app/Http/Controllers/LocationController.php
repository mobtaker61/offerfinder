<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    public function save(Request $request)
    {
        $location = $request->validate([
            'name' => 'required|string',
            'emirate' => 'required|string',
            'district' => 'required|string',
            'distance' => 'required|numeric'
        ]);

        Session::put('user_location', $location);

        return response()->json(['success' => true]);
    }
} 