<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\ProjectMember;

class AdminNotificationController extends Controller
{
    private $filePath = 'dismissed_admin.json';

    // 🔹 Ambil data dismissed dari JSON
    private function getDismissed()
    {
        if (!Storage::exists($this->filePath)) {
            return [];
        }
        return json_decode(Storage::get($this->filePath), true) ?? [];
    }

    // 🔹 Simpan data dismissed ke JSON
    private function saveDismissed($data)
    {
        Storage::put($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    // 🔹 Tampilkan daftar notifikasi admin
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengakses notifikasi ini.');
        }

        $dismissed = $this->getDismissed();
        $dismissedIds = $dismissed[$user->user_id] ?? [];

        // Ambil semua project_id yang diikuti admin
        $adminProjectIds = ProjectMember::where('user_id', $user->user_id)
            ->pluck('project_id')
            ->toArray();

        // 🔸 Komentar pada Card yang masih dalam proyek admin
        $cardComments = Comment::with(['user', 'card.board.project'])
            ->whereNotNull('card_id')
            ->whereNotIn('comment_id', $dismissedIds)
            ->whereHas('card.board.project', function ($q) use ($adminProjectIds) {
                $q->whereIn('project_id', $adminProjectIds);
            })
            ->latest('comment_id')
            ->get();

        // 🔸 Komentar pada Subtask yang masih dalam proyek admin
        $subtaskComments = Comment::with(['user', 'subtask.card.board.project'])
            ->whereNotNull('subtask_id')
            ->whereNotIn('comment_id', $dismissedIds)
            ->whereHas('subtask.card.board.project', function ($q) use ($adminProjectIds) {
                $q->whereIn('project_id', $adminProjectIds);
            })
            ->latest('comment_id')
            ->get();

        $notifCount = $cardComments->count() + $subtaskComments->count();
        session(['admin_notif_unread' => $notifCount]);

        return view('admin.notifications', compact('cardComments', 'subtaskComments'));
    }

    // 🔹 Hilangkan notifikasi saat diklik silang
    public function dismiss(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $user = Auth::user();
        $dismissed = $this->getDismissed();

        if (!isset($dismissed[$user->user_id])) {
            $dismissed[$user->user_id] = [];
        }

        $dismissed[$user->user_id][] = (int)$request->id;
        $dismissed[$user->user_id] = array_unique($dismissed[$user->user_id]);
        $this->saveDismissed($dismissed);

        $remaining = $this->countRemaining($user, $dismissed[$user->user_id]);
        session(['admin_notif_unread' => $remaining]);

        return response()->json(['success' => true, 'remaining' => $remaining]);
    }

    // 🔹 Hitung ulang sisa notifikasi (yang belum di-dismiss)
    public function countRemaining($user, $dismissedIds)
    {
        $adminProjectIds = ProjectMember::where('user_id', $user->user_id)
            ->pluck('project_id')
            ->toArray();

        $cardCount = Comment::whereNotNull('card_id')
            ->whereNotIn('comment_id', $dismissedIds)
            ->whereHas('card.board.project', fn($q) => $q->whereIn('project_id', $adminProjectIds))
            ->count();

        $subtaskCount = Comment::whereNotNull('subtask_id')
            ->whereNotIn('comment_id', $dismissedIds)
            ->whereHas('subtask.card.board.project', fn($q) => $q->whereIn('project_id', $adminProjectIds))
            ->count();

        return $cardCount + $subtaskCount;
    }

    // 🔹 Endpoint AJAX untuk hitung notifikasi baru
    public function count()
    {
        $user = Auth::user();
        $dismissed = $this->getDismissed();
        $dismissedIds = $dismissed[$user->user_id] ?? [];

        $remaining = $this->countRemaining($user, $dismissedIds);
        session(['admin_notif_unread' => $remaining]);

        return response()->json(['count' => $remaining]);
    }
}