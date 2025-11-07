<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'card_id',
        'subtask_id',
        'user_id',
        'comment_text',
        'comment_type',
        'parent_id'
    ];

    // 🔹 Relasi ke user (penulis komentar)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // 🔹 Relasi ke card (jika komentar milik card)
    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id', 'card_id');
    }

    // 🔹 Relasi ke subtask (jika komentar milik subtask)
    public function subtask()
    {
        return $this->belongsTo(Subtask::class, 'subtask_id', 'subtask_id');
    }

    // 🔹 Relasi ke komentar induk (parent comment)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'comment_id');
    }

    // 🔹 Relasi ke komentar balasan (nested replies)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'comment_id')
                    ->with(['user', 'parent', 'replies']); // agar rekursif dan lengkap
    }
}