<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Models\ProjectMember;
use App\Models\CardAssignment;

class DevNotifController extends Controller
{
    private $filePath = 'dismissed_dev.json';

    // Ambil data dismissed dari file JSON
    private function getDismissed()
    {
        if (!Storage::exists($this->filePath)) {
            return [];
        }
        return json_decode(Storage::get($this->filePath), true) ?? [];
    }

    // Simpan data dismissed ke file JSON
    private function saveDismissed($data)
    {
        Storage::put($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Halaman utama notifikasi developer/designer
    public function index()
    {
        $user = Auth::user();

        // Hanya untuk developer/designer
        if (!in_array($user->role, ['developer', 'designer'])) {
            abort(403, 'Hanya Developer dan Designer yang dapat mengakses notifikasi ini.');
        }

        // Ambil ID komentar yang sudah disilang
        $dismissed = $this->getDismissed();
        $dismissedIds = $dismissed[$user->user_id] ?? [];

        // Ambil project_id tempat user tergabung
        $userProjectIds = ProjectMember::where('user_id', $user->user_id)
            ->pluck('project_id')
            ->toArray();

        // Ambil subtask yang memang menjadi tugas user (melalui card assignment)
        $assignedCardIds = CardAssignment::where('user_id', $user->user_id)
            ->pluck('card_id')
            ->toArray();

        // Ambil komentar hanya di subtask yang:
        // - subtask-nya milik card yang ditugaskan ke user ini
        // - termasuk dalam project user
        $comments = Comment::with(['user', 'subtask.card.board.project'])
            ->whereNotNull('subtask_id')
            ->whereNotIn('comment_id', $dismissedIds)
            ->whereHas('subtask.card', function ($q) use ($assignedCardIds) {
                $q->whereIn('card_id', $assignedCardIds);
            })
            ->whereHas('subtask.card.board.project', function ($q) use ($userProjectIds) {
                $q->whereIn('project_id', $userProjectIds);
            })
            ->latest('comment_id')
            ->get();

        // Hitung notifikasi aktif
        $notifCount = $comments->count();
        session(['dev_notif_unread' => $notifCount]);

        // Tentukan view
        $viewPath = $user->role === 'developer'
            ? 'developer.notifications'
            : 'designer.notifications';

        return view($viewPath, compact('comments'));
    }

    // Saat notifikasi disilang
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
        session(['dev_notif_unread' => $remaining]);

        return response()->json(['success' => true, 'remaining' => $remaining]);
    }

    // Hitung notifikasi aktif (yang belum disilang)
    private function countRemaining($user, $dismissedIds)
    {
        $userProjectIds = ProjectMember::where('user_id', $user->user_id)
            ->pluck('project_id')
            ->toArray();

        $assignedCardIds = CardAssignment::where('user_id', $user->user_id)
            ->pluck('card_id')
            ->toArray();

        return Comment::whereNotIn('comment_id', $dismissedIds)
            ->whereNotNull('subtask_id')
            ->whereHas('subtask.card', function ($q) use ($assignedCardIds) {
                $q->whereIn('card_id', $assignedCardIds);
            })
            ->whereHas('subtask.card.board.project', function ($q) use ($userProjectIds) {
                $q->whereIn('project_id', $userProjectIds);
            })
            ->count();
    }

    // Endpoint untuk menghitung ulang notifikasi via AJAX
    public function count()
    {
        $user = Auth::user();
        $dismissed = $this->getDismissed();
        $dismissedIds = $dismissed[$user->user_id] ?? [];

        $remaining = $this->countRemaining($user, $dismissedIds);
        session(['dev_notif_unread' => $remaining]);

        return response()->json(['count' => $remaining]);
    }
}