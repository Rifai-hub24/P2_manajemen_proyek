<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Proyek - Project PRO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg: #f4f6fa;
      --card-bg: #ffffff;
      --shadow: 0 8px 20px rgba(0,0,0,0.06);
      --radius: 16px;
    }

    body {
      font-family: "Inter", sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .edit-card {
      background: var(--card-bg);
      box-shadow: var(--shadow);
      border-radius: var(--radius);
      width: 100%;
      max-width: 600px;
      padding: 40px 35px;
      transition: 0.3s ease;
    }

    .edit-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(37,99,235,0.15);
    }

    .edit-card h3 {
      font-weight: 700;
      color: var(--primary-dark);
      text-align: center;
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
      color: #1e293b;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #d1d5db;
      padding: 10px 14px;
      font-size: 0.95rem;
      transition: 0.2s;
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(37,99,235,0.15);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 20px;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #3b82f6, #1e40af);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(37,99,235,0.3);
    }

    .btn-secondary {
      border-radius: 10px;
      font-weight: 600;
      background: #e5e7eb;
      color: #1e293b;
      border: none;
      transition: 0.3s;
    }

    .btn-secondary:hover {
      background: #d1d5db;
      color: #1e293b;
      transform: translateY(-2px);
    }
    /* 📱 Responsif di layar kecil */
    @media (max-width: 768px) {
      body {
        padding: 20px;
        align-items: flex-start; /* biar form mulai dari atas, bukan tengah */
      }

      .edit-card {
        padding: 25px 20px;
        margin-top: 20px;
      }

      .edit-card h3 {
        font-size: 1.4rem;
        margin-bottom: 20px;
      }

      .btn-primary, 
      .btn-secondary {
        width: 100%;       /* tombol full width di HP */
        text-align: center;
      }

      .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;         /* jarak antar tombol */
      }
    }

    /* 📱 Layar sangat kecil (HP mini, <480px) */
    @media (max-width: 480px) {
      .edit-card {
        padding: 20px 15px;
      }

      .edit-card h3 {
        font-size: 1.2rem;
      }

      .form-control {
        font-size: 0.9rem;
        padding: 8px 12px;
      }
    }

  </style>
</head>
<body>

  <div class="edit-card">
    <h3><i class="bi bi-pencil-square"></i> Edit Proyek</h3>

    <!-- Pesan Error -->
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('projects.update', $project->project_id) }}">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Nama Proyek</label>
        <input type="text" name="project_name" class="form-control"
               value="{{ old('project_name', $project->project_name) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4"
                  placeholder="Masukkan deskripsi proyek...">{{ old('description', $project->description) }}</textarea>
      </div>

      @php
        $deadlineValue = old('deadline')
            ?: ($project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') : '');
      @endphp

      <div class="mb-4">
        <label class="form-label">Deadline</label>
        <input type="date" id="deadline" name="deadline" class="form-control"
               min="{{ now()->toDateString() }}"
               value="{{ $deadlineValue }}">
        <small class="text-muted">Hanya dapat memilih tanggal hari ini atau setelahnya.</small>
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

  <script>
    // Batasi agar tidak bisa pilih tanggal sebelum hari ini
    document.addEventListener("DOMContentLoaded", function() {
      const inputDate = document.getElementById("deadline");
      const today = new Date().toISOString().split("T")[0];
      inputDate.min = today;
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
