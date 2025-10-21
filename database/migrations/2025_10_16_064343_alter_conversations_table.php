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
        Schema::dropIfExists('conversations');
        Schema::enableForeignKeyConstraints();

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('ref_id');
            $table->date('date_created');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
