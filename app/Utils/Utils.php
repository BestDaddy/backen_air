<?php

namespace App\Utils;

class Utils
{
    static function sentTelegram($message): void
    {
        $data['chat_id'] = env('CHAT_ID', '');
        $data['parse_mode'] = 'markdown';
        $data['text'] = $message;

        $curl = curl_init('https://api.telegram.org/bot'. env('TELEGRAM_TOKEN', '') . '/sendMessage');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        curl_close($curl);
    }
}
