<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ubah enum role, tambahkan 'keluar'
            $table->enum('role', ['pending','admin','team_lead','developer','designer','keluar'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan seperti semula tanpa 'keluar'
            $table->enum('role', ['pending','admin','team_lead','developer','designer'])
                  ->default('pending')
                  ->change();
        });
    }
};
