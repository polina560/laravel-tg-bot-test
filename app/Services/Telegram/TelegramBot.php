<?php

namespace App\Services\Telegram;

use App\Models\TelegramButton;
use App\Models\TelegramImage;
use App\Models\TelegramMessage;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class TelegramBot
{
    public static function isMember(string $chat_id, string $user_id): bool|ServerResponse
    {
        $member = Request::getChatMember(['chat_id' => '-1002520572812', 'user_id' => $user_id])->toJson();
        $member = json_decode($member, true);
        //        file_put_contents(public_path('storage') . '/message.txt', print_r($member, true));

        $status = $member['result']['status'];
        $member_statuses = ['creator', 'administrator', 'member'];

        if (!in_array($status, $member_statuses)) {
            return Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'не подписался',
                'reply_markup' => new InlineKeyboard([
                    ['text' => 'Подписался', 'callback_data' => 'is-member'],
                ]),
            ]);
        }

        return false;
    }

    public static function sendMediaGroup(TelegramMessage $text, string $chat_id, int $price = 0, int $reminder = 0): ServerResponse
    {
        if ($images = TelegramImage::where('telegram_message_id', $text->id)
            ->orderBy('serial_number')
            ->get()) {
            foreach ($images as $index => $image) {
                if ($index == 0) {
                    $media_group[] = new InputMediaPhoto(
                        [
                            'media' => public_path('images/').$image->image,
                            'caption' => sprintf($text->text, $price, $reminder),
                        ]
                    );
                } else {
                    $media_group[] = new InputMediaPhoto(['media' => public_path('images/').$image->image]);
                }
            }

            return Request::sendMediaGroup([
                'chat_id' => $chat_id,
                'media' => $media_group,
            ]);
        } else {
            return Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => $text->text,
            ]);
        }
    }

    public static function sendButtons(TelegramMessage $text, string $chat_id): ServerResponse|bool
    {
        if (!empty($buttons = TelegramButton::where('telegram_message_id', $text->id)
            ->orderBy('serial_number')
            ->get())) {
            foreach ($buttons as $button) {
                $keyboardButton[] = new InlineKeyboardButton(
                    ['text' => $button->name, 'callback_data' => 'is-member']);
            }

            return Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => $text->text,
                'reply_markup' => new InlineKeyboard($keyboardButton),
            ]);
        } else {
            return false;
        }
    }



    //    static function updateLastMessageTime($user_id, $chat_id): string
    //    {
    //        if ($dialog = DialogState::findOne(['user_id' => $user_id])) {
    //            $dialog->last_msg_time = time();
    //            $dialog->quantity_reminder_msg = 0;
    //            if (!$dialog->save()) {
    //                throw new ModelSaveException($dialog);
    //            }
    //            return 'update';
    //        } else {
    //            $dialog = new DialogState();
    //            $dialog->user_id = $user_id;
    //            $dialog->chat_id = $chat_id;
    //            $dialog->last_msg_time = time();
    //            $dialog->last_msg_id = 1;
    //            $dialog->remainder = 5000; //TODO: занести значения в БД
    //            if (!$dialog->save()) {
    //                throw new ModelSaveException($dialog);
    //            }
    //            return 'new';
    //        }
    //    }

    /**
     * @throws TelegramException
     */
    public static function checkUserBlocked(): void
    {
        $telegram = BotService::class->getTelegram();
        //        $dialogs = DialogState::find()->all();

        //        foreach ($dialogs as $dialog) {
        //            try {
        //                // Пытаемся отправить служебное сообщение
        //                $result = Request::sendChatAction([
        //                    'chat_id' => $dialog->chat_id,
        //                    'action' => 'typing',
        //                ]);
        //
        //                file_put_contents(
        //                    Yii::getAlias('@htdocs/uploads').'/message_updates.txt',
        //                    print_r($result, true)
        //                );
        //                if (!$result->isOk()) {
        //                    // Обработка случая, когда пользователь заблокировал бота
        //                    DialogState::findOne(['chat_id' => $dialog->chat_id])->delete();
        //                }
        //            } catch (\Throwable $e) {
        //                Yii::error('Error checking user block status: '.$e->getMessage());
        //            }
        //        }
    }
}
