<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\TextResource;
use App\MoonShine\Resources\UserResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\TelegramMessageResource;
use App\MoonShine\Resources\TelegramImageResource;
use App\MoonShine\Resources\TelegramButtonResource;
use App\MoonShine\Resources\DialogStateResource;
use App\MoonShine\Resources\TelegramMessageButtonResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                TextResource::class,
                UserResource::class,
                TelegramMessageResource::class,
                TelegramImageResource::class,
                TelegramButtonResource::class,
                DialogStateResource::class,
                TelegramMessageButtonResource::class,
            ])
            ->pages([
                ...$config->getPages(),
            ]);
    }
}
