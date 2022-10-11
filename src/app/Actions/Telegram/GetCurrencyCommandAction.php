<?php

namespace App\Actions\Telegram;

use App\Repositories\CurrencyRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class GetCurrencyCommandAction implements Pipe
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function apply($message, Closure $next)
    {
        if ($message['command'] === '/currency:get') {

            $currencies = $this->currencyRepository->getAll();
            $resultStr = 'name | price' . PHP_EOL;

            foreach($currencies as $currency){
                $resultStr = $resultStr . $currency->name . ' | 48374$' . PHP_EOL;
            }

            return $next($resultStr);

        }

        return $next($message);
    }
}
