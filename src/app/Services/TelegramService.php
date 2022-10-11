<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleHttp;
use Illuminate\Pipeline\Pipeline;
use TelegramBot\Api\Client as TelegramClient;

class TelegramService
{
    private string $apiUrl = 'https://api.telegram.org/bot';
    private string $token;
    private GuzzleHttp $httpClient;
    private TelegramClient $telegram;

    public function __construct(GuzzleHttp $httpClient)
    {
        $this->token = config('services.telegram.token');
        $this->httpClient = $httpClient;
        $this->telegram = new TelegramClient($this->token);
    }

    public function setWebhook()
    {
        $httpsUrlOfThisServer = config('app.https_url');
        $telegramApiUrlWithBotToken = $this->apiUrl . $this->token;
        $httpsUrlOfThisServerWithBotController = $httpsUrlOfThisServer . '/api/bot/';

        $this->httpClient->get(
            $telegramApiUrlWithBotToken . '/setWebhook',
            [
                'query' => ['url' => $httpsUrlOfThisServerWithBotController],
            ]
        );
    }

    public function routesPipeline(array $commandActions)
    {

        $this->telegram->command(
            '/^\/[a-zA-Z]+/',
            function ($message) use ($commandActions) {
                $messageNow = $this->getTarnsformedMessage($message);

                $result = app(Pipeline::class)
                    ->send($message)
                    ->through($commandActions)
                    ->via('apply')
                    ->then(function ($result) {
                        return $result;
                    });

                $this->telegram->sendMessage($message->getChat()->getId(), $result);

            });

        $this->telegram->run();
    }

    private function getTarnsformedMessage($initialMessage){
        $messageText = $initialMessage->text();

        $matches = [];
        preg_match('/^\/[a-zA-Z]+/', $messageText, $matches['command']);
        preg_replace('/^\/[a-zA-Z]+./', $messageText, $matches['text']);

        return [
            'command' => $matches['command'],
            'text' => $matches['text'],
        ];
    }

}
