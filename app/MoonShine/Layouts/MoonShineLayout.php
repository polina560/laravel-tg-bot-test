<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\DialogStateResource;
use App\MoonShine\Resources\TelegramButtonResource;
use App\MoonShine\Resources\TelegramImageResource;
use App\MoonShine\Resources\TelegramMessageResource;
use App\MoonShine\Resources\TextResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\Layout\Layout;
use Override;

final class MoonShineLayout extends AppLayout
{
    #[Override]
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    #[Override]
    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make('Пользователи', UserResource::class),
            MenuItem::make('Тексты', TextResource::class),
            MenuGroup::make('Телеграм Бот', [
                MenuItem::make('Сообщения', TelegramMessageResource::class),
                //            MenuItem::make('Изображения', TelegramImageResource::class),
                MenuItem::make('Кнопки', TelegramButtonResource::class),
                MenuItem::make('Диалоги пользователей', DialogStateResource::class),
            ]),
        ];
    }

    /**
     * @param  ColorManager  $colorManager
     */
    #[Override]
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);
        // $colorManager->primary('#00000');
    }

    #[Override]
    protected function getFooterMenu(): array
    {
        return [];
    }

    #[Override]
    protected function getFooterCopyright(): string
    {
        return '';
    }

    #[Override]
    public function build(): Layout
    {
        return parent::build();
    }
}
