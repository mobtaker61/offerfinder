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
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $notification = Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'data' => json_encode($request->input('data', [])),
            ]);

            // Get token count before sending
            $tokenCount = FcmToken::count();
            
            $message = "Notification saved successfully. ";
            
            if ($tokenCount > 0) {
                // Send notifications only if tokens exist
                $pushResult = $this->sendPushNotification($notification);
                $telegramResult = $this->sendToTelegram($notification->message);
                
                $message .= "Push notifications sent to {$tokenCount} devices. ";
                $message .= "Telegram message sent successfully.";
            } else {
                $message .= "No FCM tokens found. To send push notifications, please ensure your mobile app or web application has registered FCM tokens.";
            }

            return redirect()->route('admin.notifications.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Failed to send notification: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function sendPushNotification($notification)
    {
        $firebaseServerKey = env('FIREBASE_SERVER_KEY');
        if (!$firebaseServerKey) {
            throw new \Exception('Firebase Server Key not configured');
        }
    
        // Get All Web and Mobile Tokens
        $tokens = FcmToken::pluck('token')->toArray();
        if (empty($tokens)) {
            throw new \Exception('No FCM tokens found');
        }
    
        $data = [
            "registration_ids" => $tokens,
            "notification" => [
                "title" => $notification->title,
                "body" => $notification->message,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            ],
            "data" => json_decode($notification->data, true),
        ];
    
        $response = Http::withHeaders([
            'Authorization' => 'key=' . $firebaseServerKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);

        if (!$response->successful()) {
            throw new \Exception('Failed to send push notification: ' . $response->body());
        }

        return $response->json();
    }

    private function sendToTelegram($message, $receiverId = null)
    {
        $telegramBotToken = env('TELEGRAM_BOT_TOKEN');
        if (!$telegramBotToken) {
            throw new \Exception('Telegram Bot Token not configured');
        }

        $defaultReceiverId = env('TELEGRAM_DEFAULT_RECEIVER_ID');
        if (!$defaultReceiverId) {
            throw new \Exception('Telegram Default Receiver ID not configured');
        }

        $chatId = $receiverId ?? $defaultReceiverId;

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $response = Http::post("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", $data);

        if (!$response->successful()) {
            throw new \Exception('Failed to send Telegram message: ' . $response->body());
        }

        return $response->json();
    }
}
