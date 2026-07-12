<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permiso de Vacaciones - Capital Humano</title>
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
            max-width: 620px;
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

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: .82rem;
            color: var(--text);
        }

        .form-group .hint {
            display: block;
            margin-top: 6px;
            font-size: .74rem;
            color: var(--muted);
        }

        .date-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .9rem;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #FBFCFE;
            transition: border-color .15s, box-shadow .15s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
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

        /* ── Resumen de días (dinámico) ── */
        .days-summary {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(59,91,255,0.06);
            border: 1px solid rgba(59,91,255,0.14);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height .35s ease, opacity .3s ease, margin .35s ease, padding .35s ease;
        }
        .days-summary.show { max-height: 60px; opacity: 1; }
        .days-summary .icon {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .days-summary b { font-family: 'Syne', sans-serif; font-size: .95rem; }
        .days-summary span { font-size: .78rem; color: var(--muted); display: block; }

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
            margin-top: 6px;
            transition: background .15s, transform .1s, box-shadow .15s;
            position: relative;
        }
        .btn-submit:hover { background: #2E4DE0; box-shadow: 0 6px 16px rgba(59,91,255,0.28); }
        .btn-submit:active { transform: scale(.98); }
        .btn-submit svg { transition: transform .2s; }
        .btn-submit:hover svg { transform: rotate(90deg); }

        .btn-submit.loading { color: transparent; pointer-events: none; }
        .btn-submit.loading svg { opacity: 0; }
        .btn-submit.loading::after {
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
        .btn-submit.success { background: var(--green); }

        @keyframes spin { to { transform: rotate(360deg); } }

        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: var(--muted);
            font-size: .82rem;
            font-weight: 500;
            transition: color .15s;
        }
        .btn-cancel:hover { color: var(--text); text-decoration: underline; }

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
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fieldIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%      { transform: translateX(-6px); }
            40%      { transform: translateX(5px); }
            60%      { transform: translateX(-4px); }
            80%      { transform: translateX(3px); }
        }
        @keyframes popNumber {
            0%   { transform: scale(1); }
            40%  { transform: scale(1.25); }
            100% { transform: scale(1); }
        }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .page-title { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }
        .form-card { opacity: 0; animation: fadeSlideUp .5s ease .2s forwards; }

        .form-group { opacity: 0; animation: fieldIn .4s ease forwards; }
        .form-group:nth-of-type(1) { animation-delay: .35s; }
        .form-group:nth-of-type(2) { animation-delay: .42s; }
        .form-group:nth-of-type(3) { animation-delay: .49s; }

        .btn-submit { opacity: 0; animation: fieldIn .4s ease .6s forwards; }
        .btn-cancel { opacity: 0; animation: fieldIn .4s ease .66s forwards; }

        .form-group.invalid input,
        .form-group.invalid select { animation: shake .4s ease; border-color: var(--danger); }

        .days-summary b.pop { animation: popNumber .35s ease; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-container { padding: 24px 18px 44px; }
            .form-card { padding: 24px 22px; }
            .date-row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

    <!-- Toast de confirmación -->
    <div class="toast" id="toast">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        Permiso registrado correctamente
    </div>

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
                <p class="eyebrow">Permisos de Vacaciones</p>
                <h1>Registrar Permiso de Vacaciones</h1>
            </div>

            <div class="form-card">
                <form id="demo-form">
                    <input type="hidden" name="csrf_token" value="demo">

                    <div class="form-group">
                        <label for="colaborador_id">Colaborador</label>
                        <select id="colaborador_id" name="colaborador_id" required>
                            <option value="">-- Seleccione colaborador --</option>
                            <option value="1">8-123-4567 - María Torres</option>
                            <option value="2">8-234-5678 - Samuel Smith</option>
                            <option value="3">8-345-6789 - Meredith Silva</option>
                        </select>
                    </div>

                    <div class="date-row">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </div>

                    <div class="days-summary" id="days-summary">
                        <div class="icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                        </div>
                        <div>
                            <b id="days-count">0 días</b>
                            <span>Duración total del permiso solicitado</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="motivo">Motivo (opcional)</label>
                        <input type="text" id="motivo" name="motivo" placeholder="Ej. vacaciones anuales, permiso especial">
                    </div>

                    <button type="submit" class="btn-submit" id="demo-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                        Registrar Permiso
                    </button>
                    <a href="/vacaciones" class="btn-cancel">Cancelar y volver</a>
                </form>
            </div>

        </main>

        <footer>
            Proyecto UTP &mdash; Jeremías, Juan y Luis &nbsp;·&nbsp; Capital Humano 2026
        </footer>
    </div>

    <script>
        var inicio = document.getElementById('fecha_inicio');
        var fin = document.getElementById('fecha_fin');
        var summary = document.getElementById('days-summary');
        var count = document.getElementById('days-count');

        function updateDays() {
            if (inicio.value && fin.value) {
                var d1 = new Date(inicio.value);
                var d2 = new Date(fin.value);
                var diff = Math.round((d2 - d1) / 86400000) + 1;
                if (diff > 0) {
                    count.textContent = diff + (diff === 1 ? ' día' : ' días');
                    count.classList.remove('pop');
                    void count.offsetWidth;
                    count.classList.add('pop');
                    summary.classList.add('show');
                    return;
                }
            }
            summary.classList.remove('show');
        }

        inicio.addEventListener('change', updateDays);
        fin.addEventListener('change', updateDays);

        document.getElementById('demo-form').addEventListener('submit', function (e) {
            e.preventDefault();
            var colaborador = document.getElementById('colaborador_id');
            var groups = [colaborador.closest('.form-group'), inicio.closest('.form-group'), fin.closest('.form-group')];
            groups.forEach(function (g) { g.classList.remove('invalid'); });

            if (!colaborador.value) { colaborador.closest('.form-group').classList.add('invalid'); return; }
            if (!inicio.value) { inicio.closest('.form-group').classList.add('invalid'); return; }
            if (!fin.value) { fin.closest('.form-group').classList.add('invalid'); return; }

            var btn = document.getElementById('demo-submit');
            btn.classList.add('loading');
            setTimeout(function () {
                btn.classList.remove('loading');
                btn.classList.add('success');
                btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg> Registrado';
                var toast = document.getElementById('toast');
                toast.classList.add('show');
                setTimeout(function () { toast.classList.remove('show'); }, 2600);
            }, 850);
        });
    </script>

</body>
</html>