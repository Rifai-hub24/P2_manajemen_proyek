<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monitoring Proyek - {{ $project->project_name }}</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b82f6;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #8b5cf6;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --gray-border: #e2e8f0;
            --dark: #111827;
            --white: #ffffff;
            --radius: 16px;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: "Inter", sans-serif; 
            background: #f8fafc; 
            padding: 12px; 
            color: var(--dark); 
            line-height: 1.6; 
            font-size: 14px;
        }
        .container { 
            max-width: 1280px; 
            margin: auto; 
        }

        /* Header dengan tombol kembali */
        .header-container {
            position: relative;
            margin-bottom: 16px;
        }

        header {
            background: var(--white);
            padding: 16px;
            border-radius: var(--radius);
            border: 1px solid var(--gray-border);
            box-shadow: var(--shadow);
            position: relative;
        }

        /* Tombol Kembali */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .back-button:active {
            transform: translateY(0);
        }

        .header-content {
            text-align: center;
        }

        h1 { 
            font-size: 1.3rem; 
            font-weight: 700; 
            display: flex; 
            gap: 8px; 
            align-items: center; 
            flex-wrap: wrap;
            justify-content: center;
        }
        .project-name { 
            color: var(--primary); 
            background: rgba(59, 130, 246, 0.1); 
            padding: 4px 10px; 
            border-radius: 16px; 
            font-size: 0.85em; 
        }
        .subtitle { 
            color: var(--gray); 
            margin-top: 6px; 
            font-size: 0.85rem; 
        }

        .summary-grid { 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 12px; 
            margin-bottom: 20px; 
        }
        .summary-card { 
            background: var(--white); 
            padding: 16px; 
            border-radius: var(--radius); 
            border: 1px solid var(--gray-border); 
            box-shadow: var(--shadow); 
            text-align: center;
        }
        .summary-icon { 
            width: 36px; 
            height: 36px; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 8px; 
            font-size: 1rem; 
        }
        .dev-icon { background: rgba(59, 130, 246, 0.1); color: var(--primary); }
        .designer-icon { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
        .card-icon { background: rgba(139, 92, 246, 0.1); color: var(--info); }
        .summary-title { 
            font-size: 0.75rem; 
            color: var(--gray); 
            margin-bottom: 6px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .summary-value { 
            font-size: 1.4rem; 
            font-weight: 700; 
            color: var(--dark); 
            display: flex; 
            align-items: baseline; 
            justify-content: center;
            gap: 4px; 
        }
        .summary-unit { 
            font-size: 0.8rem; 
            color: var(--gray); 
            font-weight: 500; 
        }

        /* Layout grid untuk chart */
        .chart-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .chart-row {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .chart-card { 
            background: var(--white); 
            border-radius: var(--radius); 
            border: 1px solid var(--gray-border); 
            padding: 16px; 
            box-shadow: var(--shadow); 
        }
        .chart-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start;
            margin-bottom: 12px; 
            flex-wrap: wrap;
            gap: 8px;
        }
        .chart-title { 
            font-size: 1rem; 
            font-weight: 600; 
            color: var(--dark); 
            display: flex; 
            align-items: center; 
            gap: 6px; 
        }
        .chart-icon { 
            width: 26px; 
            height: 26px; 
            border-radius: 6px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: rgba(59, 130, 246, 0.1); 
            color: var(--primary); 
            font-size: 0.9rem;
        }
        .chart-wrapper { 
            height: 220px; 
            width: 100%; 
            position: relative; 
        }

        .progress-indicators { 
            display: flex; 
            gap: 8px; 
            margin-top: 10px; 
            flex-wrap: wrap; 
            justify-content: center;
        }
        .progress-indicator { 
            display: flex; 
            align-items: center; 
            gap: 4px; 
            font-size: 0.7rem; 
            color: var(--gray); 
        }
        .indicator-color { 
            width: 8px; 
            height: 8px; 
            border-radius: 50%; 
        }
        .performance-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 4px; 
            padding: 3px 8px; 
            border-radius: 16px; 
            font-size: 0.7rem; 
            font-weight: 600; 
        }
        .badge-high { 
            background: rgba(16, 185, 129, 0.1); 
            color: var(--success); 
        }

        /* Mobile - tombol di kiri atas */
        .back-button-mobile {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
            border: none;
            cursor: pointer;
            white-space: nowrap;
            margin-bottom: 12px;
            width: auto; /* Tidak full width */
        }

        .back-button-mobile:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .back-button-mobile:active {
            transform: translateY(0);
        }

        /* Tablet */
        @media (min-width: 768px) {
            body { padding: 16px; font-size: 15px; }
            
            .header-container {
                margin-bottom: 20px;
            }
            
            header { 
                padding: 20px; 
            }
            
            .back-button {
                position: absolute;
                top: 20px;
                right: 20px;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .header-content {
                padding-right: 160px;
                text-align: left;
            }
            
            h1 { 
                font-size: 1.5rem; 
                justify-content: flex-start;
            }
            
            .summary-grid { 
                grid-template-columns: repeat(3, 1fr); 
                gap: 16px; 
                margin-bottom: 24px; 
            }
            
            .summary-card { 
                padding: 20px; 
                text-align: center; 
            }
            
            .summary-icon { margin: 0 auto 12px; }
            
            .summary-value { justify-content: center; }
            
            .chart-row { 
                flex-direction: row; 
                gap: 16px; 
            }
            
            .chart-card { 
                flex: 1; 
                padding: 18px; 
            }
            
            .chart-wrapper { height: 250px; }
        }

        /* Desktop */
        @media (min-width: 1024px) {
            body { padding: 20px; }
            
            .header-container {
                margin-bottom: 24px;
            }
            
            header { padding: 24px; }
            
            .back-button {
                top: 24px;
                right: 24px;
            }
            
            .header-content {
                padding-right: 180px;
            }
            
            h1 { font-size: 1.6rem; }
            
            .summary-grid { 
                gap: 20px; 
            }
            
            .chart-row { gap: 20px; }
            
            .chart-card { padding: 20px; }
            
            .chart-wrapper { height: 280px; }
            
            .chart-title { font-size: 1.1rem; }
            
            .progress-indicators { justify-content: flex-start; }
        }

        /* Very small phones */
        @media (max-width: 360px) {
            body { padding: 8px; }
            
            .back-button-mobile {
                padding: 8px 12px;
                font-size: 0.8rem;
                width: auto; /* Tetap tidak full width */
            }
            
            .summary-grid { 
                gap: 10px; 
            }
            
            .summary-card { padding: 14px; }
            
            .chart-card { padding: 14px; }
            
            .chart-wrapper { height: 200px; }
            
            .chart-header { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 6px;
            }
            
            .progress-indicators {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header dengan tombol -->
    <div class="header-container">
        <!-- Tombol Kembali Mobile -->
        <a href="{{ route('monitoring.index') }}" class="back-button-mobile" id="mobileBackButton">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8l-4 4 4 4M16 12H8"/>
            </svg>
            Kembali ke Monitoring
        </a>

        <header>
            <!-- Tombol Kembali Desktop -->
            <a href="{{ route('monitoring.index') }}" class="back-button" id="desktopBackButton">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8l-4 4 4 4M16 12H8"/>
                </svg>
                Kembali ke Monitoring
            </a>

            <div class="header-content">
                <h1>
                    <span>📊</span> 
                    Dashboard Monitoring 
                    <span class="project-name">{{ $project->project_name }}</span>
                </h1>
                <p class="subtitle">Visualisasi progress dan produktivitas tim secara real-time</p>
            </div>
        </header>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon dev-icon"><span>💻</span></div>
            <div class="summary-title">Total Jam Developer</div>
            <div class="summary-value">{{ $devProductivity->sum('actual') }}<span class="summary-unit">Jam</span></div>
        </div>

        <div class="summary-card">
            <div class="summary-icon designer-icon"><span>🎨</span></div>
            <div class="summary-title">Total Jam Designer</div>
            <div class="summary-value">{{ $designerProductivity->sum('actual') }}<span class="summary-unit">Jam</span></div>
        </div>

        <div class="summary-card">
            <div class="summary-icon card-icon"><span>📋</span></div>
            <div class="summary-title">Total Card</div>
            <div class="summary-value">{{ $totalCards }}<span class="summary-unit">Task</span></div>
        </div>
    </div>

    <!-- Layout grid untuk chart -->
    <div class="chart-grid">
        <!-- Baris pertama: Progress Keseluruhan dan Status Task -->
        <div class="chart-row">
            <!-- Progress Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title"><div class="chart-icon">📈</div>Progress Keseluruhan</h3>
                    <span class="performance-badge badge-high">{{ $progress }}% Complete</span>
                </div>
                <div class="chart-wrapper"><canvas id="progressChart"></canvas></div>
                <div class="progress-indicators">
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--primary);"></div><span>Selesai: {{ $progress }}%</span></div>
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--gray-light);"></div><span>Sisa: {{ 100 - $progress }}%</span></div>
                </div>
            </div>

            <!-- Status Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title"><div class="chart-icon">✅</div>Status Task</h3>
                </div>
                <div class="chart-wrapper"><canvas id="statusChart"></canvas></div>
                <div class="progress-indicators">
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--gray);"></div><span>Todo: {{ $todo }}</span></div>
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--warning);"></div><span>Progress: {{ $inProgress }}</span></div>
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--info);"></div><span>Review: {{ $review }}</span></div>
                    <div class="progress-indicator"><div class="indicator-color" style="background: var(--success);"></div><span>Done: {{ $done }}</span></div>
                </div>
            </div>
        </div>

        <!-- Baris kedua: Produktivitas Developer dan Designer -->
        <div class="chart-row">
            <!-- Developer Productivity -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title"><div class="chart-icon">💻</div>Produktivitas Developer</h3>
                    <span class="performance-badge badge-high">Total: {{ $devProductivity->sum('actual') }} Jam</span>
                </div>
                <div class="chart-wrapper"><canvas id="devChart"></canvas></div>
            </div>

            <!-- Designer Productivity -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title"><div class="chart-icon">🎨</div>Produktivitas Designer</h3>
                    <span class="performance-badge badge-high">Total: {{ $designerProductivity->sum('actual') }} Jam</span>
                </div>
                <div class="chart-wrapper"><canvas id="designerChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

<script>
const chartColors = {
    primary: "#3b82f6", grayLight: "#f1f5f9", gray: "#64748b",
    danger: "#ef4444", success: "#10b981", warning: "#f59e0b", info: "#8b5cf6"
};

const chartConfig = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { 
        legend: { display: false }, 
        tooltip: { 
            enabled: false // Menonaktifkan tooltip sepenuhnya
        } 
    },
    scales: {
        x: { 
            grid: { color: chartColors.grayLight, drawBorder: false }, 
            ticks: { 
                color: chartColors.gray, 
                font: { family: 'Inter', size: 11 }
            } 
        },
        y: { 
            grid: { color: chartColors.grayLight, drawBorder: false }, 
            ticks: { color: chartColors.gray, font: { family: 'Inter', size: 11 } }, 
            beginAtZero: true 
        }
    }
};

// Progress Chart - tanpa tooltip
new Chart(document.getElementById("progressChart"), {
    type: "doughnut",
    data: { 
        datasets: [{ 
            data: [{{ $progress }}, 100 - {{ $progress }}], 
            backgroundColor: [chartColors.primary, chartColors.grayLight], 
            borderWidth: 0, 
            borderRadius: 8 
        }] 
    },
    options: { 
        ...chartConfig,
        cutout: "70%", 
        scales: { 
            x: { display: false }, 
            y: { display: false, grid: { display: false } } 
        },
        // Menonaktifkan events untuk mencegah tooltip
        events: [],
        // Menonaktifkan hover effects
        hover: { mode: null },
        // Menonaktifkan interactions
        interaction: { mode: null }
    },
    plugins: [{
        id: 'centerText',
        afterDraw(chart) {
            const { ctx, chartArea: { width, height } } = chart;
            const progress = {{ $progress }};
            ctx.save();
            ctx.font = "bold 24px Inter"; 
            ctx.fillStyle = chartColors.primary;
            ctx.textAlign = "center"; 
            ctx.textBaseline = "middle"; 
            ctx.fillText(progress + "%", width / 2, height / 2);
            ctx.font = "12px Inter"; 
            ctx.fillStyle = chartColors.gray;
            ctx.fillText("Completed", width / 2, height / 2 + 20);
            ctx.restore();
        }
    }]
});

// Status Chart - tanpa tooltip
new Chart(document.getElementById("statusChart"), {
    type: "bar",
    data: { 
        labels: ["Todo", "In Progress", "Review", "Done"], 
        datasets: [{ 
            data: [{{ $todo }}, {{ $inProgress }}, {{ $review }}, {{ $done }}], 
            backgroundColor: [chartColors.gray, chartColors.warning, chartColors.info, chartColors.success], 
            borderRadius: 6, 
            borderSkipped: false 
        }] 
    },
    options: { 
        ...chartConfig, 
        scales: { 
            x: chartConfig.scales.x, 
            y: { display: false, grid: { display: false } } 
        }, 
        barPercentage: 0.5, 
        categoryPercentage: 0.6 
    }
});

// Developer Productivity - Line Chart - tanpa tooltip
new Chart(document.getElementById("devChart"), {
    type: "line",
    data: { 
        labels: {!! json_encode($devProductivity->pluck('username')) !!}, 
        datasets: [{ 
            label: "Jam Kerja", 
            data: {!! json_encode($devProductivity->pluck('actual')) !!}, 
            borderColor: chartColors.primary, 
            backgroundColor: "rgba(59,130,246,0.1)", 
            borderWidth: 2, 
            fill: true, 
            tension: 0.4, 
            pointBackgroundColor: chartColors.primary, 
            pointBorderColor: "#ffffff", 
            pointBorderWidth: 2, 
            pointRadius: 4, 
            pointHoverRadius: 6 
        }] 
    },
    options: { 
        ...chartConfig, 
        scales: { 
            x: chartConfig.scales.x, 
            y: { ...chartConfig.scales.y, display: true } 
        } 
    }
});

// Designer Productivity - Line Chart - tanpa tooltip
new Chart(document.getElementById("designerChart"), {
    type: "line",
    data: { 
        labels: {!! json_encode($designerProductivity->pluck('username')) !!}, 
        datasets: [{ 
            label: "Jam Kerja", 
            data: {!! json_encode($designerProductivity->pluck('actual')) !!}, 
            borderColor: chartColors.danger, 
            backgroundColor: "rgba(239,68,68,0.1)", 
            borderWidth: 2, 
            fill: true, 
            tension: 0.4, 
            pointBackgroundColor: chartColors.danger, 
            pointBorderColor: "#ffffff", 
            pointBorderWidth: 2, 
            pointRadius: 4, 
            pointHoverRadius: 6 
        }] 
    },
    options: { 
        ...chartConfig, 
        scales: { 
            x: chartConfig.scales.x, 
            y: { ...chartConfig.scales.y, display: true } 
        } 
    }
});

// Hide/show tombol berdasarkan ukuran layar
function handleResize() {
    const mobileButton = document.getElementById('mobileBackButton');
    const desktopButton = document.getElementById('desktopBackButton');
    
    if (window.innerWidth < 768) {
        mobileButton.style.display = 'inline-flex';
        desktopButton.style.display = 'none';
    } else {
        mobileButton.style.display = 'none';
        desktopButton.style.display = 'inline-flex';
    }
}

// Initial call
handleResize();
// Add event listener
window.addEventListener('resize', handleResize);
</script>
</body>
</html>