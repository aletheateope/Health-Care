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
        Schema::create('patient_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_amount');
            $table->decimal('discount_amount')->nullable();
            $table->decimal('hmo_amount_coverage')->nullable();
            $table->decimal('insurance_amount_coverage')->nullable();
            $table->decimal('balance');
            $table->enum('status', ['unpaid', 'paid', 'partially_paid', 'cancelled'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_bills');
    }
};
