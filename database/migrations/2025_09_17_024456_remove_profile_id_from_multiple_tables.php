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
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropConstrainedForeignId('profile_id');

        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('profile_id');

        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('profile_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->foreignId('profile_id')->nullable()->constrained('profiles')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('staffs')) {
            Schema::table('staffs', function (Blueprint $table) {
                $table->foreignId('profile_id')->nullable()->constrained('profiles')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                $table->foreignId('profile_id')->nullable()->constrained('profiles')->cascadeOnDelete();
            });
        }

    }
};
