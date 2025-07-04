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
        Schema::create('dialog_state', function (Blueprint $table) {
            $table->id();
            $table->integer('chat_id');
            $table->integer('last_msg_id')->nullable();
            $table->integer('last_msg_time')->nullable();
            $table->integer('quantity_reminder_msg')->default(0)->nullable();
            $table->integer('ans_1')->default(0)->nullable();
            $table->integer('ans_2')->nullable();
            $table->integer('ans_3')->default(0)->nullable();
            $table->integer('ans_4')->default(0)->nullable();
            $table->integer('ans_5')->default(0)->nullable();
            $table->integer('remainder')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialog_state');
    }
};
