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
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('staffs');
        Schema::enableForeignKeyConstraints();

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone_number');
            $table->string('contact_email');
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->text('medical_history')->nullable();
            $table->timestamps();
        });


        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_specialty_id')->nullable()->constrained()->nullableOnDelete();
            $table->string('license_number');
            $table->string('room_number');
            $table->string('clinic_phone_number');
            $table->string('doctor_note');
            $table->timestamps();
        });

        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('staffs');
        Schema::enableForeignKeyConstraints();
    }
};
