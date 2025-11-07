<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Subtask;
use App\Models\Comment;

class NotificationController extends Controller
{
    private $filePath = 'dismissed.json';

    private function getDismissed()
    {
        if (!Storage::exists($this->filePath)) return [];
        return json_decode(Storage::get($this->filePath), true) ?? [];
    }

    private function saveDismissed($data)
    {
        Storage::put($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'team_lead') abort(403);

        $dismissed = $this->getDismissed();
        $dismissedIds = array_unique($dismissed[$user->user_id] ?? []);

        // 🔹 Ambil notifikasi aktif (yang belum disilang)
        $blockers = Subtask::with('card.board.project')
            ->where('is_blocked', true)
            ->whereNotIn('subtask_id', $dismissedIds)
            ->whereHas('card.board.project.members', fn($q) => $q->where('user_id', $user->user_id))
            ->get();

        $reviews = Subtask::with('card.board.project')
            ->where('status', 'review')
            ->whereNotIn('subtask_id', $dismissedIds)
            ->whereHas('card.board.project.members', fn($q) => $q->where('user_id', $user->user_id))
            ->get();

        $comments = Comment::with(['user', 'card.board.project', 'subtask.card.board.project'])
            ->whereNotIn('comment_id', $dismissedIds)
            ->where(fn($q) => $q
                ->whereHas('card.board.project.members', fn($sub) => $sub->where('user_id', $user->user_id))
                ->orWhereHas('subtask.card.board.project.members', fn($sub) => $sub->where('user_id', $user->user_id))
            )
            ->get();

        // 🔸 Simpan jumlah ke session untuk sidebar
        $notifCount = $blockers->count() + $reviews->count() + $comments->count();
        session(['notif_unread' => $notifCount]);

        return view('teamlead.notifications', compact('blockers', 'reviews', 'comments'));
    }

    public function dismiss(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => 'required|in:subtask,comment'
        ]);

        $user = Auth::user();
        $dismissed = $this->getDismissed();
        if (!isset($dismissed[$user->user_id])) $dismissed[$user->user_id] = [];

        $dismissed[$user->user_id][] = (int) $request->id;
        $dismissed[$user->user_id] = array_unique($dismissed[$user->user_id]);
        $this->saveDismissed($dismissed);

        $remaining = $this->countRemaining($user, $dismissed[$user->user_id]);
        session(['notif_unread' => $remaining]);

        return response()->json(['success' => true, 'remaining' => $remaining]);
    }

    public function count()
    {
        $user = Auth::user();
        $dismissed = $this->getDismissed();
        $dismissedIds = $dismissed[$user->user_id] ?? [];
        $remaining = $this->countRemaining($user, $dismissedIds);
        session(['notif_unread' => $remaining]);
        return response()->json(['count' => $remaining]);
    }

    private function countRemaining($user, $dismissedIds)
    {
        $countBlockers = Subtask::where('is_blocked', true)
            ->whereNotIn('subtask_id', $dismissedIds)
            ->whereHas('card.board.project.members', fn($q) => $q->where('user_id', $user->user_id))
            ->count();

        $countReviews = Subtask::where('status', 'review')
            ->whereNotIn('subtask_id', $dismissedIds)
            ->whereHas('card.board.project.members', fn($q) => $q->where('user_id', $user->user_id))
            ->count();

        $countComments = Comment::whereNotIn('comment_id', $dismissedIds)
            ->where(fn($q) => $q
                ->whereHas('card.board.project.members', fn($sub) => $sub->where('user_id', $user->user_id))
                ->orWhereHas('subtask.card.board.project.members', fn($sub) => $sub->where('user_id', $user->user_id))
            )
            ->count();

        return $countBlockers + $countReviews + $countComments;
    }
}