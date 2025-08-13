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
        Schema::table('mtra_projects', function (Blueprint $table) {
            $table->boolean('ped_approved')->nullable()->after('status');
            $table->timestamp('ped_reviewed_at')->nullable()->after('ped_approved');
            $table->text('ped_notes')->nullable()->after('ped_reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mtra_projects', function (Blueprint $table) {
            $table->dropColumn(['ped_approved', 'ped_reviewed_at', 'ped_notes']);
        });
    }
};
