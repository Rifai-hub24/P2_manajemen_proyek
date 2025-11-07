<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Proyek - Project PRO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e40af;
      --accent: #3b82f6;
      --success: #22c55e;
      --danger: #ef4444;
      --warning: #f59e0b;
      --gray: #f8fafc;
      --card-bg: #ffffff;
      --text-dark: #0f172a;
      --text-muted: #64748b;
      --radius: 16px;
      --shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--gray);
      color: var(--text-dark);
    }

    .container {
      max-width: 950px;
    }

    /* Header */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: white;
      background: var(--primary);
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }

    .back-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }

    .page-header h3 {
      font-weight: 700;
      color: var(--primary);
      letter-spacing: -0.5px;
    }

    /* Card */
    .card {
      border: none;
      border-radius: var(--radius);
      background: var(--card-bg);
      box-shadow: var(--shadow);
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-2px);
    }

    .card-header {
      font-weight: 600;
      border-radius: var(--radius) var(--radius) 0 0;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      color: white;
    }

    .project-info {
      background: linear-gradient(135deg, #ffffff, #f1f5ff);
      border-radius: var(--radius);
      padding: 2rem;
      box-shadow: inset 0 0 0 1px #e2e8f0;
    }

    .project-info h2 {
      font-weight: 700;
      color: var(--primary-dark);
    }

    .project-info .desc {
      font-size: 1rem;
      color: var(--text-muted);
    }

    .badge {
      font-size: 0.85rem;
      padding: 6px 10px;
      border-radius: 8px;
    }

    .list-group-item {
      border: none;
      border-bottom: 1px solid #e2e8f0;
      transition: 0.2s;
    }

    .list-group-item:hover {
      background: #f9fafc;
    }

    .btn-modern {
      border-radius: 10px;
      font-weight: 500;
      transition: 0.25s ease;
    }

    .btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert {
      border: none;
      border-radius: 10px;
      box-shadow: var(--shadow);
    }
    /* === HEADER RESPONSIVE === */
    .page-header {
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 10px;
    }

    /* Tombol kembali */
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: white;
      background: var(--primary);
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
      .container {
        padding: 0 15px;
      }

      .page-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
      }

      .project-info {
        padding: 1.5rem;
      }

      .project-info h2 {
        font-size: 1.3rem;
      }

      .desc {
        font-size: 0.95rem;
      }

      .card-header {
        font-size: 1rem;
      }

      .list-group-item {
        font-size: 0.95rem;
      }

      .d-flex.justify-content-between.align-items-start.flex-wrap {
        flex-direction: column;
        gap: 0.8rem;
      }

      .back-btn {
       width: auto; 
       justify-content: center;
       align-self: flex-start;
      }
    }

    @media (max-width: 576px) {
      .page-header h3 {
        font-size: 1.2rem;
      }

      .project-info {
        padding: 1.2rem;
      }

      .card-body form {
        flex-direction: column;
      }

      .card-body .col-md-10,
      .card-body .col-md-2 {
        width: 100% !important;
      }

      .btn-modern {
        width: 100%;
      }

      .list-group-item.d-flex {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.6rem;
      }

      .form-control-sm.w-auto {
        width: 100% !important;
      }
    }

  </style>
</head>
<body>

<div class="container py-5">

  <!-- Header -->
  <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
    <h3 class="mb-3 mb-md-0"><i class="bi bi-kanban"></i> Detail Proyek</h3>
    <a href="{{ route('dashboard') }}" class="back-btn">
      <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
    </a>
  </div>


  <!-- Notifikasi -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Info Proyek -->
  <div class="project-info mb-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap">
      <div>
        <h2>{{ $project->project_name }}</h2>
        <p class="desc mb-2">{{ $project->description ?? 'Tidak ada deskripsi proyek.' }}</p>
        <p class="text-muted mb-1"><i class="bi bi-calendar-event"></i> 
          Deadline: {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
        </p>
        <p class="mb-0"><i class="bi bi-info-circle"></i> Status:
          @if($project->status == 'draft')
            <span class="badge bg-secondary">Draft</span>
          @elseif($project->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
          @elseif($project->status == 'approved')
            <span class="badge bg-success">Approved</span>
          @elseif($project->status == 'rejected')
            <span class="badge bg-danger">Rejected</span>
          @endif
        </p>
      </div>
      <i class="bi bi-folder-fill fs-1 text-primary opacity-25"></i>
    </div>
  </div>

  <!-- Boards -->
  <div class="card mb-4">
    <div class="card-header">
      <i class="bi bi-columns-gap"></i> Boards
    </div>
    <ul class="list-group list-group-flush">
      @forelse($project->boards as $board)
        <li class="list-group-item">{{ $board->board_name }}</li>
      @empty
        <li class="list-group-item text-muted">Belum ada board</li>
      @endforelse
    </ul>
  </div>

  <!-- Anggota -->
  <div class="card mb-4">
    <div class="card-header bg-success">
      <i class="bi bi-people-fill"></i> Anggota Proyek
    </div>
    <ul class="list-group list-group-flush">
      @forelse($project->members as $member)
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
          <div class="d-flex align-items-center gap-2">
            <strong>{{ $member->user->full_name }}</strong>
            <span class="badge bg-secondary">{{ ucfirst($member->role) }}</span>
          </div>
          @if($project->status !== 'approved' && !$hasStarted && !$hasDone)
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
              <form action="{{ route('projects.members.updateUser', $member->member_id) }}" method="POST" class="d-flex align-items-center gap-2">
                @csrf
                @method('PUT')
                <input type="text" name="username" value="{{ $member->user->username }}" 
                       class="form-control form-control-sm w-auto" placeholder="Username baru">
                <button type="submit" class="btn btn-sm btn-warning btn-modern"><i class="bi bi-pencil"></i></button>
              </form>
              <form action="{{ route('projects.members.delete', $member->member_id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger btn-modern"><i class="bi bi-trash"></i></button>
              </form>
            </div>
          @else
            <span class="text-muted small">🚫 Tidak bisa edit/hapus</span>
          @endif
        </li>
      @empty
        <li class="list-group-item text-muted">Belum ada anggota</li>
      @endforelse
    </ul>
  </div>

  <!-- Tambah Anggota -->
  @if($project->status !== 'approved')
    <div class="card">
      <div class="card-header bg-info">
        <i class="bi bi-person-plus"></i> Tambah Anggota
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('projects.members.add', $project->project_id) }}" class="row g-3">
          @csrf
          <div class="col-md-10">
            <input type="text" name="username" class="form-control" placeholder="Masukkan username anggota..." required>
          </div>
          <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-info text-white btn-modern">
              <i class="bi bi-plus-circle"></i> Tambah
            </button>
          </div>
        </form>
      </div>
    </div>
  @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
