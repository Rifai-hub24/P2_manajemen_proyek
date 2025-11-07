<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM('pending','admin','team_lead','developer','designer') 
            NOT NULL DEFAULT 'pending'
        ");
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM('admin','team_lead','developer','designer') 
            NOT NULL DEFAULT 'developer'
        ");
    }
};