<?php

namespace App\Services\Telegram\Commands;

use App\Models\DialogState;
use App\Models\TelegramButton;
use App\Models\TelegramMessage;
use App\Services\Telegram\TelegramBot;
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

        if ($result = TelegramBot::isMember($chat_id, $user_id)) {
            return $result;
        }

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
        try {
            $text = TelegramMessage::where('key', 'play')
                ->where('serial_number', 1)
                ->first();
            if (!$text) {
                throw new \Exception('Сообщение не найдено');
            }

            TelegramBot::sendMediaGroup($text, $chat_id);

            $buttons = TelegramButton::where('key', '/play')->orderBy('serial_number')->get();

            TelegramBot::sendButtons($buttons, $chat_id, 'Выберете один вариант:');

            $dialog = DialogState::where(['user_id' => $user_id])->first();
            $dialog->last_msg_id = 1;
            $dialog->remainder = 5000; // TODO: занести значения в БД
            $dialog->saveQuietly();

            return $this->getCallbackQuery()->answer();
        } catch (\Exception $e) {
            error_log('Error in handleAnswerGetMoney: '.$e->getMessage());

            Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => $e->getMessage(),
            ]);

            return $this->getCallbackQuery()->answer();
        }
    }

    protected function handleActionPlay($chat_id, $user_id, $message_id, int $number): ServerResponse
    {
        Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'test',
        ]);

        // проверка на конец теста
        $dialog = DialogState::where('user_id', $user_id)->first();
        $last_text = TelegramMessage::where(['key' => 'play', 'serial_number' => $dialog->last_msg_id])->first();
        $button = TelegramButton::query()->where(['key' => '/play', 'serial_number' => $number])->first();
        if (!$button) {
            throw new \Exception('Сообщение не найдено');
        }

        $price = $button->value;
        if ($price <= $dialog->remainder) {
            $remainder = $dialog->remainder - $price;
            switch ($number) {
                case 1:
                    $dialog->ans_1 += 1;
                    break;
                case 2:
                    $dialog->ans_2 += 1;
                    break;
                case 3:
                    $dialog->ans_3 += 1;
                    break;
                case 4:
                    $dialog->ans_4 += 1;
                    break;
                case 5:
                    $dialog->ans_5 += 1;
                    break;
                default:
                    break;
            }
            $dialog->remainder = $remainder;
            $dialog->last_msg_id += 1;
            $dialog->saveQuietly();
        } else {
            Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'не хватает монет',
            ]);

            return $this->getCallbackQuery()->answer();
        }

        Request::deleteMessage([
            'chat_id' => $chat_id,
            'message_id' => $message_id,
        ]);

        //        if ($dialog->last_msg_id > 5) {
        //            return $this->sendEndTestMessage($chat_id, $dialog);
        //        }

        // отправка нового сообщения
        $text = TelegramMessage::where(['key' => 'play', 'serial_number' => $dialog->last_msg_id])->first();
        if (!$text) {
            $this->getCallbackQuery()->answer();
            throw new \Exception('Сообщение не найдено');
        }

        TelegramBot::sendMediaGroup($text, $chat_id, $price, $remainder);

        $buttons = TelegramButton::where('key', '/play')->orderBy('serial_number')->get();
        TelegramBot::sendButtons($buttons, $chat_id, 'Выберете один вариант:');

        return $this->getCallbackQuery()->answer();
    }
}
