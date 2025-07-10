<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramButton extends Model
{
    protected $table = 'telegram_button';

    protected $fillable = [
        'serial_number',
        'name',
        'text',
        'key',
        'callback_data',
        'url',
    ];

}
