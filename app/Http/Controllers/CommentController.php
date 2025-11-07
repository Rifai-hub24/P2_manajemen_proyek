<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Subtask;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Simpan komentar untuk Card
     */
    public function storeCard(Request $request, Card $card)
    {
        $request->validate([
            'comment_text' => 'required|string'
        ]);

        $user = auth()->user();

        // Hanya admin & team_lead
        if (!in_array($user->role, ['admin', 'team_lead'])) {
            return back()->with('error', 'Anda tidak memiliki izin komentar di Card.');
        }

        Comment::create([
            'card_id'      => $card->card_id,
            'subtask_id'   => null,
            'user_id'      => $user->user_id,
            'comment_text' => $request->comment_text,
            'comment_type' => 'card',
            'parent_id'    => $request->parent_id ?? null, // kalau balasan
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
    public function update(Request $request, $comment_id)
    {
       $comment = \App\Models\Comment::findOrFail($comment_id);

       // 🔒 Cek agar hanya pemilik komentar yang bisa edit
        if ($comment->user_id !== auth()->id()) {
         return back()->with('error', 'Anda tidak diizinkan mengedit komentar ini.');
        }

        $request->validate([
            'comment_text' => 'required|string|max:500'
        ]);

        $comment->update([
         'comment_text' => $request->comment_text
       ]);

      return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy($comment_id)
    {
         $comment = \App\Models\Comment::findOrFail($comment_id);

        // 🔒 Hanya pemilik komentar yang bisa hapus
        if ($comment->user_id !== auth()->id()) {
         return back()->with('error', 'Anda tidak diizinkan menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Simpan komentar untuk Subtask
     */
    public function storeSubtask(Request $request, Subtask $subtask)
    {
        $request->validate([
            'comment_text' => 'required|string'
        ]);

        $user = auth()->user();

        // Semua role boleh komentar
        if (!in_array($user->role, ['admin','team_lead','developer','designer'])) {
            return back()->with('error', 'Anda tidak memiliki izin komentar di Subtask.');
        }

        Comment::create([
            'card_id'      => null,
            'subtask_id'   => $subtask->subtask_id,
            'user_id'      => $user->user_id,
            'comment_text' => $request->comment_text,
            'comment_type' => 'subtask',
            'parent_id'    => $request->parent_id ?? null,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
    public function indexCard(Card $card)
    {
        $comments = Comment::where('card_id', $card->card_id)
            ->whereNull('parent_id')
            ->with([
                'user',
                'replies.user',
                'replies.replies.user', // level 2
                'replies.replies.replies.user' // level 3 (boleh tambah kalau mau lebih dalam)
            ])
            ->latest()
            ->get();

        return view('comments.index_card', compact('card', 'comments'));
    }
    // Tampilkan daftar komentar untuk Subtask
    public function indexSubtask(Subtask $subtask)
    {
        $comments = Comment::with([
                'user',
                'replies.user',
                'replies.replies.user',
                'replies.replies.replies.user',
                'parent.user'
            ])
            ->where('subtask_id', $subtask->subtask_id)
            ->whereNull('parent_id') // 🔹 hanya komentar utama
            ->orderBy('created_at', 'asc')
            ->get();

        return view('comments.subtask', compact('subtask', 'comments'));
    }
    public function updatesubtaks(Request $request, Comment $comment)
    {
       if ($comment->user_id !== auth()->id()) {
           abort(403, 'Tidak diizinkan mengedit komentar ini.');
        }

        $request->validate([
            'comment_text' => 'required|string|max:1000'
        ]);

        $comment->update([
             'comment_text' => $request->comment_text
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroysubtaks(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Tidak diizinkan menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

}