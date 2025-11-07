<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>👥 Anggota Tim Saya</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-light: #dbeafe;
      --secondary: #f8fafc;
      --accent: #60a5fa;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --card-bg: #ffffff;
      --shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      --radius: 22px;
    }

    body {
      background: linear-gradient(145deg, #f0f4ff, #ffffff);
      font-family: "Inter", "Poppins", sans-serif;
      color: var(--text-dark);
      min-height: 100vh;
      padding: 40px 20px 80px;
      position: relative;
    }

    /* 🔹 Tombol Kembali di Kanan Atas */
    .btn-dashboard {
      position: absolute;
      top: 30px;
      right: 30px;
      border-radius: 12px;
      font-weight: 600;
      padding: 10px 25px;
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      color: white;
      border: none;
      box-shadow: 0 4px 18px rgba(6, 182, 212, 0.35);
      transition: all 0.3s ease;
      z-index: 10;
    }

    .btn-dashboard:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      color: white;
      box-shadow: 0 6px 25px rgba(14, 165, 233, 0.45);
    }

    h1 {
      font-weight: 700;
      color: var(--primary);
      text-shadow: 0 2px 4px rgba(37, 99, 235, 0.15);
    }

    .subtitle {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 45px;
    }

    /* Project Card */
    .project-card {
      border: none;
      border-radius: var(--radius);
      background: var(--card-bg);
      box-shadow: var(--shadow);
      transition: all 0.35s ease;
      overflow: hidden;
      transform: scale(1);
    }

    .project-card:hover {
      transform: translateY(-6px) scale(1.01);
      box-shadow: 0 10px 30px rgba(37, 99, 235, 0.12);
    }

    .project-header {
      background: linear-gradient(135deg, #2563eb, #1e40af);
      color: #fff;
      padding: 18px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 1.05rem;
    }

    .project-header .badge-status {
      background: #fff;
      color: var(--primary);
      border-radius: 20px;
      font-size: 0.8rem;
      padding: 5px 12px;
      font-weight: 600;
    }

    .card-body {
      padding: 30px;
      background: var(--secondary);
    }

    /* Member Card */
    .member-card {
      border: none;
      border-radius: 18px;
      background: var(--card-bg);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
      padding: 24px 20px;
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
    }

    .member-card:hover {
      transform: scale(1.02);
      background: var(--primary-light);
    }

    .member-avatar {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2563eb, #60a5fa);
      color: white;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 16px;
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
    }

    .member-info h6 {
      font-weight: 600;
      margin-bottom: 3px;
      color: var(--text-dark);
    }

    .member-info p {
      font-size: 0.9rem;
      margin-bottom: 4px;
      color: var(--text-muted);
    }

    /* Role Badge */
    .role-badge {
      padding: 5px 10px;
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: capitalize;
    }

    .role-admin { background: #fee2e2; color: #991b1b; }
    .role-team_lead { background: #fef3c7; color: #92400e; }
    .role-developer { background: #dbeafe; color: #1e3a8a; }
    .role-designer { background: #e0f2fe; color: #075985; }

    .alert {
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    @media (max-width: 768px) {
      .btn-dashboard {
        position: static;
        display: block;
        margin: 0 auto 20px;
      }
    }
    /* ==============================
    💻 Tablet (max-width: 992px)
    ============================== */
    @media (max-width: 992px) {
      body {
        padding: 30px 15px 60px;
      }

      h1 {
        font-size: 1.8rem;
      }

      .subtitle {
        font-size: 0.9rem;
        margin-bottom: 35px;
      }

      .btn-dashboard {
        position: static;
        display: inline-block;
        margin: 0 auto 20px;
        padding: 8px 20px;
        font-size: 0.95rem;
      }

      .project-card {
        border-radius: 18px;
      }

      .project-header {
        font-size: 0.95rem;
        padding: 14px 20px;
      }

      .card-body {
        padding: 20px;
      }

      .member-card {
        padding: 18px;
        flex-direction: row;
      }

      .member-avatar {
        width: 55px;
        height: 55px;
        font-size: 1.2rem;
        margin-right: 14px;
      }

      .member-info h6 {
        font-size: 0.95rem;
      }

      .member-info p {
        font-size: 0.85rem;
      }

      .role-badge {
        font-size: 0.75rem;
      }
    }

    /* ==============================
    📱 HP besar (max-width: 768px)
     ============================== */
    @media (max-width: 768px) {
      body {
        padding: 25px 10px 50px;
      }

      .btn-dashboard {
        width: auto;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 10px;
      }

      .text-center.mb-5 {
        margin-bottom: 35px;
      }

      .subtitle {
        font-size: 0.85rem;
        margin-bottom: 25px;
      }

      .project-card {
        margin-bottom: 25px;
        border-radius: 16px;
      }

      .project-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        font-size: 0.9rem;
      }

      .badge-status {
        font-size: 0.75rem;
        align-self: flex-end;
      }

      .member-card {
        padding: 16px;
        flex-direction: row;
        align-items: flex-start;
      }

      .member-avatar {
        width: 50px;
        height: 50px;
        font-size: 1.1rem;
        margin-right: 12px;
      }

      .member-info h6 {
        font-size: 0.9rem;
      }

      .member-info p {
        font-size: 0.8rem;
      }

      .role-badge {
        font-size: 0.7rem;
        padding: 4px 8px;
      }
    }

    /* ==============================
    📱 HP kecil (max-width: 576px)
    ============================== */
    @media (max-width: 576px) {
      body {
        padding: 20px 8px 40px;
      }

      h1 {
        font-size: 1.4rem;
      }

      .btn-dashboard {
        display: block;
        width: fit-content;
        margin: 0 auto 20px 3%;
        padding: 7px 14px;
        font-size: 0.85rem;
        border-radius: 8px;
      }

      .project-card {
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
      }

      .project-header {
        padding: 12px 16px;
        font-size: 0.85rem;
      }

      .badge-status {
        font-size: 0.7rem;
        padding: 4px 8px;
      }

      .card-body {
        padding: 15px;
      }

      .col-lg-4.col-md-6 {
        width: 100%;
      }

      .member-card {
        padding: 14px;
        flex-direction: row;
        margin: 0 auto;
        border-radius: 14px;
        max-width: 370px; /* ⬅️ Card tidak full layar */
      }

      .member-avatar {
        width: 45px;
        height: 45px;
        font-size: 1rem;
        margin-right: 10px;
      }

      .member-info h6 {
        font-size: 0.9rem;
        margin-bottom: 3px;
      }

      .member-info p {
        font-size: 0.8rem;
        margin-bottom: 2px;
      }

      .role-badge {
        font-size: 0.7rem;
        padding: 3px 7px;
      }
    }

  </style>
</head>

<body>
  <!-- 🔝 Tombol Kembali -->
  <a href="{{ route('teamlead.dashboard') }}" class="btn btn-dashboard">
    <i class="bi bi-arrow-left-circle"></i> Kembali 
  </a>

  <div class="container">
    <div class="text-center mb-5">
      <h1><i class="bi bi-people-fill"></i> Anggota Tim Saya</h1>
      <p class="subtitle">Pantau seluruh anggota dalam setiap proyek yang Anda pimpin</p>
    </div>

    @php
      $jumlahProject = $projects->count();
      $approvedCount = $projects->where('status', 'approved')->count();
      $unapprovedProjects = $projects->where('status', '!=', 'approved');
    @endphp

    @if($jumlahProject === 0)
      <div class="alert alert-info text-center">
        <i class="bi bi-info-circle"></i> Belum ada proyek yang Anda pimpin.
      </div>

    @elseif($jumlahProject === 1 && $approvedCount === 1)
      <div class="alert alert-warning text-center">
        <i class="bi bi-check-circle"></i> Semua proyek Anda sudah disetujui.
      </div>

    @else
      <div class="row g-5">
        @foreach($unapprovedProjects as $project)
          <div class="col-12">
            <div class="project-card">
              <div class="project-header">
                <span>📌 {{ $project->project_name }}</span>
                <span class="badge-status">{{ ucfirst($project->status) }}</span>
              </div>

              <div class="card-body">
                <div class="row g-4">
                  @forelse($project->members as $m)
                    <div class="col-lg-4 col-md-6">
                      <div class="member-card">
                        <div class="member-avatar">
                          {{ strtoupper(substr($m->user->full_name, 0, 1)) }}
                        </div>
                        <div class="member-info">
                          <h6>{{ $m->user->full_name }}</h6>
                          <p><i class="bi bi-person"></i> {{ $m->user->username }}</p>
                          <p><i class="bi bi-envelope"></i> {{ $m->user->email }}</p>
                          <span class="role-badge role-{{ $m->user->role }}">
                            {{ ucfirst(str_replace('_', ' ', $m->user->role)) }}
                          </span>
                        </div>
                      </div>
                    </div>
                  @empty
                    <div class="col-12">
                      <div class="alert alert-secondary text-center">
                        <i class="bi bi-info-circle"></i> Belum ada anggota dalam proyek ini.
                      </div>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
