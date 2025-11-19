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
        Schema::create('patient_bill_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_bill_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount');
            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_bill_transactions');
    }
};
