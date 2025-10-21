<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('conversations_messages', 'conversation_messages');
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('conversation_messages', 'conversations_messages');
    }
};
