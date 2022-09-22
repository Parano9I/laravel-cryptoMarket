<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Currency::count()) {
            $this->importCurrencies();
        }
    }

    protected function importCurrencies()
    {
        $currenciesName = [
            [
                'name' => 'BTC',
                'image' => '37746251/btc.png'
            ],
            [
                'name' => 'ETH',
                'image' => '37746238/eth.png'
            ],
            [
                'name' => 'REP',
                'image' => '37747024/rep.png'
            ],
            [
                'name' => 'BNB',
                'image' => '40485170/bnb.png'
            ],
            [
                'name' => 'ATOM',
                'image' => '37746867/atom.png'
            ],
            [
                'name' => 'SOL',
                'image' => '37747734/sol.png'
            ]
        ];

        foreach ($currenciesName as $currencyName) {
            Currency::create([
                'name' => $currencyName['name'],
                'image_url' => $currencyName['image']
            ]);

            // DB::table('currencies')->insert([
            //     'name' => $currencyName
            // ]);
        }
    }
}