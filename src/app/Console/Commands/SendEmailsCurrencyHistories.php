<?php

namespace App\Console\Commands;

use App\Jobs\DailyCurrenciesMailJob;
use App\Mail\CurrenciesEmail;
use App\Models\Currency;
use App\Models\User;
use App\Models\CurrencyHistory;
use App\Notifications\EmailNotitfication;
use App\Repositories\CurrencyHistoryRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailsCurrencyHistories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to users with a history of the currencies they subscribed to';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        CurrencyHistoryRepository $currencyHistoryRepository,
        DailyCurrenciesMailJob $job
    )
    {
        $date = Carbon::today();
        $currencyHistories = $currencyHistoryRepository
            ->getAllByDate($date)
            ->map(function ($value, $key) {
                return [
                    'id' => $key,
                    'data' => $value
                ];
            })->values();

        $users = User::all();

        foreach ($users as $user) {
            $trackedCurrencies = $user->currencies()->pluck('id');
            $trackedCurrenciesHistories = $currencyHistories
                ->whereIn('id', $trackedCurrencies)
                ->values()
                ->map(function ($value, $key) {
                    return $value['data'];
                });

            $job->dispatch($user, $trackedCurrenciesHistories);
        }
    }
}
