<?php

namespace App\Services\Telegram\Commands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class InfoCommand extends UserCommand
{
    protected $name = 'info';
    protected $description = 'Info command';
    protected $usage = '/info';
    protected $version = '1.0.0';

    /**
     * @throws TelegramException
     */
    public function execute(): \Longman\TelegramBot\Entities\ServerResponse
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        //        TelegramBot::updateLastMessageTime($user_id, $chat_id);

        // TODO: занести значение в БД
        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Выберите действие:',
            'reply_markup' => new InlineKeyboard([
                ['text' => 'Официальный сайт', 'url' => 'https://example.com'],
            ]),
        ]);
    }
}
