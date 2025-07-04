<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramMessage;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class CallbackqueryCommand extends SystemCommand
{

    protected $name = 'callbackquery';
    protected $description = 'Handle the callback query';
    protected $version = '1.0.0';


    public function execute(): ServerResponse
    {
        $callback_query = $this->getCallbackQuery();
        $callback_data = $callback_query->getData();
        $user_id = $callback_query->getFrom()->getId();
        $chat_id = $callback_query->getMessage()->getChat()->getId();
        $message_id = $callback_query->getMessage()->getMessageId();

        //  обновление записи диолга с пользователем
        DialogState::updateLastMessageTime($user_id, $chat_id);

        switch ($callback_data) {
            case 'get-money':
                return $this->handleAnswerGetMoney($chat_id, $user_id);
            case 'play_1':
                return $this->handleActionPlay($chat_id, $user_id, $message_id, 1);
            case 'play_2':
                return $this->handleActionPlay($chat_id, $user_id, $message_id, 2);
            case 'play_3':
                return $this->handleActionPlay($chat_id, $user_id, $message_id, 3);
            case 'play_4':
                return $this->handleActionPlay($chat_id, $user_id, $message_id, 4);
            case 'play_5':
                return $this->handleActionPlay($chat_id, $user_id, $message_id, 5);
            default:
                return Request::answerCallbackQuery([
                    'callback_query_id' => $callback_query->getId(),
                    'text' => 'Неизвестная команда',
                    'show_alert' => false,
                ]);
        }
    }

    protected function handleAnswerGetMoney($chat_id, $user_id): ServerResponse
    {
        $callback_query = $this->getCallbackQuery();

        try {
            $text = TelegramMessage::where(['key' => 'play'])
                ->andWhere(['serial_number' => 1])
                ->one();
            if (!$text) {
                throw new \Exception('Сообщение не найдено');
            }

            $messageResponse = $this->sendTestMessage($text, $chat_id);

            $dialog = DialogState::where(['user_id' => $user_id])->one();
            $dialog->last_msg_id = 1;
            $dialog->remainder = 5000; //TODO: занести значения в БД
            $dialog->saveQuietly();

            $callback_query->answer([
                'text'       => 'OK',
                'show_alert' => false,
            ]);

            return $messageResponse;
        } catch (\Exception $e) {
            error_log('Error in handleAnswerGetMoney: ' . $e->getMessage());

            $callback_query->answer([
                'text'       => 'ERROR',
                'show_alert' => false,
            ]);
            return Request::sendMessage([
                'chat_id' => $chat_id . $e->getMessage(),
                'text' => 'Произошла ошибка, попробуйте позже'
            ]);
        }
    }
}
