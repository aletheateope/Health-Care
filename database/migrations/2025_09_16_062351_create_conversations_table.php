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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('conversations_messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
        Schema::enableForeignKeyConstraints();



        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->date('date_created');
            $table->timestamps();
        });

        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('conversations_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->nullOnDelete();
            $table->text('message');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('conversations_messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
        Schema::enableForeignKeyConstraints();

    }
};
