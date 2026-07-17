<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Capital Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:      #101A3D;
            --navy-2:    #16224D;
            --bg:        #F3F5FB;
            --card:      #FFFFFF;
            --border:    #E6E9F2;
            --accent:    #3B5BFF;
            --accent2:   #6C63FF;
            --teal:      #0EBAC5;
            --amber:     #F2A93B;
            --text:      #131A2C;
            --muted:     #8891A6;
            --danger:    #E5484D;
            --green:     #1FA971;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        .sidebar {
            width: 232px;
            flex-shrink: 0;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            padding: 22px 14px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow: hidden;
            z-index: 10;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px 26px;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.02rem;
            color: #fff;
            letter-spacing: -.3px;
        }

        .sidebar-brand .dot {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: var(--teal);
            box-shadow: 0 0 10px var(--teal);
            flex-shrink: 0;
        }

        .sidebar-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.56);
            font-size: .85rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }

        .sidebar-link:hover { color: #fff; background: rgba(255,255,255,0.06); }

        .sidebar-item.active .sidebar-link {
            color: #fff;
            background: linear-gradient(90deg, rgba(59,91,255,0.35), rgba(59,91,255,0.05));
            box-shadow: inset 2px 0 0 var(--accent);
        }

        .sidebar-foot {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 16px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px 14px;
        }

        .sidebar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .8rem;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-user .who { display: flex; flex-direction: column; overflow: hidden; }
        .sidebar-user .who b { font-size: .82rem; color: #fff; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .who span { font-size: .7rem; color: rgba(255,255,255,0.45); }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            background: rgba(229,72,77,0.14);
            color: #FF8589;
            border: 1px solid rgba(229,72,77,0.3);
            border-radius: 10px;
            font-size: .8rem;
            font-weight: 600;
            transition: background .15s, color .15s;
        }

        .btn-logout:hover { background: var(--danger); color: #fff; }

        .main-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; margin-left: 232px; }

        .main-container {
            flex: 1;
            padding: 34px 40px 56px;
            max-width: 1240px;
            width: calc(100% - 232px);
            margin: 0 auto;
        }

        .header-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 26px;
        }

        .header-actions h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text);
        }

        .header-actions p {
            font-size: .95rem;
            color: var(--muted);
            max-width: 680px;
        }

        .reports-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(220px, 1fr));
            gap: 20px;
        }

        .report-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .report-card:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(16,26,61,0.09); }

        .stats-section {
            margin-top: 32px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        .stat-card h4 {
            margin-bottom: 14px;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .stat-card ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
            color: var(--text);
        }

        .stat-card li {
            margin-bottom: 10px;
            font-size: .92rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .stat-bar-wrap {
            flex: 1;
            height: 6px;
            background: #EEF1F8;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 10px;
        }
        .stat-bar {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--accent2), var(--accent));
            width: 0;
            transition: width 1s cubic-bezier(.22,1,.36,1);
        }

        .table-section {
            margin-top: 32px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 18px;
        }

        .table-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            margin: 0;
            color: var(--text);
        }

        .table-header p {
            margin: 0;
            color: var(--muted);
            font-size: .9rem;
        }

        .table-wrap {
            overflow-x: auto;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        thead th {
            text-align: left;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--muted);
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-size: .9rem;
            color: var(--text);
        }

        tbody tr { transition: background .15s; }
        tbody tr:hover { background: rgba(59,91,255,0.03); }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f1f5f9;
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            transition: background .15s, color .15s, transform .12s;
        }

        .page-link.active,
        .page-link:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-1px);
        }

        .report-icon {
            font-size: 2rem;
            margin-bottom: 18px;
            display: inline-block;
            transition: transform .2s ease;
        }
        .report-card:hover .report-icon { transform: scale(1.15) rotate(-4deg); }

        .report-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .report-desc {
            font-size: .9rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 22px;
            flex: 1;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 700;
            transition: background .15s, transform .1s, box-shadow .15s;
            position: relative;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            border: none;
        }

        .btn-primary:hover { background: #2E4DE0; box-shadow: 0 6px 16px rgba(59,91,255,0.28); }

        .btn-primary.loading { color: transparent; pointer-events: none; }
        .btn-primary.loading::after {
            content: '';
            position: absolute;
            width: 16px; height: 16px;
            margin: -8px 0 0 -8px;
            top: 50%; left: 50%;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.35);
            border-top-color: #fff;
            animation: spin .6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: #e2e8f0; }

        .toast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-16px);
            background: var(--text);
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: .84rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 28px rgba(16,26,61,0.25);
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease, transform .25s ease;
            z-index: 50;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        .toast svg { color: var(--green); flex-shrink: 0; }

        /* ── ANIMACIONES DE ENTRADA ── */
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-14px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes rowIn { from { opacity: 0; transform: translateX(-8px); } to { opacity: 1; transform: translateX(0); } }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .header-actions { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }

        .report-card { opacity: 0; animation: fadeSlideUp .5s ease forwards; }
        .report-card:nth-child(1) { animation-delay: .2s; }
        .report-card:nth-child(2) { animation-delay: .27s; }
        .report-card:nth-child(3) { animation-delay: .34s; }

        .stat-card { opacity: 0; animation: fadeSlideUp .5s ease forwards; }
        .stat-card:nth-child(1) { animation-delay: .42s; }
        .stat-card:nth-child(2) { animation-delay: .49s; }

        .table-section { opacity: 0; animation: fadeSlideUp .5s ease .55s forwards; }

        tbody tr { opacity: 0; animation: rowIn .35s ease forwards; }
        tbody tr:nth-child(1) { animation-delay: .7s; }
        tbody tr:nth-child(2) { animation-delay: .75s; }
        tbody tr:nth-child(3) { animation-delay: .8s; }
        tbody tr:nth-child(4) { animation-delay: .85s; }
        tbody tr:nth-child(5) { animation-delay: .9s; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        @media (max-width: 980px) {
            .reports-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-wrap { margin-left: 0; }
            .main-container { padding: 24px 18px 44px; width: 100%; }
            .reports-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Toast de confirmación -->
    <div class="toast" id="toast">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        PDF generado correctamente
    </div>

    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="/home">Inicio</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/usuarios">Usuarios</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/colaboradores">Colaboradores</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/vacaciones">Vacaciones</a>
            </li>
            <li class="sidebar-item active">
                <a class="sidebar-link" href="/reportes">Reportes</a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/planillas">Planillas</a>
            </li>
        </ul>

        <div class="sidebar-foot">
            <div class="sidebar-user">
                <div class="sidebar-avatar">A</div>
                <div class="who">
                    <b>admin</b>
                    <span>Administrador</span>
                </div>
            </div>
            <a href="/logout" class="btn-logout">Salir</a>
        </div>
    </aside>

    <div class="main-wrap">
        <main class="main-container">
            <div class="header-actions">
                <h1>Centro de Reportes</h1>
                <p>Genera y descarga documentos oficiales en formato PDF, con el mismo estilo de navegación que el resto del sistema.</p>
            </div>

            <div class="reports-grid">
                <div class="report-card">
                    <div>
                        <div class="report-icon">📊</div>
                        <h3 class="report-title">Listado de Colaboradores</h3>
                        <p class="report-desc">Genera un PDF con la lista completa de empleados, cédulas y departamentos activos.</p>
                    </div>
                    <button type="button" class="btn-primary" data-report="Listado de Colaboradores">Generar PDF</button>
                </div>

                <div class="report-card">
                    <div>
                        <div class="report-icon">🌴</div>
                        <h3 class="report-title">Estado de Vacaciones</h3>
                        <p class="report-desc">Genera un PDF con todas las solicitudes y su estado actual, incluidos los permisos de vacaciones.</p>
                    </div>
                    <button type="button" class="btn-primary" data-report="Estado de Vacaciones">Generar PDF</button>
                </div>

                <div class="report-card">
                    <div>
                        <div class="report-icon">👤</div>
                        <h3 class="report-title">Fichas Individuales</h3>
                        <p class="report-desc">Descarga la ficha de un colaborador desde su perfil en el módulo de Colaboradores.</p>
                    </div>
                    <a href="/colaboradores" class="btn-primary">Ir a Colaboradores</a>
                </div>
            </div>

            <section class="stats-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Colaboradores por Sexo</h4>
                        <ul>
                            <li><strong>Femenino:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="68"></span></span> 68</li>
                            <li><strong>Masculino:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="54"></span></span> 54</li>
                            <li><strong>No especificado:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="2"></span></span> 2</li>
                        </ul>
                    </div>
                    <div class="stat-card">
                        <h4>Colaboradores por Rango de Edad</h4>
                        <ul>
                            <li><strong>18-24:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="14"></span></span> 14</li>
                            <li><strong>25-30:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="38"></span></span> 38</li>
                            <li><strong>31-40:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="46"></span></span> 46</li>
                            <li><strong>41-50:</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="20"></span></span> 20</li>
                            <li><strong>51+ :</strong> <span class="stat-bar-wrap"><span class="stat-bar" data-value="6"></span></span> 6</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="table-section">
                <div class="table-header">
                    <h2>Colaboradores Activos</h2>
                    <p>Mostrando página 1 de 12.</p>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Sexo</th>
                                <th>Edad</th>
                                <th>Departamento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>8-123-4567</td>
                                <td>María Torres</td>
                                <td>Femenino</td>
                                <td>29</td>
                                <td>Recursos Humanos</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>8-234-5678</td>
                                <td>Samuel Smith</td>
                                <td>Masculino</td>
                                <td>34</td>
                                <td>Tecnología</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>8-345-6789</td>
                                <td>Meredith Silva</td>
                                <td>Femenino</td>
                                <td>27</td>
                                <td>Finanzas</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>8-456-7890</td>
                                <td>Jorge Pérez</td>
                                <td>Masculino</td>
                                <td>41</td>
                                <td>Operaciones</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td>8-567-8901</td>
                                <td>Luisa García</td>
                                <td>Femenino</td>
                                <td>25</td>
                                <td>Tecnología</td>
                                <td>Activo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <a href="#" class="page-link active">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <a href="#" class="page-link">4</a>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Barras de estadísticas animadas al cargar
        setTimeout(function () {
            document.querySelectorAll('.stat-bar').forEach(function (bar) {
                var val = parseInt(bar.getAttribute('data-value'), 10);
                var max = 70;
                bar.style.width = Math.min((val / max) * 100, 100) + '%';
            });
        }, 500);

        // Simulación de generación de PDF
        document.querySelectorAll('.btn-primary[data-report]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var nombre = btn.getAttribute('data-report');
                btn.classList.add('loading');
                setTimeout(function () {
                    btn.classList.remove('loading');
                    var toast = document.getElementById('toast');
                    toast.lastChild.textContent = ' ' + nombre + ' generado correctamente';
                    toast.classList.add('show');
                    setTimeout(function () { toast.classList.remove('show'); }, 2600);
                }, 900);
            });
        });
    </script>

</body>
</html>