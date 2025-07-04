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
			$table->string('url')->nullable();
			$table->string('callback_data')->nullable();
			$table->string('key')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_message_button');
    }
};
