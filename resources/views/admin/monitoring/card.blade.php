<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title> Detail Card - {{ $card->title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #1e3a8a;
      --bg: #f9fafb;
      --text-dark: #1e293b;
      --card-bg: #ffffff;
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: linear-gradient(135deg, #eef2ff, #f8fafc);
      color: var(--text-dark);
      padding: 40px;
      min-height: 100vh;
    }

    /* Header */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 2rem;
    }

    h2 {
      font-weight: 700;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Card Detail */
    .card-detail {
      background: var(--card-bg);
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.06);
      border: 1px solid #e5e7eb;
      padding: 30px;
      margin-bottom: 40px;
    }

    .card-detail h4 {
      font-weight: 700;
      color: var(--primary);
      border-bottom: 2px solid var(--primary);
      padding-bottom: 8px;
      margin-bottom: 20px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
      gap: 1.2rem;
    }

    .info-box {
      background: #f9fafb;
      border-radius: 10px;
      padding: 14px 18px;
      border: 1px solid #e5e7eb;
    }

    .info-box strong {
      display: block;
      color: #6b7280;
      font-size: 0.9rem;
    }

    .info-box span {
      font-weight: 600;
      color: var(--text-dark);
    }

    /* Table */
   .table-wrapper {
      background: var(--card-bg);
      border: 2px solid #000;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      overflow-x: auto; /* ✅ agar tabel bisa digeser horizontal di HP */
      border-radius: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 800px; /* ✅ agar kolom tidak mepet di layar kecil */
    }


    thead tr {
      background: #000; /* baris pertama hitam */
      color: #fff;      /* tulisan putih */
    }

    thead th {
      padding: 14px 12px;
      border: 1px solid #000;
      text-align: center;
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    tbody td {
      padding: 12px;
      text-align: center;
      border: 1px solid #000; /* border hitam semua sisi */
      vertical-align: middle;
      background-color: #ffffff;
      color: var(--text-dark);
      font-size: 0.95rem;
    }

    tbody tr:hover {
      background-color: #f3f4f6;
      transition: 0.25s ease;
    }

    /* Badge Status */
    .badge-status {
      border-radius: 8px;
      padding: 6px 12px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .badge-todo { background: #e2e8f0; color: #334155; }
    .badge-inprogress { background: #fde68a; color: #92400e; }
    .badge-review { background: #bae6fd; color: #075985; }
    .badge-done { background: #bbf7d0; color: #065f46; }

    /* Button */
    .btn-modern {
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      transition: 0.3s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-back {
      background: #1e3a8a;
      color: #fff;
      box-shadow: 0 4px 10px rgba(30,58,138,0.3);
    }

    .btn-back:hover {
      background: #1e40af;
      transform: translateY(-2px);
    }

    .btn-comment {
      background: linear-gradient(135deg, #059669, #10b981);
      color: #fff;
      padding: 6px 14px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
      border: none;
    }

    .btn-comment:hover {
      background: linear-gradient(135deg, #047857, #059669);
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(34,197,94,0.3);
    }
    .card-desc {
      font-size: 0.95rem;
      color: #374151;
      margin-bottom: 15px;
    }
    
    .subtask-desc {
      text-align: left;
      word-break: break-word;
      font-size: 0.9rem;
      overflow-wrap: break-word;
    }

    .desc-link {
      color: #2563eb;
      text-decoration: underline;
      word-break: break-word;
    }

    .desc-link:hover {
      color: #1e3a8a;
    }
    @media (max-width: 768px) {
  body {
    padding: 20px;
  }

  .card-detail {
    padding: 20px;
  }

  h2 {
    font-size: 1.3rem;
  }

  .card-detail h4 {
    font-size: 1.1rem;
  }

  table {
    font-size: 0.85rem;
  }

  .btn-modern {
    padding: 8px 14px;
    font-size: 0.9rem;
  }

  .info-grid {
    grid-template-columns: 1fr; /* ✅ kolom info jadi 1 di HP */
  }
}


  </style>
</head>
<body>

  <div class="container">
    <!-- Header -->
    <div class="page-header">
      <h2><i class="bi bi-clipboard-data"></i> Detail Card</h2>
      <a href="{{ route('monitoring.board', ['project' => $card->board->project_id, 'board' => $card->board_id]) }}" class="btn-modern btn-back">
        <i class="bi bi-arrow-left-circle"></i> Kembali
      </a>
    </div>

    <!-- Detail Card -->
    <div class="card-detail">
      <h4>{{ $card->title }}</h4>
      <p class="mb-3 card-desc">
          {!! nl2br(
          preg_replace(
            '/(https?:\/\/[^\s<]+)/',
            '<a href="$1" target="_blank" class="desc-link">$1</a>',
            e($card->description ?? 'Tidak ada deskripsi')
          )
        ) !!}
      </p>


      <div class="info-grid">
        <div class="info-box">
          <strong>Prioritas:</strong>
          @if($card->priority == 'high')
            <span class="badge bg-danger">High</span>
          @elseif($card->priority == 'medium')
            <span class="badge bg-warning text-dark">Medium</span>
          @else
            <span class="badge bg-secondary">Low</span>
          @endif
        </div>
        <div class="info-box">
          <strong>Estimasi Jam:</strong>
          <span>{{ $card->estimated_hours ?? '-' }}</span>
        </div>
        <div class="info-box">
          <strong>Deadline:</strong>
          <span>{{ \Carbon\Carbon::parse($card->deadline)->format('d-m-Y') }}</span>
        </div>
        <div class="info-box">
          <strong>Status:</strong>
          <span>
            <span class="badge 
              @if($card->status == 'todo') bg-secondary
              @elseif($card->status == 'in_progress') bg-primary
              @elseif($card->status == 'review') bg-info text-dark
              @else bg-success @endif">
              {{ ucfirst($card->status) }}
            </span>
          </span>
        </div>
      </div>
    </div>

    <!-- Table -->
    <h4 class="fw-bold text-primary mb-3"><i class="bi bi-list-task"></i> Subtasks</h4>
    <div class="table-wrapper">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Estimasi (jam)</th>
            <th>Aktual (jam)</th>
            <th>Tanggal Dibuat</th>
            <th>Komentar</th>
          </tr>
        </thead>
        <tbody>
          @forelse($card->subtasks->sortBy('position') as $subtask)
            <tr>
              <td class="fw-semibold">{{ $subtask->subtask_title }}</td>
              <td class="subtask-desc">
                {!! nl2br(
                preg_replace(
                  '/(https?:\/\/[^\s<]+)/',
                  '<a href="$1" target="_blank" class="desc-link">$1</a>',
                  e($subtask->description ?? '-')
                  )
                ) !!}
              </td>

              <td>
                <span class="badge-status 
                  @if($subtask->status == 'todo') badge-todo 
                  @elseif($subtask->status == 'in_progress') badge-inprogress 
                  @elseif($subtask->status == 'review') badge-review 
                  @else badge-done @endif">
                  {{ ucfirst($subtask->status) }}
                </span>
              </td>
              <td>{{ $subtask->estimated_hours ?? '-' }}</td>
              <td>{{ $subtask->actual_hours ?? '-' }}</td>
              <td>{{ \Carbon\Carbon::parse($subtask->created_at)->format('d-m-Y') }}</td>
              <td>
                <a href="{{ route('comments.subtask.index', $subtask->subtask_id) }}" class="btn btn-comment btn-sm">
                  <i class="bi bi-chat-dots"></i> Komentar
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-3">Belum ada subtask</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
