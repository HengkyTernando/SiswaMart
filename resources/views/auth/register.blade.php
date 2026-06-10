<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – SiswaMart</title>
    <meta name="description" content="Buat akun SiswaMart gratis dan mulai belanja atau jual produk pelajar.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --purple-400: #a78bfa;
            --purple-500: #8b5cf6;
            --purple-600: #7c3aed;
            --purple-700: #6d28d9;
            --bg-dark: #0d0b1e;
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
            align-items: flex-start;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -25%;
            right: -15%;
            width: 65%;
            height: 65%;
            background: radial-gradient(ellipse, rgba(109,40,217,.3) 0%, transparent 70%);
            pointer-events: none;
            animation: floatGlow 9s ease-in-out infinite alternate;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -15%;
            left: -10%;
            width: 55%;
            height: 55%;
            background: radial-gradient(ellipse, rgba(76,29,149,.2) 0%, transparent 70%);
            pointer-events: none;
            animation: floatGlow 11s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatGlow {
            0%   { transform: translate(0, 0) scale(1); }
            100% { transform: translate(3%, 4%) scale(1.1); }
        }

        #particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; }

        .auth-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
        }

        /* ── Logo ── */
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

        .card-title    { font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin-bottom: .25rem; }
        .card-subtitle { font-size: .875rem; color: var(--text-secondary); margin-bottom: 1.75rem; }

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
        .alert-error ul { padding-left: 1rem; }
        .alert-error li { margin-bottom: .2rem; }

        /* ── Role tabs ── */
        .role-label {
            font-size: .75rem;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: .75rem;
        }
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: 1.5rem;
        }
        .role-option { position: relative; cursor: pointer; }
        .role-option input[type=radio] { position: absolute; opacity: 0; width: 0; height: 0; }
        .role-box {
            padding: .875rem .75rem;
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 14px;
            text-align: center;
            transition: border-color .2s, background .2s, box-shadow .2s;
            background: rgba(255,255,255,.03);
        }
        .role-option input:checked + .role-box {
            border-color: var(--purple-500);
            background: rgba(139,92,246,.12);
            box-shadow: 0 0 0 3px rgba(139,92,246,.15);
        }
        .role-emoji { display: flex; justify-content: center; align-items: center; margin-bottom: .3rem; color: var(--purple-400); }
        .role-name  { font-size: .8125rem; font-weight: 700; color: var(--text-primary); }
        .role-desc  { font-size: .7rem; color: var(--text-muted); margin-top: .15rem; }

        /* ── Fields ── */
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
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
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

        /* ── Two-column row ── */
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }

        /* ── Terms checkbox ── */
        .terms-wrap {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            margin-bottom: 1.5rem;
        }
        .terms-wrap input[type=checkbox] {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            flex-shrink: 0;
            accent-color: var(--purple-500);
            cursor: pointer;
        }
        .terms-wrap span {
            font-size: .8125rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }
        .terms-wrap a {
            color: var(--purple-400);
            text-decoration: none;
        }
        .terms-wrap a:hover { text-decoration: underline; }

        /* ── Button ── */
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
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 8px 24px rgba(109,40,217,.4);
            letter-spacing: .01em;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 30px rgba(109,40,217,.5);
        }
        .btn-primary:active { transform: scale(.98); }

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

        /* ── Social ── */
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
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
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

        /* ── Footer ── */
        .auth-footer {
            text-align: center;
            font-size: .8125rem;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--purple-400);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }

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
        <h1 class="card-title">Create Account</h1>
        <p class="card-subtitle">Join us and start your journey</p>

        @if ($errors->any())
            <div class="alert-error">
                <ul>@foreach ($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('auth.register') }}" method="POST" id="register-form">
            @csrf

            <!-- Role selector -->
            <p class="role-label">Daftar sebagai</p>
            <div class="role-grid">
                <label class="role-option">
                    <input type="radio" name="role" value="customer" {{ old('role','customer') === 'customer' ? 'checked' : '' }}>
                    <div class="role-box">
                        <span class="role-emoji">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="28" height="28"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </span>
                        <div class="role-name">Customer</div>
                        <div class="role-desc">Belanja produk</div>
                    </div>
                </label>
                <label class="role-option">
                    <input type="radio" name="role" value="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                    <div class="role-box">
                        <span class="role-emoji">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="28" height="28"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </span>
                        <div class="role-name">Seller</div>
                        <div class="role-desc">Jual produk</div>
                    </div>
                </label>
            </div>

            <!-- Full Name -->
            <div class="field">
                <label for="name">Full Name</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           placeholder="Enter your full name" required autocomplete="name">
                </div>
            </div>

            <!-- Email -->
            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           placeholder="Enter your email address" required autocomplete="email">
                </div>
            </div>

            <!-- Password -->
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password"
                           placeholder="Create a strong password" required autocomplete="new-password">
                    <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password">
                        <svg id="eyeIcon1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Confirm your password" required autocomplete="new-password">
                    <button type="button" class="toggle-pw" id="togglePw2" aria-label="Toggle confirm password">
                        <svg id="eyeIcon2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Terms -->
            <div class="terms-wrap">
                <input type="checkbox" id="terms" name="terms" required>
                <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
            </div>

            <button type="submit" class="btn-primary" id="register-btn">Register</button>
        </form>

        <p class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </p>
    </div>

    <a href="{{ route('home') }}" class="back-home">← Kembali ke Beranda</a>
</div>

<script>
// Toggle password 1
function makeToggle(btnId, inputId, iconId) {
    document.getElementById(btnId)?.addEventListener('click', () => {
        const inp = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            inp.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    });
}
makeToggle('togglePw',  'password',              'eyeIcon1');
makeToggle('togglePw2', 'password_confirmation', 'eyeIcon2');

// Particle background
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

    for (let i = 0; i < 55; i++) {
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
        for (let i = 0; i < dots.length; i++) {
            for (let j = i + 1; j < dots.length; j++) {
                const dx = dots[i].x - dots[j].x;
                const dy = dots[i].y - dots[j].y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 110) {
                    ctx.beginPath();
                    ctx.moveTo(dots[i].x, dots[i].y);
                    ctx.lineTo(dots[j].x, dots[j].y);
                    ctx.strokeStyle = `rgba(139,92,246,${(1 - dist/110) * .12})`;
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
