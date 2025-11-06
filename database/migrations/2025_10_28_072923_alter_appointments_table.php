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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['service_id']);

            $table->foreignId('doctor_id')
              ->nullable()
              ->change();

            // Finally, re-add the constraint with ON DELETE SET NULL
            $table->foreign('doctor_id')
                ->references('id')->on('doctors')
                ->nullOnDelete();

            $table->foreignId('service_id')
             ->nullable()
             ->change();

            // Finally, re-add the constraint with ON DELETE SET NULL
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['service_id']);

            $table->foreignId('doctor_id')
              ->change();

            // Finally, re-add the constraint with CASCADE ON DELETE
            $table->foreign('doctor_id')
                ->references('id')->on('doctors')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
             ->change();

            // Finally, re-add the constraint with CASCADE ON DELETE
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->cascadeOnDelete();
        });
    }
};
