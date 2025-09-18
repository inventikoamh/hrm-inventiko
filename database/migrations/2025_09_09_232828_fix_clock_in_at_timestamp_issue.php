<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix the clock_in_at column to remove ON UPDATE current_timestamp()
        DB::statement('ALTER TABLE attendances MODIFY COLUMN clock_in_at timestamp NOT NULL DEFAULT current_timestamp()');
    }

    public function down(): void
    {
        // Revert back to the original with ON UPDATE
        DB::statement('ALTER TABLE attendances MODIFY COLUMN clock_in_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()');
    }
};