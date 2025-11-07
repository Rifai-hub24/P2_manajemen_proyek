<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Edit Card</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --bg-main: #f4f6fa;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --radius: 18px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    body {
      background: var(--bg-main);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--text-dark);
      padding: 50px 20px;
    }

    /* Tombol Kembali */
    .btn-back {
      position: absolute;
      top: 40px;
      right: 60px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: white;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      padding: 9px 18px;
      transition: 0.3s ease;
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #2268ffff, #254fc4ff);
      color: white;
      transform: translateY(-2px);
    }

    /* Container Form */
    .card-container {
      background: #fff;
      border-radius: var(--radius);
      padding: 45px 35px;
      box-shadow: var(--shadow);
      max-width: 750px;
      margin: 0 auto;
    }

    .form-title {
      text-align: center;
      font-weight: 700;
      font-size: 1.9rem;
      color: var(--primary);
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
    }

    .form-control,
    select,
    textarea {
      border-radius: 10px;
      border: 1.5px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .form-control:focus,
    select:focus,
    textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }

    /* Tombol simpan full width */
    .btn-primary {
      width: 100%;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      border: none;
      padding: 14px 24px;
      font-weight: 600;
      border-radius: 10px;
      transition: 0.3s ease;
      font-size: 1rem;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(37, 99, 235, 0.25);
    }

    small.text-muted {
      font-size: 0.85rem;
    }
    /* ==============================
     🌍 RESPONSIVE DESIGN
  ===============================*/

  /* Tablet (≤992px) */
  @media (max-width: 992px) {
    body {
      padding: 40px 20px;
    }

    .card-container {
      padding: 35px 25px;
      max-width: 90%;
    }

    .btn-back {
      top: 30px;
      right: 30px;
      padding: 8px 16px;
      font-size: 0.9rem;
    }

    .form-title {
      font-size: 1.7rem;
    }
  }

  /* HP Sedang (≤768px) */
  @media (max-width: 768px) {
    body {
      padding: 30px 15px;
    }

    .card-container {
      padding: 30px 20px;
      max-width: 100%;
    }

    /* 🔹 Tombol Kembali pindah ke kiri atas */
    .btn-back {
      position: relative;
      top: -8px; 
      left: 10px; /* 🔹 geser sedikit ke kanan */
      display: inline-flex;
      align-items: center;
      justify-content: flex-start;
      margin-bottom: 15px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      font-size: 0.9rem;
      padding: 8px 14px;
    }

    .form-title {
      font-size: 1.5rem;
    }

    .btn-primary {
      font-size: 0.95rem;
      padding: 12px;
    }
  }

  /* HP Kecil (≤480px) */
  @media (max-width: 480px) {
    body {
      padding: 25px 10px;
    }

    .card-container {
      padding: 25px 15px;
    }

    .form-title {
      font-size: 1.3rem;
    }

    .btn-back {
      font-size: 0.85rem;
      padding: 7px 12px;
    }

    .btn-primary {
      font-size: 0.9rem;
      padding: 10px;
      border-radius: 8px;
    }

    .form-control,
    select,
    textarea {
      font-size: 0.9rem;
      padding: 8px 10px;
    }

    small.text-muted {
      font-size: 0.8rem;
    }
  }
  </style>
</head>
<body>

  <!-- Tombol Kembali di Luar Form -->
  <a href="{{ route('teamlead.cards.index', $board->board_id) }}" class="btn btn-back">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>

  <div class="container">
    <div class="card-container">
      <h1 class="form-title"><i class="bi bi-pencil-square"></i> Edit Card</h1>
      <h5 class="mb-4 text-secondary text-center">Board: <strong>{{ $board->board_name }}</strong></h5>

      {{-- Alert Error --}}
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Terjadi Kesalahan:</strong>
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <!-- Form -->
      <form method="POST" action="{{ route('teamlead.cards.update', [$board->board_id, $card->card_id]) }}">
        @csrf
        @method('PUT')

        <!-- 1. Judul -->
        <div class="mb-3">
          <label class="form-label">Judul Card</label>
          <input type="text" name="card_title" class="form-control" value="{{ $card->card_title }}" required>
        </div>

        <!-- 2. Deskripsi -->
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" rows="3" class="form-control">{{ $card->description }}</textarea>
        </div>

        <!-- 3. Prioritas -->
        <div class="mb-3">
          <label class="form-label">Prioritas</label>
          <select name="priority" class="form-control" required>
            <option value="low" @if($card->priority=='low') selected @endif>Low</option>
            <option value="medium" @if($card->priority=='medium') selected @endif>Medium</option>
            <option value="high" @if($card->priority=='high') selected @endif>High</option>
          </select>
        </div>

        <!-- 4. Estimasi Jam -->
        <div class="mb-3">
          <label class="form-label">Estimasi Jam</label>
          <input type="number" name="estimated_hours" class="form-control" value="{{ $card->estimated_hours }}">
        </div>

        <!-- 5. Deadline -->
        <div class="mb-3">
          <label class="form-label">Deadline</label>
          <input type="date" name="due_date" class="form-control" value="{{ $card->due_date }}">
        </div>

        <!-- 6. Posisi -->
        <div class="mb-3">
          <label class="form-label">Posisi</label>
          <input type="number" name="position" class="form-control"
            value="{{ $card->position }}" placeholder="Kosongkan untuk default 1">
          <small class="text-muted">Semakin kecil posisi → semakin atas.</small>
        </div>

        <!-- 7. Assign ke Username -->
        <div class="mb-4">
          <label class="form-label">Assign ke Username</label>
          <select name="username" class="form-control" required>
            <option value="">-- Pilih User --</option>
            @foreach ($members as $m)
              <option value="{{ $m->username }}"
                @if($card->assignments->first() && $card->assignments->first()->user->user_id == $m->user_id) selected @endif>
                {{ $m->username }} ({{ ucfirst($m->role) }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- Tombol Simpan Full Width -->
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>

      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
