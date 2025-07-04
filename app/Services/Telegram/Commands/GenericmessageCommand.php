<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramMessage;
use Illuminate\Support\Facades\DB;
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
        $text = TelegramMessage::where('key', '/default')->first()->text;

        return $this->replyToChat($text);
    }
}
