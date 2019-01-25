<?php

namespace App\Http\Controllers\Channels;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class ConfirmNotificationTelegramController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $response = Telegram::getWebhookUpdates();

        $chat_id = $response->getMessage()->getChat()->getId();

        $getMessage = $response->getMessage()->getText();

        $getCode = str_replace('/start ', '', $getMessage);

        if ($getCode != $user->telegram_verification_code) {
            return abort(410, 'Link has expired');
        }

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => "Thanks! I've recieved your verification code [" . $getCode . "]. I'm looking up your account now ..."
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

        return view('message', ['message' => 'Notification telegram has been updated']);
    }
}
