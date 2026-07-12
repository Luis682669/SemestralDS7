<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derechos de Vacaciones - Capital Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy:      #101A3D;
            --bg:        #F3F5FB;
            --card:      #FFFFFF;
            --border:    #E6E9F2;
            --accent:    #3B5BFF;
            --text:      #131A2C;
            --muted:     #8891A6;
            --danger:    #E5484D;
        }
        html, body { height: 100%; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        .sidebar { width: 232px; flex-shrink: 0; background: var(--navy); display: flex; flex-direction: column; padding: 22px 14px; position: sticky; top: 0; height: 100vh; }
        .sidebar-brand { display:flex; align-items:center; gap:10px; padding:6px 10px 26px; font-family:'Syne',sans-serif; font-weight:800; font-size:1.02rem; color:#fff; }
        .dot { width:9px; height:9px; border-radius:50%; background:#0EBAC5; }
        .sidebar-nav { list-style:none; display:flex; flex-direction:column; gap:3px; }
        .sidebar-link { display:flex; align-items:center; gap:12px; padding:11px 12px; border-radius:10px; color:rgba(255,255,255,0.56); font-size:.85rem; font-weight:500; transition: background .15s, color .15s; }
        .sidebar-link:hover { color:#fff; background:rgba(255,255,255,0.06); }
        .sidebar-item.active .sidebar-link { color:#fff; background:linear-gradient(90deg, rgba(59,91,255,0.35), rgba(59,91,255,0.05)); box-shadow: inset 2px 0 0 #3B5BFF; }
        .sidebar-foot { margin-top:auto; border-top:1px solid rgba(255,255,255,0.08); padding-top:16px; }
        .sidebar-user { display:flex; align-items:center; gap:10px; padding:8px 10px 14px; }
        .sidebar-avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg, #3B5BFF, #6C63FF); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; color:#fff; }
        .who b { font-size:.82rem; color:#fff; font-weight:600; }
        .who span { font-size:.7rem; color:rgba(255,255,255,0.45); }
        .btn-logout { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:10px; background:rgba(229,72,77,0.14); color:#FF8589; border:1px solid rgba(229,72,77,0.3); border-radius:10px; font-size:.8rem; font-weight:600; transition: background .15s, color .15s; }
        .btn-logout:hover { background:var(--danger); color:#fff; }
        .main-wrap { flex:1; min-width:0; display:flex; flex-direction:column; }
        .main-container { flex:1; padding:34px 40px 56px; max-width:1160px; width:100%; margin:0 auto; }
        .page-title { margin-bottom: 22px; }
        .page-title p { font-size:.7rem; font-weight:600; letter-spacing:1.4px; text-transform:uppercase; color:#3B5BFF; margin-bottom:6px; }
        .page-title h1 { font-family:'Syne',sans-serif; font-size:1.7rem; font-weight:800; color:var(--text); }
        .card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:28px; box-shadow:0 2px 14px rgba(16,26,61,0.04); }
        .card-header { display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px; }
        .card-header h2 { font-family:'Syne',sans-serif; font-size:1.05rem; font-weight:700; color:var(--text); }
        .card-header p { font-size:.9rem; color:var(--muted); margin:0; }
        .btn-secondary { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 18px; border-radius:12px; background:#f1f5f9; color:var(--text); border:1px solid var(--border); font-weight:700; transition: background .15s, transform .12s; }
        .btn-secondary:hover { background:#e2e8f0; transform: translateY(-1px); }
        .btn-secondary:active { transform: scale(.97); }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:760px; }
        thead th { text-align:left; font-size:.75rem; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:var(--muted); padding:14px 16px; border-bottom:1px solid var(--border); }
        tbody td { padding:14px 16px; border-bottom:1px solid var(--border); font-size:.9rem; color:var(--text); }
        tbody tr { transition: background .15s; }
        tbody tr:hover { background:rgba(59,91,255,0.04); }
        .status-pill { display:inline-flex; align-items:center; padding:6px 12px; border-radius:999px; font-size:.8rem; font-weight:700; }
        .status-info { background:rgba(59,91,255,0.12); color:#2746B0; }
        .dias-num { font-weight: 700; display: inline-block; }
        footer { text-align:center; padding:18px; font-size:.73rem; color:var(--muted); border-top:1px solid var(--border); }

        /* ── ANIMACIONES ── */
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-14px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeSlideUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes rowIn { from { opacity: 0; transform: translateX(-8px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes countUpFade { from { opacity: .35; } to { opacity: 1; } }

        .sidebar-item { opacity: 0; animation: slideInLeft .45s ease forwards; }
        .sidebar-item:nth-child(1) { animation-delay: .05s; }
        .sidebar-item:nth-child(2) { animation-delay: .1s; }
        .sidebar-item:nth-child(3) { animation-delay: .15s; }
        .sidebar-item:nth-child(4) { animation-delay: .2s; }
        .sidebar-item:nth-child(5) { animation-delay: .25s; }
        .sidebar-item:nth-child(6) { animation-delay: .3s; }

        .page-title { opacity: 0; animation: fadeSlideUp .5s ease .1s forwards; }
        .card { opacity: 0; animation: fadeSlideUp .5s ease .2s forwards; }

        tbody tr { opacity: 0; animation: rowIn .4s ease forwards; }
        tbody tr:nth-child(1) { animation-delay: .4s; }
        tbody tr:nth-child(2) { animation-delay: .45s; }
        tbody tr:nth-child(3) { animation-delay: .5s; }
        tbody tr:nth-child(4) { animation-delay: .55s; }
        tbody tr:nth-child(5) { animation-delay: .6s; }

        .dias-num { animation: countUpFade .3s ease; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .001s !important; animation-delay: 0s !important; transition-duration: .001s !important; }
        }

        @media (max-width: 760px) { .sidebar { display:none; } .main-container { padding:24px 18px 44px; } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="sidebar-brand" href="/home"><span class="dot"></span>Capital Humano</a>
        <ul class="sidebar-nav">
            <li class="sidebar-item"><a class="sidebar-link" href="/home">Inicio</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/usuarios">Usuarios</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/colaboradores">Colaboradores</a></li>
            <li class="sidebar-item active"><a class="sidebar-link" href="/vacaciones">Vacaciones</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/reportes">Reportes</a></li>
            <li class="sidebar-item"><a class="sidebar-link" href="/planillas">Planillas</a></li>
        </ul>
        <div class="sidebar-foot">
            <div class="sidebar-user">
                <div class="sidebar-avatar">A</div>
                <div class="who"><b>admin</b><span>Administrador</span></div>
            </div>
            <a href="/logout" class="btn-logout">Salir</a>
        </div>
    </aside>
    <div class="main-wrap">
        <main class="main-container">
            <div class="page-title">
                <p>Vacaciones</p>
                <h1>Derechos de Vacaciones</h1>
            </div>
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2>Derechos generados</h2>
                        <p>Calcula el derecho de vacaciones según 1 día por 11 días trabajados y 1 mes por 11 meses trabajados.</p>
                    </div>
                    <a href="/vacaciones" class="btn-secondary">Volver a Solicitudes</a>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Colaborador</th>
                                <th>Fecha Contratación</th>
                                <th>Días Trabajados</th>
                                <th>Días de Vacaciones</th>
                                <th>Meses Trabajados</th>
                                <th>Meses de Vacaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>8-123-4567</td>
                                <td>María Torres</td>
                                <td>12/03/2022</td>
                                <td>1206</td>
                                <td><span class="dias-num">109</span></td>
                                <td>39</td>
                                <td><span class="dias-num">3</span></td>
                            </tr>
                            <tr>
                                <td>8-234-5678</td>
                                <td>Samuel Smith</td>
                                <td>04/07/2023</td>
                                <td>729</td>
                                <td><span class="dias-num">66</span></td>
                                <td>23</td>
                                <td><span class="dias-num">2</span></td>
                            </tr>
                            <tr>
                                <td>8-345-6789</td>
                                <td>Meredith Silva</td>
                                <td>19/01/2024</td>
                                <td>530</td>
                                <td><span class="dias-num">48</span></td>
                                <td>17</td>
                                <td><span class="dias-num">1</span></td>
                            </tr>
                            <tr>
                                <td>8-456-7890</td>
                                <td>Jorge Pérez</td>
                                <td>22/09/2024</td>
                                <td>283</td>
                                <td><span class="dias-num">25</span></td>
                                <td>9</td>
                                <td><span class="dias-num">0</span></td>
                            </tr>
                            <tr>
                                <td>8-567-8901</td>
                                <td>Luisa García</td>
                                <td>08/05/2025</td>
                                <td>420</td>
                                <td><span class="dias-num">38</span></td>
                                <td>13</td>
                                <td><span class="dias-num">1</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <footer>Proyecto UTP — Jeremías, Juan y Luis · Capital Humano 2026</footer>
    </div>
</body>
</html>