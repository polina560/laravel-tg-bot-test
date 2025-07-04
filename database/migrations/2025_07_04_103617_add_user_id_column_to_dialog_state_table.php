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
        Schema::table('dialog_state', function (Blueprint $table) {
            $table->addColumn('text', 'user_id')->after('chat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dialog_state', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
