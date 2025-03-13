<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('sendToTelegram')) {
    function sendToTelegram($message, $receiverId = null)
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