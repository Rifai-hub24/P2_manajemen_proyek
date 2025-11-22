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
        Schema::table('project_members', function (Blueprint $table) {
            // Menambah kolom untuk menyimpan role asli user saat bergabung
            if (!Schema::hasColumn('project_members', 'role_at_join')) {
                $table->string('role_at_join')->nullable()->after('role');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_members', function (Blueprint $table) {
            if (Schema::hasColumn('project_members', 'role_at_join')) {
                $table->dropColumn('role_at_join');
            }
        });
    }
};
