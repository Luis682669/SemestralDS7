<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($colaborador['primer_nombre'] . ' ' . $colaborador['primer_apellido']); ?> - Capital Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <!-- Incluimos la librería Chart.js desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #101A3D; --bg: #F3F5FB; --card: #FFFFFF; --border: #E6E9F2;
            --accent: #3B5BFF; --text: #131A2C; --muted: #8891A6; --danger: #E5484D;
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
        .main-container { flex:1; padding:34px 40px 56px; max-width:1100px; width:100%; margin:0 auto; }
        .page-title { margin-bottom: 26px; }
        .page-title p.eyebrow { font-size:.7rem; font-weight:600; letter-spacing:1.4px; text-transform:uppercase; color:var(--accent); margin-bottom:6px; }
        .page-title h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--text); }
        .profile-header { display: flex; align-items: center; gap: 24px; margin-bottom: 32px; }
        .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), #6C63FF); display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 800; font-size: 2rem; color: #fff; flex-shrink: 0; }
        .profile-info h2 { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; }
        .profile-info p { font-size: .9rem; color: var(--muted); margin-top: 4px; }
        .grid-layout { display: grid; grid-template-columns: 1fr 320px; gap: 32px; align-items: flex-start; }
        .card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:28px; box-shadow:0 2px 14px rgba(16,26,61,0.04); }
        .card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .card-header h3 { font-family:'Syne',sans-serif; font-size:1.05rem; font-weight:700; }
        .btn-secondary { display:inline-flex; align-items:center; justify-content:center; padding:9px 16px; border-radius:10px; background:#f1f5f9; color:var(--text); border:1px solid var(--border); font-weight:600; font-size:.8rem; transition: background .15s; }
        .btn-secondary:hover { background:#e2e8f0; }
        table { width:100%; border-collapse:collapse; }
        thead th { text-align:left; font-size:.7rem; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:var(--muted); padding:10px 14px; border-bottom:1px solid var(--border); }
        tbody td { padding:12px 14px; border-bottom:1px solid var(--border); font-size:.86rem; }
        tbody tr:last-child td { border-bottom: none; }
        .status-pill { display:inline-block; padding:4px 10px; border-radius:20px; font-size:.7rem; font-weight:700; }
        .status-active { background:rgba(31,169,113,0.14); color:#1FA971; }
        .status-inactive { background:rgba(229,72,77,0.12); color:var(--danger); }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: .8rem; }
        input[type="text"], input[type="number"], input[type="date"] { width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: .88rem; font-family: 'Inter', sans-serif; }
        .btn-submit { display:flex; align-items:center; justify-content:center; width:100%; background:var(--accent); color:#fff; padding:11px; border-radius:8px; border:none; font-size:.85rem; font-weight:700; cursor:pointer; transition: background .15s; }
        .btn-submit:hover { background: #2E4DE0; }
        .chart-container { position: relative; height: 250px; width: 100%; }
        footer { text-align:center; padding:24px; font-size:.75rem; color:var(--muted); border-top:1px solid var(--border); margin-top: 40px; }
        @media (max-width: 960px) { .grid-layout { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .sidebar { display:none; } .main-container { padding:24px 18px; } .profile-header { flex-direction: column; text-align: center; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>
        <ul class="sidebar-nav">
            <li class="sidebar-item"><a class="sidebar-link" href="/home">Inicio</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/usuarios">Usuarios</a></li>
            <li class="sidebar-item active"><a class="sidebar-link" href="/colaboradores">Colaboradores</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/vacaciones">Vacaciones</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/reportes">Reportes</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/planillas">Planillas</a></li>
        </ul>
    </aside>

    <div class="main-wrap">
        <main class="main-container">
            <div class="page-title">
                <p class="eyebrow">Colaboradores</p>
                <h1>Perfil del Colaborador</h1>
            </div>

            <div class="profile-header">
                <div class="profile-avatar">
                    <?php echo htmlspecialchars(strtoupper(substr($colaborador['primer_nombre'], 0, 1) . substr($colaborador['primer_apellido'], 0, 1))); ?>
                </div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($colaborador['primer_nombre'] . ' ' . $colaborador['primer_apellido']); ?></h2>
                    <p><?php echo htmlspecialchars($colaborador['ocupacion']); ?> en <?php echo htmlspecialchars($colaborador['departamento']); ?></p>
                </div>
            </div>

            <div class="grid-layout">
                <div class="main-content">
                    <!-- Gráfica de Evolución Salarial -->
                    <div class="card" style="margin-bottom: 32px;">
                        <div class="card-header">
                            <h3>Evolución Salarial</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="salaryChart"></canvas>
                        </div>
                    </div>

                    <!-- Historial de Cargos -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Historial de Cargos y Salarios</h3>
                            <a href="/reportes/ficha?id=<?php echo $colaborador['id']; ?>" class="btn-secondary" target="_blank">Generar Ficha PDF</a>
                        </div>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Cargo</th>
                                        <th>Salario</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($cargos)): ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: var(--muted);">No hay historial de cargos para este colaborador.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($cargos as $cargo): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($cargo['nombre_cargo']); ?></td>
                                                <td>$<?php echo htmlspecialchars(number_format($cargo['sueldo'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($cargo['fecha_inicio']))); ?></td>
                                                <td><?php echo $cargo['fecha_fin'] ? htmlspecialchars(date('d/m/Y', strtotime($cargo['fecha_fin']))) : 'Presente'; ?></td>
                                                <td>
                                                    <?php if ($cargo['es_activo']): ?>
                                                        <span class="status-pill status-active">Activo</span>
                                                    <?php else: ?>
                                                        <span class="status-pill status-inactive">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Formulario para nuevo cargo/salario -->
                <aside class="sidebar-right">
                    <div class="card">
                        <div class="card-header">
                            <h3>Actualizar Cargo/Salario</h3>
                        </div>
                        <form action="/colaboradores/cargo/guardar" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="colaborador_id" value="<?php echo htmlspecialchars($colaborador['id']); ?>">
                            
                            <div class="form-group">
                                <label for="nombre_cargo">Nuevo Cargo</label>
                                <input type="text" id="nombre_cargo" name="nombre_cargo" required value="<?php echo htmlspecialchars($colaborador['ocupacion']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="sueldo">Nuevo Salario</label>
                                <input type="number" id="sueldo" name="sueldo" step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio del Cambio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <button type="submit" class="btn-submit">Guardar Cambio</button>
                        </form>
                    </div>
                </aside>
            </div>
        </main>
        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano <?php echo date('Y'); ?>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtenemos los datos JSON que pasamos desde el controlador
            const chartData = <?php echo $chart_data_json; ?>;

            // Verificamos si hay datos para mostrar en la gráfica
            if (chartData.labels.length > 0) {
                const ctx = document.getElementById('salaryChart').getContext('2d');

                // Creamos un gradiente para el fondo de la línea
                const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                gradient.addColorStop(0, 'rgba(59, 91, 255, 0.25)');
                gradient.addColorStop(1, 'rgba(59, 91, 255, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Salario Mensual',
                            data: chartData.salaries,
                            backgroundColor: gradient, // Fondo con gradiente
                            borderColor: 'rgba(59, 91, 255, 1)',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: 'rgba(59, 91, 255, 1)',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true, // Rellenar el área bajo la línea
                            tension: 0.3 // Curva suave
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false, // El salario no siempre empieza en cero
                                ticks: {
                                    // Formatear el eje Y para que se vea como dinero
                                    callback: function(value, index, values) {
                                        return '$' + new Intl.NumberFormat('en-US').format(value);
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false // Ocultar líneas de la cuadrícula en el eje X
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Ocultamos la leyenda ya que es una sola línea
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            } else {
                // Si no hay datos, mostramos un mensaje en lugar de la gráfica
                const container = document.querySelector('.chart-container');
                container.innerHTML = '<p style="text-align:center; color: var(--muted); padding-top: 80px;">No hay suficientes datos para mostrar la evolución salarial.</p>';
            }
        });
    </script>

</body>
</html>