<?php

namespace App\Services;

use App\DTO\CurrencyData;
use Illuminate\Support\Facades\Http;

class CryptoAPIService
{
    private string $url = 'https://min-api.cryptocompare.com/data/';

    private string $apiKey;

    private array $queryCategories = [
        'singleSymbolPrice' => 'price',
        'multipleSymbolsPrice' => 'pricemulti',
        'multipleSymbolsFullData' => 'pricemultifull',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.crypto.api_key');
    }

    private function fetch(string $url)
    {
        return Http::get($url);
    }

    private function createFullUrl(string $category, array $queryParams)
    {
        $url = $this->url;
        $queryParams = $this->createQueryParams($queryParams);

        return $url = $url . $category . $queryParams;
    }

    private function createQueryParams(array $queryParams)
    {
        $queryParams['api_key'] = $this->apiKey;
        $result = '?';

        foreach ($queryParams as $param => $paramValue) {

            if ($result !== '?') $result .= '&';

            if (is_array($paramValue)) $paramValue = implode(',', $paramValue);

            $result .= $param . '=' . $paramValue;
        }

        return $result;
    }

    public function getMultipleSymbolsFullData(array $cryptocurrencies, array $currencies)
    {
        $category = $this->queryCategories['multipleSymbolsFullData'];
        $fullQueryUrl = $this->createFullUrl($category, [
            'fsyms' => $cryptocurrencies,
            'tsyms' => $currencies
        ]);

        $data = $this->fetch($fullQueryUrl)->json();

        return CurrencyData::transform($data);
    }
}