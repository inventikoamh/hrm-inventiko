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
        // Update tasks table priority column from ENUM to VARCHAR
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('priority')->default('medium')->change();
        });

        // Update projects table priority column from ENUM to VARCHAR
        Schema::table('projects', function (Blueprint $table) {
            $table->string('priority')->default('medium')->change();
        });

        // Update projects table status column from ENUM to VARCHAR
        Schema::table('projects', function (Blueprint $table) {
            $table->string('status')->default('planned')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert tasks table priority column back to ENUM
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->change();
        });

        // Revert projects table priority column back to ENUM
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->change();
        });

        // Revert projects table status column back to ENUM
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['planned', 'in_progress', 'on_hold', 'completed'])->default('planned')->change();
        });
    }
};
