<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DialogState extends Model
{
    protected $table = 'dialog_state';

    protected $fillable = [
        'chat_id',
        'user_id',
        'last_msg_id',
        'last_msg_time',
        'quantity_reminder_msg',
        'ans_1',
        'ans_2',
        'ans_3',
        'ans_4',
        'ans_5',
        'remainder',
    ];

    /**
     * @param string $user_id
     * @param string $chat_id
     * @return string
     */
    public static function updateLastMessageTime(string $user_id, string $chat_id): string
    {
        if ($dialog = DialogState::where('user_id', $user_id)->first()) {
            $dialog->last_msg_time = time();
            $dialog->saveQuietly();

            return 'update';
        } else {
            $dialog = new DialogState;
            $dialog->user_id = $user_id;
            $dialog->chat_id = $chat_id;
            $dialog->last_msg_time = time();
            $dialog->saveQuietly();

            return 'new';
        }
    }
}
