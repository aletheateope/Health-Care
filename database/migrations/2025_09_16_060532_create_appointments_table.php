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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('patient_hmo_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_insurance_id')->nullable()->constrained()->nullOnDelete();
            $table->string('chief_complaint');
            $table->enum('status', ['upcoming', 'completed', 'canceled'])->default('upcoming');
            $table->enum('appoinment_type', ['walk-in', 'online'])->default('online');
            $table->date('date_booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
