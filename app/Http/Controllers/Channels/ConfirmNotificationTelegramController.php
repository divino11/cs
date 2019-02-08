<?php

namespace App\Http\Controllers\Channels;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Telegram\Bot\Laravel\Facades\Telegram;

class ConfirmNotificationTelegramController extends Controller
{
    public function __invoke()
    {
        $result = Telegram::getWebhookUpdates();

        $message = $result["message"]["text"];
        $chatId = $result["message"]["chat"]["id"];

        $code = str_replace('/start ', '', $message);
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Thanks! I've recieved your verification code [" . $code . "]. I'm looking up your account now ...",
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'parse_mode' => 'HTML',
            'text' => "Congratulations 🙌, I've successfully activated your telegram account as a channel on coinspy.com! 🍾 🎉"
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'parse_mode' => 'HTML',
            'text' => "You can now enable me on any alerts on coinspy.com! I'll message you whenever an alert triggers."
        ]);

        User::where('telegram_verification_code', $code)
            ->update([
                'telegram' => $chatId,
                'telegram_verified_at' => Carbon::now(),
            ]);

        return 1;
    }
}
