<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing enum to include 'planning'
        DB::statement("ALTER TABLE mtra_projects MODIFY COLUMN status ENUM('planning', 'berjalan', 'selesai') DEFAULT 'planning'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE mtra_projects MODIFY COLUMN status ENUM('berjalan', 'selesai') DEFAULT 'berjalan'");
    }
};
