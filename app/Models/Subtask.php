<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $primaryKey = 'subtask_id';
    public $timestamps = false;

    protected $fillable = [
        'card_id','subtask_title','description','status',
        'estimated_hours','actual_hours','position','created_at','reject_reason','reject_reason','is_blocked','block_reason' // ← tambahkan ini
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id', 'card_id');
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class, 'subtask_id', 'subtask_id');
    }
    public function comments()
    {
       return $this->hasMany(Comment::class, 'subtask_id', 'subtask_id')->whereNull('parent_id');
    }
    public function assignedUser()
    {
        // Gunakan log_id (bukan id) sebagai primary key untuk relasi hasOneOfMany
        return $this->hasOne(TimeLog::class, 'subtask_id', 'subtask_id')
                ->with('user')
                ->latestOfMany('log_id');
    }


    protected static function booted()
    {
        static::saved(function ($subtask) {
           $subtask->card->updateActualHours();
        });

        static::deleted(function ($subtask) {
           $subtask->card->updateActualHours();
        });
    }
}
