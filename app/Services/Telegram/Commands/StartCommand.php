<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramMessage;
use App\Services\Telegram\TelegramBot;
use Longman\TelegramBot\Commands\UserCommand;
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
        //  создание новой записи диолга с пользователем
        DialogState::updateLastMessageTime($user_id, $chat_id);

        // отправка начального сообщения с изображениями (если они есть)
        $text = TelegramMessage::where('key', '/start')->first();

        TelegramBot::sendMediaGroup($text, $chat_id);

        // отправка сообщения с кнопкой для получения монет
        $text = TelegramMessage::where('key', '/getMoney')->first();

        TelegramBot::sendButtons($text, $chat_id);

        return Request::answerCallbackQuery([
            'text' => 'Бот запущен',
            'show_alert' => false,
        ]);
    }
}
