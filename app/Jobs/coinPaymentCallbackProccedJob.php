<?php

namespace App\Jobs;

use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class coinPaymentCallbackProccedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->data['status'] == 100) {
            if (isset($this->data['payload']['subscription'])) {
                $user = User::find($this->data['payload']['user_id']);
                $user->subscriptions()->create([
                    'name' => 'main',
                    'braintree_id' => 1,
                    'braintree_plan' => 'premium',
                    'quantity' => 1,
                ]);
            }
            if (isset($this->data['payload']['sms'])) {
                $user = User::find($this->data['payload']['user_id']);
                if (isset($user->sms)) {
                    $user->increment('sms', 100);
                } else {
                    $user->sms = 100;
                    $user->save();
                }
            }
        }
        if ($this->data['status'] == 100 || $this->data['status'] == -1) {
            Transaction::updateOrCreate(['transaction_date' => Carbon::createFromTimestamp($this->data['time_created'])->format('Y-m-d H:i:s')], [
                'user_id' => $this->data['payload']['user_id'],
                'transaction_date' => Carbon::createFromTimestamp($this->data['time_created'])->format('Y-m-d H:i:s'),
                'description' => $this->data['payload']['description'],
                'amount' => $this->data['payload']['priceItem'],
                'service' => $this->data['payload']['service'],
                'status' => $this->data['status'],
            ]);
        }
    }
}
