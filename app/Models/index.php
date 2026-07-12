<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Capital Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #101A3D; --bg: #F3F5FB; --card: #FFFFFF; --border: #E6E9F2;
            --accent: #3B5BFF; --text: #131A2C; --muted: #8891A6; --green: #1FA971; --amber: #F2A93B;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        .sidebar { width: 232px; flex-shrink: 0; background: var(--navy); display: flex; flex-direction: column; padding: 22px 14px; position: sticky; top: 0; height: 100vh; }
        .sidebar-brand { display:flex; align-items:center; gap:10px; padding:6px 10px 26px; font-family:'Syne',sans-serif; font-weight:800; font-size:1.02rem; color:#fff; }
        .dot { width:9px; height:9px; border-radius:50%; background:#0EBAC5; }
        .sidebar-nav { list-style:none; display:flex; flex-direction:column; gap:3px; }
        .sidebar-link { display:flex; align-items:center; gap:12px; padding:11px 12px; border-radius:10px; color:rgba(255,255,255,0.56); font-size:.85rem; font-weight:500; transition: background .15s, color .15s; }
        .sidebar-link:hover { color:#fff; background:rgba(255,255,255,0.06); }
        .sidebar-item.active .sidebar-link { color:#fff; background:linear-gradient(90deg, rgba(59,91,255,0.35), rgba(59,91,255,0.05)); box-shadow: inset 2px 0 0 var(--accent); }
        .main-wrap { flex:1; min-width:0; display:flex; flex-direction:column; }
        .main-container { flex:1; padding:34px 40px 56px; max-width:1200px; width:100%; margin:0 auto; }
        .page-title { margin-bottom: 26px; }
        .page-title p.eyebrow { font-size:.7rem; font-weight:600; letter-spacing:1.4px; text-transform:uppercase; color:var(--accent); margin-bottom:6px; }
        .page-title h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--text); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .stat-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:24px; display:flex; align-items:center; gap:18px; transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(16,26,61,0.08); }
        .stat-icon { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; flex-shrink:0; }
        .stat-icon.bg-accent { background:linear-gradient(135deg, var(--accent), #6C63FF); }
        .stat-icon.bg-amber { background:linear-gradient(135deg, var(--amber), #FFC96B); }
        .stat-info .stat-number { font-family:'Syne',sans-serif; font-size:1.8rem; font-weight:800; line-height:1.1; }
        .stat-info .stat-label { font-size:.8rem; color:var(--muted); font-weight:500; }
        .dashboard-grid { display:grid; grid-template-columns: 2fr 1fr; gap:32px; align-items:flex-start; }
        .card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:28px; box-shadow:0 2px 14px rgba(16,26,61,0.04); }
        .card-header { margin-bottom:20px; }
        .card-header h3 { font-family:'Syne',sans-serif; font-size:1.05rem; font-weight:700; }
        .chart-container { position: relative; height: 260px; width: 100%; }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; font-size:.7rem; font-weight:700; text-transform:uppercase; color:var(--muted); padding:0 14px 12px; border-bottom:1px solid var(--border); }
        tbody td { padding:14px; border-bottom:1px solid var(--border); font-size:.86rem; }
        tbody tr:last-child td { border-bottom: none; }
        .status { display:inline-block; padding:5px 12px; border-radius:20px; font-size:.7rem; font-weight:700; }
        .status-pendiente { background:rgba(242,169,59,0.16); color:#946112; }
        .status-aprobada { background:rgba(31,169,113,0.14); color:var(--green); }
        .status-rechazada { background:rgba(229,72,77,0.12); color:#E5484D; }
        footer { text-align:center; padding:24px; font-size:.75rem; color:var(--muted); border-top:1px solid var(--border); margin-top: 40px; }
        @media (max-width: 960px) { .dashboard-grid { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .sidebar { display:none; } .main-container { padding:24px 18px; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>
        <ul class="sidebar-nav">
            <li class="sidebar-item active"><a class="sidebar-link" href="/home">Inicio</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/usuarios">Usuarios</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/colaboradores">Colaboradores</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/vacaciones">Vacaciones</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/reportes">Reportes</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/planillas">Planillas</a></li>
        </ul>
    </aside>

    <div class="main-wrap">
        <main class="main-container">
            <div class="page-title">
                <p class="eyebrow">Dashboard</p>
                <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Administrador'); ?></h1>
            </div>

            <!-- Tarjetas de Estadísticas -->
            <div class="stats-grid">
                <a href="/colaboradores" class="stat-card">
                    <div class="stat-icon bg-accent">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo htmlspecialchars($totalColaboradores); ?></div>
                        <div class="stat-label">Colaboradores Activos</div>
                    </div>
                </a>
                <a href="/vacaciones" class="stat-card">
                    <div class="stat-icon bg-amber">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number"><?php echo htmlspecialchars($solicitudesPendientes); ?></div>
                        <div class="stat-label">Solicitudes Pendientes</div>
                    </div>
                </a>
            </div>

            <!-- Gráficos y Actividad Reciente -->
            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-header">
                        <h3>Actividad Reciente de Vacaciones</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Colaborador</th>
                                <th>Fechas</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($actividadReciente)): ?>
                                <tr><td colspan="3" style="text-align:center; color: var(--muted);">No hay actividad reciente.</td></tr>
                            <?php else: ?>
                                <?php foreach ($actividadReciente as $actividad): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($actividad['primer_nombre'] . ' ' . $actividad['primer_apellido']); ?></td>
                                        <td><?php echo htmlspecialchars(date('d/m/y', strtotime($actividad['fecha_inicio'])) . ' → ' . date('d/m/y', strtotime($actividad['fecha_fin']))); ?></td>
                                        <td>
                                            <?php
                                                $statusClass = 'status-pendiente';
                                                if ($actividad['estado'] === 'Aprobada') $statusClass = 'status-aprobada';
                                                if ($actividad['estado'] === 'Rechazada') $statusClass = 'status-rechazada';
                                            ?>
                                            <span class="status <?php echo $statusClass; ?>"><?php echo htmlspecialchars($actividad['estado']); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div style="display:flex; flex-direction: column; gap: 32px;">
                    <div class="card">
                        <div class="card-header">
                            <h3>Distribución por Sexo</h3>
                        </div>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="sexoChart"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Distribución por Edad</h3>
                        </div>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="edadChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano <?php echo date('Y'); ?>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gráfica de Distribución por Sexo
            const sexoCtx = document.getElementById('sexoChart').getContext('2d');
            new Chart(sexoCtx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo $chartSexoLabels; ?>,
                    datasets: [{
                        label: 'Colaboradores',
                        data: <?php echo $chartSexoData; ?>,
                        backgroundColor: [
                            'rgba(59, 91, 255, 0.8)',
                            'rgba(242, 169, 59, 0.8)',
                            'rgba(31, 169, 113, 0.8)'
                        ],
                        borderColor: 'var(--card)',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11,
                                    family: "'Inter', sans-serif"
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });

            // Gráfica de Distribución por Edad
            const edadCtx = document.getElementById('edadChart').getContext('2d');
            new Chart(edadCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo $chartEdadLabels; ?>,
                    datasets: [{
                        label: 'Cantidad de Colaboradores',
                        data: <?php echo $chartEdadData; ?>,
                        backgroundColor: 'rgba(59, 91, 255, 0.7)',
                        borderRadius: 4,
                        barThickness: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Asegurarse de que los ticks sean enteros
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>