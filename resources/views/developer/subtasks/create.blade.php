<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Tambah Subtask - {{ $card->card_title }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f8fafc;
      font-family: "Inter", "Poppins", sans-serif;
      padding: 60px 20px;
    }

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
      transition: 0.3s;
    }

    .btn-back:hover {
      background: #1e40af;
      transform: translateY(-2px);
      color: #fff;
    }

    .form-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 40px 35px;
      max-width: 700px;
      margin: auto;
    }

    h2 {
      font-weight: 700;
      color: #1e3a8a;
      text-align: center;
      margin-bottom: 30px;
    }

    input, textarea {
      border-radius: 8px !important;
      border: 1px solid #d1d5db;
      background: #f9fafb;
      transition: 0.2s;
    }

    input:focus, textarea:focus {
      border-color: #2563eb;
      box-shadow: none;
      background: #fff;
    }

    .btn-save {
      width: 100%;
      background: #2563eb;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.25s;
    }

    .btn-save:hover {
      background: #1e40af;
      transform: translateY(-2px);
      color: white;
    }
     /* === RESPONSIVE === */
    @media (max-width: 992px) {
      body {
        padding: 30px 16px 70px;
      }
      .form-card {
        padding: 30px 25px;
        max-width: 90%;
      }
    }

    @media (max-width: 768px) {
      .top-right {
        text-align: left; /* tombol ke kiri di layar kecil */
        margin-left: 15px;  
        margin-bottom: 15px;
      }

      .btn-back {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        font-size: 0.9rem;
        padding: 9px 15px;
        border-radius: 8px;
      }

      h2 {
        font-size: 1.4rem;
        margin-top: 10px;
      }

      .form-card {
        padding: 25px 20px;
      }
    }

    @media (max-width: 576px) {
      body {
        padding: 20px 10px 60px;
      }

      .btn-back {
        font-size: 0.85rem;
        padding: 8px 14px;
      }

      h2 {
        font-size: 1.2rem;
      }

      .form-card {
        padding: 20px 16px;
        max-width: 100%;
      }
    }
  </style>
</head>

<body>

  <!-- Tombol kembali ke dashboard developer -->
  <div class="top-right">
    <a href="{{ route('developer.dashboard') }}" class="btn-back">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
  </div>

  <div class="container">
    <h2><i class="bi bi-plus-circle"></i> Tambah Subtask untuk {{ $card->card_title }}</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('subtasks.store', $card->card_id) }}" method="POST" class="form-card mt-4 shadow-sm">
      @csrf

      <div class="mb-3">
        <label class="form-label">Judul Subtask</label>
        <input type="text" name="subtask_title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Estimasi Jam</label>
        <input type="number" step="0.01" name="estimated_hours" class="form-control" placeholder="Contoh: 2.5">
      </div>

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
