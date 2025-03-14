<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'data' => json_encode($request->input('data', [])),
        ]);

        $this->sendPushNotification($notification);
        $this->sendToTelegram($notification->message);

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully.');
    }

    private function sendPushNotification($notification)
    {
        $firebaseServerKey = env('FIREBASE_SERVER_KEY');
    
        // Get All Web and Mobile Tokens
        $tokens = FcmToken::pluck('token')->toArray();
    
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $notification->title,
                "body" => $notification->message,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            ],
            "data" => json_decode($notification->data, true),
        ];
    
        Http::withHeaders([
            'Authorization' => 'key=' . $firebaseServerKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);
    }

    private function sendToTelegram($message, $receiverId = null)
    {
        $telegramBotToken = env('TELEGRAM_BOT_TOKEN');
        $defaultReceiverId = env('TELEGRAM_DEFAULT_RECEIVER_ID');

        $chatId = $receiverId ?? $defaultReceiverId;

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        Http::post("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", $data);
    }
}
