<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramImage extends Model
{
    protected $table = 'telegram_image';

    protected $fillable = [
        'serial_number',
        'image',
        'value',
        'telegram_message_id',
    ];

    public function telegramMessage(): BelongsTo
    {
        return $this->belongsTo(TelegramMessage::class, 'telegram_message_id');
    }
}
