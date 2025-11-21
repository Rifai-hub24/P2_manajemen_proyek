<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan pada database.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom reset_code
            $table->string('reset_code')->nullable()->after('password');
        });
    }

    /**
     * Kembalikan perubahan (rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom reset_code jika rollback dijalankan
            $table->dropColumn('reset_code');
        });
    }
};