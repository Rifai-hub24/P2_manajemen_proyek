<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password - Manajemen Proyek</title>
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

    .reset-card {
      background: var(--card-bg);
      color: var(--text-light);
      border-radius: 18px;
      box-shadow: var(--shadow);
      width: 420px;
      padding: 2.4rem;
      animation: fadeIn 0.7s ease;
      transition: 0.3s;
    }

    .reset-card:hover {
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
    }

    .icon-circle i {
      font-size: 2rem;
      color: #ffffff;
    }

    h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .subtitle {
      text-align: center;
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-bottom: 1.8rem;
    }

    .form-control {
      border-radius: 10px;
      border: none;
      background: rgba(255, 255, 255, 0.12);
      color: #ffffff;
      padding: 10px 14px;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.18);
      box-shadow: 0 0 0 0.15rem rgba(255,255,255,0.25);
      color: #fff;
    }

    .form-control::placeholder {
      color: #dbeafe;
    }

    .btn-reset {
      background: #ffffff;
      color: #2563eb;
      border-radius: 10px;
      font-weight: 600;
      border: none;
      padding: 10px;
      transition: 0.3s;
    }

    .btn-reset:hover {
      background: #f1f5ff;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255,255,255,0.25);
    }

    /* LOGIN: Bold & tanpa underline */
    .back-link {
      display: block;
      margin-top: 1rem;
      text-align: center;
      color: #ffffff;
      font-size: 0.9rem;
      font-weight: 700;
      text-decoration: none;
    }

    .alert {
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.25);
      color: #fff;
      border: none;
      font-size: 0.9rem;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <div class="reset-card">

    <div class="icon-circle">
      <i class="bi bi-key"></i>
    </div>

    <h3>Reset Password</h3>
    <p class="subtitle">Masukkan Username & PIN Reset Anda</p>

    {{-- Error --}}
    @if(session('error'))
      <div class="alert alert-danger mb-3">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
      </div>
    @endif

    {{-- Success --}}
    @if(session('success'))
      <div class="alert alert-success mb-3">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('forgot.process') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required placeholder="Masukkan username">
      </div>

      <div class="mb-3">
        <label class="form-label">PIN Reset</label>
        <input type="text" name="reset_code" class="form-control" required placeholder="PIN dari Admin">
      </div>

      <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
      </div>

      <div class="mb-4">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password baru">
      </div>

      <button type="submit" class="btn-reset w-100">
        <i class="bi bi-arrow-repeat"></i> Reset Password
      </button>
    </form>

    <a href="{{ route('login') }}" class="back-link">
       Login
    </a>

  </div>

</body>
</html>
