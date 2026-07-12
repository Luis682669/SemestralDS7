<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Colaborador - Capital Humano</title>
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

        /* header with back link */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
            flex-wrap: wrap;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--card);
            color: var(--text);
            padding: 9px 15px;
            border-radius: 9px;
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: .82rem;
            transition: border-color .15s, color .15s;
        }
        .btn-back:hover { border-color: var(--accent); color: var(--accent); }

        .header-actions .titles p.eyebrow {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 2px;
        }

        .header-actions h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.3px;
        }

        /* ── GRID / CARDS ── */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 20px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 26px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        /* profile card top */
        .profile-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        .avatar-lg {
            width: 54px; height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-head .name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
        }
        .profile-head .dept {
            font-size: .8rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .info-group { margin-bottom: 16px; }
        .info-group:last-child { margin-bottom: 0; }

        .info-label {
            font-size: .68rem;
            color: var(--muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: .92rem;
            color: var(--text);
            font-weight: 600;
        }

        .doc-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--accent);
            font-weight: 700;
            font-size: .85rem;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            width: 100%;
        }
        .doc-link:hover { text-decoration: underline; }

        /* table */
        .table-wrap { overflow-x: auto; margin-bottom: 4px; }

        table { width: 100%; border-collapse: collapse; min-width: 460px; }

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
            padding: 14px;
            border-bottom: 1px solid var(--border);
            font-size: .85rem;
            color: var(--text);
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(59,91,255,0.03); }

        .cargo-nombre { font-family: 'Syne', sans-serif; font-weight: 700; }

        .badge-active {
            background: rgba(31,169,113,0.14);
            color: var(--green);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .68rem;
            font-weight: 700;
            display: inline-block;
        }
        .badge-inactive {
            background: #F1F2F6;
            color: var(--muted);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .68rem;
            font-weight: 700;
            display: inline-block;
        }

        .empty-cell { text-align: center; padding: 30px 12px; color: var(--muted); font-size: .85rem; }

        /* form */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-row .full { grid-column: 1 / -1; }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: .8rem;
            color: var(--text);
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .88rem;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #FBFCFE;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,91,255,0.12);
            background: #fff;
        }

        .help-text { font-size: .74rem; color: var(--muted); margin-top: 6px; }

        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            font-size: .87rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            width: 100%;
            margin-top: 4px;
            transition: background .15s, transform .1s;
        }
        .btn-submit:hover { background: #2E4DE0; }
        .btn-submit:active { transform: scale(.98); }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .73rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }

        @media (max-width: 900px) {
            .profile-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-container { padding: 24px 18px 44px; }
            .card { padding: 20px; }
            .form-row { grid-template-columns: 1fr; }
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
            <li class="sidebar-item">
                <a class="sidebar-link" href="/usuarios">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6"/><path d="M19 4.5a3 3 0 0 1 0 6"/></svg>
                    Usuarios
                </a>
            </li>
            <li class="sidebar-item active">
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
                <div class="sidebar-avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?></div>
                <div class="who">
                    <b><?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?></b>
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

            <div class="header-actions">
                <a href="/colaboradores" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Volver a la lista
                </a>
                <div class="titles">
                    <p class="eyebrow">Perfil del colaborador</p>
                    <h1><?php echo htmlspecialchars($colaborador['primer_nombre'] . ' ' . $colaborador['primer_apellido']); ?></h1>
                </div>
            </div>

            <div class="profile-grid">
                <div class="card">
                    <div class="profile-head">
                        <div class="avatar-lg">
                            <?php if (!empty($colaborador['foto_perfil'])): ?>
                                <img src="/uploads/<?php echo htmlspecialchars($colaborador['foto_perfil']); ?>" alt="Foto <?php echo htmlspecialchars($colaborador['primer_nombre']); ?>">
                            <?php else: ?>
                                <?php echo strtoupper(substr($colaborador['primer_nombre'], 0, 1)); ?>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="name"><?php echo htmlspecialchars($colaborador['primer_nombre'] . ' ' . $colaborador['primer_apellido']); ?></div>
                            <div class="dept"><?php echo htmlspecialchars($colaborador['departamento']); ?></div>
                        </div>
                    </div>
                    <a href="/reportes/pdf?id=<?php echo $colaborador['id']; ?>" class="btn-primary" target="_blank" style="margin-top: 10px; display: inline-block;">Descargar PDF</a>

                    <h3 class="card-title">Información General</h3>
                    <div class="info-group">
                        <div class="info-label">Cédula</div>
                        <div class="info-value"><?php echo htmlspecialchars($colaborador['identificacion']); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Departamento</div>
                        <div class="info-value"><?php echo htmlspecialchars($colaborador['departamento']); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Fecha de Contratación</div>
                        <div class="info-value"><?php echo htmlspecialchars($colaborador['fecha_contratacion']); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Tipo de Contrato</div>
                        <div class="info-value"><?php echo htmlspecialchars($colaborador['tipo_contrato']); ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Estatus Actual</div>
                        <div class="info-value"><span class="badge-active"><?php echo htmlspecialchars($colaborador['estatus'] ?? 'Activo'); ?></span></div>
                    </div>

                    <?php if(!empty($colaborador['historial_academico_pdf'])): ?>
                    <a href="/uploads/<?php echo htmlspecialchars($colaborador['historial_academico_pdf']); ?>" target="_blank" class="doc-link">
                        📄 Ver Historial Académico
                    </a>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="card" style="margin-bottom: 20px;">
                        <h3 class="card-title">Historial de Cargos y Salarios</h3>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Cargo</th>
                                        <th>Sueldo</th>
                                        <th>Fecha Inicio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($cargos)): ?>
                                        <?php foreach($cargos as $cargo): ?>
                                        <tr>
                                            <td><span class="cargo-nombre"><?php echo htmlspecialchars($cargo['nombre_cargo']); ?></span></td>
                                            <td>$<?php echo number_format($cargo['sueldo'], 0); ?></td>
                                            <td><?php echo htmlspecialchars($cargo['fecha_inicio']); ?></td>
                                            <td>
                                                <?php if($cargo['es_activo']): ?>
                                                    <span class="badge-active">Actual</span>
                                                <?php else: ?>
                                                    <span class="badge-inactive">Finalizado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4"><div class="empty-cell">No hay cargos registrados aún.</div></td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title">Registrar Nuevo Cargo</h3>
                        <form action="/colaboradores/cargo/guardar" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="colaborador_id" value="<?php echo htmlspecialchars($colaborador['id']); ?>">

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nombre del Cargo *</label>
                                    <input type="text" name="nombre_cargo" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Salario Mensual *</label>
                                    <input type="number" name="sueldo" step="1" placeholder="Ej. 122680" required autocomplete="off">
                                    <div class="help-text">Se redondeará automáticamente a entero para el cálculo exacto de planilla y CSS SIPE.</div>
                                </div>
                                <div class="form-group full">
                                    <label>Fecha de Inicio *</label>
                                    <input type="date" name="fecha_inicio" required>
                                </div>
                            </div>
                            <button type="submit" class="btn-submit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                                Asignar Cargo
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano <?php echo date('Y'); ?>
        </footer>
    </div>

</body>
</html>