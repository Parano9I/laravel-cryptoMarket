<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TelegramBot\Api\Client as TelegramClient;

class TelegramController extends Controller
{

    private TelegramClient $telegram;
    private string $botToken;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->botToken = config('services.telegram.token');
        $this->telegram = new TelegramClient($this->botToken);
    }

    public function index(Request $request)
    {
        $this->telegram->command('start', function ($message) {
            $chatId = $message->getChat()->getId();
            $answer = 'Enter /login -u <email> -p <password> for will working with bot';

            $this->telegram->sendMessage($chatId, $answer);
        });

        $this->telegram->command('login', function ($message) {
            $chatId = $message->getChat()->getId();
            $msgStr = $message->getText();
            $credentials = [];

            preg_match('/\s-u.([A-Za-z0-9.^_]+@[A-Za-z0-9.^_]+)/', $msgStr, $credentials['email']);
            preg_match('/-p.([A-Za-z0-9.^_]+)/', $msgStr, $credentials['password']);

            if(Auth::attempt([
                'email' => $credentials['email'][1],
                'password' => $credentials['password'][1]
            ])){
                $user = Auth::user();
                $this->userRepository->insert($user->id, ['telegram_id' => ((integer) $chatId)]);

                $this->telegram->sendMessage($chatId, 'Authorized');
            } else {
                $this->telegram->sendMessage($chatId, 'Unauthorized');
            }

        });

        $this->telegram->run();
    }

    public function setWebhook(Client $httpClient)
    {
        $telegramApiUrl = 'https://api.telegram.org/bot';
        $telegramApiUrlWithBotToken = $telegramApiUrl . $this->botToken;
        $httpsPathMyServerWithBotController = config('app.https_url') . '/api/bot/';

        $httpClient->get(
            $telegramApiUrlWithBotToken . '/setWebhook',
            [
                'query' => ['url' => $httpsPathMyServerWithBotController],
            ]
        );
    }
}
