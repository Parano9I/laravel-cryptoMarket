<?php

namespace App\Http\Controllers;

use App\Actions\Telegram\StartCommandAction;
use App\Services\TelegramService;

class TelegramController extends Controller
{

    private TelegramService $service;

    public function __construct(TelegramService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->service->routesPipeline([
            StartCommandAction::class
        ]);
    }

//    public function index(Request $request)
//    {
//        $this->telegram->command('start', function ($message) {
//            $chatId = $message->getChat()->getId();
//            $answer = 'Enter /login -u <email> -p <password> for will working with bot';
//
//            $this->telegram->sendMessage($chatId, $answer);
//        });
//
//        $this->telegram->command('login', function ($message) {
//            $chatId = $message->getChat()->getId();
//            $msgStr = $message->getText();
//            $credentials = [];
//
//            preg_match('/\s-u.([A-Za-z0-9.^_]+@[A-Za-z0-9.^_]+)/', $msgStr, $credentials['email']);
//            preg_match('/-p.([A-Za-z0-9.^_]+)/', $msgStr, $credentials['password']);
//
//            if(Auth::attempt([
//                'email' => $credentials['email'][1],
//                'password' => $credentials['password'][1]
//            ])){
//                $user = Auth::user();
//                $this->userRepository->insert($user->id, ['telegram_id' => ((integer) $chatId)]);
//
//                $this->telegram->sendMessage($chatId, 'Authorized');
//            } else {
//                $this->telegram->sendMessage($chatId, 'Unauthorized');
//            }
//
//        });
//
//        $this->telegram->run();
//    }

    public function setWebhook()
    {
        $this->service->setWebhook();
    }
}
