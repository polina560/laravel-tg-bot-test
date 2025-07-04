<?php

use App\Services\Telegram\BotService;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', function (BotService $bot) {
    $bot->getTelegram()->handle();
    return response()->noContent();
});
?>
