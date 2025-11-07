<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Monitoring Board - {{ $board->board_name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --accent: #7c3aed;
      --success: #22c55e;
      --danger: #ef4444;
      --warning: #facc15;
      --bg: #f1f5f9;
      --text: #1e293b;
      --radius: 18px;
      --shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg);
      color: var(--text);
      padding: 40px;
      overflow-x: hidden;
    }

    h1 {
      font-weight: 700;
      color: var(--primary-dark);
    }

    .btn-main-back {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 18px;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(22,163,74,0.3);
    }

    .btn-main-back:hover {
      background: linear-gradient(135deg, #15803d, #166534);
      transform: translateY(-2px);
      color: white;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, 380px);
      justify-content: center; /* 🔹 biar grid tetap rata tengah */
      gap: 25px;
      margin-top: 30px;
   }


    .flip-card {
      perspective: 1000px;
      border-radius: var(--radius);
      height: 420px;
    }

    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s ease;
      transform-style: preserve-3d;
    }

    .flip-card.flipped .flip-card-inner {
      transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    /* === DEPAN === */
    .flip-card-front {
      background: #fff;
      padding: 25px 28px;
      border: 1px solid #e2e8f0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .flip-card-front h5 {
      font-weight: 600;
      color: var(--primary-dark);
      margin-bottom: 6px;
    }

    .flip-card-front p {
      font-size: 0.95rem;
      color: #374151;
      margin-bottom: 10px;
    }

    .info-line {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px dashed #e2e8f0;
      padding: 4px 0;
      font-size: 0.9rem;
    }

    .badge {
      font-size: 0.85rem;
      border-radius: 8px;
      padding: 4px 10px;
    }

    .card-actions {
      display: flex;
      justify-content: space-between;
      gap: 8px;
      flex-wrap: wrap;
    }

    .btn-modern {
      border: none;
      border-radius: 10px;
      padding: 10px 14px;
      font-weight: 600;
      transition: 0.3s;
      flex: 1;
      text-align: center;
    }

    .btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    /* 🔹 Hilangkan garis bawah pada tombol Detail dan Komentar */
    .btn-detail,
    .btn-detail:visited,
    .btn-detail:hover,
    .btn-detail:active,
    .btn-comment,
    .btn-comment:visited,
    .btn-comment:hover,
    .btn-comment:active {
      text-decoration: none !important;
    }

    .btn-detail { background: #e2e8f0; color: var(--primary-dark); }
    .btn-comment { background: linear-gradient(135deg, #059669, #10b981); color: #fff; }
    .btn-progress { background: linear-gradient(135deg, #3b82f6, #1e3a8a); color: #fff; }

    /* === BELAKANG === */
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
      width: 110px;
      height: 110px;
      border-radius: 50%;
      background: #22c55e;
      color: #fff;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 20px #22c55e;
      margin-bottom: 15px;
    }

    .progress-title {
      font-weight: 600;
      font-size: 1.05rem;
      margin-bottom: 20px;
    }

    .stats-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      width: 100%;
      max-width: 260px;
    }

    .stat-box {
      background: rgba(255,255,255,0.15);
      border-radius: 10px;
      padding: 6px 0;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .btn-back {
      border: 2px solid #fff;
      color: #fff;
      border-radius: 10px;
      padding: 8px 18px;
      font-weight: 600;
      background: transparent;
      margin-top: 20px;
      font-size: 0.9rem;
      transition: 0.3s;
    }

    .btn-back:hover {
      background: #fff;
      color: #1e3a8a;
      transform: translateY(-2px);
    }
    .progress-ring {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.4rem;
      font-weight: 700;
      color: #fff;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
      margin-bottom: 18px;
    }

    .progress-red {
      background: #ef4444;
      box-shadow: 0 0 25px #ef4444;
    }

    .progress-yellow {
      background: #f5cc29ff;
      color: #ffffffff;
      box-shadow: 0 0 25px #facc15;
    }

    .progress-green {
      background: #22c55e;
      box-shadow: 0 0 25px #22c55e;
    }
   
    /* Tulisan nama proyek di bawah judul */
    .project-name {
      font-size: 1.3rem;               /* ✨ lebih besar */
      font-weight: 700;                /* ✨ lebih tebal */
      color: #000000ff;                  /* ✨ biru gelap agar kuat */
      text-shadow: 0 1px 4px rgba(0,0,0,0.1); /* bayangan lembut */
      letter-spacing: 0.3px;           /* jarak antar huruf sedikit longgar */
    }
    .card-desc {
      font-size: 0.95rem;
      color: #374151;
      margin-bottom: 10px;
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

    h1 {
      font-size: 1.4rem;
    }

    .project-name {
      font-size: 1.1rem;
    }

    .flip-card {
      height: auto; /* biar tidak kaku di HP */
      min-height: 480px;
    }

    .flip-card-front, .flip-card-back {
      padding: 20px;
    }

    .btn-main-back {
      width: auto;          /* 🔹 tidak full layar */
      display: inline-block; /* 🔹 ukurannya mengikuti teks */
      font-size: 0.9rem;
      padding: 8px 16px;     /* 🔹 tetap proporsional */
    }

    .card-actions {
      flex-direction: column;
    }

    .btn-modern {
      width: 100%;
    }
  }
  @media (max-width: 576px) {
    .d-flex {
      flex-direction: column;
      align-items: flex-start !important;
    }

    .btn-main-back {
      margin-top: 10px;
    }
  }

  </style>
</head>

<body>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <div>
        <h1><i class="bi bi-kanban"></i> Board: {{ $board->board_name }}</h1>
        <p class="project-name">Proyek: {{ $project->project_name }}</p>
      </div>
      <a href="{{ route('monitoring.show', $project->project_id) }}" class="btn btn-main-back">
        <i class="bi bi-arrow-left-circle"></i> Kembali 
      </a>
    </div>

    <div class="card-grid">
      @foreach($board->cards as $card)
       @php
        $status = $card->status;
        $total = $card->subtasks->count();
        $todo = $card->subtasks->where('status', 'todo')->count();
        $inProgress = $card->subtasks->where('status', 'in_progress')->count();
        $review = $card->subtasks->where('status', 'review')->count();
        $doneCount = $card->subtasks->where('status', 'done')->count();
        $actualHours = $card->subtasks->sum('actual_hours');

        // Tentukan progress berdasarkan status utama card
        if ($status === 'todo') {
          $progress = 0;
        }  elseif ($status === 'in_progress') {
          $progress = 50;
        } elseif ($status === 'review') {
          $progress = 80;
        } elseif ($status === 'done') {
          $progress = 100;
        } else {
          $progress = 0;
        }
      @endphp


        <div class="flip-card">
          <div class="flip-card-inner">
            <!-- DEPAN -->
            <div class="flip-card-front">
              <div>
                <h5><i class="bi bi-card-text"></i> {{ $card->card_title }}</h5>
               <p class="card-desc">
                  {!! nl2br(
                  preg_replace(
                    '/(https?:\/\/[^\s<]+)/',
                    '<a href="$1" target="_blank" class="desc-link">$1</a>',
                    e($card->description ?? '-')
                  )
                ) !!}
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
                  @if($card->assignments->isNotEmpty())
                    @foreach($card->assignments as $a)
                      <span class="badge bg-info text-dark">{{ $a->user->username }}</span>
                    @endforeach
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </div>
              </div>

              <div class="card-actions">
                <a href="{{ route('monitoring.card', ['project' => $project->project_id, 'card' => $card->card_id]) }}" class="btn-modern btn-detail">
                  <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('comments.card.index', $card->card_id) }}" class="btn-modern btn-comment">
                  <i class="bi bi-chat-dots"></i> Komentar
                </a>
                <button class="btn-modern btn-progress" onclick="flipCard(this)">
                  <i class="bi bi-bar-chart-line"></i> Progress
                </button>
              </div>
            </div>

            <!-- BELAKANG -->
            <div class="flip-card-back">
              <div class="progress-ring">{{ $progress }}%</div>
              <div class="progress-title">Progres Subtaks</div>
              <div class="stats-container">
                <div class="stat-box">Todo<br><strong>{{ $todo }}</strong></div>
                <div class="stat-box">In Progress<br><strong>{{ $inProgress }}</strong></div>
                <div class="stat-box">Review<br><strong>{{ $review }}</strong></div>
                <div class="stat-box">Done<br><strong>{{ $doneCount }}</strong></div>
              </div>
              <button class="btn btn-back" onclick="flipCard(this)">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Depan
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
    // Ubah warna lingkaran progress berdasarkan persentase
    document.querySelectorAll('.progress-ring').forEach(ring => {
      const progress = parseFloat(ring.textContent); // ambil angka dari teks "85%"
      let color = '#ef4444'; // Merah default (<50%)

      if (progress >= 50 && progress < 99.9) {
        color = '#f5cc29ff'; // Kuning (50–99.9)
        ring.style.color = '#ffffffff'; // teks hitam agar kontras di kuning
      } else if (progress >= 99.9) {
        color = '#22c55e'; // Hijau (≥99.9)
        ring.style.color = '#fff';
      } else {
        ring.style.color = '#fff';
      }

      // Terapkan warna solid dan efek glow lembut
      ring.style.background = color;
      ring.style.boxShadow = `0 0 25px ${color}88`;
    });
  </script>
</body>
</html>
