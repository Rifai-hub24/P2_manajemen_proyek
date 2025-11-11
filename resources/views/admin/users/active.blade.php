<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar User Aktif</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* 🌈 Tema Modern & Elegan */
    :root {
      --bg-main: #f3f6fb;           /* background lembut abu kebiruan */
      --bg-card: #ffffff;           /* card putih bersih */
      --text-dark: #1e293b;         /* teks utama */
      --text-muted: #6b7280;        /* teks sekunder */
      --primary: #2563eb;           /* biru utama */
      --primary-soft: #dbeafe;      /* biru lembut */
      --border: #e5e7eb;            /* garis halus */
      --shadow: 0 4px 16px rgba(0,0,0,0.05);
      --hover-shadow: 0 8px 20px rgba(37,99,235,0.15);
      --primary-gradient: linear-gradient(135deg, #2563eb, #1e3a8a);
      --primary-gradient-hover: linear-gradient(135deg, #1e40af, #1e3a8a);
    }

    body {
      font-family: "Inter", sans-serif;
      background: var(--bg-main);
      color: var(--text-dark);
      padding: 40px 0;
      min-height: 100vh;
    }

    .container {
      max-width: 1150px;
    }

    h2 {
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    /* 🔹 Filter Section */
    .filter-section {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 20px 24px;
      box-shadow: var(--shadow);
      margin-bottom: 2rem;
      transition: 0.3s;
    }

    select, input {
      border-radius: 10px !important;
      border: 1px solid var(--border) !important;
      color: var(--text-dark) !important;
      background: #f9fafb !important;
      transition: 0.3s;
    }

    select:focus, input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.15rem rgba(37,99,235,0.25);
    }

    /* 🔹 CARD STYLE */
    .user-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 18px;
      box-shadow: var(--shadow);
      transition: all 0.35s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      padding: 1.8rem;
      position: relative;
    }

    .user-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--hover-shadow);
    }

    .user-header {
      display: flex;
      align-items: center;
      margin-bottom: 1.4rem;
    }

    /* 🔹 Profil Lingkaran */
    .user-icon {
      width: 60px;
      height: 60px;
      background: var(--primary-soft);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 16px;
      box-shadow: 0 4px 10px rgba(37,99,235,0.15);
    }

    .user-icon i {
      font-size: 2rem;
      color: var(--primary);
    }

    .card-title {
      font-weight: 600;
      margin: 0;
      color: var(--text-dark);
    }

    .card-subtitle {
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    /* 🔹 Tombol */
    .btn-modern {
      border-radius: 8px;
      transition: 0.25s ease;
      font-weight: 500;
    }

    .btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }
    /* Tombol Gradasi */
    .btn-gradient {
      background: var(--primary-gradient);
      color: white;
      border: none;
      transition: 0.3s ease;
    }

    .btn-gradient:hover {
      background: var(--primary-gradient-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 14px rgba(37,99,235,0.3);
      color: #fff;
    }

    .btn-edit {
      background: var(--primary-soft);
      color: var(--primary);
      border: none;
    }

    .btn-edit:hover {
      background: var(--primary);
      color: white;
    }

    .btn-delete {
      background: #fee2e2;
      color: #b91c1c;
      border: none;
    }

    .btn-delete:hover {
      background: #ef4444;
      color: white;
    }

    /* 🔹 Alert */
    .alert {
      border: none;
      border-radius: 10px;
      box-shadow: var(--shadow);
    }

    .alert-success {
      background: rgba(34,197,94,0.12);
      color: #15803d;
    }

    .alert-danger {
      background: rgba(239,68,68,0.12);
      color: #b91c1c;
    }

    .alert-info {
      background: rgba(37,99,235,0.12);
      color: var(--primary);
    }

    /* ✨ Animasi Halus */
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .fade-in {
      animation: fadeIn 0.6s ease forwards;
    }
    
    /* 📱 Responsive Design */
    @media (max-width: 768px) {
    /* Spasi agar konten tidak mepet di tepi */
      .container {
        padding: 0 1rem;
      }

    /* Susun elemen filter ke bawah di layar kecil */
      .filter-section .row > * {
        flex: 0 0 100%;
        max-width: 100%;
      }

      .filter-section {
        padding: 16px;
      }

      .filter-section button {
        margin-top: 0.5rem;
      }
    }

    @media (max-width: 576px) {
    /* Ukuran card disesuaikan untuk HP */
      .user-card {
        padding: 1.2rem;
      }

      .user-icon {
        width: 50px;
        height: 50px;
        margin-right: 12px;
      }

      .user-icon i {
        font-size: 1.6rem;
      }

      h5.card-title {
        font-size: 1rem;
      }

      .card-subtitle {
        font-size: 0.85rem;
      }

      /* 🔹 Atur ulang header: tombol di atas judul */
      .d-flex.mb-4 {
        flex-direction: column-reverse; /* tombol di atas judul */
        align-items: flex-start; /* tetap di kiri */
        gap: 0.75rem;
      }

      /* 🔹 Judul di tengah */
      h2.text-dark {
        text-align: center;
        width: 100%;
      }

      /* 🔹 Tombol kembali tidak full dan agak ke kanan */
      .btn-gradient.btn-modern {
        width: auto;
        align-self: flex-start;
        margin-left: 12px; /* geser sedikit ke kanan */
      }
    }


  </style>
</head>
<body>
  <div class="container fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-dark">
        <i class="bi bi-people-fill text-primary"></i> Daftar User Aktif
      </h2>
      <a href="{{ route('dashboard') }}" class="btn btn-gradient btn-modern">
        <i class="bi bi-arrow-left-circle"></i> Kembali
      </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show small">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show small">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Filter -->
    <form method="GET" action="{{ route('users.active') }}" class="filter-section">
      <div class="row g-3 align-items-center">
        <div class="col-md-4">
          <select name="role" class="form-select">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
            <option value="team_lead" {{ request('role')=='team_lead' ? 'selected' : '' }}>Team Lead</option>
            <option value="developer" {{ request('role')=='developer' ? 'selected' : '' }}>Developer</option>
            <option value="designer" {{ request('role')=='designer' ? 'selected' : '' }}>Designer</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" placeholder="Cari username..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100 btn-modern">
            <i class="bi bi-search"></i> Cari
          </button>
        </div>
      </div>
    </form>

    <!-- User Cards -->
    <div class="row">
      @forelse($users as $user)
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="user-card">
            <div class="user-header">
              <div class="user-icon">
                <i class="bi bi-person-fill"></i>
              </div>
              <div>
                <h5 class="card-title">{{ $user->full_name }}</h5>
                <div class="card-subtitle">{{ $user->username }}</div>
              </div>
            </div>

            <p class="mb-1"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
            <p class="mb-1"><i class="bi bi-list-check"></i> Status: <span class="text-muted">{{ $user->current_task_status ?? 'Idle' }}</span></p>
            <p class="mb-3"><i class="bi bi-person-badge"></i> Role: <span class="text-muted">{{ $user->role }}</span></p>

            @if(!(Auth::user()->role == 'admin' && $user->role == 'admin'))
              <form action="{{ route('users.updateRole', $user->user_id) }}" method="POST" class="mb-2">
                @csrf
                @method('PUT')
                <div class="input-group">
                  <select name="role" class="form-select">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="team_lead" {{ $user->role == 'team_lead' ? 'selected' : '' }}>Team Lead</option>
                    <option value="developer" {{ $user->role == 'developer' ? 'selected' : '' }}>Developer</option>
                    <option value="designer" {{ $user->role == 'designer' ? 'selected' : '' }}>Designer</option>
                  </select>
                  <button type="submit" class="btn btn-edit">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                </div>
              </form>
            @else
              <div class="alert alert-secondary text-center py-1 mb-2 small">
                <i class="bi bi-lock"></i> Tidak dapat mengedit admin lain
              </div>
            @endif

            @if(!(Auth::user()->role == 'admin' && $user->role == 'admin'))
              <form action="{{ route('users.destroy', $user->user_id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus user {{ $user->username }}?')" class="mt-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete w-100 btn-modern">
                  <i class="bi bi-trash"></i> Hapus User
                </button>
              </form>
            @else
              <button class="btn btn-secondary btn-sm w-100 mt-auto" disabled>
                <i class="bi bi-lock"></i> Tidak bisa hapus admin lain
              </button>
            @endif
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-info text-center shadow-sm">
            <i class="bi bi-info-circle"></i> Tidak ada user ditemukan.
          </div>
        </div>
      @endforelse
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
