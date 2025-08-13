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
        // Add 'ped' to the enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'partner', 'ped') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'ped' from the enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'partner') DEFAULT 'user'");
    }
};
