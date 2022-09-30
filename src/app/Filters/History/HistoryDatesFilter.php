<?php

namespace App\Filters\History;

use App\Filters\Pipe;
use Closure;
use Illuminate\Support\Carbon;


class HistoryDatesFilter implements Pipe
{
    public function apply($query, Closure $next)
    {
        $dateFrom = null;
        $dateTo = null;

        if (request()->hasAny(['dfrom', 'dto'])) {

            $dateFrom = (new Carbon(request()->get('dfrom')))->startOfDay();
            $dateTo = (new Carbon(request()->get('dto')))->endOfDay();

        } else {

            $dateTo = Carbon::now();
            $dateFrom = $dateTo->parse('-24 hours');

        }

        $query->whereBetween(
            'created_at',
            [
                $dateFrom,
                $dateTo
            ]
        );

        return $next($query);
    }
}
