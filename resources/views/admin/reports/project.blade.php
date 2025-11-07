<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Proyek: {{ $project->project_name }}</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      color: #111;
      margin: 25px;
    }

    h2 {
      color: #2563eb;
      text-align: center;
      margin-bottom: 15px;
    }

    h4 {
      color: #111;
      margin-top: 15px;
    }

    p {
      margin: 5px 0;
      line-height: 1.4;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #444;
      padding: 6px 8px;
      text-align: left;
    }

    th {
      background-color: #2563eb;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9fafb;
    }

    .section {
      margin-bottom: 20px;
    }

    .no-data {
      color: #777;
      font-style: italic;
      margin-top: 5px;
    }

    .badge {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: bold;
      color: #fff;
    }
    .badge.success { background: #16a34a; }
    .badge.warning { background: #facc15; color: #111; }
    .badge.danger  { background: #dc2626; }
    .badge.gray    { background: #6b7280; }
  </style>
</head>

<body>
  <h2>Laporan Detail Proyek</h2>

  <div class="section">
    <p><strong>Nama Proyek:</strong> {{ $project->project_name }}</p>
    <p><strong>Tanggal Dibuat:</strong> 
      {{ $project->created_at ? \Carbon\Carbon::parse($project->created_at)->format('d M Y') : '-' }}
    </p>
    <p><strong>Deadline:</strong> 
      {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}
    </p>
    <p><strong>Status Proyek:</strong> 
      @php
        $status = ucfirst($project->status);
      @endphp
      {{ $status }}
    </p>

   <p><strong>Status Waktu:</strong>
    @if(in_array($project->status, ['draft','rejected']))
      Belum Dikirim
    @elseif($project->status === 'pending')
      Menunggu Persetujuan
    @elseif($project->status === 'approved')
      @if($project->deadline && \Carbon\Carbon::parse($project->deadline)->isPast())
        Terlambat
      @else
        Tepat Waktu
      @endif
    @else
      Tidak Diketahui
    @endif
  </p>


    <p><strong>Deskripsi:</strong><br>
      {{ $project->description ?? '-' }}
    </p>
  </div>

  <div class="section">
    <h4>👥 Anggota Tim</h4>
    @if($project->members && $project->members->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Role</th>
            <th>Tanggal Bergabung</th>
          </tr>
        </thead>
        <tbody>
          @foreach($project->members->sortBy(function($m) {
              return match($m->role) {
                'admin' => 1,
                'team_lead' => 2,
                'developer' => 3,
                'designer' => 4,
                default => 5,
              };
          }) as $member)
            <tr>
              <td>{{ $member->user->full_name ?? 'Tidak ditemukan' }}</td>
              <td>{{ ucfirst($member->role ?? '-') }}</td>
              <td>{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('d M Y') : '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p class="no-data">Tidak ada anggota yang tergabung.</p>
    @endif
  </div>

</body>
</html>