<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Generate Laporan Proyek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
  <div class="container">
    <h2 class="text-primary mb-4"><i class="bi bi-file-earmark-text"></i> Generate Laporan Proyek</h2>

    <form action="{{ route('reports.generate') }}" method="POST" class="card p-4 shadow-sm border-0">
      @csrf
      <div class="row mb-3">
        <div class="col-md-5">
          <label class="form-label fw-semibold">Dari Tanggal</label>
          <input type="date" name="from_date" class="form-control" required>
        </div>
        <div class="col-md-5">
          <label class="form-label fw-semibold">Sampai Tanggal</label>
          <input type="date" name="to_date" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-filetype-pdf"></i> Generate PDF
          </button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>