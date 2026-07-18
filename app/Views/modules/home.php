<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Capital Humano</title>
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
        .main-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; margin-left: 232px; }

        .main-container {
            flex: 1;
            padding: 34px 40px 56px;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
        }

        /* greeting header */
        .greet-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 100%);
            border-radius: 20px;
            padding: 30px 34px 26px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
        }

        .greet-header::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(59,91,255,0.35), transparent 70%);
            border-radius: 50%;
        }

        .greet-eyebrow {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 6px;
            position: relative;
        }

        .greet-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.4px;
            margin-bottom: 18px;
            position: relative;
        }

        .search-bar {
            position: relative;
            max-width: 480px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.08);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: .85rem;
        }
        .search-bar input::placeholder { color: rgba(255,255,255,0.45); }
        .search-bar input:focus { outline: none; border-color: var(--accent); background: rgba(255,255,255,0.12); }

        .search-bar svg {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.5);
        }

        /* quick actions */
        .quick-actions {
            display: flex;
            justify-content: center;
            gap: 36px;
            margin-bottom: 30px;
            padding: 0 4px;
            flex-wrap: wrap;
        }

        .qa-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 10px;
            width: 92px;
            padding: 10px 0;
        }

        .qa-icon {
            width: 60px; height: 60px;
            margin: 0 auto;
            border-radius: 50%;
            background: var(--card);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 2px 10px rgba(16,26,61,0.06);
            transition: transform .18s, box-shadow .18s, border-color .18s;
        }

        .qa-item:hover .qa-icon {
            transform: translateY(-4px);
            border-color: var(--accent);
            box-shadow: 0 10px 22px rgba(59,91,255,0.22);
        }

        .qa-item span {
            font-size: .74rem;
            font-weight: 600;
            color: var(--muted);
            text-align: center;
            line-height: 1.25;
            transition: color .15s;
        }

        .qa-item:hover span { color: var(--text); }

        /* grid */
        .dash-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .card-head h2 {
            font-family: 'Syne', sans-serif;
            font-size: .98rem;
            font-weight: 700;
            color: var(--text);
        }

        .card-head a {
            font-size: .76rem;
            font-weight: 600;
            color: var(--accent);
        }
        .card-head a:hover { text-decoration: underline; }

        /* upcoming card */
        .upcoming-tag {
            display: inline-block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .4px;
            text-transform: uppercase;
            color: var(--accent);
            background: rgba(59,91,255,0.1);
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 14px;
        }

        .due-row {
            display: flex;
            gap: 28px;
            margin-bottom: 18px;
        }

        .due-col span { display: block; }
        .due-col .lbl { font-size: .68rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 4px; }
        .due-col .val { font-family: 'Syne', sans-serif; font-size: .95rem; font-weight: 700; color: var(--text); }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
            border: none;
            transition: background .15s, transform .1s;
        }
        .btn-primary:hover { background: #2E4DE0; }
        .btn-primary:active { transform: scale(.98); }

        /* todos */
        .todo-list { display: flex; flex-direction: column; gap: 14px; }

        .todo-item { display: flex; gap: 12px; align-items: flex-start; }

        .todo-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            margin-top: 6px;
            flex-shrink: 0;
        }
        .todo-dot.urgent { background: var(--danger); }
        .todo-dot.soon   { background: var(--amber); }
        .todo-dot.normal { background: var(--teal); }

        .todo-body p { font-size: .82rem; font-weight: 600; color: var(--text); margin-bottom: 2px; }
        .todo-body span { font-size: .72rem; color: var(--muted); }

        /* modules row (quick links repurposed) */
        .modules-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .module-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 22px 20px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 14px rgba(16,26,61,0.04);
            transition: border-color .2s, box-shadow .2s, transform .2s;
        }

        .module-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }
        .module-card.blue::before   { background: linear-gradient(90deg, var(--accent), var(--accent2)); }
        .module-card.teal::before   { background: linear-gradient(90deg, var(--teal), var(--accent)); }
        .module-card.purple::before { background: linear-gradient(90deg, var(--accent2), #a855f7); }

        .module-card:hover {
            border-color: rgba(59,91,255,0.35);
            box-shadow: 0 10px 28px rgba(16,26,61,0.1);
            transform: translateY(-3px);
        }

        .module-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 14px;
        }
        .icon-blue   { background: rgba(59,91,255,0.12); color: var(--accent); }
        .icon-teal   { background: rgba(14,186,197,0.12); color: var(--teal); }
        .icon-purple { background: rgba(108,99,255,0.12); color: var(--accent2); }

        .module-title { font-family: 'Syne', sans-serif; font-size: .95rem; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .module-desc { font-size: .78rem; color: var(--muted); line-height: 1.55; margin-bottom: 16px; flex: 1; }

        .module-stat {
            display: flex; align-items: baseline; gap: 6px;
            margin-bottom: 16px;
        }
        .module-stat b { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 800; color: var(--text); }
        .module-stat span { font-size: .72rem; color: var(--muted); }

        .module-btn {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 10px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: rgba(59,91,255,0.04);
            color: var(--text);
            font-size: .8rem;
            font-weight: 600;
            transition: background .15s, border-color .15s, color .15s;
        }
        .module-btn svg { transition: transform .2s; }
        .module-btn:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
        .module-btn:hover svg { transform: translateX(3px); }

        /* bottom grid: chart + calendar */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 20px;
        }

        .chart-wrap { display: flex; align-items: flex-end; gap: 14px; height: 150px; padding-top: 8px; }

        .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; height: 100%; justify-content: flex-end; }

        .bar { width: 100%; max-width: 30px; border-radius: 6px 6px 2px 2px; background: linear-gradient(180deg, var(--accent2), var(--accent)); }
        .bar-col span { font-size: .68rem; color: var(--muted); font-weight: 600; }

        .total-line { display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px; }
        .total-line b { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--text); }
        .total-line span { font-size: .76rem; color: var(--green); font-weight: 600; }

        /* calendar */
        .cal-month {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }
        .cal-month b { font-family: 'Syne', sans-serif; font-size: .9rem; color: var(--text); }
        .cal-nav { display: flex; gap: 6px; }
        .cal-nav button {
            width: 26px; height: 26px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .cal-nav button:hover { border-color: var(--accent); color: var(--accent); }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            text-align: center;
        }
        .cal-grid .dow { font-size: .65rem; font-weight: 700; color: var(--muted); padding-bottom: 6px; }
        .cal-grid .day {
            font-size: .76rem;
            color: var(--text);
            padding: 7px 0;
            border-radius: 8px;
        }
        .cal-grid .day.muted { color: #C7CCDA; }
        .cal-grid .day.today { background: var(--accent); color: #fff; font-weight: 700; }
        .cal-grid .day.event { position: relative; background: rgba(14,186,197,0.12); color: var(--teal); font-weight: 700; }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .73rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }

        /* ── ANIMACIONES ── */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes popIn {
            0%   { opacity: 0; transform: scale(.6); }
            70%  { opacity: 1; transform: scale(1.08); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-14px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulseDot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(229,72,77,0.45); }
            50%      { box-shadow: 0 0 0 6px rgba(229,72,77,0); }
        }
        @keyframes growBar {
            from { transform: scaleY(0); }
            to   { transform: scaleY(1); }
        }
        @keyframes shimmerTag {
            0%   { background-position: -120px 0; }
            100% { background-position: 220px 0; }
        }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .greet-header { opacity: 0; animation: fadeSlideUp .55s ease .1s forwards; }

        .qa-item { opacity: 0; animation: popIn .5s cubic-bezier(.34,1.56,.64,1) forwards; }
        .qa-item:nth-child(1) { animation-delay: .35s; }
        .qa-item:nth-child(2) { animation-delay: .42s; }
        .qa-item:nth-child(3) { animation-delay: .49s; }
        .qa-item:nth-child(4) { animation-delay: .56s; }
        .qa-item:nth-child(5) { animation-delay: .63s; }

        .dash-grid .card { opacity: 0; animation: fadeSlideUp .5s ease forwards; }
        .dash-grid .card:nth-child(1) { animation-delay: .5s; }
        .dash-grid .card:nth-child(2) { animation-delay: .58s; }

        .module-card { opacity: 0; animation: fadeSlideUp .5s ease forwards; }
        .module-card:nth-child(1) { animation-delay: .6s; }
        .module-card:nth-child(2) { animation-delay: .67s; }
        .module-card:nth-child(3) { animation-delay: .74s; }
        .module-card:nth-child(4) { animation-delay: .81s; }

        .bottom-grid .card { opacity: 0; animation: fadeSlideUp .5s ease forwards; }
        .bottom-grid .card:nth-child(1) { animation-delay: .85s; }
        .bottom-grid .card:nth-child(2) { animation-delay: .92s; }

        .card { transition: transform .2s ease, box-shadow .2s ease; }
        .dash-grid .card:hover, .bottom-grid .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(16,26,61,0.08); }

        .todo-dot.urgent { animation: pulseDot 1.8s ease-out infinite; }

        .upcoming-tag {
            background-size: 200px 100%;
            background-image: linear-gradient(120deg, rgba(59,91,255,0.1) 30%, rgba(59,91,255,0.22) 50%, rgba(59,91,255,0.1) 70%);
            animation: shimmerTag 2.6s ease-in-out infinite;
        }

        .bar { transform-origin: bottom; animation: growBar .7s cubic-bezier(.22,1,.36,1) both; }
        .bar-col:nth-child(1) .bar { animation-delay: .95s; }
        .bar-col:nth-child(2) .bar { animation-delay: 1.0s; }
        .bar-col:nth-child(3) .bar { animation-delay: 1.05s; }
        .bar-col:nth-child(4) .bar { animation-delay: 1.1s; }
        .bar-col:nth-child(5) .bar { animation-delay: 1.15s; }
        .bar-col:nth-child(6) .bar { animation-delay: 1.2s; }
        .bar:hover { filter: brightness(1.08); }

        .cal-grid .day { opacity: 0; animation: fadeIn .3s ease forwards; transition: background .15s, color .15s, transform .15s; }
        .cal-grid .day:hover { transform: scale(1.1); }
        .cal-grid .day.today { animation: fadeIn .3s ease forwards, popIn .5s cubic-bezier(.34,1.56,.64,1) 1.4s; }

        .btn-primary, .module-btn { transition: background .15s, transform .12s, box-shadow .15s; }
        .btn-primary:hover { box-shadow: 0 8px 18px rgba(59,91,255,0.28); }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1080px) {
            .dash-grid, .bottom-grid { grid-template-columns: 1fr; }
            .modules-row { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 760px) {
            .sidebar { display: none; }
            .main-wrap { margin-left: 0; }
            .main-container { padding: 24px 18px 44px; }
            .modules-row { grid-template-columns: 1fr; }
            .quick-actions { gap: 16px; }
        }
    </style>
</head>
<body>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>

        <ul class="sidebar-nav">
            <li class="sidebar-item active">
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
                <div class="sidebar-avatar"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                <div class="who">
                    <b><?php echo htmlspecialchars($username); ?></b>
                    <span><?php echo htmlspecialchars($rol_nombre); ?></span>
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

            <!-- Greeting header -->
            <div class="greet-header">
                <p class="greet-eyebrow">Panel de Control</p>
                <h1>Buenos días, <?php echo htmlspecialchars($username); ?></h1>
                <div class="search-bar">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" placeholder="¿En qué podemos ayudarte hoy?">
                </div>
            </div>

            <!-- Quick actions -->
            <div class="quick-actions">
                <a class="qa-item" href="/colaboradores/nuevo">
                    <div class="qa-icon">🧑‍💼</div>
                    <span>Nuevo colaborador</span>
                </a>
                <a class="qa-item" href="/usuarios/nuevo">
                    <div class="qa-icon">🔐</div>
                    <span>Nuevo usuario</span>
                </a>
                <a class="qa-item" href="/vacaciones/solicitud">
                    <div class="qa-icon">🏖️</div>
                    <span>Solicitar vacaciones</span>
                </a>
                <a class="qa-item" href="/vacaciones?filtro=pendientes">
                    <div class="qa-icon">✅</div>
                    <span>Revisar solicitudes</span>
                </a>
                <a class="qa-item" href="/reportes">
                    <div class="qa-icon">📋</div>
                    <span>Generar reporte</span>
                </a>
            </div>

            <!-- Top grid: upcoming + to-dos -->
            <div class="dash-grid">
                <div class="card">
                    <div class="card-head">
                        <h2>Próximas vacaciones</h2>
                        <a href="/vacaciones">Ver todas</a>
                    </div>
                    <span class="upcoming-tag">5 solicitudes pendientes</span>
                    <div class="due-row">
                        <div class="due-col">
                            <span class="lbl">Próxima salida</span>
                            <span class="val">María Torres</span>
                        </div>
                        <div class="due-col">
                            <span class="lbl">Periodo</span>
                            <span class="val">07/07 – 14/07</span>
                        </div>
                        <div class="due-col">
                            <span class="lbl">Días hábiles</span>
                            <span class="val">6 días</span>
                        </div>
                    </div>
                    <button class="btn-primary">Revisar solicitudes pendientes</button>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>Pendientes por hacer</h2>
                        <a href="/reportes">Ver todo</a>
                    </div>
                    <div class="todo-list">
                        <div class="todo-item">
                            <span class="todo-dot urgent"></span>
                            <div class="todo-body">
                                <p>Expediente incompleto de Samuel Smith</p>
                                <span>Vence hoy</span>
                            </div>
                        </div>
                        <div class="todo-item">
                            <span class="todo-dot soon"></span>
                            <div class="todo-body">
                                <p>Aprobar resuelto de vacaciones de Meredith Silva</p>
                                <span>Vence en 3 días</span>
                            </div>
                        </div>
                        <div class="todo-item">
                            <span class="todo-dot normal"></span>
                            <div class="todo-body">
                                <p>Asignar departamento a 2 colaboradores nuevos</p>
                                <span>Sin fecha límite</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module cards -->
            <div class="modules-row">
                <div class="module-card blue">
                    <div class="module-icon icon-blue">🔐</div>
                    <h3 class="module-title">Usuarios Administrativos</h3>
                    <div class="module-stat"><b class="count-up" data-target="8">0</b><span>cuentas activas</span></div>
                    <p class="module-desc">Gestión de accesos, asignación de roles de seguridad (Admin, RRHH) y suspensiones de cuenta.</p>
                    <a href="/usuarios" class="module-btn">
                        Administrar
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="module-card teal">
                    <div class="module-icon icon-teal">👤</div>
                    <h3 class="module-title">Colaboradores</h3>
                    <div class="module-stat"><b class="count-up" data-target="124">0</b><span>en plantilla</span></div>
                    <p class="module-desc">Alta de personal, expedientes académicos en PDF, asignación de departamentos y contratos.</p>
                    <a href="/colaboradores" class="module-btn">
                        Ver personal
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="module-card purple">
                    <div class="module-icon icon-purple">🏖️</div>
                    <h3 class="module-title">Vacaciones y Permisos</h3>
                    <div class="module-stat"><b class="count-up" data-target="14">0</b><span>activas ahora</span></div>
                    <p class="module-desc">Cálculo automatizado de días acumulados, registro de ausencias y generación de resueltos oficiales.</p>
                    <a href="/vacaciones" class="module-btn">
                        Gestionar
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="module-card blue">
                    <div class="module-icon icon-blue">💼</div>
                    <h3 class="module-title">Planillas</h3>
                    <div class="module-stat"><b>0</b><span>pagos recientes</span></div>
                    <p class="module-desc">Genera la planilla mensual, calcula deducciones y visualiza el historial de pagos procesados.</p>
                    <a href="/planillas" class="module-btn">
                        Ir a Planilla
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Bottom grid: chart + calendar -->
            <div class="bottom-grid">
                <div class="card">
                    <div class="card-head">
                        <h2>Reportes generados</h2>
                        <a href="/reportes">Ver detalle</a>
                    </div>
                    <div class="total-line"><b>6</b><span>↓ 2 vs. mes anterior</span></div>
                    <div class="chart-wrap">
                        <div class="bar-col"><div class="bar" style="height:38%"></div><span>Ene</span></div>
                        <div class="bar-col"><div class="bar" style="height:55%"></div><span>Feb</span></div>
                        <div class="bar-col"><div class="bar" style="height:70%"></div><span>Mar</span></div>
                        <div class="bar-col"><div class="bar" style="height:48%"></div><span>Abr</span></div>
                        <div class="bar-col"><div class="bar" style="height:90%"></div><span>May</span></div>
                        <div class="bar-col"><div class="bar" style="height:60%"></div><span>Jun</span></div>
                    </div>
                </div>

                <div class="card">
                    <div class="cal-month">
                        <b>Julio 2026</b>
                        <div class="cal-nav">
                            <button aria-label="Mes anterior">‹</button>
                            <button aria-label="Mes siguiente">›</button>
                        </div>
                    </div>
                    <div class="cal-grid">
                        <span class="dow">Su</span><span class="dow">Mo</span><span class="dow">Tu</span><span class="dow">We</span><span class="dow">Th</span><span class="dow">Fr</span><span class="dow">Sa</span>
                        <span class="day muted">28</span><span class="day muted">29</span><span class="day muted">30</span><span class="day">1</span><span class="day">2</span><span class="day">3</span><span class="day">4</span>
                        <span class="day">5</span><span class="day">6</span><span class="day event">7</span><span class="day event">8</span><span class="day event">9</span><span class="day event">10</span><span class="day">11</span>
                        <span class="day">12</span><span class="day event">13</span><span class="day event">14</span><span class="day">15</span><span class="day">16</span><span class="day">17</span><span class="day">18</span>
                        <span class="day">19</span><span class="day">20</span><span class="day">21</span><span class="day today">22</span><span class="day">23</span><span class="day">24</span><span class="day">25</span>
                        <span class="day">26</span><span class="day">27</span><span class="day">28</span><span class="day">29</span><span class="day">30</span><span class="day">31</span><span class="day muted">1</span>
                    </div>
                </div>
            </div>

        </main>

        <footer>
            &copy; <?php echo date('Y'); ?> Proyecto Semestral Capital Humano &mdash; Luis De Los Rios, Jeremías Donoso, Lionel Cordoba y Juan Segundo.
        </footer>
    </div>

    <script>
        document.querySelectorAll('.count-up').forEach(function (el) {
            var target = parseInt(el.getAttribute('data-target'), 10);
            var duration = 900;
            var startDelay = 750;
            setTimeout(function () {
                var startTime = null;
                function step(ts) {
                    if (!startTime) startTime = ts;
                    var progress = Math.min((ts - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target);
                    if (progress < 1) requestAnimationFrame(step);
                    else el.textContent = target;
                }
                requestAnimationFrame(step);
            }, startDelay);
        });
    </script>
</body>
</html>