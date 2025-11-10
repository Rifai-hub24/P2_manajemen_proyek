<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Dashboard Team Lead - Project PRO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --sidebar-bg: #1e293b;
      --sidebar-active: #334155;
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --success: #22c55e;
      --danger: #ef4444;
      --warning: #facc15;
      --bg-main: #f8fafc;
      --radius: 18px;
      --shadow: 0 8px 25px rgba(0,0,0,0.08);
    }

    body {
      margin: 0;
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg-main);
      color: #1e293b;
    }

    /* === SIDEBAR === */
    .sidebar {
      background: var(--sidebar-bg);
      width: 240px;
      height: 100vh;
      position: fixed;         
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 25px 20px;
      z-index: 1000;           
      overflow-y: auto;         
      scrollbar-width: thin;    
      scrollbar-color: #475569 transparent;
      box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1); 
    }

    .sidebar-header {
      text-align: center;
    }

    /* === Logo Sidebar Bulat Modern === */
    .logo-circle {
       width: 58px;
       height: 58px;
       border-radius: 50%;
       background: #ffffff;
       display: flex;
       align-items: center;
       justify-content: center;
       margin: 0 auto 12px;
       box-shadow: 0 0 20px rgba(37, 99, 235, 0.25);
    }

    .logo-circle i {
      font-size: 1.9rem;
      color: #2563eb;
    }

    .sidebar-header h4 {
      font-weight: 700;
      color: #ffffff;
      text-align: center;
      margin-bottom: 0;
    }

  
    .nav-link {
      color: #cbd5e1;
      font-weight: 500;
      border-radius: 10px;
      padding: 10px 12px;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: 0.3s;
    }

    .nav-link:hover, .nav-link.active {
      background: var(--sidebar-active);
      color: #fff;
    }
    /* === Perbaikan untuk link Solve Blocker agar sejajar dan putih === */
    .nav-link i {
      color: #cbd5e1; /* warna ikon putih pudar */
      font-size: 1.1rem;
    }

    .nav-link:hover i,
    .nav-link.active i {
      color: #ffffff; /* ikon ikut putih saat aktif atau hover */
    }

    /* Hilangkan garis bawah di semua link sidebar */
    .nav-link, .nav-link:visited, .nav-link:hover, .nav-link:active {
      text-decoration: none !important;
    }

    .logout-btn {
      background: #dc2626;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 10px;
      width: 100%;
      font-weight: 600;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: #b91c1c;
      transform: translateY(-2px);
    }

    /* === MAIN === */
    .main {
      margin-left: 240px;
      padding: 30px;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 25px;
    }

    .page-header h2 {
      font-weight: 700;
      color: var(--primary-dark);
    }

    .search-box {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 10px;
      padding: 6px 12px;
      box-shadow: var(--shadow);
      width: 320px;
    }

    .search-box input {
      border: none;
      outline: none;
      flex: 1;
      padding: 6px;
      font-size: 0.95rem;
    }
   
    /* === Tombol Cari dan Reset === */
    .btn-search {
      background: #2563eb;
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }
    .btn-search:hover {
      background: #1e40af;
      transform: translateY(-2px);
      color: #fff;
    }

    .btn-reset {
      background: #6b7280;
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .btn-reset:hover {
      background: #4b5563;
      color: white;
      transform: translateY(-2px);
    }


    /* === GRID === */
    .project-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    @media(max-width: 1200px) {
      .project-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media(max-width: 768px) {
      .project-grid { grid-template-columns: 1fr; }
    }

    /* === CARD FLIP === */
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
      background: #fff;
      backface-visibility: hidden;
      border: 1px solid #e2e8f0;
      overflow: hidden;
    }

    .flip-card-front {
      padding: 25px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .flip-card-front h5 {
      font-weight: 700;
      color: var(--primary-dark);
    }

    .info-line {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px dashed #e5e7eb;
      padding: 5px 0;
      font-size: 0.9rem;
    }

    .card-actions {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-top: 12px;
    }

    .btn-modern {
      border: none;
      border-radius: 10px;
      padding: 8px 14px;
      font-weight: 600;
      flex: 1;
      transition: 0.3s;
    }

    .btn-detail { background: #e2e8f0; color: var(--primary-dark); }
    .btn-progress { background: linear-gradient(135deg, #2563eb, #1e3a8a); color: #fff; }
    .btn-send { background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; }
    .btn-modern:hover { transform: translateY(-2px); }
    /* Hilangkan garis bawah pada tombol Detail dan link btn-modern */
    .btn-modern,
    .btn-modern:visited,
    .btn-modern:hover,
    .btn-modern:active {
      text-decoration: none !important;
    }
    /* === BELAKANG === */
    .flip-card-back {
      transform: rotateY(180deg);
      background: linear-gradient(180deg, #1e3a8a, #2563eb);
      color: #fff;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
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
      box-shadow: 0 0 20px rgba(0,0,0,0.15);
      margin-bottom: 18px;
    }

    /* Tambahan warna dinamis */
    .progress-green {
       background: #22c55e;
       box-shadow: 0 0 20px #22c55e;
    }

    .progress-yellow {
       background: #f5cc29ff;
       color: #ffffffff;
       box-shadow: 0 0 20px #facc15;
    }

    .progress-red {
      background: #ef4444;
      box-shadow: 0 0 20px #ef4444;
    }


    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
      width: 80%;
    }

    .stat-box {
      background: rgba(255,255,255,0.2);
      border-radius: 10px;
      padding: 6px 0;
      font-weight: 500;
      font-size: 0.9rem;
    }

    .btn-back {
      border: 2px solid #fff;
      color: #fff;
      background: transparent;
      border-radius: 10px;
      padding: 8px 16px;
      font-weight: 600;
      margin-top: 15px;
      transition: 0.3s;
    }

    .btn-back:hover {
      background: #fff;
      color: #1e3a8a;
      transform: translateY(-2px);
    }
    
    .desc-link {
      color: #2563eb;
      text-decoration: none;
      font-weight: 500;
      word-break: break-all;
    }

    .desc-link:hover {
      text-decoration: underline;
      color: #1e40af;
    }
   /* === BURGER BUTTON === */
    .burger-btn {   
      top: 10px;               
      left: 14px;              
      background: #fff;
      color: #3006c9ff;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      font-size: 1.3rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 10px rgba(37,99,235,0.25);
      transition: 0.3s;
    }

    .burger-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }

    /* === RESPONSIVE SIDEBAR === */
    @media (max-width: 992px) {
      .sidebar {
        position: fixed;
        left: -260px;
        top: 0;
        width: 240px;
        height: 100vh; /* tinggi penuh layar */
        background: var(--sidebar-bg);
        transition: left 0.3s ease;
        z-index: 2000;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* tetap: header di atas, logout di bawah */
        padding: 25px 20px 0 20px; /* buang padding bawah */
        overflow-y: auto;
      }

      .sidebar form {
        margin-top: auto; /* 🔹 dorong tombol logout ke paling bawah */
        padding-bottom: 20px; /* 🔹 kasih jarak kecil dari bawah */
      }

      .sidebar.active {
        left: 0;
      }

      .main {
        margin-left: 0;
        /*padding-top: 80px;*/
      }

      .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.3); /* warna hitam samar */
        backdrop-filter: blur(5px); /* efek blur */
        -webkit-backdrop-filter: blur(5px); /* dukungan Safari */
        z-index: 1500;
        transition: opacity 0.3s ease;
        opacity: 0;
      }

      .sidebar-overlay.active {
        display: block;
        opacity: 1;
      }
    }
    /* === RESPONSIVE UNTUK HP: TOMBOL CARI & RESET TETAP SEBARIS === */
    @media (max-width: 576px) {
      .search-box {
        width: 200px;             
        padding: 5px 10px;
      }

      .search-box input {
        font-size: 0.85rem;
      }

      .btn-search,
      .btn-reset {
        padding: 6px 12px;         
        font-size: 0.8rem;
        border-radius: 6px;
      }

      .page-header form {
        display: flex;
        flex-wrap: nowrap;         
        align-items: center;
        gap: 8px;                  
      }

      .page-header h2 {
        font-size: 1rem;
      }
    }
    /* === POSISI SEARCH KE TENGAH KHUSUS MOBILE === */
    @media (max-width: 768px) {
      .page-header {
        flex-direction: column;          /* ubah jadi vertikal */
        align-items: center;             /* posisi tengah */
        text-align: center;              /* rata tengah untuk teks */
        gap: 10px;                       /* beri sedikit jarak antar elemen */
      }

      .page-header h2 {
        font-size: 1.1rem;
        margin-bottom: 4px;
      }

      .page-header form {
        display: flex;
        flex-direction: row;
        justify-content: center;         /* form di tengah */
        align-items: center;
        gap: 8px;
        width: 100%;
        max-width: 320px;                /* biar tidak terlalu lebar */
      }

      .search-box {
        flex: 1;
        width: 100%;
      }

      .btn-search {
        flex-shrink: 0;
      }
    }
    .project-description {
      max-height: 4.5em; /* kira-kira 3 baris */
      overflow: hidden;
      position: relative;
      display: -webkit-box;
      -webkit-line-clamp: 3;       /* tampil 3 baris dulu */
      -webkit-box-orient: vertical;
      word-break: break-word;      /* potong kata panjang */
      white-space: normal;         /* biar turun ke bawah */
    }
    .project-description.expanded {
      max-height: none;
      -webkit-line-clamp: unset;
    }


  </style>
</head>

<body>
  <div class="sidebar">
    <div>
      <div class="sidebar-header">
        <div class="logo-circle">
          <i class="bi bi-kanban"></i>
        </div>
        <h4>Project PRO</h4>
      </div>
      <ul class="nav flex-column mt-4">
        <li><a href="{{ route('teamlead.dashboard') }}" class="nav-link active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="{{ route('teamlead.myteam') }}" class="nav-link"><i class="bi bi-people-fill"></i> Tim Saya</a></li>
        <li><a href="{{ route('subtasks.solveBlocker') }}" class="nav-link"><i class="bi bi-tools"></i> Solve Blocker</a></li>
        <li class="nav-item mb-2">
          <a href="{{ route('teamlead.notifications') }}" class="nav-link d-flex align-items-center position-relative">
            <i class="bi bi-bell-fill me-2"></i> Notifikasi
            <span id="notifBadge" class="badge bg-danger ms-auto d-none"></span>
          </a>
        </li>
      </ul>
    </div>

    <form action="{{ route('logout') }}" method="POST">@csrf
      <button type="submit" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </form>
  </div>
  <div class="sidebar-overlay"></div>

  <div class="main">
    <div class="top-nav-mobile d-lg-none mb-3">
      <button class="burger-btn" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
      </button>
    </div>
    <div class="page-header">
      <h2><i class="bi bi-kanban"></i> Proyek yang Anda Pimpin</h2>
      <form method="GET" class="d-flex align-items-center gap-2" action="">
        <div class="search-box">
          <i class="bi bi-search text-secondary"></i>
          <input type="text" name="search" placeholder="Cari proyek..." value="{{ request('search') }}">
        </div>

      <!-- Tombol Cari -->
      <button type="submit" class="btn btn-search d-flex align-items-center gap-2">
        <i class="bi bi-search"></i> Cari
      </button>

      <!-- Tombol Reset muncul hanya saat ada pencarian -->
        @if(request('search'))
          <a href="{{ url()->current() }}" class="btn btn-reset d-flex align-items-center gap-2">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </a>
        @endif
      </form>
    </div>

    @php
    $filteredProjects = $projects->filter(function($project) {
      $search = strtolower(request('search', ''));
      return $search === '' || str_contains(strtolower($project->project_name), $search);
    });

    $sortedProjects = $filteredProjects->sortBy(function($project) {
      return $project->status === 'approved' ? 2 : 1;
    })->values();
    @endphp

    <div class="project-grid">
      @foreach($sortedProjects as $project)
        @php
          $totalCards = 0;
          $progressValue = 0;
          $statusWeights = ['todo'=>0, 'in_progress'=>0.5, 'review'=>0.8, 'done'=>1];
          foreach ($project->boards as $board) {
            foreach ($board->cards as $card) {
              $totalCards++;
              $progressValue += $statusWeights[strtolower($card->status)] ?? 0;
            }
          }
          $progress = $totalCards > 0 ? round(($progressValue / $totalCards) * 100, 2) : 0;
          $statusCounts = ['todo'=>0, 'in_progress'=>0, 'review'=>0, 'done'=>0];
          foreach ($project->boards as $board) {
            foreach ($board->cards as $card) {
              $statusCounts[strtolower($card->status)]++;
            }
          }
         $progressClass = $progress >= 99.9 ? 'progress-green' : ($progress >= 50 ? 'progress-yellow' : 'progress-red');

        @endphp

        <div class="flip-card">
          <div class="flip-card-inner">
            <div class="flip-card-front">
              <div>
                <h5>{{ $project->project_name }}</h5>
                <div class="text-muted project-description">
                  {!! nl2br(preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank" class="desc-link">$1</a>',
                    e($project->description ?? 'Tidak ada deskripsi')
                  )) !!}
                </div>

                <div class="info-line"><strong>Deadline:</strong> {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d-m-Y') : '-' }}</div>
                <div class="info-line"><strong>Status:</strong>
                  @if($project->status == 'draft')
                    <span class="badge bg-secondary">Draft</span>
                  @elseif($project->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                  @elseif($project->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                  @elseif($project->status == 'rejected')
                    <span class="badge bg-danger">Rejected</span>
                  @endif
                </div>
                <div class="info-line"><strong>Alasan Reject:</strong> {{ $project->status == 'rejected' ? ($project->rejection_reason ?? '-') : '-' }}</div>
              </div>

              <div class="card-actions">
                <a href="{{ route('teamlead.projects.show', $project->project_id) }}" class="btn-modern btn-detail">
                  <i class="bi bi-eye"></i> Detail
                </a>

                @if(($project->status == 'draft' || $project->status == 'rejected') && $progress == 100)
                  <form action="{{ route('projects.submit',$project->project_id) }}" method="POST" style="flex:1;">@csrf
                    <button type="submit" class="btn-modern btn-send">
                      <i class="bi bi-send"></i> {{ $project->status == 'rejected' ? 'Kirim Ulang' : 'Kirim' }}
                    </button>
                  </form>
                @endif

                <button class="btn-modern btn-progress" onclick="flipCard(this)">
                  <i class="bi bi-bar-chart"></i> Progress
                </button>
              </div>
            </div>

            <div class="flip-card-back">
              <div class="progress-ring {{ $progressClass }}">{{ $progress }}%</div>
              <div class="stats-grid">
                <div class="stat-box"> To Do<br><strong>{{ $statusCounts['todo'] }}</strong></div>
                <div class="stat-box"> In Progress<br><strong>{{ $statusCounts['in_progress'] }}</strong></div>
                <div class="stat-box"> Review<br><strong>{{ $statusCounts['review'] }}</strong></div>
                <div class="stat-box"> Done<br><strong>{{ $statusCounts['done'] }}</strong></div>
              </div>
              <button class="btn btn-back mt-3" onclick="flipCard(this)">
                <i class="bi bi-arrow-left-circle"></i> Kembali
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <script>
  // Fungsi toggle sidebar
  function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
  }

  // Tutup sidebar saat klik di luar sidebar (klik overlay)
  document.addEventListener('click', function (event) {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const burgerBtn = document.querySelector('.burger-btn');

    // Cek kalau sidebar sedang aktif
    if (sidebar.classList.contains('active')) {
      // Jika yang diklik bukan sidebar atau tombol burger → tutup sidebar
      if (
        !sidebar.contains(event.target) &&
        !burgerBtn.contains(event.target)
      ) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
      }
    }
  });

  // Tutup sidebar otomatis saat ukuran layar kembali besar
  window.addEventListener('resize', function () {
    if (window.innerWidth > 992) {
      document.querySelector('.sidebar').classList.remove('active');
      document.querySelector('.sidebar-overlay').classList.remove('active');
    }
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Jalankan fetch setiap kali halaman dimuat (misalnya dashboard)
  fetch("{{ route('teamlead.notifications.count') }}")
    .then(res => res.json())
    .then(data => {
      const badge = document.getElementById("notifBadge");
      if (badge) {
        if (data.count > 0) {
          badge.textContent = data.count;
          badge.classList.remove("d-none");
        } else {
          badge.classList.add("d-none");
        }
      }
    })
    .catch(err => console.error("Gagal memuat notifikasi:", err));
});
</script>

  <script>
    function flipCard(btn) {
      const card = btn.closest('.flip-card');
      card.classList.toggle('flipped');
    }
  </script>
  <script>
  // Jika user sedang di halaman dashboard lalu menekan tombol Back,
  // langsung arahkan ke halaman login
  window.addEventListener('popstate', function() {
      window.location.href = "{{ route('login') }}";
  });

  // Cegah halaman dashboard ditampilkan dari cache setelah logout
  window.history.pushState(null, "", window.location.href);
  window.onpopstate = function() {
      window.location.href = "{{ route('login') }}";
  };
</script>
</body>
</html>
