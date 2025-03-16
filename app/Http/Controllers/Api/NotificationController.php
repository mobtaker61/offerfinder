<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return response()->json(['notifications' => $notifications], 200);
    }

    /**
     * Store a newly created notification in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'data' => 'nullable|array',
            'send_now' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('notifications', 'public');
            $validated['image'] = $path;
        }

        $notification = Notification::create($validated);

        // Send notification immediately if requested
        if ($request->input('send_now', false)) {
            $this->sendPushNotification($notification);
        }

        return response()->json(['message' => 'Notification created successfully', 'notification' => $notification], 201);
    }

    /**
     * Display the specified notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Notification $notification)
    {
        return response()->json(['notification' => $notification], 200);
    }

    /**
     * Update the specified notification in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'image' => 'nullable|image|max:2048',
            'data' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('notifications', 'public');
            $validated['image'] = $path;
        }

        $notification->update($validated);

        return response()->json(['message' => 'Notification updated successfully', 'notification' => $notification], 200);
    }

    /**
     * Remove the specified notification from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'Notification deleted successfully'], 200);
    }

    /**
     * Send push notification to all registered tokens.
     *
     * @param  \App\Models\Notification  $notification
     * @return bool
     */
    private function sendPushNotification(Notification $notification)
    {
        $tokens = FcmToken::pluck('token')->toArray();
        
        if (empty($tokens)) {
            return false;
        }

        $serverKey = config('firebase.server_key');
        
        $data = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $notification->title,
                'body' => $notification->body,
            ],
            'data' => $notification->data ?? [],
        ];

        if ($notification->image) {
            $data['notification']['image'] = url('storage/' . $notification->image);
        }

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);

        return $response->successful();
    }
}
