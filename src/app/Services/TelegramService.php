<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleHttp;
use Illuminate\Pipeline\Pipeline;
use TelegramBot\Api\Client as TelegramClient;
use TelegramBot\Api\Types\Update;

class TelegramService
{
    private string $apiUrl = 'https://api.telegram.org/bot';
    private string $commandPattern = '/^\/[a-z:A-Z]+/';
    private TelegramClient $telegram;
    private GuzzleHttp $httpClient;
    private string $token;

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
        $this->telegram->on(
            function (Update $update) use ($commandActions) {
                $message = $update->getMessage();
                $isCommand = preg_match($this->commandPattern, $message->getText());
                $answer = 'sds';

                if ($isCommand) {

                    $transformedMessage = $this->getTransformedMessage($message);
                    $result = app(Pipeline::class)
                        ->send($transformedMessage)
                        ->through($commandActions)
                        ->via('apply')
                        ->then(function ($result) {
                            return $result;
                        });

                    if(isset($result['answer'])) {
                        $result = $result['answer'];
                    } else {
                        $result = 'This command does not exist.';
                    }

                    $this->telegram->sendMessage($transformedMessage['chat_id'],'<pre>' . $result . '</pre>', 'html');

                } else {

                    $this->telegram->sendMessage($message->getChat()->getId(), 'This command does not exist.', 'html');
                }

            }, fn() => true);

        $this->telegram->run();
    }

    private function getTransformedMessage($initialMessage)
    {
        $messageText = $initialMessage->getText();
        $matches = [];

        $matches['text'] = preg_replace($this->commandPattern, '', $messageText);
        preg_match($this->commandPattern, $messageText, $matches['command']);

        return [
            'command' => trim($matches['command'][0]),
            'text' => trim($matches['text']),
            'chat_id' => $initialMessage->getChat()->getId(),
        ];
    }
}
