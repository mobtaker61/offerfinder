<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Received FCM Token:', ['token' => $request->fcm_token]);
    
        $request->validate([
            'fcm_token' => 'required|string',
        ]);
    
        FcmToken::updateOrCreate(
            ['token' => $request->fcm_token],
            ['user_id' => Auth::check() ? Auth::id() : null]
        );
    
        return response()->json(['message' => 'Token saved successfully.']);
    }    
}
