<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::table('subtasks', function (Blueprint $table) {
                $table->boolean('is_blocked')->default(false)->after('status');
                $table->string('block_reason')->nullable()->after('is_blocked');
            });
        }

        public function down()
        {
            Schema::table('subtasks', function (Blueprint $table) {
                $table->dropColumn(['is_blocked', 'block_reason']);
            });
        }
};
