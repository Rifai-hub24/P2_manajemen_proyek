<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Edit Subtask</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg-main: #f8fafc;
      --text-dark: #1e293b;
      --text-muted: #64748b;
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg-main);
      color: var(--text-dark);
      padding: 60px 20px;
    }

    /* Tombol kembali pojok kanan atas */
    .top-right {
      text-align: right;
      margin-bottom: 25px;
    }

    .btn-back {
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: #fff;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(37,99,235,0.25);
      transition: 0.3s;
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      color: #fff;
    }

    /* Form Card */
    .form-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      padding: 40px 35px;
      max-width: 750px;
      margin: auto;
      box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      animation: fadeUp 0.6s ease;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      font-weight: 700;
      color: var(--primary-dark);
      margin-bottom: 25px;
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
    }

    input, textarea {
      border-radius: 10px !important;
      border: 1px solid #d1d5db;
      background: #f9fafb;
      transition: 0.25s;
    }

    input:focus, textarea:focus {
      border-color: var(--primary);
      box-shadow: none;
      background: #fff;
    }

    small.text-muted {
      font-size: 0.85rem;
    }

    .alert {
      border-radius: 10px;
    }

    /* Tombol utama */
    .btn-save {
      width: 100%;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      font-size: 1.05rem;
      transition: 0.3s;
      box-shadow: 0 4px 14px rgba(37,99,235,0.25);
    }

    .btn-save:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      color: white;
    }
    /* =========================
       RESPONSIVE DESIGN
    ==========================*/
    @media (max-width: 992px) {
      body { padding: 50px 15px; }
      .form-card { padding: 35px 25px; }
    }

    @media (max-width: 768px) {
      body { padding: 40px 15px; }

      .top-right {
        text-align: left;
        padding-left: 25px; /* 🔹 geser ke kanan sedikit di HP */
        margin-bottom: 15px;
      }

      .btn-back {
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
      }

      .form-card {
        padding: 25px 20px;
        max-width: 95%;
      }

      h2 { font-size: 1.3rem; }
      .btn-save { font-size: 1rem; padding: 10px; }
    }

    @media (max-width: 480px) {
      body { padding: 30px 10px; }

      .top-right {
        text-align: left;
        padding-left: 30px; /* 🔹 lebih ke kanan untuk HP kecil */
      }

      .btn-back {
        display: inline-block;
        font-size: 0.85rem;
        padding: 8px 14px;
      }

      .form-card {
        padding: 20px 15px;
        max-width: 100%;
      }

      h2 { font-size: 1.2rem; }
      .btn-save { font-size: 0.95rem; padding: 10px; }
    }

  </style>
</head>
<body>

  <!-- Tombol kembali di pojok kanan atas -->
  <div class="top-right">
    <a href="{{ route('designer.dashboard') }}" class="btn-back">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
  </div>

  <div class="container">
    <div class="form-card">
      <h2><i class="bi bi-pencil-square"></i> Edit Subtask</h2>

      <h5 class="mb-3 text-center">Subtask: <span class="text-primary fw-semibold">{{ $subtask->subtask_title }}</span></h5>

      <!-- Error Message -->
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form Edit -->
      <form action="{{ route('subtasks.update', $subtask->subtask_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Judul Subtask</label>
          <input type="text" name="subtask_title" class="form-control"
                 value="{{ old('subtask_title', $subtask->subtask_title) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $subtask->description) }}</textarea>
        </div>

        <!-- Estimasi Jam (di atas) -->
        <div class="mb-3">
          <label class="form-label">Estimasi Jam</label>
          <input type="number" name="estimated_hours" class="form-control"
                 value="{{ old('estimated_hours', $subtask->estimated_hours) }}" step="0.1" min="0" placeholder="Contoh: 2.5">
        </div>

        <!-- Posisi Subtask (di bawah) -->
        <div class="mb-3">
          <label class="form-label">Posisi Subtask</label>
          <input type="number" name="position" class="form-control"
                 value="{{ old('position', $subtask->position) }}" min="1" placeholder="Urutan subtask, contoh: 1">
          <small class="text-muted">Semakin kecil angkanya, semakin atas posisinya.</small>
        </div>

        <button type="submit" class="btn btn-save mt-3">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
