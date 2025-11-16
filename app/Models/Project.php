<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    protected $fillable = [
        'project_name',
        'description',
        'created_by',
        'deadline',
        'rejection_reason',
        'status'
    ];

    // ✅ Cast kolom deadline jadi Carbon (datetime)
    protected $casts = [
        'deadline' => 'datetime',
    ];

    // 🔹 Relasi ke members
    public function members()
    {
        return $this->hasMany(ProjectMember::class, 'project_id', 'project_id');
    }
    

    // 🔹 Relasi ke boards
    public function boards()
    {
        return $this->hasMany(Board::class, 'project_id');
    }

    // ✅ Accessor status deadline
   public function getDeadlineStatusAttribute()
{
    if ($this->status === 'draft') return 'Belum Dikirim';
    if (!$this->deadline) return 'Tidak Ada Deadline';

    $deadline = Carbon::parse($this->deadline);
    $submitted = $this->submitted_at ? Carbon::parse($this->submitted_at) : null;

    if ($this->status === 'pending') return 'Menunggu Persetujuan';

    if ($this->status === 'approved') {
        if ($submitted && $submitted->gt($deadline)) {
            return 'Terlambat';
        }
        return 'Tepat Waktu';
    }

    if ($deadline->isPast()) return 'Terlambat';

    return 'Tepat Waktu';
}


   public function getDeadlineBadgeClassAttribute()
{
    if (in_array($this->status, ['draft', 'rejected'])) {
        return 'secondary';
    }

    if (empty($this->deadline)) {
        return 'secondary';
    }

    if ($this->status === 'pending') {
        return 'warning';
    }

    $deadline = Carbon::parse($this->deadline);
    $submitted = $this->submitted_at ? Carbon::parse($this->submitted_at) : null;

    // STATUS: APPROVED
    if ($this->status === 'approved') {
        if ($submitted && $submitted->gt($deadline)) {
            return 'danger'; // Terlambat
        }
        return 'success'; // Tepat waktu
    }

    // Belum approved tapi lewat deadline → merah
    if ($deadline->isPast() && $this->status !== 'approved') {
        return 'danger';
    }

    return 'secondary';
}

}
