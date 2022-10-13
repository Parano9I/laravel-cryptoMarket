<?php

namespace App\Actions\Telegram;

use App\Helpers\TableString;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\UserRepository;
use Closure;

class GetTrackedCurrencyCommandAction implements Pipe
{
    private CurrencyHistoryRepository $currencyHistoryRepository;
    private CurrencyRepository $currencyRepository;
    private UserRepository $userRepository;

    public function __construct(
        CurrencyHistoryRepository $currencyHistoryRepository,
        CurrencyRepository $currencyRepository,
        UserRepository $userRepository
    )
    {
        $this->currencyHistoryRepository = $currencyHistoryRepository;
        $this->currencyRepository = $currencyRepository;
        $this->userRepository = $userRepository;
    }


    public function apply($message, Closure $next)
    {
        if (!isset($message['answer']) && ($message['command'] === '/tracked-currency:get')) {

            $user = $this->userRepository->getByTelegramId($message['chat_id']);
            $trackedCurrencies = $this->currencyRepository->getTrackedAll($user);
            $trackedCurrenciesWithHistory = $this->currencyHistoryRepository->getAllWithCurrency($trackedCurrencies);

            $tableHeader = ['name', 'price'];
            $tableRows = $trackedCurrenciesWithHistory->map(fn($item) => [
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
