<?php

namespace App\Actions\Telegram;

use App\Helpers\TableString;
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
        if (!isset($message['answer']) && ($message['command'] === '/currency:get')) {

            $currencies = $this->currencyRepository->getAll();
            $answer = 'sdsd';

            $tableHeader = ['name', 'price'];
            $tableRows = [
                ['BTC', '485,34$'],
                ['BTChfhddsdsdsd', '485,2'],
                ['BTC', '485,34$'],
            ];

            $answer = (new TableString($tableHeader, $tableRows))->render();

            $message['answer'] = $answer;
        }

        return $next($message);
    }
}
