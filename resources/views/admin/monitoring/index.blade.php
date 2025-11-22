<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title> Monitoring Proyek - Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --success: #22c55e;
      --bg-main: #f4f6fa;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --radius: 22px;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    body {
      background: var(--bg-main);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--text-dark);
      padding: 50px 20px;
    }

    h2 {
      font-weight: 700;
      color: var(--primary);
    }

    /* ===== HEADER ===== */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 40px;
      flex-wrap: wrap;
      gap: 12px;
      position: relative;
    }

    .page-title {
      flex: 1;
      margin-left: 30px;
    }

    .page-title h2 {
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 12px;
    }

    .search-box {
      position: relative;
      width: 280px;
    }

    .search-box i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      font-size: 1rem;
    }

    .search-box input {
      width: 100%;
      padding: 8px 12px 8px 34px;
      border: 1px solid #d1d5db;
      border-radius: 10px;
      background: #fff;
      transition: all 0.25s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .search-box input:focus {
      border-color: #2563eb;
      outline: none;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }


    .btn-dashboard {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 18px;
      font-weight: 600;
      transition: 0.3s ease;
      box-shadow: 0 6px 15px rgba(37,99,235,0.25);
    }

    .btn-dashboard:hover {
      background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
      transform: translateY(-2px);
      color: white;
    }

    .project-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, 340px);
      justify-content: center; /* biar tetap di tengah */
      gap: 28px;
   }


    /* Flip Card */
    .flip-card {
      perspective: 1000px;
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
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      backface-visibility: hidden;
      overflow: hidden;
      padding: 28px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* DEPAN */
    .flip-card-front {
      background: #fff;
      border: 1px solid #e2e8f0;
      padding: 25px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .flip-card-front h5 {
      font-weight: 600;
      color: var(--text-dark);
    }

    .flip-card-front p {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 8px;
    }

    .flip-card-front .deadline {
      font-size: 0.85rem;
      color: var(--primary);
      background: #e0ecff;
      padding: 6px 10px;
      border-radius: 8px;
      display: inline-block;
    }

    /* BELAKANG */
    .flip-card-back {
      background: linear-gradient(160deg, #2563eb, #1e3a8a);
      color: white;
      transform: rotateY(180deg);
      text-align: center;
    }

    /* Progress Lingkaran */
    .progress-circle {
      position: relative;
      width: 115px;
      height: 115px;
      border-radius: 50%;
      margin: 0 auto;
      background: conic-gradient(
        var(--progress-color, #3b82f6) calc(var(--progress) * 1%),
        rgba(255,255,255,0.15) 0%
      );
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.5s ease;
    }

    /* Hijau kalau 100% */
    .progress-circle[data-complete="true"] {
      --progress-color: #22c55e;
      background: conic-gradient(#22c55e 100%, #22c55e 0);
      box-shadow: 0 0 30px rgba(34,197,94,0.7);
    }

    .progress-circle span {
      position: absolute;
      font-weight: 700;
      font-size: 1.5rem;
      color: white;
    }

    .status-pills {
      display: grid;
      grid-template-columns: repeat(2, 1fr); /* dua kolom sejajar */
      gap: 10px;
      margin-top: 18px;
      width: 100%;
      max-width: 210px;
    }

    .status-item {
      background: rgba(255,255,255,0.18);
      border-radius: 12px;
      padding: 5px 3px;
      text-align: center;
      color: white;
      box-shadow: inset 0 0 10px rgba(255,255,255,0.1);
      transition: 0.3s ease;
    }

    .status-item span {
      font-size: 0.8rem;
      opacity: 0.8;
      display: block;
    }

    .status-item strong {
      font-size: 1.1rem;
    }

    /* Tombol */
    .btn-modern {
      border-radius: 12px;
      font-weight: 600;
      transition: 0.25s ease;
    }

    .btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .btn-primary {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      border: none;
    }

    .btn-outline-secondary {
      border: 2px solid #3b82f6;
      color: #2563eb;
      background: white;
    }

    .btn-outline-secondary:hover {
      background: #2563eb;
      color: white;
    }

    .btn-outline-light {
      border: 2px solid #fff;
      color: #fff;
      border-radius: 12px;
      font-weight: 600;
      padding: 8px 16px;
      background: rgba(255,255,255,0.1);
      transition: 0.3s ease;
    }

    .btn-outline-light:hover {
      background: #fff;
      color: var(--primary-dark);
      box-shadow: 0 0 10px rgba(255,255,255,0.3);
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
      background: #facc15;
      color: #000;
      box-shadow: 0 0 25px #facc15;
    }

    .progress-green {
      background: #22c55e;
      box-shadow: 0 0 25px #22c55e;
    }
    /* === Deskripsi proyek === */
    .project-desc {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 12px;
    }

    .desc-link {
      color: #2563eb;
      text-decoration: underline;
      word-break: break-word;
    }
    .desc-link:hover {
      color: #1e3a8a;
    }
   /* ===============================
   TOMBOL BACK RESPONSIVE (pojok kanan atas HP)
   =============================== */

  /* Desktop default */
  .btn-dashboard {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-weight: 600;
    transition: 0.3s ease;
    box-shadow: 0 6px 15px rgba(37,99,235,0.25);
    text-decoration: none;
  }

  .btn-dashboard:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
    transform: translateY(-2px);
  }

  .btn-dashboard i {
    font-size: 1.1rem;
  }

  .btn-dashboard .btn-text {
    display: inline;
  }

/* ===============================
   HP MODE (≤576px)
   =============================== */
  @media (max-width: 576px) {
    .btn-dashboard {
      position: absolute;
      top: -15px;
      right: -25px; /* pojok kanan atas */
      background: linear-gradient(135deg, #2563eb, #1e40af);
      width: 42px;
      height: 42px;
      border-radius: 12px;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 3px 8px rgba(37,99,235,0.3);
    }

    .btn-dashboard i {
      font-size: 1.4rem;
    }

    /* Sembunyikan teks, tapi tampilkan saat hover */
    .btn-dashboard .btn-text {
      display: none;
      position: absolute;
      right: 52px;
      top: 50%;
      transform: translateY(-50%);
      background: #2563eb;
      color: #fff;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.85rem;
      white-space: nowrap;
      box-shadow: 0 3px 8px rgba(37,99,235,0.25);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .btn-dashboard:hover .btn-text {
      display: inline-block;
      opacity: 1;
    }

    .page-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }
  }
  /* === HP MODE (≤576px) === */
  @media (max-width: 576px) {
    .page-title {
        margin-left: 10px; /* geser ke kiri */
    }

    .search-box {
        width: 100%;      /* biar search box tetap penuh tapi mengikuti container */
        max-width: 280px; /* tetap batasi maksimal */
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;        /* jarak antar elemen */
    }
}

 
  </style>
</head>
<body>

 <div class="container">
    <!-- HEADER -->
    <div class="page-header">
      <div class="page-title">
        <h2><i class="bi bi-speedometer2"></i> Monitoring Proyek</h2>

        <form method="GET" action="{{ route('monitoring.index') }}" class="d-flex align-items-center gap-2">
          <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari proyek..." value="{{ request('search') }}">
          </div>
          <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>

          @if(request('search'))
            <a href="{{ url()->current() }}" class="btn btn-secondary">
              <i class="bi bi-arrow-counterclockwise"></i>
            </a>
          @endif
        </form>
      </div>

      <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
         <i class="bi bi-arrow-left-circle"></i> <span class="btn-text">Kembali ke Dashboard Admin</span>
      </a>
    </div>
    <div class="project-grid">
      @php
      // Urutkan agar draft tampil paling atas, lalu pending & rejected, lalu approved
      $sortedProjects = $projects->sortBy(function($p) {
          return match ($p->status) {
            'draft' => 0,
            'pending', 'rejected' => 1,  // ✅ keduanya satu level
            'approved' => 2,
            default => 3,
          };
        });

       // Filter pencarian berdasarkan nama proyek
       $filteredProjects = $sortedProjects->filter(function($project) {
          $search = strtolower(request('search', ''));
          return $search === '' || str_contains(strtolower($project->project_name), $search);
        });
      @endphp


      @foreach($filteredProjects as $project)
        @php
          $totalCards = 0;
          $countTodo = $countInProgress = $countReview = $countDone = 0;
          $progressValue = 0;
          $weights = ['todo' => 0, 'in_progress' => 0.5, 'review' => 0.8, 'done' => 1];
          foreach ($project->boards as $board) {
              foreach ($board->cards as $card) {
                  $totalCards++;
                  $key = strtolower($card->status);
                  $progressValue += $weights[$key] ?? 0;
                  if ($key == 'todo') $countTodo++;
                  elseif ($key == 'in_progress') $countInProgress++;
                  elseif ($key == 'review') $countReview++;
                  elseif ($key == 'done') $countDone++;
              }
          }
          $progress = $totalCards > 0 ? round(($progressValue / $totalCards) * 100) : 0;
          $statusClass = match($project->status) {
            'approved' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'rejected' => 'bg-danger',
            default => 'bg-secondary'
          };
        @endphp

        <div class="flip-card">
          <div class="flip-card-inner">
            <!-- DEPAN -->
            <div class="flip-card-front">
              <div>
                <h5>{{ $project->project_name }}</h5>
                <p class="project-desc">
                  {!! nl2br(
                    preg_replace(
                      '/(https?:\/\/[^\s<]+)/',
                      '<a href="$1" target="_blank" class="desc-link">$1</a>',
                      e($project->description ?? 'Belum ada deskripsi untuk proyek ini.')
                    )
                  ) !!}
                </p>

                <p class="deadline"><i class="bi bi-calendar-event"></i> 
                  Deadline: {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
                </p>
                <span class="badge {{ $statusClass }}">{{ ucfirst($project->status) }}</span>
              </div>

              <div class="d-flex justify-content-between gap-2 mt-3">
                <button class="btn btn-primary btn-modern flex-fill flip-btn">
                  <i class="bi bi-bar-chart-line"></i> Lihat Progres
                </button>
                <!-- Tombol Grafik -->
                <a href="{{ route('monitoring.chart', $project->project_id) }}"
                    class="btn btn-success btn-modern flex-fill"style="color:#fff; font-weight:600;">
                    <i class="bi bi-graph-up"></i> Grafik
                </a>
                <a href="{{ route('monitoring.show', $project->project_id) }}" class="btn btn-outline-secondary btn-modern flex-fill">
                  <i class="bi bi-info-circle"></i> Detail
                </a>
              </div>
            </div>

            <!-- BELAKANG -->
            <div class="flip-card-back d-flex flex-column justify-content-between align-items-center">
              <div>
                <div class="progress-circle" 
                     style="--progress: {{ $progress }}" 
                     data-complete="{{ $progress == 100 ? 'true' : 'false' }}">
                  <span>{{ $progress }}%</span>
                </div>
                <h6 class="fw-bold mt-3">Progres Keseluruhan</h6>
              </div>

              <div class="status-pills">
                <div class="status-item"><span>Todo</span><strong>{{ $countTodo }}</strong></div>
                <div class="status-item"><span>In Progress</span><strong>{{ $countInProgress }}</strong></div>
                <div class="status-item"><span>Review</span><strong>{{ $countReview }}</strong></div>
                <div class="status-item"><span>Done</span><strong>{{ $countDone }}</strong></div>
              </div>

              <!-- Tombol Balik -->
              <div class="mt-4 mb-3">
                <button class="btn btn-outline-light flip-back">
                  <i class="bi bi-arrow-left-circle"></i> Kembali ke Depan
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script>
    document.querySelectorAll('.flip-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        e.target.closest('.flip-card').classList.add('flipped');
      });
    });
    document.querySelectorAll('.flip-back').forEach(btn => {
      btn.addEventListener('click', e => {
        e.target.closest('.flip-card').classList.remove('flipped');
      });
    });
    // Warna solid berdasarkan presentase progress
    document.querySelectorAll('.progress-circle').forEach(circle => {
      const progress = parseFloat(circle.style.getPropertyValue('--progress'));
      let color = '#ef4444'; // merah default (kurang dari 50%)

      if (progress >= 50 && progress < 99.9) {
        color = '#facc15'; // kuning
      } else if (progress >= 99.9) {
        color = '#22c55e'; // hijau
      }

      // lingkaran penuh warna solid
      circle.style.background = color;
      circle.style.boxShadow = `0 0 30px ${color}88`;
    });
  </script>
</body>
</html>
