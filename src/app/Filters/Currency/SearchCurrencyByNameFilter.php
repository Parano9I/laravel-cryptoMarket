<?php

namespace App\Filters\Currency;

use App\Filters\Pipe;
use Closure;

class SearchCurrencyByNameFilter implements Pipe
{
    public function apply($query, Closure $next)
    {
        if (request()->has('search')) {

            $currencySearchStr = request()->get('search');

            $query->where('name', 'like', '%' . $currencySearchStr . '%');
        }

        return $next($query);
    }
}
