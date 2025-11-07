<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('comment_id');
            
            // Relasi ke card atau subtask
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('subtask_id')->nullable();
            
            // User yang berkomentar
            $table->unsignedBigInteger('user_id');

            // Isi komentar
            $table->text('comment_text');
            
            // Jenis komentar
            $table->enum('comment_type', ['card', 'subtask']);

            // Timestamp
            $table->timestamps();

            // Foreign Keys
            $table->foreign('card_id')->references('card_id')->on('cards')->onDelete('cascade');
            $table->foreign('subtask_id')->references('subtask_id')->on('subtasks')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
