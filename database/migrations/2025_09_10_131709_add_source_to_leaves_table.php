<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->enum('source', ['marked', 'requested'])->default('marked')->after('status');
            $table->foreignId('leave_request_id')->nullable()->constrained('leave_requests')->onDelete('cascade')->after('source');
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign(['leave_request_id']);
            $table->dropColumn(['source', 'leave_request_id']);
        });
    }
};