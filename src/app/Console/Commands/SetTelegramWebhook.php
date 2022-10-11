<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class SetTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:set-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is set telegram webhook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TelegramService $service)
    {
        $service->setWebhook();

        $this->info('Webhook set');
    }
}
