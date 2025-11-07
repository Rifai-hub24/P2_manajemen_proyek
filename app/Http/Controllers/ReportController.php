<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 🔹 Halaman filter laporan
    public function index()
    {
        return view('admin.reports.index');
    }

    // 🔹 Generate laporan semua project berdasarkan tanggal
    public function generate(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;
        $adminId = auth()->id(); // ✅ Ambil ID admin yang sedang login

        // Query dasar: hanya proyek milik admin yang login
        $query = Project::where('created_by', $adminId)
                    ->orderBy('created_at', 'asc');

        // Filter tanggal jika diisi
        if ($start && $end) {
            $query->whereBetween('created_at', [
                Carbon::parse($start)->startOfDay(),
                Carbon::parse($end)->endOfDay()
            ]);
        }


        $projects = $query->get();

        // Jika tidak ada data
        if ($projects->isEmpty()) {
            return back()->with('error', '❌ Tidak ada proyek pada periode yang dipilih.');
        }

        // Format label tanggal agar rapi di PDF
        $startLabel = $start ? Carbon::parse($start)->format('d M Y') : 'Semua';
        $endLabel   = $end ? Carbon::parse($end)->format('d M Y') : 'Semua';

        // Render PDF
        $pdf = Pdf::loadView('admin.reports.period', [
            'projects' => $projects,
            'start' => $startLabel,
            'end' => $endLabel,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Laporan_Proyek.pdf");
    }


    // 🔹 Generate laporan per proyek (tombol di card)
    public function projectReport(Project $project)
    {
        // pastikan relasi members dan user ikut dimuat
        $project->load(['members.user']);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.project', [
            'project' => $project,
        ])->setPaper('a4', 'portrait')
        ->stream("Laporan_Proyek_{$project->project_name}.pdf");
    }
}