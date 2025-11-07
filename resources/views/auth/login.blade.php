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
      --bg-main: linear-gradient(145deg, #e5ebf3 0%, #f1f4f8 100%); /* abu kebiruan lembut */
      --card-bg: #2563eb;          /* biru elegan untuk kotak login */
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

    /* 🔷 Kotak Login */
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

    /* 🔹 Ikon */
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

    /* 🔹 Input */
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

    /* 🔹 Tombol */
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

    /* 🔹 Footer */
    .footer-text {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-top: 1.5rem;
    }

    .footer-text a {
      color: #ffffff; /* tulisan daftar sekarang putih */
      font-weight: 600;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    /* 🔹 Alert */
    .alert {
      border: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.15);
      color: #fff;
      font-size: 0.9rem;
    }

    /* ✨ Animasi */
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 480px) {
      .login-card {
        width: 90%;
        padding: 2rem;
      }
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
