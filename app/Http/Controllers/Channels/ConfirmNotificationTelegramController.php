<?php

namespace App\Http\Controllers\Channels;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;

class ConfirmNotificationTelegramController extends Controller
{
    public function __invoke()
    {
        $result = Telegram::getWebhookUpdates();

        $getMessage = $result["message"]["text"];
        $chat_id = $result["message"]["chat"]["id"];

            $getCode = str_replace('/start ', '', $getMessage);
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => "Thanks! I've recieved your verification code [" . $getCode . "]. I'm looking up your account now ...",
            ]);

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

            DB::table('users')
                ->where('telegram_verification_code', $getCode)
                ->update(['telegram' => $chat_id]);

            DB::table('users')
                ->where('telegram_verification_code', $getCode)
                ->update(['telegram_verified_at' => Carbon::now()]);

        return 1;
    }
}
