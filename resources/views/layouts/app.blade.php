<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiswaMart - Marketplace perlengkapan sekolah terlengkap dan terpercaya">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiswaMart – Marketplace Perlengkapan Sekolah')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        :root {
            --clr-bg:       #0d0d14;
            --clr-surface:  #13131e;
            --clr-card:     #1a1a28;
            --clr-card2:    #1f1f30;
            --clr-border:   #2e2e45;
            --clr-purple:   #8b5cf6;
            --clr-purple-d: #6d28d9;
            --clr-purple-l: #a78bfa;
            --clr-accent:   #c084fc;
            --clr-text:     #e2e0f0;
            --clr-muted:    #7c7a9a;
        }
        * { box-sizing: border-box; }
        body { background: var(--clr-bg); color: var(--clr-text); font-family: 'Plus Jakarta Sans', sans-serif; }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--clr-surface); }
        ::-webkit-scrollbar-thumb { background: var(--clr-purple-d); border-radius: 99px; }

        .grad-text {
            background: linear-gradient(135deg, #a78bfa 0%, #c084fc 60%, #e879f9 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #9333ea);
            color: #fff; font-weight: 700; transition: all .2s;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #6d28d9, #7e22ce);
            box-shadow: 0 0 20px rgba(124,58,237,.45); transform: translateY(-1px);
        }
        .glass {
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,.08);
        }
        .glow { box-shadow: 0 0 24px rgba(139,92,246,.35); }
        .glow-sm { box-shadow: 0 0 12px rgba(139,92,246,.2); }
        .pill-active {
            background: linear-gradient(135deg, #7c3aed, #9333ea) !important;
            color: #fff !important; border-color: transparent !important;
            box-shadow: 0 0 16px rgba(139,92,246,.4);
        }
        .pill-inactive {
            background: var(--clr-card); color: var(--clr-muted);
            border: 1px solid var(--clr-border);
        }
        .pill-inactive:hover { border-color: var(--clr-purple); color: var(--clr-purple-l); }
        .dark-card {
            background: var(--clr-card); border: 1px solid var(--clr-border); transition: all .25s;
        }
        .dark-card:hover { border-color: var(--clr-purple-d); box-shadow: 0 8px 32px rgba(124,58,237,.2); }
        .input-dark {
            background: var(--clr-surface); border: 1px solid var(--clr-border); color: var(--clr-text);
        }
        .input-dark:focus { border-color: var(--clr-purple); box-shadow: 0 0 0 3px rgba(139,92,246,.15); outline: none; }
        .input-dark::placeholder { color: var(--clr-muted); }
    </style>
</head>
<body>

{{-- ══ NAVBAR ══════════════════════════════════════════════════════════════════ --}}
<nav style="background:rgba(13,13,20,.9);border-bottom:1px solid var(--clr-border);"
     class="sticky top-0 z-50 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0" style="text-decoration:none">
                <img src="{{ asset('images/logo-icon.png') }}" alt="" class="h-9 w-auto">
                <span class="text-lg font-black grad-text">SiswaMart</span>
            </a>

            {{-- Search --}}
            <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 max-w-lg mx-6">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari perlengkapan sekolah..."
                           class="input-dark w-full pl-10 pr-4 py-2 rounded-xl text-sm transition">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--clr-muted)"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            {{-- Right --}}
            <div class="flex items-center gap-2">

                {{-- Cart Icon with badge --}}
                @php $cartCount = count(session()->get('cart', [])); @endphp
                <a href="{{ auth()->check() ? route('customer.cart') : route('login') }}"
                   class="relative p-2 rounded-xl transition"
                   style="color:var(--clr-muted)"
                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-muted)'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 text-white text-xs font-black rounded-full flex items-center justify-center"
                              style="background:linear-gradient(135deg,#7c3aed,#c084fc);font-size:9px">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                    @endif
                </a>

                @guest
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold px-3 py-1.5 rounded-lg transition"
                       style="color:var(--clr-muted)"
                       onmouseover="this.style.color='var(--clr-purple-l)';this.style.background='rgba(124,58,237,.12)'"
                       onmouseout="this.style.color='var(--clr-muted)';this.style.background='transparent'">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-4 py-1.5 rounded-xl">Daftar</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 px-2.5 py-1.5 rounded-xl transition"
                                style="color:var(--clr-text)"
                                onmouseover="this.style.background='rgba(124,58,237,.12)'"
                                onmouseout="this.style.background='transparent'">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black"
                                 style="background:linear-gradient(135deg,#7c3aed,#c084fc)">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold hidden sm:block max-w-24 truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5" style="color:var(--clr-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-52 rounded-2xl shadow-2xl py-1.5 z-50"
                             style="background:var(--clr-card);border:1px solid var(--clr-border);box-shadow:0 16px 48px rgba(0,0,0,.7)">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 0v10"/></svg>
                                    Dashboard Admin
                                </a>
                            @elseif(auth()->user()->isSeller())
                                <a href="{{ route('seller.dashboard') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    Dashboard Seller
                                </a>
                                <a href="{{ route('seller.orders') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    @php
                                        $sellerPids = auth()->user()->products()->pluck('id');
                                        $sOrdIds = \App\Models\OrderItem::whereIn('product_id',$sellerPids)->pluck('order_id')->unique();
                                        $sPending = \App\Models\Order::whereIn('id',$sOrdIds)->where('status','pending')->count();
                                    @endphp
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Pesanan Masuk
                                    @if($sPending > 0)
                                        <span class="ml-auto text-xs font-black px-1.5 py-0.5 rounded-full" style="background:rgba(251,191,36,.2);color:#fbbf24">{{ $sPending }}</span>
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('customer.dashboard') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Akun Saya
                                </a>
                                <a href="{{ route('customer.cart') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Keranjang
                                    @if($cartCount > 0)
                                        <span class="ml-auto text-xs font-black px-1.5 py-0.5 rounded-full" style="background:rgba(124,58,237,.25);color:var(--clr-purple-l)">{{ $cartCount }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('customer.orders') }}" class="dd-item" style="color:var(--clr-text)"
                                   onmouseover="this.style.background='rgba(124,58,237,.15)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--clr-text)'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Pesanan Saya
                                </a>
                            @endif
                            <hr style="border-color:var(--clr-border)" class="my-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dd-item w-full" style="color:#f87171"
                                        onmouseover="this.style.background='rgba(248,113,113,.1)'"
                                        onmouseout="this.style.background='transparent'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- Flash success --}}
@if(session('cart_success'))
    <div id="cart-toast"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 px-4 py-3 rounded-2xl shadow-2xl text-sm font-semibold"
         style="background:linear-gradient(135deg,#7c3aed,#9333ea);color:#fff;max-width:320px;box-shadow:0 8px 32px rgba(124,58,237,.4)">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('cart_success') }}
    </div>
    <script>setTimeout(() => { const t = document.getElementById('cart-toast'); if(t) t.style.opacity='0'; t.style.transition='opacity .5s'; }, 3000);</script>
@endif

<main>@yield('content')</main>

{{-- ══ FOOTER ══════════════════════════════════════════════════════════════════ --}}
<footer style="background:#09090f;border-top:1px solid var(--clr-border)" class="mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-3">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="" class="h-9 w-auto">
                    <span class="text-lg font-black grad-text">SiswaMart</span>
                </div>
                <p class="text-sm leading-relaxed max-w-xs" style="color:var(--clr-muted)">
                    Marketplace perlengkapan sekolah terlengkap. Belanja mudah, harga terjangkau.
                </p>
            </div>
            <div>
                <h4 class="font-bold text-white text-sm mb-3">Layanan</h4>
                <ul class="space-y-2 text-sm" style="color:var(--clr-muted)">
                    <li><a href="{{ route('home') }}" class="hover:text-purple-400 transition">Belanja</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-purple-400 transition">Jadi Seller</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white text-sm mb-3">Kontak</h4>
                <ul class="space-y-2 text-sm" style="color:var(--clr-muted)">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="flex-shrink:0"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        info@siswamart.com
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" style="flex-shrink:0"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.6 4.38 2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.4a16 16 0 0 0 6.29 6.29l1.36-1.36a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        0800-1-SISWA
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-6 text-center text-xs" style="border-top:1px solid var(--clr-border);color:var(--clr-muted)">
            © {{ date('Y') }} SiswaMart.
        </div>
    </div>
</footer>

<style>
.dd-item { display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;width:100%;transition:all .15s; }
</style>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stack('scripts')
</body>
</html>
