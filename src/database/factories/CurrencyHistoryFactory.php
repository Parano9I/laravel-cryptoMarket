<?php

namespace Database\Factories;

use App\Models\CurrencyHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurrencyHistory>
 */
class CurrencyHistoryFactory extends Factory
{

    protected $model = CurrencyHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
//            'currency_id' => ,
//            'amount' => ,
        ];
    }
}
