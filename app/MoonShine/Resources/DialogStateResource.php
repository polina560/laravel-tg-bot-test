<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\DialogState;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<DialogState>
 */
class DialogStateResource extends ModelResource
{
    protected string $model = DialogState::class;

    public function getTitle(): string
    {
        return 'Диалоги пользователей';
    }

    public function indexFields(): iterable
    {
        // TODO correct labels values
        return [
			ID::make('id')
				->sortable(),
			Number::make('ChatId', 'chat_id'),
			Number::make('UserId', 'user_id'),
			Number::make('LastMsgId', 'last_msg_id'),
			Number::make('LastMsgTime', 'last_msg_time'),
			Number::make('QuantityReminderMsg', 'quantity_reminder_msg')
				->default(0),
			Number::make('Ans1', 'ans_1')
				->default(0),
			Number::make('Ans2', 'ans_2'),
			Number::make('Ans3', 'ans_3')
				->default(0),
			Number::make('Ans4', 'ans_4')
				->default(0),
			Number::make('Ans5', 'ans_5')
				->default(0),
			Number::make('Remainder', 'remainder')
				->default(0),
        ];
    }

    public function formFields(): iterable
    {
        return [
            Box::make([
                ...$this->indexFields()
            ])
        ];
    }

    public function detailFields(): iterable
    {
        return [
            ...$this->indexFields()
        ];
    }

    public function filters(): iterable
    {
        return [
        ];
    }

    public function rules(mixed $item): array
    {
        // TODO change it to your own rules
        return [
			'chat_id' => ['int', 'required'],
			'user_id' => ['int', 'required'],
			'last_msg_id' => ['int', 'nullable'],
			'last_msg_time' => ['int', 'nullable'],
			'quantity_reminder_msg' => ['int', 'nullable'],
			'ans_1' => ['int', 'nullable'],
			'ans_2' => ['int', 'nullable'],
			'ans_3' => ['int', 'nullable'],
			'ans_4' => ['int', 'nullable'],
			'ans_5' => ['int', 'nullable'],
			'remainder' => ['int', 'nullable'],
        ];
    }
}
