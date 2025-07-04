<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramMessage;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Exception\TelegramException;

class GenericmessageCommand extends UserCommand
{
    protected $name = 'genericmessage';
    protected $description = 'Handle generic messages';

    /**
     * @throws TelegramException
     */
    public function execute(): \Longman\TelegramBot\Entities\ServerResponse
    {
        $message = $this->getMessage();
        $chat_id = $message->getFrom()->getId();
        $user_id = $message->getFrom()->getId();

        DialogState::updateLastMessageTime($user_id, $chat_id);

        $text = TelegramMessage::where('key', '/default')->first();

        return $this->replyToChat($text->text);
    }
}
