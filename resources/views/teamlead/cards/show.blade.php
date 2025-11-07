<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Detail Card - {{ $card->card_title }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg-main: #f1f5ff;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg-main);
      color: var(--text-dark);
      padding: 40px;
    }
    
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .btn-back {
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 18px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
      display: flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
    }

    .btn-back:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      color: #fff;
    }

    /* Header */
    h1 {
      color: var(--primary-dark);
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 30px;
    }

    h1 i {
      color: var(--primary);
      font-size: 1.7rem;
    }

    /* Card Detail */
    .card {
      border: none;
      border-radius: 14px;
      box-shadow: var(--shadow);
      background: #fff;
      padding: 25px 30px;
    }

    .desc-line {
      border-bottom: 2px solid #e2e8f0;
      padding-bottom: 10px;
      margin-bottom: 25px;
      color: var(--text-muted);
    }

    .info-row {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
    }

    .info-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 14px 18px;
      flex: 1;
      min-width: 220px;
      text-align: center;
    }

    .info-label {
      font-weight: 600;
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    .info-value {
      font-weight: 700;
      color: var(--text-dark);
      font-size: 1.05rem;
    }

    /* Anggota Section */
    .member-list {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 20px;
    }

    .member-card {
      display: flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, #f9fafb, #e2e8f0);
      border: 1px solid #d1d5db;
      border-radius: 10px;
      padding: 8px 14px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      transition: 0.3s ease;
    }

    .member-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(37, 99, 235, 0.15);
      border-color: var(--primary);
    }

    .member-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      font-weight: 600;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .member-info {
      display: flex;
      flex-direction: column;
      line-height: 1.2;
    }

    .member-name {
      font-weight: 600;
      color: var(--text-dark);
      font-size: 0.95rem;
    }

    .member-role {
      font-size: 0.8rem;
      color: var(--text-muted);
    }

    /* Subtasks Table */
    table {
      background: linear-gradient(180deg, #1f2937, #0f172a);
      color: #f8fafc;
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #374151;
    }

    thead {
      background: linear-gradient(90deg, #111827, #1f2937);
      color: #fff;
    }

    th, td {
      border: 1px solid #374151;
      padding: 10px;
      text-align: center;
      vertical-align: middle;
    }

    tbody tr:hover {
      background: rgba(37, 99, 235, 0.1);
      transition: 0.2s;
    }

    .badge {
      border-radius: 6px;
      padding: 5px 8px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    /* Buttons */
    .btn {
      border-radius: 6px;
      font-weight: 500;
      transition: 0.25s ease;
    }

    .btn-success {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      border: none;
      color: #fff;
    }

    .btn-danger {
      background: linear-gradient(135deg, #ef4444, #991b1b);
      border: none;
      color: #fff;
    }

     /* ✅ Tombol Komentar (Hijau Gradasi) */
    .btn-comment {
      background: linear-gradient(135deg, #059669, #10b981);
      border: none;
      color: #fff;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(16, 185, 129, 0.4);
    }

    .btn-comment:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #047857, #059669);
      color: #fff;
    }


    .action-btns {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .modal-content {
      border-radius: 10px;
      box-shadow: var(--shadow);
    }
    
    .desc-link {
      color: #2563eb; /* Warna biru sesuai tema */
      text-decoration: none;
      font-weight: 500;
      word-break: break-all; /* Biar link panjang tidak pecah layout */
    }

    .desc-link:hover {
      text-decoration: underline;
      color: #1e40af;
    }
    /* =============================
     RESPONSIVE DESIGN 
    ============================= */

    @media (max-width: 992px) {
      body { padding: 25px; }
      h1 { font-size: 1.6rem; }
      .card { padding: 20px; }
      .info-box { min-width: 180px; }
    }

    @media (max-width: 768px) {
      body { padding: 20px; }
      .page-header {
        flex-direction: column;
        align-items: flex-start;
      }
      h1 {
        font-size: 1.4rem;
        text-align: center;
        width: 100%;
        justify-content: center;
      }
      .btn-back {
        align-self: center;
        width: 50%;
        justify-content: center;
      }
      .info-row { flex-direction: column; }
      .info-box {
        width: 100%;
        text-align: left;
      }
      .member-list { flex-direction: column; }
      /* 🔹 tabel auto width di mobile */
      table {
        width: auto;
        min-width: unset;
      }
      .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
      }
    }

    @media (max-width: 480px) {
      body { padding: 15px; }
      h1 {
        font-size: 1.2rem;
        gap: 6px;
      }
      .btn-back {
        width: 60%;
        font-size: 0.9rem;
      }
      .card { padding: 18px; }
      table {
        font-size: 0.8rem;
        width: auto; /* biar fleksibel di HP */
      }
      th, td {
        padding: 6px;
        white-space: nowrap; /* biar tabel bisa digeser */
      }
      .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
      }
    }

  </style>
</head>

<body>

  <div class="container">
   <!-- Header -->
    <div class="page-header">
      <h1><i class="bi bi-clipboard2-check"></i> Detail Card: {{ $card->card_title }}</h1>
        <a href="{{ route('teamlead.cards.index', $board->board_id) }}" class="btn-back">
           <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>


    <!-- Card Detail -->
    <div class="card mb-5">
      <div class="desc-line">
          {!! nl2br(preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" class="desc-link">$1</a>',
            e($card->description ?? '-')
          )) !!}
      </div>

      <div class="info-row">
        <div class="info-box">
          <div class="info-label">Prioritas</div>
          <div class="info-value"><span class="badge bg-warning text-dark">{{ ucfirst($card->priority) }}</span></div>
        </div>

        <div class="info-box">
          <div class="info-label">Estimasi Jam</div>
          <div class="info-value">{{ $card->estimated_hours ?? '-' }}</div>
        </div>

        <div class="info-box">
          <div class="info-label">Deadline</div>
          <div class="info-value">{{ $card->due_date ?? '-' }}</div>
        </div>

        <div class="info-box">
          <div class="info-label">Status</div>
          <div class="info-value"><span class="badge bg-info text-dark">{{ ucfirst(str_replace('_',' ',$card->status)) }}</span></div>
        </div>
      </div>

      <!-- Anggota Section -->
      <div class="mt-4">
        <strong>Anggota:</strong>
        <div class="member-list mt-2">
          @forelse($card->assignments as $a)
            <div class="member-card">
              <div class="member-avatar">
                {{ strtoupper(substr($a->user->username, 0, 1)) }}
              </div>
              <div class="member-info">
                <span class="member-name">{{ $a->user->username }}</span>
                <span class="member-role">{{ ucfirst($a->user->role ?? 'Anggota') }}</span>
              </div>
            </div>
          @empty
            <span class="text-muted">Belum ada anggota</span>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Subtasks -->
    <h4 class="section-title"><i class="bi bi-list-task"></i> Subtasks</h4>
    <div class="table-responsive">
      <table class="table align-middle text-center text-white">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Estimasi (jam)</th>
            <th>Aktual (jam)</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
            <th>Komentar</th>
          </tr>
        </thead>
        <tbody>
          @forelse($card->subtasks->sortBy('position') as $subtask)
          <tr>
            <td><strong>{{ $subtask->subtask_title }}</strong></td>
            <td>
                {!! nl2br(preg_replace(
                  '/(https?:\/\/[^\s]+)/',
                  '<a href="$1" target="_blank" class="desc-link">$1</a>',
                  e($subtask->description ?? '-')
                )) !!}
            </td>

            <td>
              @if($subtask->status == 'todo')
                <span class="badge bg-secondary">To Do</span>
              @elseif($subtask->status == 'in_progress')
                <span class="badge bg-primary">In Progress</span>
              @elseif($subtask->status == 'review')
                <span class="badge bg-info text-dark">Review</span>
              @elseif($subtask->status == 'done')
                <span class="badge bg-success">Done</span>
              @endif
            </td>
            <td>{{ $subtask->estimated_hours ?? '-' }}</td>
            <td>{{ $subtask->actual_hours ?? 0 }}</td>
            <td>{{ \Carbon\Carbon::parse($subtask->created_at)->format('d-m-Y H:i') }}</td>
            <td>
              @if($subtask->status == 'review')
              <div class="action-btns">
                <form method="POST" action="{{ route('subtasks.approve', $subtask->subtask_id) }}">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Approve</button>
                </form>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $subtask->subtask_id }}">
                  <i class="bi bi-x-circle"></i> Ulangi
                </button>
              </div>

              <div class="modal fade" id="rejectModal{{ $subtask->subtask_id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <form method="POST" action="{{ route('subtasks.reject', $subtask->subtask_id) }}">
                    @csrf
                    <div class="modal-content">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-x-circle"></i> Tolak Subtask</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <label class="form-label fw-semibold">Alasan Penolakan:</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Tuliskan alasan..." required></textarea>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Kirim</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              <!-- Tombol Komentar dengan warna hijau gradasi -->
              <a href="{{ route('comments.subtask.index', $subtask->subtask_id) }}" class="btn btn-comment btn-sm">
                <i class="bi bi-chat-dots"></i> Komentar
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center text-muted">Belum ada subtask</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
