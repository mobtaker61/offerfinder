<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\FcmToken;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Handle newsletter subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'fcm_token' => 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // If user exists, update newsletter field to true
            $user->update(['newsletter' => true]);
        } else {
            // If user doesn't exist, create a new user with email and newsletter true
            $user = User::create([
                'name' => 'Guest User',
                'email' => $request->email,
                'password' => bcrypt(uniqid()), // Random password
                'newsletter' => true
            ]);
        }

        // Save FCM Token (if provided)
        if ($request->filled('fcm_token')) {
            FcmToken::updateOrCreate(
                ['token' => $request->fcm_token],
                ['user_id' => $user->id]
            );
        }

        return response()->json([
            'message' => 'You have successfully subscribed to the newsletter and push notifications!',
            'status' => 'success'
        ], 200);
    }
}
