<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramMessage;
use App\Services\Telegram\TelegramBot;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class StartCommand extends UserCommand
{
    protected $name = 'start';
    protected $description = 'Start command';

    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $chat_id = $message->getFrom()->getId();
        $user_id = $message->getFrom()->getId();

        if ($result = TelegramBot::isMember($chat_id, $user_id)) {
            return $result;
        }

        $text = TelegramMessage::where('key', '/start')->first();

        TelegramBot::sendMediaGroup($text, $chat_id);

        // TODO: текст для конпки добавить в TelegramMessage + callback_data
        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Нажми на кнопку, чтобы получить монеты!',
            'reply_markup' => new InlineKeyboard([
                ['text' => 'Получить монеты', 'callback_data' => 'is-member'],
            ]),
        ]);
    }
}
