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
        // Update tasks table status column from ENUM to VARCHAR
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // Update leave_balances table leave_type column from ENUM to VARCHAR
        Schema::table('leave_balances', function (Blueprint $table) {
            $table->string('leave_type')->change();
        });

        // Update leaves table type column from ENUM to VARCHAR
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('type')->change();
        });

        // Update leaves table status column from ENUM to VARCHAR
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // Update leaves table source column from ENUM to VARCHAR
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('source')->default('marked')->change();
        });

        // Update leave_requests table type column from ENUM to VARCHAR
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->string('type')->change();
        });

        // Update leave_requests table status column from ENUM to VARCHAR
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });

        // Update attendance_logs table type column from ENUM to VARCHAR
        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert tasks table status column back to ENUM
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->change();
        });

        // Revert leave_balances table leave_type column back to ENUM
        Schema::table('leave_balances', function (Blueprint $table) {
            $table->enum('leave_type', ['sick', 'casual', 'festival', 'privilege', 'emergency'])->change();
        });

        // Revert leaves table type column back to ENUM
        Schema::table('leaves', function (Blueprint $table) {
            $table->enum('type', ['sick', 'casual', 'festival', 'privilege', 'emergency'])->change();
        });

        // Revert leaves table status column back to ENUM
        Schema::table('leaves', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });

        // Revert leaves table source column back to ENUM
        Schema::table('leaves', function (Blueprint $table) {
            $table->enum('source', ['marked', 'requested'])->default('marked')->change();
        });

        // Revert leave_requests table type column back to ENUM
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->enum('type', ['sick', 'casual', 'festival', 'privilege', 'emergency'])->change();
        });

        // Revert leave_requests table status column back to ENUM
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });

        // Revert attendance_logs table type column back to ENUM
        Schema::table('attendance_logs', function (Blueprint $table) {
            $table->enum('type', ['clock_in', 'clock_out'])->change();
        });
    }
};
