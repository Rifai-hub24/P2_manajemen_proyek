<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Tambah Subtask - {{ $card->card_title }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg-main: #f1f5f9;
      --bg-white: #ffffff;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg-main);
      color: var(--text-dark);
      padding: 70px 20px;
    }

    /* Tombol kembali pojok kanan atas */
     .top-right {
      text-align: right;
      margin-bottom: 25px;
    }

    .btn-back {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      color: #fff;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
      transition: 0.3s ease;
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
      transform: translateY(-2px);
      color: #fff;
    }

    /* Card form melayang */
    .form-card {
      background: var(--bg-white);
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      padding: 40px 35px;
      max-width: 700px;
      margin: auto;
      box-shadow: var(--shadow);
      transition: 0.3s ease;
      animation: fadeUp 0.6s ease;
    }

    h2 {
      font-weight: 700;
      color: var(--primary-dark);
      text-align: center;
      margin-bottom: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 6px;
    }

    input, textarea {
      border-radius: 8px !important;
      border: 1px solid #d1d5db;
      transition: 0.2s;
      background: #f9fafb;
      font-size: 0.95rem;
    }

    input:focus, textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
      background: #fff;
    }

    /* Tombol simpan full width */
    .btn-save {
      width: 100%;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-size: 1rem;
      transition: 0.25s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-save:hover {
      background: linear-gradient(135deg, #1d4ed8, #1e40af);
      transform: translateY(-2px);
      color: white;
    }

    .alert {
      border-radius: 8px;
    }

    /* Animasi form muncul halus */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Placeholder styling */
    ::placeholder {
      color: var(--text-muted);
      font-size: 0.9rem;
    }
     /* ======================
       RESPONSIVE DESIGN
    =======================*/

    /* Tablet */
    @media (max-width: 992px) {
      body { padding: 60px 15px; }
      .form-card { padding: 35px 25px; }
    }

    /* HP sedang */
    @media (max-width: 768px) {
      body { padding: 50px 15px; }

      .top-right {
        text-align: left;
        padding-left: 25px; /* 🔹 sedikit ke kanan */
        margin-bottom: 20px;
      }

      .btn-back {
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 8px;
      }

      .form-card {
        padding: 30px 20px;
        max-width: 95%;
      }

      h2 {
        font-size: 1.3rem;
      }

      .btn-save {
        font-size: 0.95rem;
        padding: 10px;
      }
    }

    /* HP kecil */
    @media (max-width: 480px) {
      body { padding: 40px 10px; }

      .top-right {
        text-align: left;
        padding-left: 30px; /* 🔹 geser lebih ke kanan */
        margin-bottom: 15px;
      }

      .btn-back {
        display: inline-block;
        font-size: 0.85rem;
        padding: 8px 14px;
      }

      .form-card {
        padding: 25px 15px;
        max-width: 100%;
      }

      h2 {
        font-size: 1.15rem;
      }
    }
  </style>
</head>

<body>

  <!-- Tombol kembali -->
  <div class="top-right">
    <a href="{{ route('designer.dashboard') }}" class="btn-back">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
  </div>

  <!-- Form utama -->
  <div class="container">
    <h2><i class="bi bi-plus-circle"></i> Tambah Subtask untuk {{ $card->card_title }}</h2>

    @if($errors->any())
      <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('subtasks.store', $card->card_id) }}" method="POST" class="form-card mt-4">
      @csrf

      <div class="mb-3">
        <label class="form-label">Judul Subtask</label>
        <input type="text" name="subtask_title" class="form-control" placeholder="Masukkan judul subtask..." required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan deskripsi singkat..."></textarea>
      </div>

      <!-- Estimasi Jam -->
      <div class="mb-3">
        <label class="form-label">Estimasi Jam</label>
        <input type="number" step="0.01" name="estimated_hours" class="form-control" placeholder="Contoh: 2.5">
      </div>

      <!-- Posisi Subtask -->
      <div class="mb-3">
        <label class="form-label">Posisi Subtask</label>
        <input type="number" name="position" class="form-control" placeholder="Urutan subtask, contoh: 1">
      </div>

      <button type="submit" class="btn btn-save mt-3">
        <i class="bi bi-save"></i> Simpan Subtask
      </button>
    </form>
  </div>

</body>
</html>
