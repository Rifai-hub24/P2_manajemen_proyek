<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>👥 Manajemen User - Project PRO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg-main: #f3f6fb;
      --bg-card: #ffffff;
      --primary: linear-gradient(135deg, #2563eb, #1e3a8a);
      --primary-dark: linear-gradient(135deg, #1e40af, #1e3a8a);
      --success: #22c55e;
      --danger: #ef4444;
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
      --radius: 18px;
    }

    body {
      font-family: "Inter", "Poppins", sans-serif;
      background: var(--bg-main);
      color: var(--text-dark);
    }

    .container {
      max-width: 1200px;
      animation: fadeIn 0.6s ease-in-out;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .btn-back {
      background: var(--primary);
      color: #fff !important;
      border: none;
      border-radius: 10px;
      padding: 8px 18px;
      font-weight: 600;
      transition: 0.25s ease;
      box-shadow: 0 4px 10px rgba(37,99,235,0.25);
    }

    .btn-back:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }

    .user-card {
      background: var(--bg-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 1.8rem;
      height: 100%;
      transition: all 0.35s ease;
    }

    .user-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(37,99,235,0.12);
    }

    .avatar {
      width: 70px;
      height: 70px;
      background: linear-gradient(145deg, #dbeafe, #bfdbfe);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem auto;
      box-shadow: 0 4px 10px rgba(37,99,235,0.25);
    }

    .avatar i {
      font-size: 2rem;
      color: var(--primary-dark);
    }

    .user-info {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .user-info h5 {
      font-weight: 600;
      margin-bottom: 4px;
    }

    .user-info p {
      color: var(--text-muted);
      font-size: 0.9rem;
      margin-bottom: 6px;
    }

    .form-select {
      border-radius: 10px;
      font-size: 0.9rem;
      border: 1px solid var(--border);
      background-color: #f9fafb;
    }

    .btn-modern {
      border-radius: 10px;
      font-weight: 500;
      transition: all 0.25s ease;
      width: 100%;
      padding: 10px 0;
    }

    .btn-approve {
      background: linear-gradient(135deg, #4ade80, #22c55e);
      color: #fff;
      border: none;
    }

    .btn-approve:hover {
      background: linear-gradient(135deg, #16a34a, #15803d);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(34,197,94,0.25);
    }

    .btn-reject {
      background: linear-gradient(135deg, #f87171, #ef4444);
      color: #fff;
      border: none;
    }

    .btn-reject:hover {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239,68,68,0.25);
    }

    .alert {
      border-radius: 10px;
      border: none;
      box-shadow: var(--shadow);
      margin-bottom: 1.5rem;
    }

    .alert-success {
      background: rgba(34,197,94,0.12);
      color: #15803d;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
     /* 📱 RESPONSIVE STYLES */
    @media (max-width: 992px) {
      .col-md-6.col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
      }
    }

    @media (max-width: 768px) {
      body {
        padding: 15px;
      }

      .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }

      .page-header h2 {
        font-size: 1.4rem;
      }

      .btn-back {
        font-size: 0.9rem;
        padding: 8px 16px; /* ✅ tidak terlalu lebar */
        width: auto;       /* ✅ menyesuaikan isi */
        display: inline-block;
      }

      .col-md-6.col-lg-4 {
        flex: 0 0 100%;
        max-width: 100%;
      }

      .user-card {
       padding: 1.5rem;
      }

      .user-info h5 {
        font-size: 1rem;
      }

      .form-select {
        font-size: 0.85rem;
      }

      .btn-modern {
        padding: 8px 0;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      .page-header h2 {
      font-size: 1.2rem;
      }

      .avatar {
        width: 60px;
        height: 60px;
      }

      .avatar i {
        font-size: 1.6rem;
      }

      .btn-back {
        font-size: 0.85rem;
        padding: 7px 14px; /* ✅ lebih kecil di HP mini */
      }
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="page-header">
      <h2><i class="bi bi-people-fill text-primary"></i> Manajemen User</h2>
      <a href="{{ route('dashboard') }}" class="btn btn-back">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
      </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
      <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
      </div>
    @endif

    <div class="row">
      @foreach($users as $user)
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="user-card text-center">
            <div class="avatar">
              <i class="bi bi-person-fill"></i>
            </div>

            <div class="user-info">
              <h5>{{ $user->full_name }}</h5>
              <p>{{ $user->username }}</p>
              <p><i class="bi bi-envelope"></i> {{ $user->email }}</p>
            </div>

            <!-- APPROVE FORM -->
            <form method="POST" action="{{ route('users.approve', $user->user_id) }}" class="mb-2">
              @csrf
              <select name="role" class="form-select mb-3" required>
                <option value="developer">Developer</option>
                <option value="designer">Designer</option>
                <option value="team_lead">Team Lead</option>
                <option value="admin">Admin</option>
              </select>
              <button type="submit" class="btn btn-approve btn-modern">
                <i class="bi bi-check-circle"></i> Approve
              </button>
            </form>

            <!-- REJECT FORM -->
            <form method="POST" action="{{ route('users.reject', $user->user_id) }}">
              @csrf
              <button type="submit" class="btn btn-reject btn-modern">
                <i class="bi bi-x-circle"></i> Reject
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
