<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Buat Card Baru - {{ $board->board_name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg-light: #f5f7fa;
      --card-bg: #ffffff;
      --text-dark: #1e293b;
      --text-muted: #6b7280;
      --border: #e5e7eb;
      --radius: 14px;
      --shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    body {
      background: var(--bg-light);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--text-dark);
      min-height: 100vh;
      margin: 0;
      padding: 60px 20px 40px;
      position: relative;
    }

    /* 🔹 Tombol kembali di kanan atas */
    .top-nav {
      position: absolute;
      top: 25px;
      right: 25px;
    }

    .btn-back {
      border: none;
      background: var(--primary);
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
      padding: 10px 20px;
      transition: all 0.25s ease;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .btn-back:hover {
      background: var(--primary-dark);
      color: #fff;
      transform: translateY(-2px);
    }
    
    /* 🔹 Hilangkan garis bawah pada tombol kembali */
    .btn-back,
    .btn-back:visited,
    .btn-back:hover,
    .btn-back:active {
      text-decoration: none !important;
    }

    /* 🔹 Kontainer form */
    .form-wrapper {
      max-width: 650px;
      margin: auto;
      background: var(--card-bg);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
      padding: 45px 40px;
    }

    h1 {
      font-weight: 700;
      color: var(--primary);
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .subtitle {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 35px;
    }

    label {
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-dark);
    }

    .form-control, .form-select {
      border-radius: var(--radius);
      border: 1px solid var(--border);
      padding: 10px 14px;
      transition: border-color 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: none;
    }

    textarea {
      resize: none;
    }

    .btn-submit {
      background-color: var(--primary);
      border: none;
      color: white;
      border-radius: var(--radius);
      font-weight: 600;
      padding: 12px;
      width: 100%;
      transition: background 0.2s ease;
    }

    .btn-submit:hover {
      background-color: var(--primary-dark);
    }

    small.text-muted {
      font-size: 0.85rem;
    }

    .alert {
      border-radius: var(--radius);
    }

    @media (max-width: 768px) {
      .top-nav {
        position: static;
        display: flex;
        justify-content: flex-start; /* pindah ke kiri */
        margin-bottom: 15px;
      }
    }
    /* HP Kecil (≤480px) */
    @media (max-width: 480px) {
      body {
        padding: 25px 10px;
      }

      .form-wrapper {
        padding: 25px 18px;
        border-radius: 10px;
      }

      h1 {
        font-size: 1.2rem;
      }

      .subtitle {
        font-size: 0.85rem;
        margin-bottom: 20px;
      }

      label {
        font-size: 0.9rem;
      }

      .form-control, .form-select {
        font-size: 0.9rem;
        padding: 9px 12px;
      }

      .btn-submit {
        padding: 10px;
        font-size: 0.95rem;
        border-radius: 10px;
      }

      .btn-back {
        font-size: 0.85rem;
        padding: 7px 14px;
      }
    }
  </style>
</head>

<body>
  <!-- 🔝 Tombol Kembali di kanan atas -->
  <div class="top-nav">
    <a href="{{ route('teamlead.projects.show', $board->project_id) }}" class="btn-back">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
  </div>

  <!-- 🧾 Kontainer Form -->
  <div class="form-wrapper mt-4">
    <h1><i class="bi bi-kanban"></i> Buat Card Baru</h1>
    <p class="subtitle">Board: <strong>{{ $board->board_name }}</strong></p>

    <!-- Alert Error -->
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan:</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('teamlead.cards.store', $board->board_id) }}">
      @csrf

      <div class="mb-3">
        <label>Judul Card</label>
        <input type="text" name="card_title" class="form-control" placeholder="Masukkan judul card" required>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Tulis deskripsi singkat..."></textarea>
      </div>

      <div class="mb-3">
        <label>Prioritas</label>
        <select name="priority" class="form-select" required>
          <option value="low">Low</option>
          <option value="medium" selected>Medium</option>
          <option value="high">High</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Estimasi Jam</label>
        <input type="number" name="estimated_hours" class="form-control" placeholder="Contoh: 5">
      </div>

      <div class="mb-3">
        <label>Deadline</label>
        <input type="date" id="due_date" name="due_date" class="form-control" required>
        <small class="text-muted">Tidak dapat memilih tanggal sebelum hari ini.</small>
      </div>

      <div class="mb-3">
        <label>Assign ke Username</label>
        <select name="username" class="form-select" required>
          <option value="">-- Pilih User --</option>
          @foreach ($members as $member)
            <option value="{{ $member->username }}">
              {{ $member->username }} ({{ ucfirst($member->role) }})
            </option>
          @endforeach
        </select>
        <small class="text-muted">Hanya developer/designer yang tergabung di project ini.</small>
      </div>

      <div class="mb-4">
        <label>Posisi Card</label>
        <input type="number" name="position" class="form-control" placeholder="Kosongkan untuk default = 1">
      </div>

      <button type="submit" class="btn btn-submit">
        <i class="bi bi-check-circle"></i> Simpan Card
      </button>
    </form>
  </div>

  <script>
    // 🔒 Batasi agar hanya bisa pilih hari ini & hari setelahnya
    document.addEventListener("DOMContentLoaded", function() {
      const today = new Date();
      const yyyy = today.getFullYear();
      const mm = String(today.getMonth() + 1).padStart(2, '0');
      const dd = String(today.getDate()).padStart(2, '0');
      const minDate = `${yyyy}-${mm}-${dd}`;
      document.getElementById("due_date").setAttribute("min", minDate);
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
