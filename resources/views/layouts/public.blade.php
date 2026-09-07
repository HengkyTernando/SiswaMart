<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="@yield('meta_description', 'SiswaMart — Media promosi produk siswa. Temukan makanan, minuman, snack, dan produk kreatif karya siswa sekolah.')">
    <title>@yield('title', 'SiswaMart')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--color-bg)] text-[var(--color-text)] min-h-screen antialiased flex flex-col"
      x-data="{ mobileMenuOpen: false }">

{{-- ─── Navbar ──────────────────────────────────────────────────────── --}}
<header class="public-nav sticky top-0 z-50 transition-all">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-[60px]">
        <div class="flex items-center justify-between h-[80px] gap-6">

            {{-- Logo --}}
            <a href="{{ route('public.home') }}"
               id="nav-logo"
               class="flex-shrink-0 flex items-center group transition-transform hover:scale-105"
               aria-label="SiswaMart — Beranda">
                <img src="{{ asset('images/logo.png') }}" alt="SiswaMart Logo" class="h-8 w-auto">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center h-full gap-8" aria-label="Navigasi utama">
                <a href="{{ route('public.home') }}"
                   class="relative text-base h-full flex items-center transition-colors {{ request()->routeIs('public.home') ? 'font-extrabold text-[var(--color-primary)]' : 'font-bold text-[var(--color-text)] hover:text-[var(--color-primary)]' }}"
                   id="nav-beranda">
                   BERANDA
                </a>

                <a href="{{ route('public.kategori.index') }}"
                   class="relative text-base h-full flex items-center transition-colors {{ request()->routeIs('public.kategori.*') ? 'font-extrabold text-[var(--color-primary)]' : 'font-bold text-[var(--color-text)] hover:text-[var(--color-primary)]' }}"
                   id="nav-kategori">
                   KATEGORI
                </a>

                <a href="{{ route('public.cara_pemesanan') }}"
                   class="relative text-base h-full flex items-center transition-colors {{ request()->routeIs('public.cara_pemesanan') ? 'font-extrabold text-[var(--color-primary)]' : 'font-bold text-[var(--color-text)] hover:text-[var(--color-primary)]' }}"
                   id="nav-cara-pemesanan">
                   CARA MEMESAN
                </a>
            </nav>

            {{-- Desktop Search + Auth --}}
            <div class="hidden md:flex items-center gap-5">
                @php
                    $searchAction = route('public.produk.index');
                    if (request()->routeIs('public.kategori.*') || request()->routeIs('public.produk.index')) {
                        $searchAction = url()->current();
                    }
                @endphp
                <form action="{{ $searchAction }}" method="GET"
                      id="nav-search-form" class="relative group">
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    @if(request('kategori') && !request()->routeIs('public.kategori.*')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                    
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[var(--color-text)] font-bold pointer-events-none group-focus-within:text-[var(--color-primary)] transition-colors"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q"
                           id="nav-search-input"
                           placeholder="Cari makanan..."
                           value="{{ request('q') }}"
                           class="search-input w-56 lg:w-64 pl-11 pr-4 py-2.5 text-sm font-bold bg-[var(--color-surface)] text-[var(--color-text)] placeholder-[var(--color-text-muted)] focus:bg-white outline-none">
                </form>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           id="nav-admin-dashboard"
                           class="btn-primary text-sm px-6 py-2.5">
                            DASHBOARD
                        </a>
                    @elseif(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}"
                           id="nav-penjual-dashboard"
                           class="btn-primary text-sm px-6 py-2.5">
                            TOKO SAYA
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       id="nav-login"
                       class="btn-primary text-sm px-6 py-2.5 bg-[var(--color-text)] text-[var(--color-bg)] hover:bg-[#3b2b22] hover:text-[var(--color-bg)]">
                        MASUK
                    </a>
                @endauth
            </div>

            {{-- Mobile: Search icon + hamburger --}}
            <div class="flex md:hidden items-center gap-3">
                <a href="{{ route('login') }}"
                   id="nav-login-mobile"
                   class="text-sm font-extrabold text-[var(--color-text)] bg-[var(--color-warning)] px-4 py-2 rounded-full border-2 border-[var(--color-border)] shadow-solid-sm">
                    MASUK
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-full border-2 border-[var(--color-border)] shadow-solid-sm bg-white text-[var(--color-text)] transition-all active:translate-y-1 active:shadow-none"
                        id="mobile-menu-btn"
                        aria-label="Buka menu navigasi">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen"
         x-transition
         class="md:hidden border-t-2 border-[var(--color-border)] bg-[var(--color-surface)]"
         style="display:none;">
        <div class="px-6 py-6 space-y-2 font-bold text-lg">
            {{-- Mobile search --}}
            <form action="{{ $searchAction ?? route('public.produk.index') }}" method="GET" class="mb-6">
                @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('kategori') && !request()->routeIs('public.kategori.*')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[var(--color-text)]"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Cari makanan..." value="{{ request('q') }}"
                           class="w-full pl-11 pr-4 py-3 text-base border-2 border-[var(--color-border)] rounded-full bg-white shadow-solid-sm outline-none focus:translate-x-[-2px] focus:translate-y-[-2px] focus:shadow-solid transition-all">
                </div>
            </form>

            <a href="{{ route('public.home') }}"
               class="block px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('public.home') ? 'bg-[var(--color-primary)] text-white border-2 border-[var(--color-border)] shadow-solid-sm' : 'text-[var(--color-text)] hover:bg-[var(--color-bg)]' }}"
               id="mobile-nav-beranda">BERANDA</a>
            <a href="{{ route('public.kategori.index') }}"
               class="block px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('public.kategori.*') ? 'bg-[var(--color-primary)] text-white border-2 border-[var(--color-border)] shadow-solid-sm' : 'text-[var(--color-text)] hover:bg-[var(--color-bg)]' }}"
               id="mobile-nav-kategori">KATEGORI</a>
            <a href="{{ route('public.cara_pemesanan') }}"
               class="block px-4 py-3 rounded-2xl transition-all {{ request()->routeIs('public.cara_pemesanan') ? 'bg-[var(--color-primary)] text-white border-2 border-[var(--color-border)] shadow-solid-sm' : 'text-[var(--color-text)] hover:bg-[var(--color-bg)]' }}"
               id="mobile-nav-cara-pemesanan">CARA MEMESAN</a>

            <div class="pt-6 mt-4 border-t-2 border-[var(--color-border)]">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="block text-center text-white bg-[var(--color-text)] px-4 py-3 rounded-full border-2 border-[var(--color-border)] shadow-solid-sm"
                           id="mobile-nav-admin">DASHBOARD ADMIN</a>
                    @elseif(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}"
                           class="block text-center text-white bg-[var(--color-text)] px-4 py-3 rounded-full border-2 border-[var(--color-border)] shadow-solid-sm"
                           id="mobile-nav-penjual-dash">TOKO SAYA</a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="block text-center text-[var(--color-text)] bg-[var(--color-warning)] px-4 py-3 rounded-full border-2 border-[var(--color-border)] shadow-solid-sm"
                       id="mobile-nav-login">LOGIN / MASUK</a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- ─── Page Content ───────────────────────────────────────────────── --}}
<main class="flex-grow">
    @yield('content')
</main>

{{-- ─── Footer ─────────────────────────────────────────────────────── --}}
<footer class="bg-[var(--color-text)] text-[var(--color-bg)] border-t-2 border-[var(--color-border)] mt-20">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-[60px] py-16">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-extrabold mb-2 text-[var(--color-primary-border)]">SiswaMart.</h2>
                <p class="text-lg font-medium opacity-90 max-w-sm">
                    Marketplace makanan sekolah yang fun, fresh, dan dibuat oleh siswa.
                </p>
            </div>
            <div class="flex gap-6 font-bold text-sm">
                <a href="{{ route('public.home') }}" class="hover:text-[var(--color-primary-border)] transition-colors">BERANDA</a>
                <a href="{{ route('public.kategori.index') }}" class="hover:text-[var(--color-primary-border)] transition-colors">KATEGORI</a>
                <a href="{{ route('public.cara_pemesanan') }}" class="hover:text-[var(--color-primary-border)] transition-colors">CARA MEMESAN</a>
            </div>
        </div>
        <div class="border-t border-white/20 mt-12 pt-8 text-center text-sm font-medium opacity-60">
            &copy; {{ date('Y') }} SiswaMart. Dibuat dengan 💛 oleh siswa.
        </div>
    </div>
</footer>

</body>
</html>
