<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\TelegramButton;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<TelegramButton>
 */
class TelegramButtonResource extends ModelResource
{
    protected string $model = TelegramButton::class;

    public function getTitle(): string
    {
        return 'Кнопки';
    }

    public function indexFields(): iterable
    {
        // TODO correct labels values
        return [
			ID::make('id')
				->sortable(),
			Number::make('SerialNumber', 'serial_number'),
			Text::make('Name', 'name'),
			Text::make('Key', 'key'),
			Text::make('CallbackData', 'callback_data'),
			Text::make('Url', 'url'),
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
			'serial_number' => ['int', 'nullable'],
			'name' => ['string', 'required'],
			'callback_data' => ['string', 'nullable'],
			'url' => ['string', 'nullable'],
        ];
    }
}
