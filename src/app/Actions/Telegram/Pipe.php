<?php

namespace App\Actions\Telegram;

use Closure;

interface Pipe
{
    public function apply($message, Closure $next);
}
