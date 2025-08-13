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
        Schema::table('mtra_photos', function (Blueprint $table) {
            // Drop the old photo_path column if it exists
            if (Schema::hasColumn('mtra_photos', 'photo_path')) {
                $table->dropColumn('photo_path');
            }
            
            // Add the new path column
            if (!Schema::hasColumn('mtra_photos', 'path')) {
                $table->string('path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtra_photos', function (Blueprint $table) {
            // Drop the new path column
            if (Schema::hasColumn('mtra_photos', 'path')) {
                $table->dropColumn('path');
            }
            
            // Add back the old photo_path column
            if (!Schema::hasColumn('mtra_photos', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }
        });
    }
};
