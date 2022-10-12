<?php

namespace App\Actions\Telegram;

use Closure;

class StartCommandAction implements Pipe
{

    public function apply($message, Closure $next)
    {
        if (!isset($message['answer']) && ($message['command'] === '/start')) {
            $answer = 'Enter /login -u <email> -p <password> for will working with bot';
            $message['answer'] = $answer;
        }

        return $next($message);
    }
}
