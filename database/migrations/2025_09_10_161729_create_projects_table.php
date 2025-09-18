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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('estimated_start_date');
            $table->integer('estimated_days');
            $table->foreignId('project_lead_id')->constrained('users')->onDelete('cascade');
            $table->json('team_members')->nullable(); // Array of user IDs
            $table->decimal('project_budget', 15, 2)->nullable();
            $table->string('currency', 3)->default('USD'); // ISO currency code
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['planned', 'in_progress', 'on_hold', 'completed'])->default('planned');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'priority']);
            $table->index('project_lead_id');
            $table->index('estimated_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};