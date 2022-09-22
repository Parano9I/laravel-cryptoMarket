<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Services\CryptoAPIService;
use Illuminate\Console\Command;

class ParseCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse currencies from external API and save data db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CryptoAPIService $cryptoAPIService)
    {
        $currenciesName = Currency::pluck('name')->toArray();
        $currenciesData = $cryptoAPIService->getMultipleSymbolsFullData(
            $currenciesName,
            ['USD']
        );

        foreach ($currenciesData as $currencyData) {
            $currencyId = Currency::where('name', $currencyData->name)->value('id');

            $currencyHistory = new CurrencyHistory();
            $currencyHistory->create([
                'currency_id' => $currencyId,
                'amount' => $currencyData->price,
            ]);

            $this->info("Successful preservation of the {$currencyData->name} currency");
        }

        return 0;
    }
}