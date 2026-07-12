<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planilla y Deducciones - Capital Humano</title>
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
            bottom: 0;
            height: 100vh;
            overflow-y: auto;
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

        .sidebar-nav { list-style: none; display: flex; flex-direction: column; gap: 3px; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 11px 12px; border-radius: 10px; color: rgba(255,255,255,0.56); font-size: .85rem; font-weight: 500; transition: background .15s, color .15s; }
        .sidebar-link:hover { color: #fff; background: rgba(255,255,255,0.06); }
        .sidebar-item.active .sidebar-link { color: #fff; background: linear-gradient(90deg, rgba(59,91,255,0.35), rgba(59,91,255,0.05)); box-shadow: inset 2px 0 0 var(--accent); }

        .sidebar-foot { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 16px; }
        .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 8px 10px 14px; }
        .sidebar-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent2)); display: flex; align-items: center; justify-content: center; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .8rem; color: #fff; flex-shrink: 0; }
        .sidebar-user .who { display: flex; flex-direction: column; overflow: hidden; }
        .sidebar-user .who b { font-size: .82rem; color: #fff; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .who span { font-size: .7rem; color: rgba(255,255,255,0.45); }
        .btn-logout { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; background: rgba(229,72,77,0.14); color: #FF8589; border: 1px solid rgba(229,72,77,0.3); border-radius: 10px; font-size: .8rem; font-weight: 600; transition: background .15s, color .15s; }
        .btn-logout:hover { background: var(--danger); color: #fff; }

        .main-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; margin-left: 232px; }
        .main-container { flex: 1; padding: 34px 40px 56px; max-width: 1240px; width: 100%; margin: 0 auto; }

        .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-bottom: 26px; }
        .page-header h1 { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--text); margin-bottom: 8px; }
        .page-header p { color: var(--muted); max-width: 760px; }

        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 2px 14px rgba(16,26,61,0.04); margin-bottom: 24px; }
        .card-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid var(--border); }

        .form-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 0.8fr; gap: 16px; align-items: end; }
        .form-group { margin-bottom: 0; }
        .form-group label { display: block; margin-bottom: 10px; font-weight: 600; font-size: .88rem; color: var(--text); }
        select, input[type="number"] { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 12px; background: #FBFCFE; color: var(--text); font-size: .92rem; }
        select:focus, input[type="number"]:focus { border-color: var(--accent); outline: none; box-shadow: 0 0 0 3px rgba(59,91,255,0.12); }

        .btn-submit { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px 18px; border-radius: 12px; border: none; background: var(--accent); color: #fff; font-size: .95rem; font-weight: 700; cursor: pointer; transition: background .15s, transform .1s; }
        .btn-submit:hover { background: #2E4DE0; }
        .btn-submit:active { transform: scale(.98); }

        .btn-secondary { display: inline-flex; align-items: center; justify-content: center; padding: 10px 16px; border-radius: 12px; border: 1px solid rgba(16,26,61,0.08); background: #F6F7FB; color: var(--text); font-weight: 600; transition: background .15s, color .15s; text-decoration: none; }
        .btn-secondary:hover { background: #E9EDF7; }

        .card-heading-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 18px; }

        .alert-success, .alert-danger { padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-size: .95rem; }
        .alert-success { background: #dff3e9; color: #0f5132; border: 1px solid #b7dfca; }
        .alert-danger { background: #fde8ea; color: #842029; border: 1px solid #f5c2c7; }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 14px 16px; border-bottom: 1px solid var(--border); }
        th { text-align: left; font-size: .72rem; letter-spacing: .4px; text-transform: uppercase; color: var(--muted); }
        td { font-size: .9rem; color: var(--text); }
        .number-col { text-align: right; font-family: 'Inter', monospace; }
        .empty-row td { text-align: center; color: var(--muted); }

        @media (max-width: 980px) { .form-grid { grid-template-columns: 1fr; } }
        @media (max-width: 760px) { .sidebar { display: none; } .main-container { padding: 24px 18px 44px; } }
    </style>
</head>
<body>

    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>
        <ul class="sidebar-nav">
            <li class="sidebar-item"><a class="sidebar-link" href="/home">Inicio</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/usuarios">Usuarios</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/colaboradores">Colaboradores</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/vacaciones">Vacaciones</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/reportes">Reportes</a></li>
            <li class="sidebar-item active"><a class="sidebar-link" href="/planillas">Planillas</a></li>
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
            <div class="page-header">
                <div>
                    <h1>Planilla y Deducciones</h1>
                    <p>Genera pagos mensuales, calcula deducciones obligatorias y revisa el historial de planillas con el mismo diseño del resto de la app.</p>
                </div>
            </div>

            <?php if(isset($_GET['msg'])): ?>
                <?php if($_GET['msg'] === 'exito'): ?>
                    <div class="alert-success">✅ Planilla generada y calculada correctamente.</div>
                <?php elseif($_GET['msg'] === 'error_salario'): ?>
                    <div class="alert-danger">❌ Error: El colaborador seleccionado no tiene un salario activo asignado.</div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card">
                <h2 class="card-title">Generar Pago Mensual</h2>
                <form action="/planillas/generar" method="POST" class="form-grid">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

                    <div class="form-group">
                        <label>Colaborador</label>
                        <select name="colaborador_id" required>
                            <option value="">-- Seleccione empleado --</option>
                            <?php foreach($colaboradores as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['identificacion'] . ' - ' . $c['primer_nombre'] . ' ' . $c['primer_apellido']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mes</label>
                        <select name="mes" required>
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio" selected>Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Septiembre">Septiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" value="2026" required>
                    </div>

                    <button type="submit" class="btn-submit">Procesar Pago</button>
                </form>
            </div>

            <div class="card">
                <div class="card-heading-row">
                    <h2 class="card-title">Registro de Planillas Procesadas</h2>
                    <a href="/planillas/exportar" class="btn-secondary">Exportar a Excel</a>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Recibo #</th>
                                <th>Colaborador</th>
                                <th>Periodo</th>
                                <th class="number-col">Salario Base</th>
                                <th class="number-col" style="color: #e04f5f;">(-) CSS SIPE</th>
                                <th class="number-col" style="color: #e04f5f;">(-) Seg. Edu.</th>
                                <th class="number-col" style="color: #1a73e8;">(P) XIII Mes</th>
                                <th class="number-col" style="color: #137333;">Neto a Pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($planillas)): ?>
                                <?php foreach($planillas as $p): ?>
                                <tr>
                                    <td><?php echo str_pad($p['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo htmlspecialchars($p['primer_nombre'] . ' ' . $p['primer_apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($p['mes'] . ' ' . $p['anio']); ?></td>
                                    <td class="number-col">$<?php echo number_format($p['salario_base'], 0); ?></td>
                                    <td class="number-col" style="color: #e04f5f;">$<?php echo number_format($p['css_sipe'], 0); ?></td>
                                    <td class="number-col" style="color: #e04f5f;">$<?php echo number_format($p['seguro_educativo'], 0); ?></td>
                                    <td class="number-col" style="color: #1a73e8;">$<?php echo number_format($p['xiii_mes'], 0); ?></td>
                                    <td class="number-col" style="font-weight: 700; color: #137333;">$<?php echo number_format($p['salario_neto'], 0); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8" class="empty-row">No hay pagos procesados en el sistema.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>