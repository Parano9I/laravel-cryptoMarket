<?php

namespace App\Filters\Currency;

use Closure;
use App\Filters\Pipe;

class CurrencyNameFilter implements Pipe
{
    public function apply($query, Closure $next)
    {
        if(request()->has('cs')){

            $currenciesNameStr = request()->get('cs');
            $currenciesName = [];

            if(str_contains($currenciesNameStr, ',')){
                $currenciesName = explode(',', $currenciesNameStr);
            } else {
                array_push($currenciesName, $currenciesNameStr);
            }

            $query->whereIn('name', $currenciesName);
        }

        return $next($query);
    }
}
