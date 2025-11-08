<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title> Detail Proyek - {{ $project->project_name }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --secondary-btn: linear-gradient(135deg, #06b6d4, #0ea5e9); /* biru muda - cyan */
      --gradient-btn: linear-gradient(135deg, #2563eb, #1e40af);
      --light-bg: #f8fafc;
      --card-bg: #ffffff;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      --radius: 20px;
    }

    body {
      background: linear-gradient(145deg, #f3f6ff, #ffffff);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--text-dark);
      min-height: 100vh;
      padding-bottom: 80px;
    }

    /* 🔷 Header Proyek */
    .project-header {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      padding: 35px 40px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      margin-bottom: 40px;
      position: relative;
    }
    .project-header p {
      white-space: pre-wrap;     /* biar baris baru di database tetap muncul */
      word-wrap: break-word;     /* supaya kata panjang terpotong ke bawah */
      max-width: 100%;           /* pastikan tidak meluber ke samping */
      line-height: 1.2;          /* jarak antarbaris biar rapi */
      overflow-wrap: break-word; /* pecah kata panjang ke baris baru */
    }

    .project-header h1 {
      font-weight: 700;
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .project-header p {
      color: #e2e8f0;
      margin-bottom: 6px;
      font-size: 0.95rem;
    }

    .project-header strong {
      color: #fff;
    }

    /* 🌈 Tombol Kembali di kanan atas (biru muda - cyan) */
    .btn-dashboard {
      position: absolute;
      top: 25px;
      right: 35px;
      background: var(--secondary-btn);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 22px;
      box-shadow: 0 4px 15px rgba(6, 182, 212, 0.35);
      transition: all 0.3s ease;
    }

    .btn-dashboard:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(6, 182, 212, 0.45);
      opacity: 0.95;
    }

    /* 📦 Board Card */
    .board-card {
      border: none;
      border-radius: var(--radius);
      background: var(--card-bg);
      box-shadow: var(--shadow);
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .board-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 28px rgba(37, 99, 235, 0.12);
    }

    .board-card .card-header {
      background: linear-gradient(135deg, #1e3a8a, #1e40af);
      color: white;
      font-weight: 600;
      border: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 18px;
      border-top-left-radius: var(--radius);
      border-top-right-radius: var(--radius);
    }

    .board-card .card-body {
      background: var(--card-bg);
      padding: 25px;
      text-align: center;
    }

    /* 🔹 Tombol umum */
    .btn {
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    /* 🟩 Tambah Card */
    .btn-success {
      background: linear-gradient(135deg, #22c55e, #15803d);
      border: none;
      display: flex;
      align-items: center;
      gap: 5px;
      font-weight: 600;
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #16a34a, #166534);
      transform: translateY(-2px);
    }

    /* 🔵 Tombol Lihat Cards */
    .btn-primary {
      background: var(--gradient-btn);
      border: none;
      color: #fff;
      padding: 10px 0;
      font-weight: 600;
    }

    .btn-primary:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    /* Responsif */
    @media (max-width: 768px) {
      .project-header {
        padding: 25px;
        text-align: center;
      }

      .btn-dashboard {
        position: static;
        display: block;
        margin: 15px auto 0;
      }
    }
      .desc-link {
        color: #38bdf8; /* biru muda yang selaras dengan tema */
        text-decoration: none;
        font-weight: 500;
        word-break: break-all; /* agar link panjang tetap rapi di layar kecil */
      }

      .desc-link:hover {
        color: #0ea5e9;
        text-decoration: underline;
      }
      
  </style>
</head>

<body>
  <div class="container py-5">

    <!-- 🧭 Info Proyek -->
    <div class="project-header">
      <h1><i class="bi bi-kanban"></i> {{ $project->project_name }}</h1>
      <p>
        {!! nl2br(preg_replace(
          '/(https?:\/\/[^\s]+)/',
          '<a href="$1" target="_blank" class="desc-link">$1</a>',
          e($project->description ?? 'Tidak ada deskripsi')
        )) !!}
      </p>

      <p><strong>🗓 Deadline:</strong> {{ \Carbon\Carbon::parse($project->deadline)->format('d-m-Y') }}</p>

      <!-- 🔙 Tombol Kembali ke Dashboard di kanan atas -->
      <a href="{{ route('teamlead.dashboard') }}" class="btn btn-dashboard">
        <i class="bi bi-arrow-left-circle"></i> Kembali Ke Dashboard
      </a>
    </div>

    <!-- 🗂 Boards -->
    <div class="row g-4">
      @foreach($project->boards as $board)
        <div class="col-lg-3 col-md-6">
          <div class="board-card">
            <div class="card-header">
              <span><i class="bi bi-columns-gap"></i> {{ $board->board_name }}</span>

              <!-- Tombol tambah Card -->
              @if(auth()->user()->role == 'team_lead' && $board->board_name == 'To Do' && $project->status !== 'approved')
                <a href="{{ route('teamlead.cards.create', $board->board_id) }}" class="btn btn-sm btn-success shadow-sm">
                  <i class="bi bi-plus-circle"></i> Card
                </a>
              @endif
            </div>

            <div class="card-body">
              <p class="mb-2 text-muted"><i class="bi bi-collection"></i> Total Cards:</p>
              <h4 class="fw-bold text-primary mb-3">{{ $board->cards->count() }}</h4>

              <a href="{{ route('teamlead.cards.index', $board->board_id) }}" class="btn btn-primary w-100">
                <i class="bi bi-eye"></i> Lihat Cards
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</body>
</html>
