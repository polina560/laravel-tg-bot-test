<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\TelegramMessage;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<TelegramMessage>
 */
class TelegramMessageResource extends ModelResource
{
    protected string $model = TelegramMessage::class;

    public function getTitle(): string
    {
        return 'Сообщения';
    }

    public function indexFields(): iterable
    {
        // TODO correct labels values
        return [
            ID::make('id')
                ->sortable(),
            Text::make('Text', 'text'),
            //            Text::make('Button Text', 'btn_text'),
            Number::make('SerialNumber', 'serial_number'),
            Text::make('Key', 'key'),
        ];
    }

    public function formFields(): iterable
    {
        return [
            Box::make([
                ID::make('id')
                    ->sortable(),
                Text::make('Text', 'text'),
                //                Text::make('Button Text', 'btn_text'),
                Number::make('SerialNumber', 'serial_number'),
                Text::make('Key', 'key'),
                RelationRepeater::make('Images', 'telegramImages', resource: TelegramImageResource::class)
                    ->creatable(limit: 10)
                    ->removable()
                    ->vertical(),
                RelationRepeater::make('Buttons', 'telegramButtons', resource: TelegramButtonResource::class)
                    ->creatable(limit: 10)
                    ->removable()
                    ->vertical(),
            ]),

        ];
    }

    public function detailFields(): iterable
    {
        return [
            ID::make('id')
                ->sortable(),
            Text::make('Text', 'text'),
            //            Text::make('Button Text', 'btn_text'),
            Number::make('SerialNumber', 'serial_number'),
            Text::make('Key', 'key'),
            RelationRepeater::make('Images', 'telegramImages', resource: TelegramImageResource::class)
                ->vertical()
                ->fields([
                    Image::make('Image', 'image'),
                ]),
            RelationRepeater::make('Buttons', 'telegramButtons', resource: TelegramButtonResource::class)
                ->vertical()
                ->fields([
                    Text::make('Name', 'name'),
                ]),
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
            'key' => ['string', 'nullable'],
            'text' => ['string', 'nullable'],
            'btn_text' => ['string', 'nullable'],
        ];
    }
}
