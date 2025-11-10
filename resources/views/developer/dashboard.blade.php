@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Dashboard Developer - Project PRO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --dark-bg: #1e293b;
      --dark-active: #334155;
      --success-gradient: linear-gradient(135deg, #059669, #10b981);
      --success-gradient-hover: linear-gradient(135deg, #047857, #059669);
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    body {
      margin: 0;
      font-family: "Inter", "Poppins", sans-serif;
      background: #f9fafb;
      display: flex;
      min-height: 100vh;
      color: #1e293b;
    }

    /* === SIDEBAR === */
    .sidebar {
      width: 230px;
      background: var(--dark-bg);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 28px 20px;
      position: fixed;
      height: 100vh;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
    }

    .sidebar-header {
      text-align: center;
    }

    .logo-circle {
      width: 60px;
      height: 60px;
      background: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 12px;
      box-shadow: 0 0 20px rgba(37, 99, 235, 0.25);
    }

    .logo-circle i {
      font-size: 1.9rem;
      color: var(--primary);
    }

    .sidebar h4 {
      font-weight: 700;
      margin-bottom: 25px;
    }

    .nav-link {
      color: #cbd5e1;
      font-weight: 500;
      border-radius: 8px;
      padding: 10px 12px;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: 0.3s;
    }

    .nav-link:hover, .nav-link.active {
      background: var(--dark-active);
      color: #fff;
      transform: translateX(3px);
    }

    .logout-btn {
      background: #ef4444;
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 10px;
      padding: 10px;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background: #dc2626;
      transform: translateY(-2px);
    }

    /* === CONTENT === */
    .content {
      flex: 1;
      margin-left: 230px;
      padding: 40px;
      background: #f8fafc;
      min-height: 100vh;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 30px;
      gap: 12px;
    }

    .page-header h2 {
      font-weight: 700;
      color: var(--primary);
    }

    /* === SEARCH === */
    .search-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #fff;
      box-shadow: var(--shadow);
      padding: 10px 12px 10px 36px;
      width: 240px;
      font-size: 0.95rem;
    }

    .search-box i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
    }

    .btn-search {
      background: var(--primary);
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 10px 16px;
      transition: 0.3s;
    }

    .btn-search:hover {
      background: var(--primary-dark);
    }

    .btn-reset {
      background: #6b7280;
      border: none;
      color: #fff;
      font-weight: 600;
      padding: 10px 16px;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-reset:hover {
      background: #4b5563;
    }

    /* === CARD === */
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: var(--shadow);
      transition: 0.3s;
    }

    .card:hover { transform: translateY(-3px); }

    .card-header {
      background: var(--primary);
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      padding: 16px 20px;
    }

    .card-header .badge {
      background: rgba(255,255,255,0.3);
    }

    /* === BUTTONS === */
    /* Tombol Laporkan Blocker */
    .btn-outline-danger-modern {
      background: #ef4444;
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      width: 70%;
      padding: 5px 0;
      transition: 0.3s ease;
      box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
    }
    .btn-outline-danger-modern:hover {
      background: #f53117ff;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 5px 14px rgba(249, 115, 22, 0.4);
    }

    /* Tombol Selesai */
    .btn-success.btn-action {
      width: 80%;
      font-weight: 600;
      border-radius: 8px;
      padding: 10px 0;
      transition: 0.3s;
      background: linear-gradient(135deg, #059669, #10b981);
      border: none;
    }
    .btn-success.btn-action:hover {
      background: linear-gradient(135deg, #047857, #059669);
      transform: translateY(-2px);
    }

    .btn-success {
      background: var(--success-gradient);
      border: none;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 6px 14px;
      border-radius: 6px;
      transition: 0.3s;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-success:hover {
      background: var(--success-gradient-hover);
      transform: translateY(-1px);
    }

    .btn-warning, .btn-danger {
      font-weight: 600;
      border: none;
      font-size: 0.85rem;
      padding: 6px 10px;
    }

    .btn-warning { color: #000; }

    .edit-delete {
      display: flex;
      justify-content: center;
      gap: 6px;
      margin-top: 4px;
    }

    /* === KOMENTAR === */
    .btn-comment {
      background: var(--success-gradient);
      border: none;
      color: #fff;
      font-weight: 600;
      font-size: 0.8rem;
      padding: 6px 14px;
      transition: 0.3s;
      line-height: 1.2;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
      border-radius: 6px;
      gap: 5px;
    }

    .btn-comment:hover {
      background: var(--success-gradient-hover);
      transform: translateY(-1px);
      color: white;
    }

    /* === TABLE === */
   /* TABLE FIX WIDTH */
   .table {
      table-layout: fixed;
      width: 100%;
    }

    .table th, .table td {
      word-wrap: break-word;
      white-space: normal;
      text-align: center;
      vertical-align: middle;
    }
  

  /* Atur lebar tiap kolom */
  .table th:nth-child(1), .table td:nth-child(1) { width: 15%; }  /* Subtask */
  .table th:nth-child(2), .table td:nth-child(2) { width: 28%; }  /* Deskripsi (paling lebar) */
  .table th:nth-child(3), .table td:nth-child(3) { width: 9%; }  /* Estimasi */
  .table th:nth-child(4), .table td:nth-child(4) { width: 8%; }  /* Aktual */
  .table th:nth-child(5), .table td:nth-child(5) { width: 10%; }  /* Status */
  .table th:nth-child(6), .table td:nth-child(6) { width: 17%; }  /* Aksi (lebar kedua) */
  .table th:nth-child(7), .table td:nth-child(7) { width: 15%; }   /* Komentar */

    tbody tr:hover {
      background: #f1f5f9;
      transition: 0.2s;
    }

    .table td {
      vertical-align: middle;
    }
    
    .btn-primary {
      background: var(--primary);
      border: none;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 10px 0;
      border-radius: 8px;
      transition: 0.3s;
      width: 80%; 
    }

    .btn-primary:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
    }
    .btn-mulai {
      width: 88%;              
      display: block;
      margin: 0 auto;           
      border-radius: 8px;
    }

    .desc-link {
      color: #2563eb; /* warna biru elegan sesuai tema */
      text-decoration: none;
      font-weight: 500;
      word-break: break-all; /* supaya link panjang tetap rapi */
    }

    .desc-link:hover {
      color: #1e40af;
      text-decoration: underline;
    }
    /* ALERT MODERN (Blocker & Solusi) */
    .alert-modern {
      border-radius: 10px;
      border: none;
      padding: 14px 16px;
      font-size: 0.9rem;
      box-shadow: var(--shadow);
      display: flex;
      align-items: flex-start;
      gap: 10px;
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(5px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .alert-modern i {
      font-size: 1.3rem;
      margin-top: 2px;
    }

    .alert-danger-modern {
      background: #fee2e2; /* merah lembut */
      color: #991b1b;
    }

    .alert-success-modern {
      background: #dcfce7; /* hijau lembut */
      color: #166534;
    }
    /* === RESPONSIVE === */
    /* === FIX SIDEBAR RESPONSIVE === */
    @media (max-width: 992px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: -230px;
        height: 100vh;
        width: 230px;
        z-index: 1051; /* naikkan agar di atas overlay */
        transition: left 0.3s ease;
      }

      .sidebar.show {
        left: 0; /* muncul penuh */
      }

      #sidebarOverlay {
        z-index: 1050; /* di bawah sidebar */
      }

      .content {
        margin-left: 0;
        padding: 80px 20px 40px;
      }
    }
    
    @media (max-width: 768px) {
      .table-wrapper {
        width: 87vw;
        overflow-x: auto;
      }
      .table { 
        width: 100%;
        min-width: 992px;
        display: block; 
        -webkit-overflow-scrolling: touch; 
        scrollbar-width: thin; 
        white-space: nowrap; 
      }
      .table th, .table td { font-size: 0.8rem; padding: 6px; }
      .page-header { flex-direction: column; align-items: flex-start; }
      .search-box input { width: 180px; }
    }

    @media (max-width: 576px) {
      .sidebar { width: 200px; }
      .logo-circle { width: 50px; height: 50px; }
      .logo-circle i { font-size: 1.4rem; }
      .page-header h2 { font-size: 1.1rem; }
      .content { padding: 70px 10px 30px; }
      .btn-comment { font-size: 0.7rem; padding: 5px 10px; }
      .alert-modern { font-size: 0.8rem; }
    }
    /* 🌐 Hanya untuk layar kecil (≤ 992px) */
    @media (max-width: 992px) {
      body, html {
        margin: 0;
        padding: 0;
      }

      .content {
        padding-top: 0 !important;
        margin-top: 0 !important;
      }

      .top-nav-mobile {
        margin: 0 !important;
        padding: 0 !important;
        position: relative;
        top: 0;
        left: 0;
      }

      .top-nav-mobile .btn {
        background: transparent;
        border: none;
        box-shadow: none;
        color: #1e293b;
        padding: 4px 6px;
      }

      .top-nav-mobile .btn:hover {
        color: #2563eb;
        transform: scale(1.1);
      }
    }

    /* Extra kecil (≤ 576px) biar lebih rapat lagi */
    @media (max-width: 576px) {
      .top-nav-mobile .btn {
        padding: 3px 5px;
      }

      .top-nav-mobile .btn i {
        font-size: 1.4rem;
     }
    }

  </style>
</head>

<body>
 
  <!-- OVERLAY -->
  <div id="sidebarOverlay" class="d-lg-none" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);backdrop-filter:blur(1px);display:none;z-index:1030;"></div>
  <!-- SIDEBAR -->
  <div class="sidebar">
    <div>
      <div class="sidebar-header">
        <div class="logo-circle">
          <i class="bi bi-kanban"></i>
        </div>
        <h4>Project PRO</h4>
      </div>
      <a href="{{ route('developer.dashboard') }}" class="nav-link active">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('developer.myteam') }}" class="nav-link">
        <i class="bi bi-people-fill"></i> Tim Saya
      </a>
      <a href="{{ route('dev.notifications') }}" class="nav-link d-flex align-items-center">
        <i class="bi bi-bell-fill"></i>
        <span class="ms-2">Notifikasi</span>
        <span id="devNotifBadge" class="badge bg-danger ms-auto d-none"></span>
      </a>
    </div>
    <form action="{{ route('logout') }}" method="POST">@csrf
      <button type="submit" class="logout-btn w-100">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>

  <!-- MAIN CONTENT -->
  <div class="content">
    <div class="page-header">
      <div class="top-nav-mobile d-lg-none mb-2">
        <button id="toggleSidebar" class="btn btn-light">
          <i class="bi bi-list" style="font-size:1.5rem;"></i>
        </button>
      </div>
      <h2><i class="bi bi-terminal"></i> Tugas Anda</h2>

      <!-- SEARCH -->
      <div class="search-container">
        <form method="GET" id="search-form" action="{{ route('developer.dashboard') }}" class="search-box">
          <i class="bi bi-search"></i>
          <input type="text" name="search" placeholder="Cari proyek..." value="{{ request('search') }}">
        </form>
        <button type="submit" form="search-form" class="btn btn-search d-flex align-items-center gap-2">
          <i class="bi bi-search"></i> Cari
        </button>
        @if(request('search'))
          <a href="{{ url()->current() }}" class="btn btn-reset d-flex align-items-center gap-2">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </a>
        @endif
      </div>
    </div>

    <!-- FILTER -->
    @php
      $filteredCards = $cards->filter(function($card) {
        $search = strtolower(request('search', ''));
        return $search === '' || str_contains(strtolower($card->board->project->project_name), $search);
      });
    @endphp

    @if($filteredCards->isEmpty())
      <div class="alert alert-info shadow-sm">Belum ada tugas untuk Anda.</div>
    @else
      @foreach($filteredCards as $card)
        <div class="card mb-4">
          <div class="card-header">
            <div>
              <strong>{{ $card->card_title }}</strong>
              <span class="badge text-light">{{ $card->board->board_name }}</span>
            </div>
            <span class="badge bg-light text-dark">{{ ucfirst($card->board->project->status) }}</span>
          </div>

          <div class="card-body">
            @if($card->subtasks->whereNotNull('reject_reason')->count() > 0)
              <div class="alert alert-danger">
                ⚠️ Ada revisi dari Team Lead:
                <ul>
                  @foreach($card->subtasks->whereNotNull('reject_reason') as $r)
                    <li><strong>{{ $r->subtask_title }}</strong> → {{ $r->reject_reason }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <p><strong>Proyek:</strong> {{ $card->board->project->project_name }}</p>
            <p><strong>Deskripsi Card:</strong><br>
                {!! nl2br(preg_replace(
                  '/(https?:\/\/[^\s]+)/',
                  '<a href="$1" target="_blank" class="desc-link">$1</a>',
                  e($card->description ?? '-')
                )) !!}
            </p>

            <p><strong>Status Proyek:</strong>
              @if($card->board->project->status == 'approved') ✅ Approved
              @elseif($card->board->project->status == 'pending') ⏳ Pending
              @elseif($card->board->project->status == 'rejected') ❌ Rejected
              @else 📝 Draft
              @endif
            </p>
            <p><strong>Prioritas:</strong> {{ ucfirst($card->priority) }}</p>
            <p><strong>Status Card:</strong> {{ ucfirst($card->status) }}</p>
            <p><strong>Estimasi:</strong> {{ $card->estimated_hours ?? '-' }} jam</p>
            <p><strong>Deadline:</strong>
              @if($card->due_date)
                {{ \Carbon\Carbon::parse($card->due_date)->format('d-m-Y') }}
              @else
                <span class="text-muted">-</span>
              @endif
            </p>

            @if($card->board->project->status != 'approved')
              <a href="{{ route('subtasks.create', $card->card_id) }}" class="btn btn-success mb-3">
                ➕ Tambah Subtask
              </a>
            @endif
            @php
              // Ambil semua subtask yang belum selesai
              $notDoneSubtasks = $card->subtasks->where('status', '!=', 'done');

              // Subtask yang sudah diklik bantuan
              $blockedSubs = $notDoneSubtasks->where('is_blocked', true);

              // Subtask yang punya solusi asli (bukan pesan otomatis)
              $solvedSubs = $notDoneSubtasks->filter(function($s) {
                return $s->block_reason && !Str::contains($s->block_reason, 'menunggu solusi Team Lead');
              });
            @endphp

            {{-- 🚨 Masih menunggu bantuan Team Lead --}}
            @if($blockedSubs->count() > 0 && $solvedSubs->count() == 0)
             <div class="alert alert-danger d-flex align-items-start mb-3 shadow-sm" role="alert" style="border-radius: 10px;">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
              <div>
               <strong>Ada Subtask Terhambat!</strong><br>
                Subtask sedang terhambat menunggu bantuan dari Team Lead.
              </div>
            </div>

            {{-- 💡 Sudah ada solusi dari Team Lead --}}
            @elseif($solvedSubs->count() > 0)
              <div class="alert alert-success d-flex align-items-start mb-3 shadow-sm" role="alert" style="border-radius: 10px;">
                <i class="bi bi-lightbulb-fill fs-4 me-2"></i>
                  <div>
                    <strong>Solusi dari Team Lead:</strong><br>
                    @foreach($solvedSubs as $s)
                      - {{ Str::after($s->block_reason, ':') }} <br>
                    @endforeach
                  </div>
              </div>
            @endif

            <div class="table-wrapper">
              <table class="table table-bordered align-middle text-center">
                <thead>
                  <tr>
                    <th>Subtask</th>
                    <th>Deskripsi</th>
                    <th>Estimasi (Jam)</th>
                    <th>Aktual (Jam)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>Komentar</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($card->subtasks->sortBy('position') as $subtask)
                    <tr>
                      <td>
                        {{ $subtask->subtask_title }}
                        @if($subtask->reject_reason)
                          <br><small class="text-danger">❌ {{ $subtask->reject_reason }}</small>
                        @endif
                      </td>
                      <td>
                          {!! nl2br(preg_replace(
                            '/(https?:\/\/[^\s]+)/',
                            '<a href="$1" target="_blank" class="desc-link">$1</a>',
                            e($subtask->description ?? '-')
                          )) !!}
                      </td>

                      <td>{{ $subtask->estimated_hours ?? '-' }}</td>
                      <td>{{ $subtask->actual_hours ?? '-' }}</td>
                      <td>
                        @if($subtask->status == 'todo')
                          <span class="badge bg-secondary">To Do</span>
                        @elseif($subtask->status == 'in_progress')
                          <span class="badge bg-primary">In Progress</span>
                        @elseif($subtask->status == 'review')
                          <span class="badge bg-warning text-dark">Review</span>
                        @elseif($subtask->status == 'done')
                          <span class="badge bg-success">Done</span>
                        @endif
                      </td>
                      <td>
                        @if($subtask->status == 'todo')
                          <form action="{{ route('subtasks.start', $subtask->subtask_id) }}" method="POST" class="mb-2">@csrf
                            <button type="submit" class="btn btn-primary fw-semibold  py-2 btn-mulai">🚀 Mulai</button>
                          </form>
                          <div class="edit-delete">
                            <a href="{{ route('subtasks.edit', $subtask->subtask_id) }}" class="btn btn-warning">✏️ Edit</a>
                            <form action="{{ route('subtasks.destroy', $subtask->subtask_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tahap ini?')">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-danger">🗑️ Hapus</button>
                            </form>
                          </div>
                        @elseif($subtask->status == 'in_progress')
                          <form action="{{ route('subtasks.complete', $subtask->subtask_id) }}" method="POST">@csrf
                            <button type="submit" class="btn btn-success fw-semibold px-3">✅ Selesai</button>
                          </form>
                           @if(!$subtask->is_blocked)
                          <form action="/subtasks/{{ $subtask->subtask_id }}/block" method="POST" class="mt-2">
                              @csrf
                              <button type="submit" class="btn-outline-danger-modern btn-action">🚫 Bantuan</button>
                          </form>
                        @endif
                        @elseif($subtask->status == 'review')
                          <span class="badge bg-info text-dark">Menunggu Review</span>
                        @else
                          <span class="text-muted">✔ Selesai</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('comments.subtask.index', $subtask->subtask_id) }}" class="btn btn-comment">
                          <i class="bi bi-chat-dots-fill"></i> Komentar
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="7" class="text-muted text-center">Belum ada subtask</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    // Klik tombol ☰
    toggleSidebar.addEventListener('click', function () {
      sidebar.classList.toggle('show');
      overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    });

    // Klik area luar sidebar
    overlay.addEventListener('click', function () {
      sidebar.classList.remove('show');
      overlay.style.display = 'none';
    });
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const badge = document.getElementById("devNotifBadge");

  function updateDevNotif() {
    fetch("{{ route('dev.notifications.count') }}")
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
      .catch(err => console.error("Gagal memuat notifikasi developer:", err));
  }

  // 🔹 Jalankan saat dashboard pertama kali dibuka
  updateDevNotif();

  // 🔁 (Opsional) Auto-refresh tiap 30 detik
  setInterval(updateDevNotif, 30000);
});
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
