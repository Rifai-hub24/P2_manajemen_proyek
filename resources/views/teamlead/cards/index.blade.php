<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Cards - {{ $board->board_name }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary: #2563eb;
      --dark: #1e3a8a;
      --bg: #f1f5f9;
      --shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    body {
      background: var(--bg);
      font-family: "Inter", "Poppins", sans-serif;
      color: #1e293b;
      padding: 40px;
    }

    h1 {
      font-weight: 700;
      color: var(--dark);
    }

    .btn-back {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 18px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(37,99,235,0.3);
      transition: 0.3s;
    }
    .btn-back:hover {
      transform: translateY(-2px);
      color: white !important;
    }

    .btn-add {
      background: linear-gradient(135deg, #16a34a, #15803d);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 18px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(22,163,74,0.3);
      transition: 0.3s;
    }
    .btn-add:hover {
      transform: translateY(-2px);
      color: white !important;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, 420px);
      justify-content: center;
      gap: 30px;
      margin-top: 30px;
    }

    .flip-card {
      perspective: 1000px;
      border-radius: 18px;
      height: 460px;
    }

    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s ease;
      transform-style: preserve-3d;
    }

    .flip-card.flipped .flip-card-inner { transform: rotateY(180deg); }

    .flip-card-front, .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 18px;
      box-shadow: var(--shadow);
      backface-visibility: hidden;
      overflow: hidden;
    }

    /* DEPAN */
    .flip-card-front {
      background: #fff;
      padding: 28px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 1px solid #e2e8f0;
    }

    .flip-card-front h5 {
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 10px;
    }

    .info-line {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px dashed #e2e8f0;
      padding: 4px 0;
      font-size: 0.9rem;
    }

    .card-actions {
      display: flex;
      gap: 8px;
      margin-top: 10px;
      flex-wrap: wrap;
    }

    .btn-modern {
      border: none;
      border-radius: 10px;
      padding: 9px 12px;
      font-weight: 600;
      flex: 1;
      transition: 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .btn-modern:hover { transform: translateY(-2px); }
    .btn-detail { background: #e2e8f0; color: var(--dark); }
    .btn-edit { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .btn-comment { background: linear-gradient(135deg, #059669, #10b981); color: white; }
    .btn-delete { background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; }
    .btn-progress { background: linear-gradient(135deg, #2563eb, #1e3a8a); color: white; }
    /* 🔹 Hilangkan garis bawah hanya pada tombol Detail, Edit, dan Komentar */
    .btn-detail,
    .btn-detail:visited,
    .btn-detail:hover,
    .btn-detail:active,
    .btn-edit,
    .btn-edit:visited,
    .btn-edit:hover,
    .btn-edit:active,
    .btn-comment,
    .btn-comment:visited,
    .btn-comment:hover,
    .btn-comment:active {
      text-decoration: none !important;
    }

    /* BELAKANG */
    .flip-card-back {
      transform: rotateY(180deg);
      background: linear-gradient(180deg, #2563eb, #1e3a8a);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 25px;
    }

    .progress-ring {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.6rem;
      font-weight: 700;
      color: #fff;
      box-shadow: 0 0 25px rgba(0,0,0,0.25);
      margin-bottom: 15px;
    }

    .progress-red { background: #ef4444; box-shadow: 0 0 25px #ef4444; }
    .progress-yellow { background: #f5cc29ff; color: #ffffffff; box-shadow: 0 0 25px #facc15; }
    .progress-green { background: #22c55e; box-shadow: 0 0 25px #22c55e; }

    .progress-text {
      font-size: 1.1rem;
      font-weight: 600;
      margin-top: 8px;
      text-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }

    .btn-back-flip {
      border: 2px solid #fff;
      color: #fff;
      border-radius: 10px;
      padding: 8px 16px;
      background: transparent;
      transition: 0.3s;
      font-weight: 600;
      margin-top: 20px;
    }
    .btn-back-flip:hover { background: #fff; color: #1e3a8a; }
    
    .desc-link {
      color: #2563eb; /* biru elegan, senada dengan tema Project PRO */
      text-decoration: none;
      font-weight: 500;
      word-break: break-all; /* biar link panjang tetap rapi */
    }

    .desc-link:hover {
      color: #1e40af;
      text-decoration: underline;
    }
     /* =========================
     RESPONSIVE DESIGN
    ==========================*/
    @media (max-width: 992px) {
      body { padding: 25px; }
      h1 { font-size: 1.6rem; }

      .card-grid {
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
      }

      .flip-card { height: 480px; }
    }

    @media (max-width: 768px) {
      body { padding: 20px; }
      h1 { font-size: 1.4rem; text-align: center; }

      .card-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .flip-card {
        height: 520px; /* ✅ lebih tinggi di mobile */
      }

      .flip-card-front {
        padding: 22px;
      }

      .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 15px;
      }

      .d-flex.gap-2 {
        width: 100%;
        display: flex;
        justify-content: space-between;
      }

      .btn-add {
        width: 48%;
        text-align: center;
        font-size: 0.9rem;
      }

      /* ✅ Tombol kembali tidak full, lebarnya sekitar 40% */
      .btn-back {
        width: 40%;
        text-align: center;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      body { padding: 15px; }

      h1 {
        font-size: 1.25rem;
        text-align: center;
      }

      .card-grid {
        grid-template-columns: 1fr;
        gap: 18px;
      }

      .flip-card {
        height: 560px; 
      }

      .btn-add {
        width: 48%;
        font-size: 0.85rem;
      }

      .btn-back {
        width: 40%;
        font-size: 0.85rem;
      }

      .card-actions {
        flex-direction: column;
        gap: 10px;
      }

      .btn-modern {
        width: 100%;
      }
    }
    /* 🔹 Tombol Kembali di kiri dan Tambah Card di kanan pada layar kecil */
    @media (max-width: 768px) {
    .d-flex.gap-2 {
      width: 100%;
      display: flex;
      justify-content: space-between; /* tombol di kiri & kanan */
    }

    .btn-add,
    .btn-back {
      flex: 0 0 48%;   /* masing-masing lebar 48% agar sejajar */
      text-align: center;
      font-size: 0.9rem;
    }

    /* Kalau ingin tombol kembali di kiri, pastikan urutannya seperti ini di HTML */
    .d-flex.gap-2 a.btn-back {
      order: 1;
    }

    .d-flex.gap-2 a.btn-add {
      order: 2;
    }
  }
  /* === STATUS GRID KECIL DI SISI BELAKANG === */
  .status-grid {
    display: grid;
    grid-template-columns: repeat(2, 90px); /* kecil tapi seimbang */
    gap: 12px;
    justify-content: center;
    margin-top: 8px;
  }

  .status-box {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 8px 5px;
    text-align: center;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    backdrop-filter: blur(3px);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .status-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 10px rgba(0,0,0,0.25);
  }

  .status-box span {
    display: block;
    font-size: 0.8rem;
    opacity: 0.9;
  }

  .status-box strong {
    display: block;
    font-size: 1rem;
    margin-top: 3px;
  }

  /* 📱 Responsif di HP */
  @media (max-width: 576px) {
    .status-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }
    .status-box {
      padding: 7px 4px;
    }
    .status-box strong {
      font-size: 0.9rem;
    }
  }
  .flip-card-front p {
    white-space: normal;        /* biar teks turun ke bawah */
    word-wrap: break-word;      /* potong kata panjang */
    overflow: hidden;           /* sembunyikan sisanya */
    display: -webkit-box;
    -webkit-line-clamp: 2;      /* batasi 3 baris */
    -webkit-box-orient: vertical;
    line-height: 1.4rem;
  }


  </style>
</head>
<body>

  <div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <div>
        <h1><i class="bi bi-kanban"></i> {{ $board->board_name }}</h1>
      </div>
      <div class="d-flex gap-2">
        <!-- Tombol Tambah Card -->
        @if($board->board_name == 'To Do' && $board->project->status != 'approved')
          <a href="{{ route('teamlead.cards.create', $board->board_id) }}" class="btn btn-add">
            <i class="bi bi-plus-circle"></i> Tambah Card
          </a>
        @endif

        <a href="{{ route('teamlead.projects.show', $board->project->project_id) }}" class="btn btn-back">
          <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
      </div>
    </div>

    <!-- Grid Cards -->
    <div class="card-grid">
      @foreach($cards as $card)
       @php
        $status = $card->status;
        $total = $card->subtasks->count();
        $done = $card->subtasks->where('status','done')->count();
        $actualHours = $card->subtasks->sum('actual_hours');

        // Tentukan progress berdasarkan status utama card
        switch ($status) {
        case 'todo':
            $progress = 0;
            break;
        case 'in_progress':
            $progress = 50;
            break;
        case 'review':
            $progress = 80;
            break;
        case 'done':
            $progress = 100;
            break;
        default:
            $progress = 0;
            break;
        }
      @endphp


        <div class="flip-card">
          <div class="flip-card-inner">
            <!-- DEPAN -->
            <div class="flip-card-front">
              <div>
                <h5>{{ $card->card_title }}</h5>
                @php
                  $desc = $card->description ?? '-';
                  $shortDesc = Str::limit($desc, 100, '...');
                @endphp

                <p>
                  {!! nl2br(preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank" class="desc-link">$1</a>',
                    e($card->description ?? '-')
                  )) !!}
                </p>

                <div class="info-line"><strong>Prioritas:</strong>
                  @if($card->priority == 'high')
                    <span class="badge bg-danger">High</span>
                  @elseif($card->priority == 'medium')
                    <span class="badge bg-warning text-dark">Medium</span>
                  @else
                    <span class="badge bg-secondary">Low</span>
                  @endif
                </div>
                <div class="info-line"><strong>Estimasi:</strong> {{ $card->estimated_hours ?? '-' }} jam</div>
                <div class="info-line"><strong>Actual:</strong> {{ $actualHours ?? 0 }} jam</div>
                <div class="info-line"><strong>Status:</strong> 
                  <span class="badge bg-info text-dark">{{ ucfirst($card->status) }}</span>
                </div>
                <div class="info-line"><strong>Deadline:</strong> {{ $card->due_date ? \Carbon\Carbon::parse($card->due_date)->format('d-m-Y') : '-' }}</div>
                <div class="info-line"><strong>Anggota:</strong>
                  @forelse($card->assignments as $a)
                    <span class="badge bg-info text-dark">{{ $a->user->username }}</span>
                  @empty
                    <span class="text-muted">-</span>
                  @endforelse
                </div>
              </div>

              <div class="card-actions">
                <a href="{{ route('teamlead.cards.show', [$board->board_id, $card->card_id]) }}" class="btn-modern btn-detail">
                  <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('comments.card.index', $card->card_id) }}" class="btn-modern btn-comment">
                  <i class="bi bi-chat-dots"></i> Komentar
                </a>
                @if($card->status != 'done')
                  <a href="{{ route('teamlead.cards.edit', [$board->board_id, $card->card_id]) }}" class="btn-modern btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form method="POST" action="{{ route('teamlead.cards.destroy', [$board->board_id, $card->card_id]) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-delete" onclick="return confirm('Yakin mau hapus card ini?')">
                      <i class="bi bi-trash3"></i> Hapus
                    </button>
                  </form>
                @endif
                <button class="btn-modern btn-progress" onclick="flipCard(this)">
                  <i class="bi bi-bar-chart-line"></i> Progress
                </button>
              </div>
            </div>

            <!-- BELAKANG -->
            <div class="flip-card-back">
              <div class="progress-ring">
                {{ $progress }}%
              </div>

              <h5 class="mb-4 fw-bold">Status Subtask</h5>
              <div class="status-grid">
                  <div class="status-box">
                    <span>To Do</span>
                    <strong>{{ $card->subtasks->where('status','todo')->count() }}</strong>
                  </div>
                  <div class="status-box">
                    <span>In Progress</span>
                    <strong>{{ $card->subtasks->where('status','in_progress')->count() }}</strong>
                  </div>
                  <div class="status-box">
                    <span>Review</span>
                    <strong>{{ $card->subtasks->where('status','review')->count() }}</strong>
                  </div>
                  <div class="status-box">
                    <span>Done</span>
                    <strong>{{ $card->subtasks->where('status','done')->count() }}</strong>
                  </div>
                </div>

                <button class="btn btn-back-flip mt-4" onclick="flipCard(this)">
                  <i class="bi bi-arrow-left-circle"></i> Kembali
                </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script>
    function flipCard(btn) {
      const card = btn.closest('.flip-card');
      card.classList.toggle('flipped');
    }

    //  Warna dinamis progress lingkaran
    document.querySelectorAll('.progress-ring').forEach(ring => {
      const value = parseFloat(ring.textContent);
      if (value < 50) ring.classList.add('progress-red');
      else if (value >= 50 && value < 99.9) ring.classList.add('progress-yellow');
      else ring.classList.add('progress-green');
    });
  </script>
</body>
</html>
