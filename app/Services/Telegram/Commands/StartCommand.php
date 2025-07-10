<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramButton;
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

        //  создание новой записи диолга с пользователем
        DialogState::updateLastMessageTime($user_id, $chat_id);

        $text = TelegramMessage::where('key', '/start')->first();

        // отправка начального сообщения с изображениями (если они есть)
        TelegramBot::sendMediaGroup($text, $chat_id);

        $button = TelegramButton::where('key', '/getMoney')->first();
        //
        //        // отправка сообщения с кнопкой для получения монет
        //        TelegramBot::sendButtons($buttons, $chat_id);

        Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => $button->text,
            'reply_markup' => new InlineKeyboard([
                ['text' => $button->name, 'callback_data' => 'get-money'],
            ]),
        ]);

        return Request::answerCallbackQuery([
            'show_alert' => false,
        ]);
    }
}
