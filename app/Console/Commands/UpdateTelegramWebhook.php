<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram;

class UpdateTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data webhook';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = str_replace('http://', 'https://', route('telegram.webhook') . '/');
        $result = Telegram::bot()->setWebhook([
            'url' => $url,
        ]);

        if (!$result->getResult()) {
            $this->error('Webhook have error: ' . $result->getDecodedBody()['description']);
            return;
        }

        $this->info('Webhook has been update');
    }
}
