<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Capital Humano</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0d1b2e;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
            overflow: hidden;
        }

        /* ── Esferas flotantes ── */
        .scene {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(2px);
            animation: float linear infinite;
        }

        .s1 { width: 160px; height: 160px; left: 5%;  top: 55%; background: radial-gradient(circle at 35% 35%, #b06fd8, #6a1fa0); animation-duration: 9s;  animation-delay: 0s;   }
        .s2 { width: 190px; height: 190px; left: 70%; top: 5%;  background: radial-gradient(circle at 35% 35%, #5ec8f7, #1670c0); animation-duration: 12s; animation-delay: -3s;  }
        .s3 { width: 130px; height: 130px; left: 78%; top: 60%; background: radial-gradient(circle at 35% 35%, #4db8f0, #0d5fa0); animation-duration: 10s; animation-delay: -6s;  }
        .s4 { width: 110px; height: 110px; left: 20%; top: 5%;  background: radial-gradient(circle at 35% 35%, #7fd4f8, #1a8acb); animation-duration: 11s; animation-delay: -2s;  }
        .s5 { width:  90px; height:  90px; left: 55%; top: 75%; background: radial-gradient(circle at 35% 35%, #c98af0, #7a22cc); animation-duration: 8s;  animation-delay: -4s;  }
        .s6 { width: 200px; height: 200px; left: -4%; top: 10%; background: radial-gradient(circle at 35% 35%, #6dd5f8, #1366b8); animation-duration: 14s; animation-delay: -7s; filter: blur(6px); opacity: .7; }

        @keyframes float {
            0%   { transform: translateY(0px)   rotate(0deg); }
            33%  { transform: translateY(-22px) rotate(4deg); }
            66%  { transform: translateY(14px)  rotate(-3deg); }
            100% { transform: translateY(0px)   rotate(0deg); }
        }

        /* ── Tarjeta glass ── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 360px;
            padding: 44px 36px 36px;
            border-radius: 20px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(22px) saturate(160%);
            -webkit-backdrop-filter: blur(22px) saturate(160%);
            border: 1px solid rgba(255,255,255,0.14);
            box-shadow:
                0 8px 40px rgba(0,0,0,0.45),
                inset 0 1px 0 rgba(255,255,255,0.18);
        }

        .login-card h1 {
            text-align: center;
            font-size: 1.35rem;
            font-weight: 500;
            color: #fff;
            letter-spacing: .3px;
            margin-bottom: 28px;
        }

        /* ── Error ── */
        .error-message {
            background: rgba(239,68,68,0.15);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: .82rem;
            text-align: center;
            border: 1px solid rgba(239,68,68,0.3);
        }

        /* ── Inputs ── */
        .form-group {
            position: relative;
            margin-bottom: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.07);
            color: #e8eaf0;
            font-size: .88rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s, background .2s;
        }

        .form-control::placeholder { color: rgba(200,210,230,0.5); }

        .form-control:focus {
            border-color: rgba(100,180,255,0.55);
            background: rgba(255,255,255,0.11);
        }

        /* toggle contraseña */
        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(180,200,230,0.6);
            display: flex;
            align-items: center;
            padding: 2px;
            transition: color .2s;
        }
        .toggle-pw:hover { color: rgba(180,200,230,1); }

        /* ── Botón submit ── */
        .btn-submit {
            width: 100%;
            padding: 13px;
            border-radius: 10px;
            border: none;
            background: rgba(255,255,255,0.88);
            color: #0d1b2e;
            font-size: .92rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: .2px;
            margin-top: 10px;
            transition: background .2s, transform .1s, box-shadow .2s;
            box-shadow: 0 4px 18px rgba(0,0,0,0.25);
        }
        .btn-submit:hover  { background: #fff; box-shadow: 0 6px 24px rgba(0,0,0,0.35); }
        .btn-submit:active { transform: scale(.98); }

        /* ── Footer ── */
        .footer-text {
            text-align: center;
            font-size: .75rem;
            color: rgba(180,200,230,0.4);
            margin-top: 24px;
        }
    </style>
</head>
<body>

    <!-- Esferas animadas -->
    <div class="scene" aria-hidden="true">
        <div class="sphere s1"></div>
        <div class="sphere s2"></div>
        <div class="sphere s3"></div>
        <div class="sphere s4"></div>
        <div class="sphere s5"></div>
        <div class="sphere s6"></div>
    </div>

    <!-- Tarjeta -->
    <div class="login-card">
        <h1>Capital Humano</h1>

        <?php if(isset($error) && !empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? ''); ?>">

            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Usuario" required autocomplete="off">
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Mostrar contraseña">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn-submit">Ingresar</button>
        </form>

        <div class="footer-text">
            Proyecto UTP &mdash; Jeremías, Juan y Luis
        </div>
    </div>

    <script>
        function togglePw() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
            }
        }
    </script>

</body>
</html>