<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Manajemen Proyek</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --bg-main: linear-gradient(145deg, #e5ebf3 0%, #f1f4f8 100%);
      --card-bg: #2563eb;
      --text-light: #f8fafc;
      --text-muted: #cbd5e1;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      --hover-shadow: 0 12px 32px rgba(37, 99, 235, 0.25);
    }

    body {
      font-family: "Inter", sans-serif;
      background: var(--bg-main);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    /* KOTAK LOGIN */
    .login-card {
      background: var(--card-bg);
      color: var(--text-light);
      border-radius: 18px;
      box-shadow: var(--shadow);
      width: 400px;
      padding: 2.4rem;
      transition: 0.35s ease;
      animation: fadeIn 0.7s ease;
    }

    .login-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--hover-shadow);
    }

    .icon-circle {
      width: 70px;
      height: 70px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      box-shadow: 0 3px 10px rgba(255,255,255,0.15);
    }

    .icon-circle i {
      font-size: 2rem;
      color: #ffffff;
    }

    h3 {
      text-align: center;
      font-weight: 600;
      color: #ffffff;
      margin-bottom: 0.5rem;
    }

    .subtitle {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-bottom: 1.8rem;
    }

    /* Input */
    .form-control {
      border-radius: 10px;
      border: none;
      background: rgba(255, 255, 255, 0.12);
      color: #ffffff;
      padding: 10px 14px;
      transition: 0.25s;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.18);
      box-shadow: 0 0 0 0.15rem rgba(255,255,255,0.25);
      color: #fff;
    }

    .form-control::placeholder {
      color: #dbeafe;
    }

    label {
      font-weight: 500;
      color: #e0e7ff;
    }

    /* Tombol */
    .btn-light {
      background: #ffffff;
      color: #2563eb;
      border: none;
      border-radius: 10px;
      padding: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-light:hover {
      background: #f1f5ff;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255,255,255,0.25);
    }

    /* Manual link */
    .manual-link {
      text-align: center;
      margin-top: 1rem;
    }
    .manual-link button {
      background: transparent;
      color: #fff;
      border: 1px solid #dbeafe;
      border-radius: 8px;
      padding: 6px 14px;
      font-size: 0.9rem;
      transition: 0.25s;
    }
    .manual-link button:hover {
      background: rgba(255,255,255,0.2);
    }

    /* Footer */
    .footer-text {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-top: 1.5rem;
    }

    .footer-text a {
      color: #ffffff;
      font-weight: 600;
      text-decoration: none;
    }

    .forgot-text {
      text-align: center;
      margin-top: 0.5rem;
    }

    .forgot-text a {
      color: #ffffff;
      font-size: 0.92rem;
      font-weight: 700;
      text-decoration: none;
      opacity: 0.95;
    }

    .alert {
      border: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 0.9rem;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body>

  <div class="login-card">
    <div class="icon-circle">
      <i class="bi bi-kanban"></i>
    </div>

    <h3>Login</h3>
    <p class="subtitle">Masuk ke sistem Manajemen Proyek Anda</p>

    {{-- Alert Error --}}
    @if(session('error'))
      <div class="alert alert-danger small">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="mb-3">
        <label for="login" class="form-label">Username atau Email</label>
        <input type="text" name="login" id="login" class="form-control" placeholder="Masukkan username atau email" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn btn-light w-100 mt-2">
        <i class="bi bi-box-arrow-in-right me-1"></i> Login
      </button>
    </form>

    <p class="footer-text">
      Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </p>

    <p class="forgot-text">
      <a href="{{ route('forgot') }}">Lupa Password?</a>
    </p>

    <!-- Tombol Manual Book -->
    <div class="manual-link">
      <button data-bs-toggle="modal" data-bs-target="#manualModal">
        📘 Manual Book
      </button>
    </div>
  </div>

  <!-- MODAL MANUAL BOOK MODERN & RAPI -->
<div class="modal fade" id="manualModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 15px; overflow: hidden;">

      <!-- HEADER -->
      <div class="modal-header" style="background:#2563eb; color:#fff; border-bottom:none;">
        <h5 class="modal-title d-flex align-items-center fw-bold" style="font-size:1.3rem;">
          <i class="bi bi-book-half me-2" style="font-size:1.6rem;"></i>
          Manual Book – Sistem Manajemen Proyek
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body p-4" style="background:#f7f9fc; color:#111; font-size:0.95rem; line-height:1.6;">

        <!-- 1. PERAN PENGGUNA -->
        <div class="manual-section mb-4 p-3" style="background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
          <h6 class="fw-bold mb-3" style="color:#2563eb;">📌 1. Peran Pengguna</h6>
          <ul style="list-style:none; padding-left:0; margin:0;">
            <li style="display:flex; align-items:flex-start; margin-bottom:10px;">
              <span style="min-width:25px; color:#10b981;">⚙️</span>
              <span style="margin-left:8px; line-height:1.5;">
                <strong>Admin:</strong> Membuat proyek, menambah anggota, memantau progres, menilai produktivitas, dan menyetujui project.
              </span>
            </li>
            <li style="display:flex; align-items:flex-start; margin-bottom:10px;">
              <span style="min-width:25px; color:#f59e0b;">📋</span>
              <span style="margin-left:8px; line-height:1.5;">
                <strong>Team Lead:</strong> Membuat card, membagi tugas, memeriksa subtasks, mengirim project ke admin.
              </span>
            </li>
            <li style="display:flex; align-items:flex-start; margin-bottom:10px;">
              <span style="min-width:25px; color:#3b82f6;">💻</span>
              <span style="margin-left:8px; line-height:1.5;">
                <strong>Developer/Designer:</strong> Membuat subtasks, menyelesaikan tugas, dan bisa meminta bantuan jika kesusahan.
              </span>
            </li>
          </ul>
        </div>

        <!-- 2. ALUR KERJA UTAMA -->
        <div class="manual-section mb-4 p-3" style="background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
          <h6 class="fw-bold mb-3" style="color:#2563eb;">🔄 2. Alur Kerja Utama</h6>
          <ol style="padding-left:1.2rem; margin:0;">
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">🛠️</span>
              <span style="margin-left:8px;">Admin membuat project dan menambahkan anggota.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">📌</span>
              <span style="margin-left:8px;">Team Lead membuat card dan membagi tugas.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">📝</span>
              <span style="margin-left:8px;">Developer/Designer membuat subtasks.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">🆘</span>
              <span style="margin-left:8px;">Jika ada kendala, anggota meminta bantuan.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">✔️</span>
              <span style="margin-left:8px;">Team Lead memeriksa subtasks.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">📤</span>
              <span style="margin-left:8px;">Project dikirim ke Admin.</span>
            </li>
            <li class="mb-2" style="display:flex; align-items:flex-start;">
              <span style="min-width:25px;">🏁</span>
              <span style="margin-left:8px;">Admin menyetujui atau menolak project.</span>
            </li>
          </ol>
        </div>

        <!-- 3. FITUR TAMBAHAN -->
        <div class="manual-section mb-4 p-3" style="background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
          <h6 class="fw-bold mb-3" style="color:#2563eb;">📊 3. Fitur Tambahan</h6>
          <ul style="list-style:none; padding-left:0; margin:0;">
            <li style="display:flex; align-items:flex-start; margin-bottom:8px;">
              <span style="min-width:25px; color:#ef4444;">📈</span>
              <span style="margin-left:8px;">Grafik progres proyek.</span>
            </li>
            <li style="display:flex; align-items:flex-start; margin-bottom:8px;">
              <span style="min-width:25px; color:#f97316;">⏱️</span>
              <span style="margin-left:8px;">Laporan produktivitas anggota.</span>
            </li>
            <li style="display:flex; align-items:flex-start; margin-bottom:8px;">
              <span style="min-width:25px; color:#3b82f6;">🕒</span>
              <span style="margin-left:8px;">Riwayat aktivitas lengkap.</span>
            </li>
            <li style="display:flex; align-items:flex-start; margin-bottom:8px;">
              <span style="min-width:25px; color:#10b981;">🔔</span>
              <span style="margin-left:8px;">Notifikasi status real-time.</span>
            </li>
          </ul>
        </div>

        <!-- 4. ALUR SINGKAT -->
        <div class="manual-section p-3" style="background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
          <h6 class="fw-bold mb-2" style="color:#2563eb;">⚡ 4. Alur Singkat</h6>
          <p class="mb-0 fw-semibold" style="line-height:1.5;">
            Admin → Team Lead → Developer/Designer → Team Lead → Admin
          </p>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer" style="border-top:none; background:#f7f9fc;">
        <button class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
