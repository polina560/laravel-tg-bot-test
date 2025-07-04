<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\TelegramImage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<TelegramImage>
 */
class TelegramImageResource extends ModelResource
{
    protected string $model = TelegramImage::class;

    protected array $with = ['telegramMessage'];

    public function getTitle(): string
    {
        return 'Изображения';
    }

    public function indexFields(): iterable
    {
        // TODO correct labels values
        return [
            ID::make('id')
                ->sortable(),
            Number::make('SerialNumber', 'serial_number'),
            Image::make('Image', 'image'),
        ];
    }

    public function formFields(): iterable
    {
        return [
            Box::make([
                ...$this->indexFields(),
            ]),
        ];
    }

    public function detailFields(): iterable
    {
        return [
            ...$this->indexFields(),
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
            'image' => ['file', 'nullable'],
            'telegram_message_id' => ['int', 'required'],
        ];
    }
}
