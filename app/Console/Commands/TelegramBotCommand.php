<?php

namespace App\Console\Commands;


use App\Services\Telegram\BotService;
use Illuminate\Console\Command;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TelegramBotCommand extends Command
{

    protected $signature = 'telegram:bot {--webhook}';
    protected $description = 'Run Telegram bot in polling or webhook mode';

    /**
     * @throws TelegramException
     */
    public function handle(BotService $botService): void
    {
        $telegram = $botService->getTelegram();

        $commands = [
            ['command' => 'start', 'description' => 'Запуск бота'],
            ['command' => 'info', 'description' => 'Информация о боте'],
            ['command' => 'share', 'description' => 'Поделиться'],
        ];
        Request::setMyCommands([
            'commands' => json_encode($commands),
        ]);

        if ($this->option('webhook')) {
            $telegram->setWebhook(config('telegram.webhook.url'));
            $this->info('Webhook mode activated!');
        } else {
            $telegram->useGetUpdatesWithoutDatabase();
            $this->info('Polling mode activated!');
            while (true) {
                $telegram->handleGetUpdates();
            }
        }
    }
}
