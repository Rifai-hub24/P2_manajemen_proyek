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
        // Draft / Rejected = Belum dikirim
        if (in_array($this->status, ['draft', 'rejected'])) {
            return 'Belum Dikirim';
        }

        if (empty($this->deadline)) {
            return 'Tidak Ada Deadline';
        }

        // Pending = Menunggu persetujuan
        if ($this->status === 'pending') {
            return 'Menunggu Persetujuan';
        }

        $deadline = Carbon::parse($this->deadline);
        $created = Carbon::parse($this->created_at);
        $today = Carbon::now();

        // ✅ Jika sudah approved
        if ($this->status === 'approved') {
            // Jika proyek dibuat atau diserahkan setelah deadline → Terlambat
            if ($created->gt($deadline)) {
                return 'Terlambat';
            }
            // Jika proyek dikumpulkan sebelum deadline → Tepat Waktu
            return 'Tepat Waktu';
        }

        // Jika belum approved dan sudah melewati deadline → Terlambat
        if ($today->gt($deadline)) {
            return 'Terlambat';
        }

        // Default: masih tepat waktu
        return 'Tepat Waktu';
    }

    // ✅ Badge warna otomatis
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
        $created = Carbon::parse($this->created_at);

        // 🔹 Jika approved tapi dibuat/melewati deadline → merah (terlambat)
        if ($this->status === 'approved' && $created->gt($deadline)) {
            return 'danger';
        }

        // 🔹 Jika approved dan tepat waktu → hijau
        if ($this->status === 'approved') {
            return 'success';
        }

        // 🔹 Jika lewat deadline dan belum approved → merah
        if ($this->deadline->isPast() && $this->status !== 'approved') {
            return 'danger';
        }

        return 'secondary';
    }
}
