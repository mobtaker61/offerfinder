<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FcmTokenController extends Controller
{
    /**
     * Store FCM token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::info('API: Received FCM Token', ['token' => $request->fcm_token]);
    
        $request->validate([
            'fcm_token' => 'required|string',
            'email' => 'nullable|email'
        ]);
        
        $userId = null;
        
        // If email is provided, associate with user
        if ($request->filled('email')) {
            $user = User::where('email', $request->email)->first();
            
            if ($user) {
                $userId = $user->id;
            } else {
                // Create guest user if needed
                $user = User::create([
                    'name' => 'Guest User',
                    'email' => $request->email,
                    'password' => bcrypt(uniqid()),
                    'newsletter' => true
                ]);
                $userId = $user->id;
            }
        }
    
        FcmToken::updateOrCreate(
            ['token' => $request->fcm_token],
            ['user_id' => $userId]
        );
    
        return response()->json(['message' => 'FCM token saved successfully'], 200);
    }
}
