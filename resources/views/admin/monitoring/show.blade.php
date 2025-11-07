<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title> Detail Proyek - Monitoring</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e40af;
      --accent: #16a34a;
      --dark-navy: #1e293b;
      --light-bg: #f8fafc;
      --soft-gray: #e2e8f0;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
      --radius: 20px;
    }

    body {
      background: var(--light-bg);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--dark-navy);
      padding: 40px 20px;
    }

    .container {
      max-width: 1200px;
    }

    /* HEADER PROJECT */
    .project-header {
      background: linear-gradient(135deg, #2364ccff, #1e40af); /* versi biru sebelumnya */
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 40px 30px;
      margin-bottom: 40px;
    }

    .project-header h1 {
      font-weight: 700;
      color: #ffffffff; 
      margin-bottom: 10px;
    }

    .project-header p {
      color: #ffffffff; 
      margin: 0;
      font-size: 1.05rem;
      font-weight: 500;
    }

    .meta-info {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 18px;
    }

    .meta-item {
      background: rgba(255, 255, 255, 0.75);
      border-radius: 10px;
      padding: 8px 14px;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 6px;
      color: #111827;
      font-weight: 500;
    }

    .meta-item i {
      color: var(--primary-dark);
    }

    /* TOMBOL KEMBALI */
    .btn-back {
      background: linear-gradient(135deg, #16a34a, #15803d);
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 18px;
      transition: 0.3s ease;
      box-shadow: 0 4px 10px rgba(22,163,74,0.3);
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #15803d, #166534);
      transform: translateY(-2px);
      color: white;
    }

    /* BOARD CARD */
    .board-card {
      border: none;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background: #ffffff;
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .board-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .board-card .card-header {
      background: #1e293b;
      color: #fff;
      font-weight: 600;
      font-size: 1rem;
      padding: 14px 18px;
    }

    .board-card .card-body {
      padding: 18px;
    }

    .board-card p {
      color: #475569;
      font-size: 0.9rem;
      margin-bottom: 12px;
    }

    .btn-view {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      border: none;
      color: white;
      border-radius: 10px;
      font-weight: 500;
      transition: 0.3s;
      width: 100%;
      padding: 8px 0;
    }

    .btn-view:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      color: white;
    }
    .project-desc {
      font-size: 0.9rem;
      color: #475569;
    }

    .desc-link {
      color: #14bde7ff;
      text-decoration: underline;
      word-break: break-word;
    }

    .desc-link:hover {
      color: #1fa7ddff;
    }
    @media (max-width: 768px) {
    body {
      padding: 20px 10px;
    }

    .project-header {
      padding: 25px 20px;
    }

    .meta-info {
      flex-direction: column;
      gap: 10px;
    }

    .meta-item {
      width: 100%;
      justify-content: center;
    }
  }

    
  </style>
</head>
<body>

  <div class="container">

    <!-- HEADER PROYEK -->
    <div class="project-header">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h1><i class="bi bi-folder2-open"></i> {{ $project->project_name }}</h1>
          <p class="project-desc">
            {!! nl2br(
              preg_replace(
                '/(https?:\/\/[^\s<]+)/',
                '<a href="$1" target="_blank" class="desc-link">$1</a>',
                e($project->description ?? 'Tidak ada deskripsi proyek.')
             )
           ) !!}
          </p>

        </div>

        <!-- 🔹 Tombol kembali ke /monitoring -->
        <a href="{{ route('monitoring.index') }}" class="btn btn-back">
          <i class="bi bi-arrow-left-circle"></i> Kembali 
        </a>
      </div>

      <div class="meta-info">
        <div class="meta-item">
          <i class="bi bi-calendar-event"></i>
          <span><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</span>
        </div>
        <div class="meta-item">
          <i class="bi bi-list-task"></i>
          <span><strong>Total Board:</strong> {{ $project->boards->count() }}</span>
        </div>
      </div>
    </div>

    <!-- BOARDS -->
    <div class="row">
      @foreach($project->boards as $board)
        <div class="col-md-6 col-lg-3 mb-4">
          <div class="board-card">
            <div class="card-header">
              <i class="bi bi-columns-gap me-1"></i> {{ $board->board_name }}
            </div>
            <div class="card-body">
              <p><i class="bi bi-card-checklist"></i> Total Cards: {{ $board->cards->count() }}</p>
              <a href="{{ route('monitoring.board', ['project' => $project->project_id, 'board' => $board->board_id]) }}"
                 class="btn btn-view">
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
