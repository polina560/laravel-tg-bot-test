<?php

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramButton extends Model
{
	protected $table =  'telegram_button';

    protected $fillable = [
		'serial_number',
		'name',
        'key',
		'callback_data',
		'url',
    ];

}
