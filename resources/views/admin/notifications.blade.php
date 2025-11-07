<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Notifikasi Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f8fafc;
      font-family: "Inter", sans-serif;
      color: #1e293b;
      padding: 40px 20px;
    }

    /* === TOP BAR === */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 10px;
    }

    h3 {
      font-weight: 700;
      color: #1e3a8a;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* === Tombol Kembali === */
    .btn-back {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 9px 16px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: 0.3s;
      text-decoration: none;
      white-space: nowrap;
      box-shadow: 0 4px 10px rgba(37,99,235,0.25);
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      text-decoration: none;
      color: #fff;
    }

    /* === WRAPPER (agar tidak full di desktop) === */
    .notif-wrapper {
      max-width: 750px;
      margin: 0 auto;
    }

    /* === NOTIFIKASI CARD === */
    .notif-card {
      background: #ffffff;
      border-radius: 18px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
      padding: 24px 26px;
      margin-bottom: 22px;
      position: relative;
      transition: all 0.25s ease;
    }

    .notif-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(37, 99, 235, 0.12);
    }

    .notif-card strong {
      color: #1e3a8a;
      font-weight: 600;
    }

    .notif-card .close-btn {
      position: absolute;
      top: 14px;
      right: 18px;
      border: none;
      background: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 1.2rem;
      transition: 0.2s;
    }

    .notif-card .close-btn:hover {
      color: #dc2626;
    }

    .notif-meta {
      font-size: 0.9rem;
      color: #475569;
      margin-top: 6px;
    }

    .notif-meta i {
      color: #2563eb;
      margin-right: 4px;
    }

    .notif-text {
      font-size: 0.95rem;
      color: #334155;
      margin-top: 6px;
    }

    /* === ALERT INFO === */
    .alert-info {
      border-radius: 12px;
      background: #e0f2fe;
      border: none;
      color: #075985;
    }

    /* ==========================
       💻 RESPONSIVE DESIGN
       ========================== */
    @media (max-width: 992px) {
      body { padding: 30px 15px; }
      .notif-wrapper { max-width: 95%; }
      .notif-card { padding: 20px; }
    }

    @media (max-width: 768px) {
      body { padding: 25px 12px; }
      .top-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
      .btn-back { font-size: 0.9rem; padding: 8px 14px; border-radius: 8px; }
      h3 { font-size: 1.2rem; }
      .notif-card { padding: 18px; }
    }

    @media (max-width: 576px) {
      body { padding: 20px 10px; }
      .notif-wrapper { max-width: 100%; }
      .btn-back { font-size: 0.85rem; padding: 7px 12px; }
      h3 { font-size: 1.1rem; }
      .notif-card { padding: 16px; }
      .notif-meta { font-size: 0.85rem; }
      .notif-text { font-size: 0.9rem; }
    }
  </style>
</head>
<body>
  <div class="notif-wrapper">
    <div class="top-bar">
      <h3><i class="bi bi-bell-fill text-primary"></i> Notifikasi Admin</h3>
      <a href="{{ route('dashboard') }}" class="btn-back">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
      </a>
    </div>

    {{-- 🔹 Komentar di Card --}}
    @forelse($cardComments as $c)
    <div class="notif-card" id="notif-comment-{{ $c->comment_id }}">
      <button class="close-btn" onclick="dismiss({{ $c->comment_id }})">&times;</button>

      <strong>💬 Komentar di Card:</strong> {{ $c->card->card_title ?? 'Card dihapus' }}

      @if($c->card && $c->card->board && $c->card->board->project)
      <div class="notif-meta">
        <i class="bi bi-diagram-3"></i> Project:
        <span class="fw-semibold text-dark">{{ $c->card->board->project->project_name }}</span>
      </div>
      @endif

      <div class="notif-text">{{ $c->comment_text }}</div>
      <div class="notif-meta">
        <i class="bi bi-person-circle"></i> Oleh: {{ $c->user->username ?? 'User' }}
      </div>
    </div>
    @empty
    @endforelse

    {{-- 🔹 Komentar di Subtask --}}
    @forelse($subtaskComments as $c)
    <div class="notif-card" id="notif-comment-{{ $c->comment_id }}">
      <button class="close-btn" onclick="dismiss({{ $c->comment_id }})">&times;</button>

      <strong>💬 Komentar di Subtask:</strong> {{ $c->subtask->subtask_title ?? 'Subtask dihapus' }}

      @if($c->subtask && $c->subtask->card)
      <div class="notif-meta">
        <i class="bi bi-kanban"></i> Card:
        <span class="fw-semibold text-dark">{{ $c->subtask->card->card_title ?? 'Card dihapus' }}</span>
      </div>
      @endif

      @if($c->subtask && $c->subtask->card && $c->subtask->card->board && $c->subtask->card->board->project)
      <div class="notif-meta">
        <i class="bi bi-diagram-3"></i> Project:
        <span class="fw-semibold text-dark">{{ $c->subtask->card->board->project->project_name }}</span>
      </div>
      @endif

      <div class="notif-text">{{ $c->comment_text }}</div>
      <div class="notif-meta">
        <i class="bi bi-person-circle"></i> Oleh: {{ $c->user->username ?? 'User' }}
      </div>
    </div>
    @empty
    @endforelse

    {{-- 🔹 Jika tidak ada notifikasi --}}
    @if($cardComments->isEmpty() && $subtaskComments->isEmpty())
    <div class="alert alert-info text-center">Tidak ada notifikasi baru.</div>
    @endif
  </div>

  <script>
    function dismiss(id) {
      fetch("{{ route('admin.notifications.dismiss') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          document.getElementById(`notif-comment-${id}`).remove();
          const badge = document.getElementById("adminNotifBadge");
          if (badge) {
            if (data.remaining > 0) badge.innerText = data.remaining;
            else badge.remove();
          }
        }
      });
    }
  </script>
</body>
</html>
