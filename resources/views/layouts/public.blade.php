<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="description" content="@yield('meta_description', 'SiswaMart — Media promosi produk siswa. Temukan makanan, minuman, snack, dan produk kreatif karya siswa sekolah.')">
    <title>@yield('title', 'Katalog SiswaMart') | SiswaMart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFF] text-[#172033] min-h-screen antialiased"
      x-data="{ mobileMenuOpen: false }">

{{-- ─── Navbar ──────────────────────────────────────────────────────── --}}
<header class="public-nav border-b border-[#E2E8F0]/60 sticky top-0 z-50 bg-white/80 backdrop-blur-lg">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-[60px]">
        <div class="flex items-center justify-between h-[72px] gap-4">

            {{-- Logo --}}
            <a href="{{ route('public.home') }}"
               id="nav-logo"
               class="flex-shrink-0 flex items-center group"
               aria-label="SiswaMart — Beranda">
                <img src="{{ asset('images/logo.png') }}" alt="SiswaMart Logo" class="h-7 w-auto group-hover:opacity-90 transition-opacity">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center h-full gap-8" aria-label="Navigasi utama">
                <a href="{{ route('public.home') }}"
                   class="relative text-sm h-full flex items-center transition-colors {{ request()->routeIs('public.home') ? 'font-bold text-[#172554]' : 'font-medium text-[#64748B] hover:text-[#172554]' }}"
                   id="nav-beranda">
                   Beranda
                   @if(request()->routeIs('public.home'))
                   <span class="absolute bottom-[-1px] left-0 w-full h-[3px] bg-[#2563EB] rounded-t-full"></span>
                   @endif
                </a>

                <a href="{{ route('public.kategori.index') }}"
                   class="relative text-sm h-full flex items-center transition-colors {{ request()->routeIs('public.kategori.*') ? 'font-bold text-[#172554]' : 'font-medium text-[#64748B] hover:text-[#172554]' }}"
                   id="nav-kategori">
                   Kategori
                   @if(request()->routeIs('public.kategori.*'))
                   <span class="absolute bottom-[-1px] left-0 w-full h-[3px] bg-[#2563EB] rounded-t-full"></span>
                   @endif
                </a>

                <a href="{{ route('public.cara_pemesanan') }}"
                   class="relative text-sm h-full flex items-center transition-colors {{ request()->routeIs('public.cara_pemesanan') ? 'font-bold text-[#172554]' : 'font-medium text-[#64748B] hover:text-[#172554]' }}"
                   id="nav-cara-pemesanan">
                   Cara Memesan
                   @if(request()->routeIs('public.cara_pemesanan'))
                   <span class="absolute bottom-[-1px] left-0 w-full h-[3px] bg-[#2563EB] rounded-t-full"></span>
                   @endif
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
                    
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#94A3B8] pointer-events-none group-focus-within:text-[#2563EB] transition-colors"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q"
                           id="nav-search-input"
                           placeholder="Cari sesuatu..."
                           value="{{ request('q') }}"
                           class="w-56 lg:w-64 pl-10 pr-4 py-2.5 text-sm border-none rounded-full bg-[#F1F5F9] text-[#172554] placeholder-[#94A3B8] transition-all focus:bg-white focus:ring-1 focus:ring-[#2563EB] focus:shadow-[0_0_0_4px_rgba(37,99,235,0.1)] outline-none">
                </form>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           id="nav-admin-dashboard"
                           class="flex items-center gap-2 text-sm font-semibold text-white bg-[#172554] hover:bg-[#1e293b] px-5 py-2.5 rounded-full shadow-sm transition-all hover:shadow">
                            Dashboard
                        </a>
                    @elseif(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}"
                           id="nav-penjual-dashboard"
                           class="flex items-center gap-2 text-sm font-semibold text-white bg-[#172554] hover:bg-[#1e293b] px-5 py-2.5 rounded-full shadow-sm transition-all hover:shadow">
                            Toko Saya
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       id="nav-login"
                       class="flex items-center gap-2 text-sm font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] px-6 py-2.5 rounded-full shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                        Masuk
                    </a>
                @endauth
            </div>

            {{-- Mobile: Search icon + hamburger --}}
            <div class="flex md:hidden items-center gap-2">
                <a href="{{ route('login') }}"
                   id="nav-login-mobile"
                   class="text-sm font-semibold text-[#2563EB] px-3 py-1.5 rounded-lg hover:bg-[#EFF6FF] transition-all">
                    Masuk
                </a>
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-lg text-[#64748B] hover:text-[#172033] hover:bg-[#F1F5F9] transition-all"
                        id="mobile-menu-btn"
                        aria-label="Buka menu navigasi">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden border-t border-[#E2E8F0] bg-white"
         style="display:none;">
        <div class="px-4 py-3 space-y-1">
            {{-- Mobile search --}}
            <form action="{{ $searchAction ?? route('public.produk.index') }}" method="GET" class="mb-3">
                @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if(request('kategori') && !request()->routeIs('public.kategori.*')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#94A3B8]"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}"
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-[#E2E8F0] rounded-lg bg-[#F8FAFF]">
                </div>
            </form>

            <a href="{{ route('public.home') }}"
               class="flex items-center text-sm px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('public.home') ? 'font-semibold text-[#2563EB] bg-[#EFF6FF]' : 'font-medium text-[#172033] hover:bg-[#EFF6FF] hover:text-[#2563EB]' }}"
               id="mobile-nav-beranda">Beranda</a>
            <a href="{{ route('public.kategori.index') }}"
               @click="mobileMenuOpen = false"
               class="flex items-center text-sm px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('public.kategori.*') ? 'font-semibold text-[#2563EB] bg-[#EFF6FF]' : 'font-medium text-[#172033] hover:bg-[#EFF6FF] hover:text-[#2563EB]' }}"
               id="mobile-nav-kategori">Kategori</a>
            <a href="{{ route('public.cara_pemesanan') }}"
               class="flex items-center text-sm px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('public.cara_pemesanan') ? 'font-semibold text-[#2563EB] bg-[#EFF6FF]' : 'font-medium text-[#172033] hover:bg-[#EFF6FF] hover:text-[#2563EB]' }}"
               id="mobile-nav-cara-pemesanan">Cara Memesan</a>

            <div class="pt-2 mt-2 border-t border-[#E2E8F0]">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="block text-sm font-semibold text-white bg-[#2563EB] text-center px-4 py-2.5 rounded-lg"
                           id="mobile-nav-admin">Dashboard Admin</a>
                    @elseif(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}"
                           class="block text-sm font-semibold text-white bg-[#2563EB] text-center px-4 py-2.5 rounded-lg"
                           id="mobile-nav-penjual-dash">Dashboard Penjual</a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="block text-center text-sm font-semibold text-white bg-[#2563EB] hover:bg-[#1D4ED8] px-4 py-2.5 rounded-lg transition-colors"
                       id="mobile-nav-login">Login / Masuk</a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- ─── Page Content ───────────────────────────────────────────────── --}}
@yield('content')

{{-- ─── Footer ─────────────────────────────────────────────────────── --}}
<footer class="bg-white border-t border-[#E2E8F0] mt-auto">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-[60px] py-6">
        <p class="text-xs sm:text-sm text-[#64748B] text-center md:text-left">
            &copy; {{ date('Y') }} <strong>SiswaMart</strong>. Media promosi produk siswa di lingkungan sekolah.
        </p>
    </div>
</footer>

</body>
</html>
