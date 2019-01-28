<?php

namespace App\Http\Controllers\Channels;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram;

class ConfirmNotificationTelegramController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $result = Telegram::getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

        $getMessage = $result["message"]["text"]; //Текст сообщения
        $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя

        $getCode = str_replace('/start ', '', $getMessage);

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => "Thanks! I've recieved your verification code [" . $getCode . "]. I'm looking up your account now ...",
        ]);

        $user->forceFill([
            'telegram' => $chat_id
        ])->save();

        $user->markNotificationTelegramAsVerified();

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => "Congratulations 🙌, I've successfully activated your telegram account as a channel on coinspy.com! 🍾 🎉"
        ]);

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => "You can now enable me on any alerts on coinspy.com! I'll message you whenever an alert triggers."
        ]);
    }
}
