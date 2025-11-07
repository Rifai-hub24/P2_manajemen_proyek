<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Komentar Subtask - {{ $subtask->subtask_title }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f0f2f5;
      font-family: "Inter", "Poppins", sans-serif;
      padding: 30px;
      overflow-x: hidden; /* 🔒 cegah scroll horizontal */
    }

    .chat-container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .chat-header {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    .chat-body {
      padding: 20px;
      height: 65vh;
      overflow-y: auto;
      background: #e9eef5;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .chat-message {
      display: flex;
      align-items: flex-end;
      width: 100%;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    .chat-message.self { justify-content: flex-end; }
    .chat-message.other { justify-content: flex-start; }

    .message-bubble {
      padding: 10px 14px;
      border-radius: 14px;
      max-width: 70%;
      box-shadow: 0 2px 5px rgba(0,0,0,0.08);
      position: relative;
      word-wrap: break-word;
      overflow-x: hidden;
      margin: 2px 0;
    }

    .chat-message.self .message-bubble {
      background: #dcf8c6;
      border-top-right-radius: 0;
    }

    .chat-message.other .message-bubble {
      background: #ffffff;
      border-top-left-radius: 0;
    }

    .reply-preview {
      background: #e0f2fe;
      border-left: 4px solid #0ea5e9;
      border-radius: 8px;
      padding: 5px 8px;
      margin-bottom: 6px;
      font-size: 0.85rem;
      cursor: pointer;
      overflow: hidden;
    }

    .reply-preview:hover { background: #bae6fd; }

    .message-info {
      font-size: 0.8rem;
      color: #64748b;
      text-align: right;
      margin-top: 4px;
    }

    .btn-small {
      padding: 3px 8px;
      font-size: 0.8rem;
      border-radius: 8px;
    }

    .btn-reply { background: #64748b; color: white; border: none; }
    .btn-edit { background: #3b82f6; color: white; border: none; }
    .btn-delete { background: #ef4444; color: white; border: none; }

    .btn-reply:hover { background: #475569; }
    .btn-edit:hover { background: #2563eb; }
    .btn-delete:hover { background: #b91c1c; }

    .chat-footer {
      padding: 15px 20px;
      border-top: 1px solid #e2e8f0;
      background: #fff;
    }

    .btn-send {
      border-radius: 12px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      font-weight: 600;
    }

    .btn-back {
      border-radius: 12px;
      background: #6b7280;
      color: white;
      font-weight: 600;
    }

    .btn-back:hover { background: #4b5563; color: white; }

    @media (max-width: 768px) {
      .message-bubble { max-width: 90%; }
    }

    @media (max-width: 480px) {
      .message-bubble {
        max-width: 95%;
        font-size: 0.85rem;
        padding: 8px 10px;
      }
    }
  </style>
</head>

<body>
  @php
    $role = auth()->user()->role ?? 'user';
    $dashboardRoute = match($role) {
      'admin' => route('dashboard'),
      'team_lead' => route('teamlead.dashboard'),
      'developer' => route('developer.dashboard'),
      'designer' => route('designer.dashboard'),
      default => route('dashboard'),
    };
  @endphp

  <div class="chat-container">
    <div class="chat-header">
      <h4><i class="bi bi-chat-dots"></i> Komentar Subtask - {{ $subtask->subtask_title }}</h4>
      <p class="mb-0 text-white-50">{{ $subtask->description ?? '-' }}</p>
    </div>

    <div class="chat-body" id="chatBody">
      @forelse($comments as $comment)
        @include('components.comment-thread-subtask', ['comment' => $comment, 'level' => 0])
      @empty
        <p class="text-muted text-center mt-4">Belum ada komentar</p>
      @endforelse
    </div>

    <div class="chat-footer">
      <form action="{{ route('comments.subtask.store', $subtask->subtask_id) }}" method="POST" class="d-flex gap-2">
        @csrf
        <textarea name="comment_text" class="form-control" rows="1" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="btn btn-send"><i class="bi bi-send"></i></button>
      </form>

      <div class="text-end mt-2">
        <a href="{{ $dashboardRoute }}" class="btn btn-back">
          <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>
      </div>
    </div>
  </div>

  <script>
    function toggleEdit(id) {
      document.getElementById(`edit-form-${id}`).classList.toggle('d-none');
    }

    function toggleReply(id) {
      document.getElementById(`reply-form-${id}`).classList.toggle('d-none');
    }

    function scrollToComment(id) {
      const target = document.getElementById(`comment-${id}`);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        target.style.transition = 'background 0.5s';
        target.style.background = '#fff3cd';
        setTimeout(() => target.style.background = '', 1200);
      }
    }

    document.addEventListener("DOMContentLoaded", () => {
      const chatBody = document.getElementById("chatBody");
      if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
    });
  </script>
</body>
</html>