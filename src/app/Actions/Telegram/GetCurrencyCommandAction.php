<?php

namespace App\Actions\Telegram;

use App\Helpers\TableString;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class GetCurrencyCommandAction implements Pipe
{
    private CurrencyHistoryRepository $currencyHistoryRepository;
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyHistoryRepository $currencyHistoryRepository, CurrencyRepository $currencyRepository)
    {
        $this->currencyHistoryRepository = $currencyHistoryRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function apply($message, Closure $next)
    {
        if (!isset($message['answer']) && ($message['command'] === '/currency:get')) {

            $currencies = $this->currencyRepository->getAll();
            $currenciesHistory = $this->currencyHistoryRepository->getAllWithCurrency($currencies);
            $answer = '';

            $tableHeader = ['name', 'price'];
            $tableRows = $currenciesHistory->map(fn ($item) => [
                $item['currency']->name,
                $item['history'][0]->amount . '$',
            ])->toArray();

            $answer = (new TableString($tableHeader, $tableRows))->render();

            $message['answer'] = [
                'type' => 'html',
                'message' => $answer
            ];
        }

        return $next($message);
    }
}
