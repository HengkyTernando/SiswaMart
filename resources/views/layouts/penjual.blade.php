<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penjual') | SiswaMart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        :root {
            --bg-body: #f8f9fa;
            --text-main: #202124;
            --bg-surface: #fff;
            --border-color: #e8eaed;
            --text-muted: #5f6368;
            --bg-hover: #f8f9fa;
            --bg-active: #e8f0fe;
            --text-active: #1a73e8;
            --shadow-hover: rgba(32,33,36,0.2);
            --input-border: #dadce0;
            
            /* Status colors */
            --color-success: #34a853;
            --color-warning: #fbbc04;
            --color-danger: #ea4335;
        }

        html.dark {
            --bg-body: #121212;
            --text-main: #e8eaed;
            --bg-surface: #1e1e1e;
            --border-color: #3c4043;
            --text-muted: #9aa0a6;
            --bg-hover: #292a2d;
            --bg-active: #303134;
            --text-active: #8ab4f8;
            --shadow-hover: rgba(0,0,0,0.5);
            --input-border: #5f6368;
            color-scheme: dark;
        }

        * { font-family: 'Roboto', Arial, sans-serif; box-sizing: border-box; }
        .font-display { font-family: 'Google Sans', Roboto, sans-serif; }
        body { background: var(--bg-body); color: var(--text-main); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #bdc1c6; border-radius: 3px; }

        /* ── Sidebar ── */
        .app-sidebar {
            background: var(--bg-surface);
            border-right: 1px solid var(--border-color);
            width: 256px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 16px 16px 6px;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 0 24px 24px 0;
            margin-right: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
        }
        .sidebar-link svg { flex-shrink: 0; }
        .sidebar-link:hover { background: var(--bg-hover); color: var(--text-main); }
        .sidebar-link.active { background: var(--bg-active); color: var(--text-active); font-weight: 600; }
        .sidebar-link.active svg { color: var(--text-active); }

        /* ── Topbar ── */
        .app-topbar {
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* ── Cards & Tables ── */
        .admin-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }
        .admin-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
        }

        /* Forms */
        .form-input {
            width: 100%;
            background: var(--bg-body);
            border: 1px solid var(--input-border);
            color: var(--text-main);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.875rem;
            transition: border 0.2s;
        }
        .form-input:focus { outline: none; border-color: var(--text-active); }

        /* Buttons */
        .btn-primary {
            background: #1a73e8;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
            border: none;
        }
        .btn-primary:hover { background: #1557b0; color: white; }
        
        .btn-outline {
            background: transparent;
            color: var(--text-active);
            border: 1px solid var(--border-color);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .btn-outline:hover { background: var(--bg-active); border-color: var(--text-active); }

        /* Flash */
        .admin-flash {
            position: fixed;
            bottom: 24px;
            left: 24px;
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            padding: 12px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-main);
            z-index: 9999;
            animation: slideUp 0.3s ease-out forwards;
        }
        @keyframes slideUp { from { transform: translateY(100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-aktif { background: #e6f4ea; color: #137333; }
        .badge-pending { background: #fef7e0; color: #b06000; }
        .badge-ditolak { background: #fce8e6; color: #c5221f; }
    </style>
</head>
<body class="flex min-h-screen">

    {{-- ── Sidebar ── --}}
    <aside class="app-sidebar hidden lg:flex">
        <div class="h-16 flex items-center px-6 border-b border-[var(--border-color)]">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="SiswaMart Logo" class="h-10 w-auto drop-shadow-sm">
            </a>
            <span class="ml-3 text-[10px] bg-[var(--bg-active)] text-[var(--text-active)] px-2 py-0.5 rounded-full font-bold shadow-sm">PENJUAL</span>
        </div>
        
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="sidebar-section-title">Menu Utama</div>
            <a href="{{ route('penjual.dashboard') }}" class="sidebar-link {{ request()->routeIs('penjual.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            
            <div class="sidebar-section-title mt-4">Katalog Saya</div>
            <a href="{{ route('penjual.produk.index') }}" class="sidebar-link {{ request()->routeIs('penjual.produk.*') && !request()->routeIs('penjual.produk.create') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk Saya
            </a>
            <a href="{{ route('penjual.produk.create') }}" class="sidebar-link {{ request()->routeIs('penjual.produk.create') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk
            </a>
            <a href="{{ route('penjual.laporan') }}" class="sidebar-link {{ request()->routeIs('penjual.laporan') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                Laporan Promosi
            </a>
        </nav>

        {{-- User info --}}
        <div class="p-4 border-t border-[var(--border-color)] flex-shrink-0">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-[#1a73e8] flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs truncate">{{ Auth::user()->penjual?->nama_toko ?? 'Toko' }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('public.produk.index') }}" target="_blank" class="flex-1 text-center text-xs text-[var(--text-muted)] hover:text-[#1a73e8] border border-[var(--border-color)] hover:border-[#1a73e8] py-1.5 rounded-full transition-colors">
                    Katalog
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button class="w-full text-xs text-[#d93025] hover:bg-[#fce8e6] dark:hover:bg-[#4a1c18] border border-[#fce8e6] dark:border-[#4a1c18] py-1.5 rounded-full transition-colors">Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main Area ── --}}
    <div class="flex-1 min-w-0 flex flex-col min-h-screen">
        {{-- Topbar --}}
        <header class="app-topbar">
            <div class="flex items-center gap-3 w-full mx-auto">
                <button class="p-2 rounded-full hover:bg-[var(--bg-hover)] text-[var(--text-muted)] lg:hidden flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex-1 min-w-0">
                    <h1 class="font-display font-semibold text-lg text-[var(--text-main)] truncate">@yield('page-title', 'Dashboard Penjual')</h1>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button id="themeToggleBtnAdmin" class="p-2 rounded-full hover:bg-[var(--bg-hover)] text-[var(--text-muted)] transition-colors">
                        <svg id="themeIconLightAdmin" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg id="themeIconDarkAdmin" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-[#e8f0fe] text-[#1a73e8] font-bold text-sm flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div id="adminFlash" class="admin-flash">
            <svg class="w-4 h-4 text-[#34a853] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div id="adminFlash" class="admin-flash">
            <svg class="w-4 h-4 text-[#ea4335] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
        @endif

        <main class="flex-1 p-6 overflow-x-hidden">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Auto-hide flash
        setTimeout(() => {
            const el = document.getElementById('adminFlash');
            if (el) { el.style.transition = 'opacity 0.4s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }
        }, 3500);

        // Theme toggle logic
        const themeBtnAdmin = document.getElementById('themeToggleBtnAdmin');
        const iconLightAdmin = document.getElementById('themeIconLightAdmin');
        const iconDarkAdmin = document.getElementById('themeIconDarkAdmin');

        function updateThemeIconAdmin() {
            if (document.documentElement.classList.contains('dark')) {
                iconLightAdmin?.classList.remove('hidden');
                iconDarkAdmin?.classList.add('hidden');
            } else {
                iconDarkAdmin?.classList.remove('hidden');
                iconLightAdmin?.classList.add('hidden');
            }
        }
        updateThemeIconAdmin();

        themeBtnAdmin?.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
            updateThemeIconAdmin();
        });
    </script>
</body>
</html>