<?php

namespace App\Actions\Telegram;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoginCommandAction implements Pipe
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function apply($message, Closure $next)
    {
        if ($message['command'] === '/login') {

            $credentials = [];

            preg_match('/-u.([A-Za-z0-9.^_]+@[A-Za-z0-9.^_]+)/', $message['text'], $credentials['email']);
            preg_match('/-p.([A-Za-z0-9.^_]+)/', $message['text'], $credentials['password']);

            if (Auth::attempt([
                'email' => $credentials['email'][1],
                'password' => $credentials['password'][1]
            ])) {

                $user = Auth::user();
                $this->userRepository->insert($user->id, ['telegram_id' => $message['chat_id']]);

                return $next('Authorized');

            } else {

                return $next('Unauthorized');

            }
        }

        return $next($message);
    }
}
