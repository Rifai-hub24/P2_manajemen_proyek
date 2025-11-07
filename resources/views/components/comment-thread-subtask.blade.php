@php $isSelf = $comment->user_id === auth()->id(); @endphp
<div id="comment-{{ $comment->comment_id }}" 
     class="chat-message {{ $isSelf ? 'self' : 'other' }} {{ $comment->parent_id ? 'nested-reply' : '' }}">
  
  <div class="message-bubble" style="
        background: {{ $isSelf ? '#dcf8c6' : '#ffffff' }};
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 8px 12px;
        max-width: 80%;
        position: relative;
        word-wrap: break-word;
    ">

    {{-- 🔹 Preview pesan yang dibalas --}}
    @if($comment->parent)
      <div class="reply-preview" onclick="scrollToComment({{ $comment->parent->comment_id }})"
           style="background:#e0f2fe;border-left:4px solid #0ea5e9;
                  border-radius:8px;padding:5px 8px;margin-bottom:6px;cursor:pointer;">
        <small class="fw-bold text-primary d-block">{{ $comment->parent->user->username }}</small>
        <small class="text-dark">{{ Str::limit($comment->parent->comment_text, 80) }}</small>
      </div>
    @endif

    {{-- 🔸 Pesan utama --}}
    <strong>{{ $comment->user->username }}</strong><br>
    <span>{{ $comment->comment_text }}</span>

    {{-- 🕒 Waktu --}}
    <div class="message-info text-end mt-1" style="font-size:0.8rem;color:#64748b;">
      {{ \Carbon\Carbon::parse($comment->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
    </div>

    {{-- 🔘 Tombol aksi --}}
    <div class="mt-2 d-flex justify-content-end gap-2">
      <button class="btn btn-reply btn-small" style="background:#94a3b8;color:white;border:none;"
              onclick="toggleReply({{ $comment->comment_id }})">
        <i class="bi bi-reply"></i>
      </button>
      @if($isSelf)
        <button class="btn btn-edit btn-small" style="background:#3b82f6;color:white;border:none;"
                onclick="toggleEdit({{ $comment->comment_id }})">
          <i class="bi bi-pencil"></i>
        </button>
        <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST"
              onsubmit="return confirm('Hapus komentar ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-delete btn-small" style="background:#ef4444;color:white;border:none;">
            <i class="bi bi-trash"></i>
          </button>
        </form>
      @endif
    </div>

    {{-- ✏️ Form Edit --}}
    <form id="edit-form-{{ $comment->comment_id }}" class="edit-form mt-2 d-none"
          action="{{ route('comments.update', $comment->comment_id) }}" method="POST">
      @csrf @method('PUT')
      <textarea name="comment_text" class="form-control mb-2" rows="2">{{ $comment->comment_text }}</textarea>
      <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
    </form>

    {{-- 💬 Form Balas --}}
    <form id="reply-form-{{ $comment->comment_id }}" class="reply-form mt-2 d-none"
          action="{{ route('comments.subtask.store', $comment->subtask_id) }}" method="POST">
      @csrf
      <input type="hidden" name="parent_id" value="{{ $comment->comment_id }}">
      <textarea name="comment_text" class="form-control mb-2" rows="1" placeholder="Balas komentar..."></textarea>
      <button type="submit" class="btn btn-secondary btn-sm">Kirim Balasan</button>
    </form>
  </div>
</div>

{{-- 🔁 Balasan (nested reply) --}}
@if($comment->replies && $comment->replies->count() > 0)
  @foreach($comment->replies as $reply)
    @include('components.comment-thread-subtask', ['comment' => $reply])
  @endforeach
@endif