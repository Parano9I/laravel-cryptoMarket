<?php

namespace App\Filters;

use Closure;

interface Pipe
{
    public function apply($query, Closure $next);
}
