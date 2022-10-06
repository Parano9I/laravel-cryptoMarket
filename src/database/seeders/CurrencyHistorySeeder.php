<?php

namespace Database\Seeders;

use App\Repositories\CurrencyRepository;
use Illuminate\Database\Seeder;

class CurrencyHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(CurrencyRepository $currencyRepository)
    {
        $currencyRepository->getAll()->reject(function ($currency) {

        });

    }
}
