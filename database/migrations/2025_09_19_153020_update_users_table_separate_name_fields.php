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
        Schema::table('users', function (Blueprint $table) {
            // Rename name column to first_name
            $table->renameColumn('name', 'first_name');
            
            // Add last_name column
            $table->string('last_name')->after('first_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add name column back
            $table->string('name')->after('id');
            
            // Drop last_name column
            $table->dropColumn('last_name');
            
            // Rename first_name back to name
            $table->renameColumn('first_name', 'name');
        });
    }
};