<?php

namespace App\Jobs;

use App\Mail\CurrenciesEmail;
use App\Models\CurrencyHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class DailyCurrenciesMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected Collection $data;


    /**
     * Create a new job instance.
     * @param User $user
     * @param Collection $data
     * @return void
     */
    public function __construct(User $user, Collection $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)
            ->send(new CurrenciesEmail(
                $this->data,
                'Currency Histories'
            ));
    }
}
