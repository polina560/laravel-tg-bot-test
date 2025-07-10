<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramMessage extends Model
{
    protected $table = 'telegram_message';

    protected $fillable = [
        'serial_number',
        'key',
        'text',
    ];

    public function telegramImages(): HasMany
    {
        return $this->hasMany(TelegramImage::class, 'telegram_message_id', 'id');
    }




}
