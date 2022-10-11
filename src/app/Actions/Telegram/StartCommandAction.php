<?php

namespace App\Actions\Telegram;

use Closure;

class StartCommandAction implements Pipe
{

    public function apply($message, Closure $next)
    {
        if($message['command'] === '/start'){
            return $next('Enter /login -u <email> -p <password> for will working with bot');
        }

        return $next($message);
    }
}
