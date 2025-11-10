<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Manajemen Proyek</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --sidebar-bg: #1e293b;
      --accent: #2563eb;
      --card-bg: #ffffff;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --shadow-light: 0 6px 18px rgba(0, 0, 0, 0.08);
      --shadow-hover: 0 12px 30px rgba(37, 99, 235, 0.15);
    }

    /* ========== GLOBAL ========== */
    body {
      font-family: "Inter", sans-serif;
      background: #f3f6fb;
      margin: 0;
      overflow-x: hidden;
    }

    /* ========== SIDEBAR ========== */
    .sidebar {
      width: 230px;
      background: var(--sidebar-bg);
      color: #fff;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 1.5rem 1rem;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #475569 transparent;
      box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
    }

    .sidebar-logo i {
      font-size: 2rem;
      color: var(--accent);
      background: #fff;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.15);
    }

    .sidebar h4 {
      text-align: center;
      font-weight: 600;
      color: #fff;
      margin-bottom: 1.5rem;
    }

    .nav-link {
      color: #cbd5e1;
      font-weight: 500;
      padding: 10px 16px;
      border-radius: 8px;
      margin-bottom: 5px;
      transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      background: rgba(255, 255, 255, 0.12);
      color: #fff;
    }

    /* ========== MAIN CONTENT ========== */
    .flex-grow-1 {
      margin-left: 230px;
      transition: margin-left 0.3s ease;
    }

    /* ========== NAVBAR ========== */
    .navbar {
      background: #fff;
      box-shadow: var(--shadow-light);
      z-index: 900;
    }

    /* ========== INPUT PENCARIAN ========== */
    .input-group {
      display: flex;
      align-items: center;
      background: #fff;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      overflow: hidden;
      max-width: 350px;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #6b7280;
      padding: 8px 10px;
    }

    .input-group .form-control {
      border: none;
      box-shadow: none;
      background: transparent;
      padding: 8px 10px;
      font-size: 0.95rem;
      color: #1e293b;
    }

    /* ========== FORM FILTER & LAPORAN ========== */
    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .search-form {
      flex-grow: 1;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      min-width: 280px;
    }

    .filter-form {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-wrap: nowrap;
    }

    /* Input tanggal */
    .filter-form input[type="date"].form-control-sm {
      appearance: none;
      -webkit-appearance: none;
      background-color: #fff;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      padding: 8px 12px;
      width: 160px;
      font-size: 0.9rem;
      color: #1e293b;
      transition: all 0.2s ease-in-out;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .filter-form input[type="date"].form-control-sm:hover {
      border-color: #2563eb;
      box-shadow: 0 3px 8px rgba(37, 99, 235, 0.1);
    }

    .filter-form input[type="date"].form-control-sm:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
      outline: none;
    }

    .filter-form input[type="date"].form-control-sm::-webkit-calendar-picker-indicator {
      filter: invert(35%) sepia(88%) saturate(6241%) hue-rotate(214deg)
        brightness(96%) contrast(101%);
      cursor: pointer;
      transition: 0.2s;
    }

    /* Tombol kecil */
    .btn.btn-primary.btn-sm {
      background-color: #2563eb;
      border: none;
      border-radius: 6px;
      padding: 8px 14px;
      font-size: 0.875rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease-in-out;
    }

    .btn.btn-primary.btn-sm:hover {
      background-color: #1d4ed8;
      transform: translateY(-1px);
    }

    .btn.btn-danger.btn-sm {
      background-color: #dc2626;
      border: none;
      border-radius: 6px;
      padding: 8px 14px;
      font-size: 0.875rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease-in-out;
    }

    .btn.btn-danger.btn-sm:hover {
      background-color: #b91c1c;
      transform: translateY(-1px);
    }

    /* Tombol hijau buat proyek */
    .btn-create-project {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background-color: #15803d;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      padding: 10px 18px;
      font-size: 0.9rem;
      gap: 8px;
      transition: all 0.25s ease-in-out;
    }

    .btn-create-project:hover {
      background-color: #166534;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    }

    /* ========== PROJECT CARD ========== */
    .project-card {
      background: var(--card-bg);
      border-radius: 18px;
      box-shadow: var(--shadow-light);
      padding: 1.6rem;
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
      height: 100%;
    }

    .project-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-hover);
    }

    .project-card::before {
      content: "";
      position: absolute;
      top: -40px;
      right: -40px;
      width: 100px;
      height: 100px;
      background: var(--accent);
      opacity: 0.07;
      border-radius: 50%;
      filter: blur(30px);
    }

    .project-title {
      font-weight: 600;
      font-size: 1.2rem;
      color: var(--text-dark);
      margin-bottom: 0.6rem;
    }

    .project-meta {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 0.25rem;
    }

    .project-desc {
    color: var(--text-muted);
    font-size: 0.92rem;
    line-height: 1.5;
    margin: 0.6rem 0 1.2rem;
    max-width: 40ch;      /* maksimal 40 karakter per baris */
    white-space: normal;   /* teks bisa wrap ke bawah */
    word-wrap: break-word; /* kata panjang dipotong ke baris baru */
    overflow-wrap: break-word;
}

    /* Footer tombol card */
    .card-footer {
      border-top: 1px solid #f1f5f9;
      padding-top: 0.9rem;
    }

    .card-footer .btn-outline-danger {
      border: 1px solid #dc2626;
      color: #dc2626;
      font-weight: 500;
      padding: 4px 8px;
      font-size: 0.8rem;
      border-radius: 6px;
      transition: 0.2s ease;
    }

    .card-footer .btn-outline-danger:hover {
      background: #dc2626;
      color: #fff;
      transform: translateY(-2px);
    }

    .card-footer .btn-modern {
      padding: 5px 9px;
      font-size: 0.8rem;
    }
    
    /* Samakan ukuran tombol hapus dengan tombol edit & detail */
    .card-footer .btn.btn-danger.btn-modern {
      padding: 5px 9px !important;
      font-size: 0.8rem !important;
    }

    /* Tambah gaya seragam untuk tombol info dan edit */
    .card-footer .btn.btn-info.btn-modern,
    .card-footer .btn.btn-warning.btn-modern {
      padding: 5px 9px;
      font-size: 0.8rem;
    }

    /* Perbesar tombol reset (btn-secondary) di filter */
    .btn.btn-secondary.btn-sm {
      background-color: #475569;
      border: none;
      border-radius: 8px;
      padding: 10px 18px; /* diperbesar */
      font-size: 0.9rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: all 0.2s ease-in-out;
    }

    .btn.btn-secondary.btn-sm:hover {
      background-color: #334155;
      transform: translateY(-1px);
    }

    /* ========== LOGOUT BUTTON ========== */
    .btn-logout {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 8px 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #b91c1c, #7f1d1d);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(185, 28, 28, 0.4);
    }

    /* ========== RESPONSIVE ========== */

    /* Tablet */
    @media (max-width: 992px) {
      .flex-grow-1 {
        margin-left: 0;
      }

      .burger-btn {
        display: block;
        background: none;
        border: none;
        font-size: 1.8rem;
        color: var(--accent);
        cursor: pointer;
        z-index: 1100;
      }

      /* Sidebar default tersembunyi dengan animasi geser */
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 230px;
        height: 100vh;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1050;
        display: flex; /* 🔹 penting: tampilkan flex agar JS bisa munculkan */
      }

      /* Saat tombol burger diklik */
      .sidebar.show {
        transform: translateX(0);
      }

      /* Hilangkan margin kiri utama agar konten tidak geser */
      .flex-grow-1 {
        margin-left: 0 !important;
      }

      /* Overlay hitam lembut */
      .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
      }

      .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
      }


      .navbar {
        border-bottom: 1px solid #e5e7eb;
      }

      /* Filter bar responsif */
      .filter-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
      }

      .search-form {
        width: 100%;
        justify-content: space-between;
      }

      .filter-form {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
      }

      .filter-form form {
        flex-direction: column;
        width: 100%;
        gap: 0.6rem;
      }

      .filter-form input[type="date"].form-control-sm {
        width: 100%;
      }

      .filter-form button,
      .filter-form .btn-danger {
        width: 100%;
      }

      .btn-create-project {
        width: 100%;
        justify-content: center;
      }
    }

    /* Mobile */
    @media (max-width: 768px) {
      .project-card {
        padding: 1.2rem;
      }

      .btn-logout {
        width: 100%;
        font-size: 0.85rem;
        padding: 10px;
      }

      .card-footer .btn-outline-danger {
        padding: 3px 6px;
        font-size: 0.75rem;
      }

      .card-footer .btn-modern {
        padding: 4px 8px;
        font-size: 0.75rem;
      }
    }

    /* Extra small */
    @media (max-width: 576px) {
      .project-title {
        font-size: 1rem;
      }

      .project-desc {
        font-size: 0.85rem;
      }
    }
    /* Tombol burger */
    .burger-btn {
      display: none; /* 🔹 Sembunyikan default */
      background: none;
      border: none;
      font-size: 1.7rem;
      color: var(--accent);
      cursor: pointer;
      transition: 0.2s;
    }

    /* Tampilkan hanya di layar kecil */
    @media (max-width: 992px) {
      .burger-btn {
        display: block; /* 🔹 Muncul hanya di HP/Tablet */
      }

      .sidebar {
        transform: translateX(-100%); /* 🔹 Tersembunyi awalnya */
        transition: transform 0.3s ease;
      }

      .sidebar.show {
        transform: translateX(0); /* 🔹 Muncul saat diklik */
      }

      .flex-grow-1 {
        margin-left: 0 !important;
      }
    }
    /* Overlay blur hitam */
    #sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4); /* warna hitam transparan */
      backdrop-filter: blur(5px); /* efek blur */
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      z-index: 998;
    }

    /* Saat sidebar aktif, overlay muncul */
    #sidebar-overlay.show {
      opacity: 1;
      visibility: visible;
    }

    /* Sidebar harus di atas overlay */
    .sidebar {
      z-index: 999;
    }

    
  </style>
</head>
<body>
<div class="d-flex">

  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <div class="sidebar-logo">
        <i class="bi bi-kanban"></i>
      </div>
      <h4>Project PRO</h4>
      <ul class="nav flex-column">
        <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('projects.create') }}" class="nav-link"><i class="bi bi-folder-plus"></i> Projects</a></li>
        <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link"><i class="bi bi-people"></i> Manajemen User</a></li>
        <li class="nav-item"><a href="{{ route('users.active') }}" class="nav-link"><i class="bi bi-person-lines-fill"></i> Daftar User</a></li>
        <li class="nav-item"><a href="{{ route('monitoring.index') }}" class="nav-link"><i class="bi bi-graph-up"></i> Monitoring</a></li>
        <li class="nav-item mb-2">
          <a href="{{ route('admin.notifications') }}" class="nav-link d-flex align-items-center">
            <i class="bi bi-bell-fill me-2"></i> Notifikasi
            <span id="adminNotifBadge" class="badge bg-danger ms-auto d-none"></span>
          </a>
        </li>

      </ul>
    </div>

    <!-- Tombol Logout di bawah -->
    <form action="{{ route('logout') }}" method="POST" class="mt-3 logout-form">
      @csrf
      <button type="submit" class="btn btn-logout w-100">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </button>
    </form>

  </div>
  <div id="sidebar-overlay"></div>
  <!-- Main Content -->
  <div class="flex-grow-1">
    <nav class="navbar navbar-light px-4">
      <button class="burger-btn" id="burger-toggle">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand mb-0 h4 text-primary"><i class="bi bi-kanban"></i> Dashboard Admin</span>
    </nav>

    <div class="p-4">
      <!-- Baris atas: Judul & tombol Buat Proyek Baru -->
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 search-filter-container">
        <h3 class="fw-bold mb-3 mb-md-0">Daftar Proyek</h3>

        <!-- Tombol Buat Proyek Baru -->
        <a href="{{ route('projects.create') }}" class="btn btn-success btn-create-project">
          <i class="bi bi-plus-circle"></i> Buat Proyek Baru
        </a>
      </div>

      <!-- 🔹 Baris Pencarian + Filter + Laporan -->
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 filter-bar">

      <!-- 🔍 Kiri: Pencarian -->
      <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 search-form">
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Cari proyek..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Cari</button>
      </form>

      <!-- 📅 Kanan: Filter & Laporan -->
      <div class="d-flex align-items-center gap-2 filter-form">
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 flex-wrap">
          <label for="start_date" class="form-label mb-0 fw-semibold">Dari:</label>
          <input type="date" name="start_date" id="start_date" class="form-control form-control-sm"
              value="{{ request('start_date') }}">

          <label for="end_date" class="form-label mb-0 fw-semibold">Sampai:</label>
          <input type="date" name="end_date" id="end_date" class="form-control form-control-sm"
              value="{{ request('end_date') }}">

          <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-funnel"></i> Filter
          </button>

          @if(request('start_date') || request('end_date'))
          <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-counterclockwise"></i>
          </a>
           @endif
        </form>

    <form action="{{ route('reports.generate') }}" method="POST">
      @csrf
      <input type="hidden" name="start_date" value="{{ request('start_date') }}">
      <input type="hidden" name="end_date" value="{{ request('end_date') }}">
      <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-filetype-pdf"></i> Laporan
      </button>
    </form>
  </div>
</div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <!-- Card Grid -->
      <div class="row g-4">
        @foreach($projects as $project)
        <div class="col-md-6 col-lg-4">
          <div class="project-card">
            <!-- Header -->
            <div class="card-header">
              <div>
                <h5 class="project-title">{{ $project->project_name }}</h5>
                <p class="project-meta mb-0">
                  <i class="bi bi-calendar-event"></i>
                   Deadline: {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
                </p>
                <p class="project-meta">
                  <i class="bi bi-clock"></i>
                  Dibuat: {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y ') }}
                </p>
              </div>
              <div>
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
            </div>

            <!-- Deskripsi -->
           <p class="project-desc">
              {!! nl2br(preg_replace(
                '/(https?:\/\/[^\s]+)/',
                '<a href="$1" target="_blank" class="desc-link">$1</a>',
                e($project->description ?? 'Belum ada deskripsi untuk proyek ini.')
              )) !!}
           </p>

            <!-- Info -->
            <div class="project-info">
              <div>
                <i class="bi bi-clock-history"></i> 
                <span class="badge bg-{{ $project->deadline_badge_class }}">{{ $project->deadline_status }}</span>
              </div>
            </div>

            <!-- Tombol -->
            <div class="card-footer d-flex justify-content-between align-items-center">
                <!-- 🔹 Tombol Laporan di Kiri -->
              <div>
                <a href="{{ route('projects.report', $project->project_id) }}" 
                    class="btn btn-outline-danger btn-xs btn-modern" 
                    title="Generate Laporan PDF">
                    <i class="bi bi-filetype-pdf"></i>
                </a>
              </div>
              <div class="card-actions">
                <a href="{{ route('projects.show',$project->project_id) }}" class="btn btn-info btn-sm btn-modern" title="Detail">
                  <i class="bi bi-person-plus"></i>
                </a>

                @if($project->status !== 'approved')
                  <a href="{{ route('projects.edit',$project->project_id) }}" class="btn btn-warning btn-sm btn-modern" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <form action="{{ route('projects.destroy',$project->project_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-modern" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                @endif

                @if($project->status == 'pending')
                  <form action="{{ route('projects.approve',$project->project_id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm btn-modern" title="Approve">
                      <i class="bi bi-check-circle"></i>
                    </button>
                  </form>
                  <button type="button" class="btn btn-danger btn-sm btn-modern" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $project->project_id }}" title="Reject">
                    <i class="bi bi-x-circle"></i>
                  </button>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Reject -->
        <div class="modal fade" id="rejectModal{{ $project->project_id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $project->project_id }}" aria-hidden="true">
          <div class="modal-dialog">
            <form action="{{ route('projects.reject',$project->project_id) }}" method="POST">
              @csrf
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="rejectModalLabel{{ $project->project_id }}">Alasan Penolakan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <textarea name="reason" class="form-control" rows="4" placeholder="Tuliskan alasan..." required></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Kirim</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<script>
  const burger = document.getElementById("burger-toggle");
  const sidebar = document.querySelector(".sidebar");
  const overlay = document.getElementById("sidebar-overlay");

  // Klik tombol burger untuk buka/tutup sidebar
  burger.addEventListener("click", (event) => {
    event.stopPropagation(); // biar klik burger gak dianggap klik luar sidebar
    sidebar.classList.toggle("show");
    if (overlay) overlay.classList.toggle("show");
  });

  // Klik overlay untuk menutup
  if (overlay) {
    overlay.addEventListener("click", () => {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  }

  // Klik di luar sidebar menutup sidebar
  document.addEventListener("click", (event) => {
    if (
      sidebar.classList.contains("show") && // sidebar sedang terbuka
      !sidebar.contains(event.target) && // yang diklik bukan di dalam sidebar
      event.target !== burger // dan bukan tombol burger
    ) {
      sidebar.classList.remove("show");
      if (overlay) overlay.classList.remove("show");
    }
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const badge = document.getElementById("adminNotifBadge");

  function updateAdminNotif() {
    fetch("{{ route('admin.notifications.count') }}")
      .then(res => res.json())
      .then(data => {
        if (!badge) return;
        if (data.count > 0) {
          badge.textContent = data.count;
          badge.classList.remove("d-none");
        } else {
          badge.classList.add("d-none");
        }
      })
      .catch(err => console.error("Gagal memuat notifikasi admin:", err));
  }

  // Jalankan langsung saat dashboard dibuka
  updateAdminNotif();

  // (Opsional) Auto-refresh setiap 30 detik
  setInterval(updateAdminNotif, 30000);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
