<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Colaborador - Capital Humano</title>
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
            max-width: 880px;
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
            text-align: center;
        }

        .page-title h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.4px;
            text-align: center;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px 32px 28px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: .96rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 18px;
            margin-top: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title:first-of-type { margin-top: 0; }

        .section-title .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 18px 20px;
        }

        .form-group { margin-bottom: 4px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: .8rem;
            color: var(--text);
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
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

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,91,255,0.12);
            background: #fff;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%238891A6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        /* file upload */
        .upload-box {
            grid-column: 1 / -1;
            background: rgba(59,91,255,0.04);
            padding: 18px 20px;
            border-radius: 12px;
            border: 1px dashed rgba(59,91,255,0.35);
        }

        .upload-box label {
            color: var(--accent);
            font-weight: 700;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 10px;
        }

        input[type="file"] {
            width: 100%;
            padding: 9px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: .82rem;
            color: var(--text);
        }

        .upload-hint {
            font-size: .74rem;
            color: var(--muted);
            margin-top: 8px;
        }

        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            padding: 13px 24px;
            border-radius: 10px;
            border: none;
            font-size: .9rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            width: 100%;
            margin-top: 28px;
            transition: background .15s, transform .1s;
        }
        .btn-submit:hover { background: #2E4DE0; }
        .btn-submit:active { transform: scale(.98); }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: var(--muted);
            font-size: .82rem;
            font-weight: 500;
        }
        .btn-cancel:hover { color: var(--text); text-decoration: underline; }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .73rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }

        /* --- ANIMACIONES DE ENTRADA --- */
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-14px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .page-title { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }
        .form-card { opacity: 0; animation: fadeSlideUp .5s ease .2s forwards; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .001s !important;
                animation-delay: 0s !important;
                transition-duration: .001s !important;
            }
        }

        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-container { padding: 24px 18px 44px; }
            .form-card { padding: 24px 22px; }
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

            <div class="page-title">
                <p class="eyebrow">Colaboradores</p>
                <h1>Registrar Nuevo Colaborador</h1>
            </div>

            <div class="form-card">
                <form action="/colaboradores/guardar" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

                    <h3 class="section-title"><span class="dot"></span>Datos Personales</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="identificacion">Cédula / Identificación *</label>
                            <input type="text" id="identificacion" name="identificacion" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento *</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="form-group">
                            <label for="primer_nombre">Primer Nombre *</label>
                            <input type="text" id="primer_nombre" name="primer_nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="segundo_nombre">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre" name="segundo_nombre">
                        </div>
                        <div class="form-group">
                            <label for="primer_apellido">Primer Apellido *</label>
                            <input type="text" id="primer_apellido" name="primer_apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="segundo_apellido">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido" name="segundo_apellido">
                        </div>
                        <div class="form-group">
                            <label for="sexo">Sexo *</label>
                            <select id="sexo" name="sexo" required>
                                <option value="">Seleccione...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>

                    <h3 class="section-title"><span class="dot"></span>Datos de Contacto</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="correo_personal">Correo Electrónico</label>
                            <input type="email" id="correo_personal" name="correo_personal">
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" id="celular" name="celular">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono Fijo</label>
                            <input type="text" id="telefono" name="telefono">
                        </div>
                        <div class="form-group full">
                            <label for="direccion">Dirección Residencial</label>
                            <input type="text" id="direccion" name="direccion">
                        </div>
                        <div class="form-group full">
                            <label for="foto_perfil">Foto de Perfil</label>
                            <input type="file" id="foto_perfil" name="foto_perfil" accept="image/jpeg,image/png,image/webp">
                            <p class="upload-hint">Formatos permitidos: JPG, PNG, WEBP. Tamaño recomendado: 2MB.</p>
                        </div>
                    </div>

                    <h3 class="section-title"><span class="dot"></span>Datos Laborales e Historial Académico</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="departamento">Departamento *</label>
                            <input type="text" id="departamento" name="departamento" required>
                        </div>
                        <div class="form-group">
                            <label for="ocupacion">Cargo / Ocupación *</label>
                            <input type="text" id="ocupacion" name="ocupacion" required>
                        </div>
                        <div class="form-group">
                            <label for="sueldo">Sueldo *</label>
                            <input type="number" id="sueldo" name="sueldo" step="1" min="0" placeholder="Ej. 120000" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_contratacion">Fecha de Contratación *</label>
                            <input type="date" id="fecha_contratacion" name="fecha_contratacion" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_contrato">Tipo de Contrato *</label>
                            <select id="tipo_contrato" name="tipo_contrato" required>
                                <option value="">Seleccione...</option>
                                <option value="Permanente">Permanente</option>
                                <option value="Eventual">Eventual</option>
                                <option value="Interino">Interino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="estatus">Estatus Inicial *</label>
                            <select id="estatus" name="estatus" required>
                                <option value="Activo" selected>Activo</option>
                                <option value="Vacaciones">Vacaciones</option>
                                <option value="Licencia">Licencia</option>
                                <option value="Incapacitado">Incapacitado</option>
                            </select>
                        </div>

                        <div class="upload-box">
                            <label for="historial_academico">📄 Subir Historial Académico (Formato PDF)</label>
                            <input type="file" id="historial_academico" name="historial_academico" accept=".pdf">
                            <p class="upload-hint">Tamaño máximo recomendado: 5MB.</p>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                        Guardar Colaborador
                    </button>
                    <a href="/colaboradores" class="btn-cancel">Cancelar y volver a la lista</a>
                </form>
            </div>

        </main>

        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano <?php echo date('Y'); ?>
        </footer>
    </div>

</body>
</html>