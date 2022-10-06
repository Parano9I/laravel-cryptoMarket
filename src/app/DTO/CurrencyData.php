<?php

namespace App\DTO;

class CurrencyData
{
    public string $name;
    public float $price;
    public string $imageUrl;

    public function __construct(
        string $name,
        float $price,
        string $imageUrl
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
    }

    private static function pipeFormated(array $data)
    {
        return $data['RAW'];
    }

    public static function transform(array $data): array
    {
        $result = [];
        $currencies = self::pipeFormated($data);

        foreach ($currencies as $currency) {
            $currency = $currency[key($currency)];
            array_push($result, new CurrencyData(
                $currency['FROMSYMBOL'],
                $currency['PRICE'],
                $currency['IMAGEURL']
            ));
        };

        return $result;
    }
}
