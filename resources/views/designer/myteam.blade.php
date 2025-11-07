<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <title>Tim Saya</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1e3a8a;
      --bg-main: #f1f5f9;
      --text-dark: #1e293b;
      --shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    body {
      background: var(--bg-main);
      font-family: "Inter", "Poppins", sans-serif;
      padding: 50px 20px;
    }

     /* Tombol kembali di pojok kanan atas */
    .top-right {
      position: relative;  
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
      box-shadow: 0 4px 12px rgba(37,99,235,0.25);
      transition: 0.3s;
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #1e40af, #1e3a8a);
      transform: translateY(-2px);
      color: #fff;
    }

    h1 {
      font-weight: 700;
      color: var(--primary-dark);
      text-align: center;
      margin-bottom: 50px;
    }

    .project-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
      margin-bottom: 40px;
    }

    .project-header {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #fff;
      padding: 20px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }

    .project-header h5 {
      margin: 0;
      font-weight: 700;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .status-pill {
      background: #fff;
      color: var(--primary-dark);
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 0.85rem;
      text-transform: capitalize;
    }

    .member-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 18px;
      padding: 25px;
    }

    .member-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: var(--shadow);
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
      transition: all 0.25s ease;
    }

    /* Hover efek biru muda */
    .member-card:hover {
      transform: translateY(-4px);
      background: #ebf5ff;
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
      cursor: pointer;
    }

    /* Efek klik */
    .member-card:active {
      background: #dbeafe;
      transform: scale(0.98);
    }

    .avatar {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: #fff;
      font-weight: 700;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .member-info {
      display: flex;
      flex-direction: column;
    }

    .member-info strong {
      font-size: 1rem;
      color: var(--text-dark);
    }

    .member-info small {
      color: #64748b;
      font-size: 0.9rem;
    }

    .role-badge {
      display: inline-block;
      margin-top: 6px;
      font-size: 0.75rem;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 10px;
    }

    .bg-admin { background: #fee2e2; color: #b91c1c; }
    .bg-teamlead { background: #fef3c7; color: #92400e; }
    .bg-developer { background: #dbeafe; color: #1e3a8a; }
    .bg-designer { background: #e0f2fe; color: #075985; }

     /* Responsif untuk layar kecil */
    @media (max-width: 576px) {
      body {
        padding: 30px 15px;
      }

      .top-right {
        text-align: left; /* tombol pindah ke kiri */
      }

      .btn-back {
        padding: 8px 14px;
        font-size: 0.9rem;
      }

      h1 {
        font-size: 1.6rem;
        margin-bottom: 30px;
      }

      .project-header h5 {
        font-size: 1rem;
      }

      .status-pill {
        font-size: 0.8rem;
      }
    }
    
  </style>
</head>

<body>
  <!-- Tombol kembali pojok kanan atas -->
  <div class="top-right">
    <a href="{{ route('designer.dashboard') }}" class="btn-back">
      <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
  </div>

  <div class="container">
    <h1><i class="bi bi-people-fill text-primary"></i> Anggota Tim Saya</h1>

    @if($hasApprovedOnly || $projects->isEmpty())
      <div class="alert alert-info text-center py-3">
        <i class="bi bi-info-circle"></i> Belum ada project.
      </div>
    @else
      @foreach($projects as $project)
        @if($project->status !== 'approved')
          <div class="project-card">
            <div class="project-header">
              <h5>📌 {{ $project->project_name }}</h5>
              <span class="status-pill">{{ ucfirst($project->status) }}</span>
            </div>

            <div class="member-grid">
              @foreach($project->members as $m)
                <div class="member-card">
                  <div class="avatar">{{ strtoupper(substr($m->user->username, 0, 1)) }}</div>
                  <div class="member-info">
                    <strong>{{ $m->user->full_name }}</strong>
                    <small><i class="bi bi-person"></i> {{ $m->user->username }}</small>
                    <small><i class="bi bi-envelope"></i> {{ $m->user->email }}</small>
                    <span class="role-badge 
                      @if($m->user->role=='admin') bg-admin 
                      @elseif($m->user->role=='team_lead') bg-teamlead 
                      @elseif($m->user->role=='developer') bg-developer 
                      @else bg-designer @endif">
                      {{ ucfirst(str_replace('_',' ', $m->user->role)) }}
                    </span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach
    @endif
  </div>
</body>
</html>
