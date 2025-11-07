<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Proyek Baru</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f8fafc;
      font-family: "Poppins", "Inter", sans-serif;
      color: #1e293b;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      background: #ffffff;
      transition: 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    h1 {
      color: #2563eb;
    }

    .form-label {
      font-weight: 600;
    }

    .form-control {
      border-radius: 0.75rem;
      border: 1px solid #cbd5e1;
      transition: 0.2s;
    }

    .form-control:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }

    .btn-primary {
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      border: none;
      transition: 0.3s;
      font-weight: 600;
      padding: 10px 0;
      border-radius: 0.75rem;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
    }
    
    .text-softblue {
      color: #60a5fa; /* biru muda (Tailwind blue-400) */ 
    }


    /* 🌐 Responsif */
    @media (max-width: 768px) {
      body {
        padding: 30px 15px;
        align-items: flex-start;
      }

      .card {
        margin-top: 20px;
      }

      h1 {
        font-size: 1.4rem;
      }

      .btn-primary {
        font-size: 1rem;
      }
    }

    @media (max-width: 480px) {
      .card-body {
        padding: 1.5rem;
      }

      h1 {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>
  <div class="card shadow-lg w-100" style="max-width: 500px;">
    <div class="card-body p-4">
      <h1 class="h4 mb-4 text-center fw-bold text-softblue">Buat Proyek Baru</h1>

      <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="mb-3">
          <label for="project_name" class="form-label">Nama Proyek</label>
          <input type="text" class="form-control" id="project_name" name="project_name" placeholder="Masukkan nama proyek" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Deskripsi</label>
          <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tulis deskripsi proyek..." required></textarea>
        </div>

        <div class="mb-3">
          <label for="deadline" class="form-label">Deadline</label>
          <input type="date" class="form-control" id="deadline" name="deadline" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
      </form>
    </div>
  </div>

  <script>
    // ⏰ Set tanggal minimal = hari ini
    document.addEventListener("DOMContentLoaded", function() {
      const today = new Date().toISOString().split("T")[0];
      document.getElementById("deadline").min = today;
    });
  </script>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
