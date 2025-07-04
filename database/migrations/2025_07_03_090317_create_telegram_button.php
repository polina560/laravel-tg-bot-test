<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_button', function (Blueprint $table) {
			$table->id();
			$table->integer('serial_number')->nullable();
			$table->string('name')->nullable();
			$table->foreignIdFor(\App\Models\TelegramMessage::class, 'telegram_message_id')
				->constrained()
				->cascadeOnDelete()
				->cascadeOnUpdate();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_button');
    }
};
