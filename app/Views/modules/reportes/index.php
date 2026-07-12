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
        }

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
        }

        .page-link.active,
        .page-link:hover {
            background: var(--accent);
            color: #fff;
        }

        .report-icon {
            font-size: 2rem;
            margin-bottom: 18px;
        }

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
            transition: background .15s, transform .1s;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            border: none;
        }

        .btn-primary:hover { background: #2E4DE0; }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: #e2e8f0; }

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
                <div class="sidebar-avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)); ?></div>
                <div class="who">
                    <b><?php echo htmlspecialchars($_SESSION['username'] ?? 'Usuario'); ?></b>
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
                    <a href="/reportes/listado" class="btn-primary" target="_blank">Generar PDF</a>
                </div>

                <div class="report-card">
                    <div>
                        <div class="report-icon">🌴</div>
                        <h3 class="report-title">Estado de Vacaciones</h3>
                        <p class="report-desc">Genera un PDF con todas las solicitudes y su estado actual, incluidos los permisos de vacaciones.</p>
                    </div>
                    <a href="/reportes/vacaciones" class="btn-primary" target="_blank">Generar PDF</a>
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
                            <?php foreach ($colaboradoresBySexo as $row): ?>
                                <li><strong><?php echo htmlspecialchars($row['sexo'] === '' ? 'No especificado' : $row['sexo']); ?>:</strong> <?php echo (int)$row['total']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="stat-card">
                        <h4>Colaboradores por Rango de Edad</h4>
                        <ul>
                            <li><strong>18-24:</strong> <?php echo (int)$colaboradoresByAge['age_18_24']; ?></li>
                            <li><strong>25-30:</strong> <?php echo (int)$colaboradoresByAge['age_25_30']; ?></li>
                            <li><strong>31-40:</strong> <?php echo (int)$colaboradoresByAge['age_31_40']; ?></li>
                            <li><strong>41-50:</strong> <?php echo (int)$colaboradoresByAge['age_41_50']; ?></li>
                            <li><strong>51+ :</strong> <?php echo (int)$colaboradoresByAge['age_51_plus']; ?></li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="table-section">
                <div class="table-header">
                    <h2>Colaboradores Activos</h2>
                    <p>Mostrando página <?php echo $page; ?> de <?php echo $totalPages; ?>.</p>
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
                            <?php if (!empty($colaboradores)): ?>
                                <?php foreach ($colaboradores as $col): ?>
                                    <?php $edad = $col['fecha_nacimiento'] ? (new DateTime($col['fecha_nacimiento']))->diff(new DateTime())->y : '-'; ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($col['identificacion']); ?></td>
                                        <td><?php echo htmlspecialchars($col['primer_nombre'] . ' ' . $col['primer_apellido']); ?></td>
                                        <td><?php echo htmlspecialchars($col['sexo'] ?: 'N/A'); ?></td>
                                        <td><?php echo is_numeric($edad) ? $edad : '-'; ?></td>
                                        <td><?php echo htmlspecialchars($col['departamento']); ?></td>
                                        <td><?php echo htmlspecialchars($col['estatus'] ?? 'Activo'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No hay colaboradores activos para mostrar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="/reportes?page=<?php echo $i; ?>" class="page-link<?php echo $i === $page ? ' active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            </section>
        </main>
    </div>

</body>
</html>