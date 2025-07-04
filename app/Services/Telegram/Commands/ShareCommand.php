<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Services\Telegram\TelegramBot;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class ShareCommand extends UserCommand
{
    protected $name = 'share';
    protected $description = 'Share command';
    protected $usage = '/share';
    protected $version = '1.0.0';

    /**
     * @throws TelegramException
     */
    public function execute(): \Longman\TelegramBot\Entities\ServerResponse
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();

        DialogState::updateLastMessageTime($user_id, $chat_id);

        if ($result = TelegramBot::isMember($chat_id, $user_id)) {
            return $result;
        }

        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Выберите чат, в котором хотите поделиться ботом:',
            'reply_markup' => new InlineKeyboard([
                ['text' => 'Поделиться', 'switch_inline_query' => 'подпишись '],
            ]),
        ]);
    }
}
