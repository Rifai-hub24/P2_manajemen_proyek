<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Proyek</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      color: #111;
      margin: 25px;
    }

    h2 {
      text-align: center;
      color: #2563eb;
      margin-bottom: 5px;
    }

    p.periode {
      text-align: center;
      font-size: 12px;
      color: #555;
      margin-top: 0;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #333;
      padding: 6px;
      text-align: left;
      vertical-align: top;
    }

    th {
      background: #2563eb;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f8fafc;
    }

    td small {
      color: #6b7280;
    }
  </style>
</head>
<body>

  <!-- Judul & Periode -->
  <h2>Laporan Proyek</h2>
  <p class="periode">
    @if($start !== 'Semua' && $end !== 'Semua')
      Periode: {{ $start }} - {{ $end }}
    @else
      Periode: Semua Waktu
    @endif
  </p>

  <!-- Tabel Laporan -->
  <table>
    <thead>
      <tr>
        <th style="width: 30px;">No</th>
        <th>Nama Proyek</th>
        <th style="width: 80px;">Dibuat</th>
        <th style="width: 80px;">Deadline</th>
        <th style="width: 85px;">Status</th>
        <th style="width: 110px;">Status Waktu</th>
        <th>Deskripsi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($projects as $i => $project)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $project->project_name }}</td>
          <td>{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</td>
          <td>{{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : '-' }}</td>
          <td>{{ ucfirst($project->status) }}</td>
          <td>
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
          </td>
          <td>{{ $project->description ?? '-' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7" align="center">Tidak ada proyek pada periode yang dipilih.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

</body>
</html>