<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – SiswaMart</title>
    <meta name="description" content="Masuk ke akun SiswaMart dan mulai belanja produk pelajar terbaik.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --purple-400: #a78bfa;
            --purple-500: #8b5cf6;
            --purple-600: #7c3aed;
            --purple-700: #6d28d9;
            --violet-500: #8b5cf6;
            --bg-dark: #0d0b1e;
            --bg-card: rgba(255,255,255,0.04);
            --border: rgba(255,255,255,0.08);
            --border-focus: rgba(139,92,246,0.6);
            --text-primary: #f1f0ff;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* ── Animated background ── */
        body::before {
            content: '';
            position: fixed;
            top: -30%;
            left: -20%;
            width: 70%;
            height: 70%;
            background: radial-gradient(ellipse, rgba(109,40,217,0.35) 0%, transparent 70%);
            pointer-events: none;
            animation: floatGlow 8s ease-in-out infinite alternate;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            right: -15%;
            width: 60%;
            height: 60%;
            background: radial-gradient(ellipse, rgba(76,29,149,0.25) 0%, transparent 70%);
            pointer-events: none;
            animation: floatGlow 10s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatGlow {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(3%, 5%) scale(1.08); }
        }

        /* ── Particles canvas ── */
        #particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }

        /* ── Wrapper ── */
        .auth-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }

        /* ── Logo bar ── */
        .logo-bar {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }
        .logo-text {
            font-size: 1.35rem;
            font-weight: 800;
            background: linear-gradient(90deg, #c4b5fd, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Card ── */
        .auth-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 60px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.06);
            animation: cardIn .5s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-title   { font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin-bottom: .25rem; }
        .card-subtitle { font-size: .875rem; color: var(--text-secondary); margin-bottom: 2rem; }

        /* ── Alert ── */
        .alert-error {
            margin-bottom: 1.25rem;
            padding: .875rem 1rem;
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            border-radius: 12px;
            font-size: .8125rem;
            color: #fca5a5;
        }

        /* ── Form fields ── */
        .field { margin-bottom: 1.25rem; }
        .field label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: .5rem;
            letter-spacing: .02em;
            text-transform: uppercase;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
            pointer-events: none;
            transition: color .2s;
        }
        .input-wrap input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: .875rem 1rem .875rem 2.75rem;
            color: var(--text-primary);
            font-size: .9rem;
            font-family: inherit;
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .input-wrap input::placeholder { color: var(--text-muted); }
        .input-wrap input:focus {
            border-color: var(--border-focus);
            background: rgba(139,92,246,.08);
            box-shadow: 0 0 0 3px rgba(139,92,246,.15);
        }
        .input-wrap input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--purple-400); }

        .toggle-pw {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            transition: color .2s;
            padding: 0;
            display: flex;
        }
        .toggle-pw:hover { color: var(--purple-400); }

        /* ── Remember / forgot ── */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8125rem;
            color: var(--text-secondary);
            cursor: pointer;
        }
        .checkbox-label input[type=checkbox] {
            width: 16px;
            height: 16px;
            accent-color: var(--purple-500);
            border-radius: 4px;
            cursor: pointer;
        }
        .forgot-link {
            font-size: .8125rem;
            color: var(--purple-400);
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: var(--purple-400); text-decoration: underline; }

        /* ── Primary button ── */
        .btn-primary {
            width: 100%;
            padding: .9rem;
            background: linear-gradient(135deg, var(--purple-600), #4f46e5);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: .9375rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s, opacity .2s;
            box-shadow: 0 8px 24px rgba(109,40,217,.4);
            letter-spacing: .01em;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 30px rgba(109,40,217,.5);
        }
        .btn-primary:active { transform: translateY(0) scale(.98); }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.07);
        }
        .divider span { font-size: .75rem; color: var(--text-muted); white-space: nowrap; }

        /* ── Social buttons ── */
        .social-row {
            display: flex;
            gap: .75rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .btn-social {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s, border-color .2s, transform .15s;
            text-decoration: none;
        }
        .btn-social:hover {
            background: rgba(139,92,246,.15);
            border-color: rgba(139,92,246,.35);
            transform: translateY(-2px);
        }
        .btn-social svg { width: 22px; height: 22px; }

        /* ── Footer link ── */
        .auth-footer {
            text-align: center;
            font-size: .8125rem;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--purple-400);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s;
        }
        .auth-footer a:hover { text-decoration: underline; }

        /* ── Back home ── */
        .back-home {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: .8125rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }
        .back-home:hover { color: var(--purple-400); }


    </style>
</head>
<body>

<canvas id="particles"></canvas>

<div class="auth-wrapper">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo-bar">
        <img src="{{ asset('images/logo-icon.png') }}" alt="" style="height:44px;width:auto">
        <span class="logo-text">SiswaMart</span>
    </a>

    <!-- Card -->
    <div class="auth-card">
        <h1 class="card-title">Welcome Back</h1>
        <p class="card-subtitle">Login to your account to continue</p>

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="field">
                <label for="email">Email or Username</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           placeholder="Enter your email or username" required autocomplete="email">
                </div>
            </div>

            <!-- Password -->
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password" required autocomplete="current-password">
                    <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Remember / Forgot -->
            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary" id="login-btn">Login</button>
        </form>

        <p class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </p>


    </div>

    <a href="{{ route('home') }}" class="back-home">← Kembali ke Beranda</a>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePw')?.addEventListener('click', () => {
    const pw = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        pw.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
});

// Particle effect
(function(){
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let W, H, dots = [];

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    const N = 55;
    for (let i = 0; i < N; i++) {
        dots.push({
            x: Math.random() * W,
            y: Math.random() * H,
            r: Math.random() * 1.4 + .3,
            vx: (Math.random() - .5) * .25,
            vy: (Math.random() - .5) * .25,
            a: Math.random() * .5 + .15
        });
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);
        dots.forEach(d => {
            d.x += d.vx; d.y += d.vy;
            if (d.x < 0) d.x = W; if (d.x > W) d.x = 0;
            if (d.y < 0) d.y = H; if (d.y > H) d.y = 0;
            ctx.beginPath();
            ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(167,139,250,${d.a})`;
            ctx.fill();
        });
        // Draw connecting lines
        for (let i = 0; i < dots.length; i++) {
            for (let j = i + 1; j < dots.length; j++) {
                const dx = dots[i].x - dots[j].x;
                const dy = dots[i].y - dots[j].y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 110) {
                    ctx.beginPath();
                    ctx.moveTo(dots[i].x, dots[i].y);
                    ctx.lineTo(dots[j].x, dots[j].y);
                    ctx.strokeStyle = `rgba(139,92,246,${(1 - dist/110) * 0.12})`;
                    ctx.lineWidth = .5;
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(draw);
    }
    draw();
})();
</script>
</body>
</html>
