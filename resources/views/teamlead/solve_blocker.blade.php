<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Solve Blocker - Project PRO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    :root {
      --brand: linear-gradient(135deg, #2563eb, #1e3a8a);
      --brand-dark: linear-gradient(135deg, #1e40af, #1e3a8a);
      --success: #22c55e;
      --success-dark: #15803d;
      --ink: #0f172a;
      --muted: #475569;
      --bg: #f1f5f9;
      --card-bg: #ffffff;
      --radius: 16px;
      --shadow: 0 8px 26px rgba(2, 6, 23, 0.08);
    }

    body {
      background: var(--bg);
      color: var(--ink);
      font-family: "Inter", "Poppins", "Segoe UI", system-ui, sans-serif;
      font-size: 0.95rem;
    }

    /* === HEADER === */
    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 35px;
    }

    .page-title {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--brand);
    }

    .page-title i {
      font-size: 1.7rem;
    }

    /* Tombol Kembali */
    .btn-back {
      background: var(--brand);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 18px;
      transition: 0.25s;
      box-shadow: 0 6px 16px rgba(37, 99, 235, 0.2);
      text-decoration: none; /* ✅ Hilangkan garis bawah */
    }

    .btn-back:hover {
      background: var(--brand-dark);
      transform: translateY(-2px);
      color: #fff;
      text-decoration: none; /* ✅ Pastikan tidak muncul underline saat hover */
    }

    /* === CARD === */
    .blocker-card {
      background: var(--card-bg);
      border-radius: var(--radius);
      border: 1px solid #e2e8f0;
      box-shadow: var(--shadow);
      padding: 24px 22px;
      height: 100%;
      display: flex;
      flex-direction: column;
      transition: 0.3s ease;
    }

    .blocker-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(37, 99, 235, 0.18);
    }

    .blocker-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--brand-dark);
      text-transform: capitalize;
      margin-bottom: 10px;
    }

    .chip-user {
      background: var(--brand);
      color: #fff;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      font-size: 0.85rem;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
    }

    .meta {
      font-size: 0.92rem;
      color: var(--muted);
      margin-top: 10px;
      flex-grow: 1;
    }

    .meta i {
      margin-right: 0.4rem;
    }

    .label-strong {
      color: var(--ink);
      font-weight: 600;
    }

    /* Deskripsi */
    .desc-wrap {
      margin-top: 0.3rem;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px 12px;
      font-size: 0.93rem;
      color: #334155;
      line-height: 1.5;
      white-space: pre-wrap;
      word-break: break-word;
      overflow-wrap: anywhere;
      max-height: 100px;
      overflow-y: auto;
    }

    .desc-wrap a {
      color: #2563eb;
      text-decoration: none;
      font-weight: 600;
      word-break: break-all;
    }

    .desc-wrap a:hover {
      text-decoration: underline;
    }

    /* Tombol Solve */
    .btn-solve {
      background: linear-gradient(135deg, var(--success), var(--success-dark));
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 11px 14px;
      font-weight: 700;
      letter-spacing: 0.3px;
      transition: 0.3s;
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2);
    }

    .btn-solve:hover {
      background: linear-gradient(135deg, #16a34a, #15803d);
      transform: translateY(-2px);
      color: #fff;
    }

    .desc-wrap::-webkit-scrollbar {
      width: 6px;
    }

    .desc-wrap::-webkit-scrollbar-thumb {
      background-color: #94a3b8;
      border-radius: 10px;
    }

    .alert-success {
      background: #dcfce7;
      color: #065f46;
      border: none;
      border-radius: 12px;
      font-weight: 500;
    }
    .desc-wrap {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px 12px;
      font-size: 0.93rem;
      color: #334155;
      line-height: 1.5;
      text-align: left;
      white-space: normal; /* 🔑 ganti dari pre-wrap ke normal */
      word-break: break-word;
      overflow-wrap: anywhere;
      max-height: 100px;
      overflow-y: auto;
    }

    @media (min-width: 992px) {
      .col-card {
        display: flex;
      }
    }
    /* ===========================
    💻 Tablet (max-width: 992px)
    =========================== */
    @media (max-width: 992px) {
      body {
        padding: 25px 15px;
      }

    .page-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }

    .btn-back {
      padding: 8px 14px;
      font-size: 0.9rem;
    }

    .blocker-card {
      padding: 20px 18px;
    }

    .blocker-title {
      font-size: 1rem;
    }

    .desc-wrap {
      max-height: 90px;
      font-size: 0.9rem;
    }
  }

  /* ===========================
   📱 HP besar (max-width: 768px)
   =========================== */
  @media (max-width: 768px) {
    .page-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }

    .page-title h2 {
      font-size: 1.2rem;
    }

    .btn-back {
      font-size: 0.9rem;
      padding: 8px 12px;
      border-radius: 8px;
    }

    .row.g-4 {
      gap: 18px;
    }

    /* Card tidak menempel ke tepi layar */
    .col-card {
      padding: 0 12px;
    }

    .blocker-card {
      padding: 18px;
      border-radius: 14px;
    }

    .blocker-title {
      font-size: 0.95rem;
    }

    .chip-user {
      font-size: 0.8rem;
      padding: 5px 10px;
    }

    .desc-wrap {
      font-size: 0.85rem;
      max-height: 80px;
    }

    .btn-solve {
      font-size: 0.9rem;
      padding: 9px 12px;
    }

    textarea.form-control {
      font-size: 0.9rem;
    }
  }

  /* ===========================
   📱 HP kecil (max-width: 576px)
   =========================== */
  @media (max-width: 576px) {
    body {
      padding: 20px 10px;
    }

    .container {
      padding: 0 5px;
    }

    .page-title h2 {
      font-size: 1.05rem;
    }

    .btn-back {
      font-size: 0.85rem;
      padding: 7px 12px;
      border-radius: 8px;
      align-self: flex-start;
      width: auto; /* ❗ Tombol tidak full layar */
    }

    .row.g-4 {
      gap: 14px;
    }

    /* ❗ Card tidak menempel ke tepi layar HP */
    .col-card {
      padding: 0 14px;
    }

    .blocker-card {
      padding: 16px;
      border-radius: 12px;
      width: 100%;
      max-width: 380px; /* ❗ Batas lebar maksimum di HP */
      margin: 0 auto;   /* ❗ Tengah di layar */
    }

    .blocker-title {
      font-size: 0.9rem;
      margin-bottom: 8px;
    }

    .chip-user {
      font-size: 0.8rem;
      padding: 4px 10px;
    }

    .desc-wrap {
      font-size: 0.85rem;
      max-height: 75px;
      line-height: 1.4;
    }

    textarea.form-control {
      font-size: 0.85rem;
      padding: 8px 10px;
    }

    .btn-solve {
      font-size: 0.85rem;
      padding: 8px 10px;
      border-radius: 10px;
    }
  }

  </style>
</head>

<body class="py-5">
  <div class="container">
    <!-- Header -->
    <div class="page-header">
      <div class="page-title">
        <i class="bi bi-tools"></i>
        <h2 class="m-0 fw-bold">Solve Blocker</h2>
      </div>
      <a href="{{ route('teamlead.dashboard') }}" class="btn-back d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
      </a>
    </div>

    @if($blockers->isEmpty())
      <div class="alert alert-success text-center py-3">
        🎉 Semua subtaks berjalan lancar. Tidak ada blocker saat ini.
      </div>
    @else
      <div class="row g-4">
        @foreach($blockers as $subtask)
          <div class="col-12 col-md-6 col-lg-4 col-card">
            <div class="blocker-card w-100">
              <h5 class="blocker-title">{{ $subtask->subtask_title }}</h5>

              <div class="mb-3">
                <span class="chip-user">
                  <i class="bi bi-person-fill"></i>
                  {{ $subtask->assignedUser->user->username ?? 'Belum dikerjakan' }}
                </span>
              </div>

              <div class="meta">
                <p>
                  <i class="bi bi-kanban"></i>
                  <span class="label-strong">Proyek:</span>
                  {{ $subtask->card->board->project->project_name ?? '-' }}
                </p>

                <div class="mb-2">
                  <i class="bi bi-card-text"></i>
                  <span class="label-strong">Deskripsi:</span>
                </div>

                <div class="desc-wrap mt-1">
                    @php
                        $desc = $subtask->description ?? 'Tidak ada deskripsi';
                        $desc = trim($desc); // hilangkan enter awal/akhir
                        $desc = e($desc); // escape dulu semua teks
                        $desc = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $desc);
                        // ubah nl2br jadi versi manual agar tidak tambahkan <br> pertama
                        $desc = str_replace("\n", "<br>", $desc);
                    @endphp
                    {!! $desc !!}
                </div>

                <p>
                  <i class="bi bi-exclamation-triangle text-danger"></i>
                  <span class="label-strong">Alasan Blocker:</span>
                  {{ $subtask->block_reason ?? '-' }}
                </p>
              </div>

              <form action="{{ route('subtasks.solveBlockerAction', $subtask->subtask_id) }}" method="POST" class="mt-3">
                @csrf
                <textarea
                  name="solution"
                  rows="2"
                  class="form-control mb-3"
                  placeholder="Tulis solusi dari hambatan ini..."
                  required
                  style="border-radius:10px"></textarea>

                <button type="submit" class="btn-solve w-100">
                  <i class="bi bi-check-circle me-1"></i> Tandai Selesai
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</body>
</html>
