<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('project_members', function (Blueprint $table) {
            // ubah role_at_join menjadi string supaya bisa menyimpan semua nilai
            $table->string('role_at_join')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('project_members', function (Blueprint $table) {
            // kembalikan ke enum jika undo
            $table->enum('role_at_join', ['admin','team_lead','developer','designer'])
                  ->nullable()
                  ->change();
        });
    }
};
