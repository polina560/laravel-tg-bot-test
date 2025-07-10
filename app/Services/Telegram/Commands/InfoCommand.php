<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramButton;
use App\Models\TelegramMessage;
use App\Services\Telegram\TelegramBot;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
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
        $user_id = $message->getFrom()->getId();


        DialogState::updateLastMessageTime($user_id, $chat_id);

        if ($result = TelegramBot::isMember($chat_id, $user_id)) {
            return $result;
        }

//        $text = TelegramMessage::where('key', '/getInfo')->first();
        $buttons = TelegramButton::where('key', '/getInfo')->get();
        foreach ($buttons as $button) {
            $keyboardButton[] = new InlineKeyboardButton(
                ['text' => $button->name, 'url' => $button->url]);
        }

        return Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Узнать подробнее можно тут:',
            'reply_markup' => new InlineKeyboard($keyboardButton),
        ]);
    }
}
