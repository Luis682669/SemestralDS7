<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vacaciones - Capital Humano</title>
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

        /* ── SIDEBAR ── */
        .sidebar {
            width: 232px;
            flex-shrink: 0;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            padding: 22px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
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

        .sidebar-link svg { flex-shrink: 0; opacity: .85; }

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

        /* ── MAIN ── */
        .main-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        .main-container {
            flex: 1;
            padding: 34px 40px 56px;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
        }

        .page-title { margin-bottom: 26px; }

        .page-title p.eyebrow {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .page-title h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.4px;
        }

        /* ── CARD / TABLE ── */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 26px 28px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .card-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
        }

        .card-header p {
            font-size: .8rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            padding: 11px 20px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 700;
            transition: background .15s, transform .1s, box-shadow .15s;
        }
        .btn-new:hover { background: #2E4DE0; box-shadow: 0 6px 16px rgba(59,91,255,0.28); }
        .btn-new:active { transform: scale(.98); }
        .btn-new svg { transition: transform .2s; }
        .btn-new:hover svg { transform: rotate(90deg); }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 18px;
            border-radius: 10px;
            background: #f1f5f9;
            color: var(--text);
            border: 1px solid var(--border);
            font-weight: 700;
            font-size: .85rem;
            transition: background .15s, transform .1s;
        }
        .btn-secondary:hover { background: #e2e8f0; transform: translateY(-1px); }
        .btn-secondary:active { transform: scale(.97); }

        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 620px; }

        thead th {
            text-align: left;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--muted);
            padding: 0 14px 12px;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 16px 14px;
            border-bottom: 1px solid var(--border);
            font-size: .86rem;
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background .15s, opacity .35s ease, transform .35s ease; }
        tbody tr:hover { background: rgba(59,91,255,0.03); }
        tbody tr.removing { opacity: 0; transform: translateX(12px); }

        .colaborador-cell { display: flex; align-items: center; gap: 10px; font-weight: 600; }

        .avatar-sm {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .7rem;
            color: #fff;
            flex-shrink: 0;
            transition: transform .15s;
        }
        tbody tr:hover .avatar-sm { transform: scale(1.08); }

        .dias-disponibles { font-family: 'Syne', sans-serif; font-weight: 800; color: var(--text); }

        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .2px;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        }
        .status-pendiente  { background: rgba(242,169,59,0.16); color: #946112; position: relative; padding-left: 20px; }
        .status-pendiente::before {
            content: '';
            position: absolute;
            left: 9px; top: 50%;
            width: 6px; height: 6px;
            margin-top: -3px;
            border-radius: 50%;
            background: #946112;
            animation: pulseAmber 1.8s ease-out infinite;
        }
        .status-aprobada   { background: rgba(31,169,113,0.14); color: var(--green); }
        .status-rechazada  { background: rgba(229,72,77,0.12);  color: var(--danger); }
        .status.updated { animation: popStatus .4s cubic-bezier(.34,1.56,.64,1); }

        @keyframes pulseAmber {
            0%, 100% { box-shadow: 0 0 0 0 rgba(148,97,18,0.4); }
            50%      { box-shadow: 0 0 0 4px rgba(148,97,18,0); }
        }
        @keyframes popStatus {
            0%   { transform: scale(.7); }
            60%  { transform: scale(1.12); }
            100% { transform: scale(1); }
        }

        .actions { display: flex; gap: 8px; }

        .btn {
            padding: 7px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: .76rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            transition: background .15s, transform .1s, box-shadow .15s;
        }
        .btn:active { transform: scale(.96); }

        .btn-aprob { background: rgba(31,169,113,0.12); color: var(--green); }
        .btn-aprob:hover { background: var(--green); color: #fff; }

        .btn-rech { background: rgba(229,72,77,0.1); color: var(--danger); }
        .btn-rech:hover { background: var(--danger); color: #fff; }

        .no-actions { color: var(--muted); font-size: .8rem; }

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
        .toast .check { color: var(--green); flex-shrink: 0; }
        .toast .cross { color: #FF8589; flex-shrink: 0; }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .73rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }

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

        .page-title { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }
        .card { opacity: 0; animation: fadeSlideUp .5s ease .2s forwards; }

        tbody tr.entering { opacity: 0; animation: rowIn .4s ease forwards; }
        tbody tr:nth-child(1) { animation-delay: .4s; }
        tbody tr:nth-child(2) { animation-delay: .45s; }
        tbody tr:nth-child(3) { animation-delay: .5s; }
        tbody tr:nth-child(4) { animation-delay: .55s; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-container { padding: 24px 18px 44px; }
            .card { padding: 20px; }
        }
    </style>
</head>
<body>

    <!-- Toast de confirmación -->
    <div class="toast" id="toast"></div>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="/home">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5"/><path d="M5 10v10h14V10"/></svg>
                    Inicio
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/usuarios">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6"/><path d="M19 4.5a3 3 0 0 1 0 6"/></svg>
                    Usuarios
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/colaboradores">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 4v16"/></svg>
                    Colaboradores
                </a>
            </li>
            <li class="sidebar-item active">
                <a class="sidebar-link" href="/vacaciones">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                    Vacaciones
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/reportes">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5M4 19h16M8 16v-4M12 16V8M16 16v-6"/></svg>
                    Reportes
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="/planillas">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16M4 10h16M4 15h16M4 20h16"/></svg>
                    Planillas
                </a>
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
            <a href="/logout" class="btn-logout">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                Salir
            </a>
        </div>
    </aside>

    <!-- ── MAIN ── -->
    <div class="main-wrap">
        <main class="main-container">

            <div class="page-title">
                <p class="eyebrow">Vacaciones y Permisos</p>
                <h1>Solicitudes de Vacaciones</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <h2>Listado de solicitudes</h2>
                        <p>Revisa, aprueba o rechaza las solicitudes y permisos de vacaciones de tus colaboradores.</p>
                    </div>
                    <div style="display:flex; gap:12px; flex-wrap: wrap; align-items:center;">
                        <a href="/vacaciones/crear" class="btn-new">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            Nueva Solicitud
                        </a>
                        <a href="/vacaciones/derechos" class="btn-secondary">Derechos de Vacaciones</a>
                        <a href="/reportes/vacaciones" class="btn-secondary">Exportar resueltos</a>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Colaborador</th>
                                <th>Fechas</th>
                                <th>Días Solicitados</th>
                                <th>Motivo</th>
                                <th>Disponibles</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr class="entering" data-id="1">
                                <td><div class="colaborador-cell"><div class="avatar-sm">M</div>María Torres</div></td>
                                <td>07/07 → 14/07</td>
                                <td>6</td>
                                <td>Vacaciones anuales</td>
                                <td><span class="dias-disponibles">12</span></td>
                                <td><span class="status status-pendiente">Pendiente</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-aprob" data-accion="Aprobada">Aprobar</button>
                                        <button class="btn btn-rech" data-accion="Rechazada">Rechazar</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="entering" data-id="2">
                                <td><div class="colaborador-cell"><div class="avatar-sm">S</div>Samuel Smith</div></td>
                                <td>15/07 → 17/07</td>
                                <td>3</td>
                                <td>Permiso médico</td>
                                <td><span class="dias-disponibles">8</span></td>
                                <td><span class="status status-pendiente">Pendiente</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-aprob" data-accion="Aprobada">Aprobar</button>
                                        <button class="btn btn-rech" data-accion="Rechazada">Rechazar</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="entering" data-id="3">
                                <td><div class="colaborador-cell"><div class="avatar-sm">L</div>Luisa García</div></td>
                                <td>01/06 → 10/06</td>
                                <td>8</td>
                                <td>Vacaciones anuales</td>
                                <td><span class="dias-disponibles">14</span></td>
                                <td><span class="status status-aprobada">Aprobada</span></td>
                                <td><span class="no-actions">—</span></td>
                            </tr>
                            <tr class="entering" data-id="4">
                                <td><div class="colaborador-cell"><div class="avatar-sm">J</div>Jorge Pérez</div></td>
                                <td>20/05 → 22/05</td>
                                <td>2</td>
                                <td>Asunto personal</td>
                                <td><span class="dias-disponibles">5</span></td>
                                <td><span class="status status-rechazada">Rechazada</span></td>
                                <td><span class="no-actions">—</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano 2026
        </footer>
    </div>

    <script>
        document.querySelectorAll('.btn-aprob, .btn-rech').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var row = btn.closest('tr');
                var accion = btn.getAttribute('data-accion');
                var statusEl = row.querySelector('.status');
                var actionsEl = row.querySelector('.actions');

                statusEl.className = 'status ' + (accion === 'Aprobada' ? 'status-aprobada' : 'status-rechazada');
                statusEl.textContent = accion;
                statusEl.classList.add('updated');

                actionsEl.parentElement.innerHTML = '<span class="no-actions">—</span>';

                var toast = document.getElementById('toast');
                if (accion === 'Aprobada') {
                    toast.innerHTML = '<svg class="check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg> Solicitud aprobada';
                } else {
                    toast.innerHTML = '<svg class="cross" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg> Solicitud rechazada';
                }
                toast.classList.add('show');
                setTimeout(function () { toast.classList.remove('show'); }, 2400);
            });
        });
    </script>

</body>
</html>