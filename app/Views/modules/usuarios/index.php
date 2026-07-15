<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Capital Humano</title>
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

        /* ── HEADER ACTIONS ── */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-actions p {
            font-size: .82rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            padding: 11px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: .85rem;
            border: none;
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            white-space: nowrap;
        }
        .btn-primary:hover { background: #2E4DE0; box-shadow: 0 6px 16px rgba(59,91,255,0.28); transform: translateY(-1px); }
        .btn-primary:active { transform: scale(.98); }
        .btn-primary svg { transition: transform .2s; }
        .btn-primary:hover svg { transform: rotate(90deg); }

        /* ── TABLE ── */
        .table-container {
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; text-align: left; min-width: 760px; }

        th {
            padding: 14px 20px;
            background: #FAFBFD;
            font-weight: 700;
            color: var(--muted);
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-size: .86rem;
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background .15s; }
        tbody tr:hover { background: rgba(59,91,255,0.03); }

        .id-cell { color: var(--muted); font-weight: 600; }

        .user-cell { display: flex; align-items: center; gap: 10px; font-weight: 700; }

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
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
        }
        .badge-active   { background: rgba(31,169,113,0.14); color: var(--green); position: relative; padding-left: 20px; }
        .badge-active::before {
            content: '';
            position: absolute;
            left: 9px; top: 50%;
            width: 6px; height: 6px;
            margin-top: -3px;
            border-radius: 50%;
            background: var(--green);
            animation: pulseGreen 1.8s ease-out infinite;
        }
        .badge-inactive { background: rgba(229,72,77,0.1);   color: var(--danger); }

        @keyframes pulseGreen {
            0%, 100% { box-shadow: 0 0 0 0 rgba(31,169,113,0.4); }
            50%      { box-shadow: 0 0 0 4px rgba(31,169,113,0); }
        }

        .btn-action {
            padding: 7px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: .78rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            transition: background .15s, color .15s, transform .1s;
        }
        .btn-action:active { transform: scale(.96); }

        .btn-disable {
            background: rgba(242,169,59,0.16);
            color: #946112;
        }
        .btn-disable:hover { background: var(--amber); color: #fff; }

        .protegido {
            font-size: .78rem;
            color: var(--muted);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .73rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }

        /* ── ANIMACIONES ── */
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-14px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .page-title { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }
        .header-actions { opacity: 0; animation: fadeSlideUp .5s ease .2s forwards; }
        .table-container { opacity: 0; animation: fadeSlideUp .5s ease .3s forwards; }

        tbody tr { opacity: 0; animation: rowIn .4s ease forwards; }
        tbody tr:nth-child(1) { animation-delay: .45s; }
        tbody tr:nth-child(2) { animation-delay: .5s; }
        tbody tr:nth-child(3) { animation-delay: .55s; }
        tbody tr:nth-child(4) { animation-delay: .6s; }
        tbody tr:nth-child(5) { animation-delay: .65s; }
        tbody tr:nth-child(6) { animation-delay: .7s; }

        .avatar-sm { transition: transform .15s; }
        tbody tr:hover .avatar-sm { transform: scale(1.08); }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-container { padding: 24px 18px 44px; }
        }
    </style>
</head>
<body>

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
            <li class="sidebar-item active">
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
            <li class="sidebar-item">
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
                <p class="eyebrow">Capital Humano</p>
                <h1>Gestión de Usuarios</h1>
            </div>

            <?php
                // Mostramos mensajes de éxito, error o advertencia
                \App\Core\FlashMessage::display('success');
                \App\Core\FlashMessage::display('error');
                \App\Core\FlashMessage::display('warning');
            ?>

            <div class="header-actions">
                <p>Administra los accesos y roles de seguridad del sistema.</p>
                <a href="/usuarios/crear" class="btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    Nuevo Usuario
                </a>
            </div>

            <div class="table-container">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Rol Asignado</th>
                                <th>Estado</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($usuarios) && !empty($usuarios)): ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><span class="id-cell">#<?php echo htmlspecialchars($usuario['id']); ?></span></td>
                                        <td>
                                            <div class="user-cell">
                                                <div class="avatar-sm"><?php echo strtoupper(substr($usuario['username'], 0, 1)); ?></div>
                                                <?php echo htmlspecialchars($usuario['username']); ?>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($usuario['rol_nombre']); ?></td>
                                        <td>
                                            <?php if ($usuario['activo']): ?>
                                                <span class="badge badge-active">Activo</span>
                                            <?php else: ?>
                                                <span class="badge badge-inactive">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($usuario['creado_en']))); ?></td>
                                        <td>
                                            <?php if ($usuario['username'] !== 'admin' && $usuario['activo']): ?>
                                                <form method="POST" action="/usuarios/desactivar" style="display:inline;">
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                                                    <button type="submit" class="btn-action btn-disable">Desactivar</button>
                                                </form>
                                            <?php elseif ($usuario['username'] === 'admin'): ?>
                                                <span class="protegido">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 4 5v6c0 5.2 3.4 9 8 11 4.6-2 8-5.8 8-11V5l-8-3Z"/></svg>
                                                    Protegido
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center; padding: 24px; color: var(--muted);">No hay usuarios registrados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano 2026
        </footer>
    </div>

</body>
</html>