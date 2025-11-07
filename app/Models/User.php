<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Jika primary key di tabel user bukan 'id'
    protected $primaryKey = 'user_id';

    // Kalau tidak pakai timestamps di tabel users
    public $timestamps = false;

    protected $fillable = [
        'username',
        'full_name',
        'password',
        'email',
        'role',
        'current_task_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
     /**
     * Relasi ke ProjectMember
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke CardAssignment
     */
    public function cardAssignments()
    {
        return $this->hasMany(CardAssignment::class, 'user_id', 'user_id');
    }

     public function timeLogs()
    {
        return $this->hasMany(TimeLog::class, 'user_id', 'user_id');
    }
}
