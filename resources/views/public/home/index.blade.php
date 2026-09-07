@extends('layouts.public')

@section('title', 'Katalog SiswaMart')
@section('meta_description', 'SiswaMart — Temukan produk kreatif siswa: makanan, minuman, snack, dan berbagai produk karya siswa di lingkungan sekolah.')

@section('content')

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 md:px-10 lg:px-[60px] py-10 lg:py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 auto-rows-min">
        
        {{-- ─── 1. Welcome Card (Span 8) ─────────────────────────────────── --}}
        <div class="lg:col-span-8 bg-[#EFF6FF] rounded-[24px] p-8 lg:p-10 flex flex-col justify-center relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 shadow-sm border border-[#BFDBFE]">
            {{-- Decorative Blob --}}
            <div class="absolute top-[-20%] right-[-10%] w-[400px] h-[400px] bg-[#DBEAFE] rounded-full mix-blend-multiply filter blur-3xl opacity-60 pointer-events-none group-hover:scale-105 transition-transform duration-700"></div>
            
            <div class="relative z-10 w-full md:w-3/4">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#172554] leading-[1.2] tracking-tight mb-4">
                    Selamat datang di <br class="hidden sm:block"> <span class="text-[#2563EB]">SiswaMart</span> 👋
                </h1>
                <p class="text-[#64748B] text-base sm:text-lg leading-relaxed mb-8 max-w-md">
                    Temukan makanan, minuman, dan produk favorit dari berbagai toko karya siswa.
                </p>
                <a href="{{ route('public.produk.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#2563EB] text-white text-sm font-semibold rounded-[16px] shadow-sm hover:shadow-md hover:bg-[#1D4ED8] transition-all hover:-translate-y-0.5">
                    Jelajahi Produk &rarr;
                </a>
            </div>

            {{-- Floating Food Elements --}}
            <div class="hidden sm:flex absolute right-6 lg:right-12 bottom-6 lg:bottom-1/2 lg:translate-y-1/2 flex-col gap-4 pointer-events-none">
                <div class="bg-white p-3.5 rounded-[18px] shadow-lg border border-[#F1F5F9] transform rotate-[10deg] group-hover:-translate-y-2 group-hover:rotate-[15deg] transition-all duration-500 delay-75">
                    <span class="text-3xl block drop-shadow-sm">🍔</span>
                </div>
                <div class="bg-white p-3 rounded-[16px] shadow-lg border border-[#F1F5F9] transform rotate-[-15deg] group-hover:-translate-y-2 group-hover:rotate-[-5deg] transition-all duration-500 -ml-8">
                    <span class="text-2xl block drop-shadow-sm">🧋</span>
                </div>
            </div>
        </div>

        {{-- ─── 2. Produk Populer (Span 4) ───────────────────────────────── --}}
        <div class="lg:col-span-4 bg-white rounded-[24px] p-6 sm:p-8 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 border border-[#E2E8F0] flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-[#172554] tracking-tight">Produk Populer</h2>
                <div class="w-8 h-8 rounded-full bg-[#FEF2F2] flex items-center justify-center text-[#DC2626]">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/></svg>
                </div>
            </div>
            
            <div class="flex-1 flex flex-col gap-4 justify-center">
                @forelse($produkPopuler as $produk)
                    <a href="{{ route('public.produk.show', $produk->slug) }}" class="flex items-center gap-4 group/item">
                        <div class="w-16 h-16 rounded-[14px] bg-[#F8FAFF] overflow-hidden flex-shrink-0 border border-[#E2E8F0]">
                            @if($produk->foto_utama)
                                <img src="{{ asset('storage/' . $produk->foto_utama) }}" alt="{{ $produk->nama }}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center opacity-40">
                                    <img src="{{ asset('images/icons/bag.svg') }}" class="w-6 h-6 grayscale">
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-[15px] font-bold text-[#172033] truncate group-hover/item:text-[#2563EB] transition-colors">{{ $produk->nama }}</h3>
                            <p class="text-sm font-semibold text-[#2563EB] mt-0.5">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-[#64748B] bg-[#F1F5F9] px-2.5 py-1.5 rounded-lg flex-shrink-0">
                            👁 {{ number_format($produk->views, 0, ',', '.') }}
                        </div>
                    </a>
                @empty
                    <div class="text-sm text-[#64748B] text-center py-4">Belum ada produk populer.</div>
                @endforelse
            </div>
        </div>

        {{-- ─── Left Column: Kategori & Statistik (Span 4) ────────────────────── --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            {{-- Kategori --}}
            <div class="bg-white rounded-[24px] p-6 shadow-sm border border-[#E2E8F0] flex flex-col h-full">
                <h2 class="text-lg font-bold text-[#172554] tracking-tight mb-5">Kategori Favorit</h2>
                <div class="grid grid-cols-2 gap-4 flex-1">
                    @foreach($kategoriList->take(4) as $kat)
                        @php
                            $catData = [
                                'makanan' => ['icon'=>'food.svg', 'bg'=>'bg-[#FEE2E2]', 'text'=>'text-[#B91C1C]'],
                                'minuman' => ['icon'=>'drink.svg', 'bg'=>'bg-[#DBEAFE]', 'text'=>'text-[#1D4ED8]'],
                                'snack' => ['icon'=>'snack.svg', 'bg'=>'bg-[#FEF08A]', 'text'=>'text-[#A16207]'],
                                'dessert' => ['icon'=>'dessert.svg', 'bg'=>'bg-[#F3E8FF]', 'text'=>'text-[#6B21A8]'],
                            ];
                            $data = $catData[$kat->slug] ?? ['icon'=>'bag.svg', 'bg'=>'bg-[#F1F5F9]', 'text'=>'text-[#334155]'];
                        @endphp
                        <a href="{{ route('public.kategori.show', $kat->slug) }}" class="flex flex-col items-center justify-center p-4 rounded-[16px] {{ $data['bg'] }} group/kat hover:-translate-y-1 transition-all duration-200 aspect-[5/4] sm:aspect-square lg:aspect-[5/4]">
                            <div class="w-10 h-10 mb-2 drop-shadow-sm group-hover/kat:scale-110 transition-transform">
                                <img src="{{ asset('images/icons/' . $data['icon']) }}" alt="{{ $kat->nama }}" class="w-full h-full object-contain">
                            </div>
                            <span class="text-xs font-bold {{ $data['text'] }} text-center">{{ $kat->nama }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-[20px] p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-[#E2E8F0] flex flex-col justify-center h-[100px]">
                    <div class="w-7 h-7 rounded-lg bg-[#DCFCE7] flex items-center justify-center text-[#16A34A] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="text-[#64748B] text-[10px] font-bold uppercase tracking-wider mb-0.5">Total Produk</div>
                    <div class="text-xl font-extrabold text-[#172554] leading-none">{{ number_format($totalProduk) }}</div>
                </div>
                <div class="bg-white rounded-[20px] p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-[#E2E8F0] flex flex-col justify-center h-[100px]">
                    <div class="w-7 h-7 rounded-lg bg-[#F3E8FF] flex items-center justify-center text-[#9333EA] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div class="text-[#64748B] text-[10px] font-bold uppercase tracking-wider mb-0.5">Toko / Penjual</div>
                    <div class="text-xl font-extrabold text-[#172554] leading-none">{{ number_format($totalPenjual) }}</div>
                </div>
                <div class="bg-white rounded-[20px] p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-[#E2E8F0] flex flex-col justify-center h-[100px]">
                    <div class="w-7 h-7 rounded-lg bg-[#FEF3C7] flex items-center justify-center text-[#D97706] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </div>
                    <div class="text-[#64748B] text-[10px] font-bold uppercase tracking-wider mb-0.5">Kategori</div>
                    <div class="text-xl font-extrabold text-[#172554] leading-none">{{ number_format($totalKategori) }}</div>
                </div>
                <div class="bg-white rounded-[20px] p-4 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all border border-[#E2E8F0] flex flex-col justify-center h-[100px]">
                    <div class="w-7 h-7 rounded-lg bg-[#E0E7FF] flex items-center justify-center text-[#4F46E5] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-[#64748B] text-[10px] font-bold uppercase tracking-wider mb-0.5">Akses Cepat</div>
                    <a href="{{ route('public.produk.index') }}" class="text-xs font-bold text-[#2563EB] hover:text-[#1D4ED8] flex items-center gap-1">
                        Katalog <span class="text-sm leading-none">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── Right Column: Rekomendasi (Span 8) ────────────────────────── --}}
        <div class="lg:col-span-8 bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-[#E2E8F0] h-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-[#172554] tracking-tight">Rekomendasi Untukmu</h2>
                <a href="{{ route('public.produk.index') }}" class="text-sm font-semibold text-[#2563EB] hover:text-[#1D4ED8] bg-[#EFF6FF] px-4 py-2 rounded-[12px] hover:bg-[#DBEAFE] transition-colors">
                    Lihat semua
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($produkRekomendasi as $item)
                    <x-public.product-card :produk="$item" />
                @endforeach
            </div>
        </div>

    </div>

    {{-- ─── Information Footer: Cara Memesan ────────────────────────────── --}}
    <div class="mt-8 bg-[#EFF6FF] border border-[#BFDBFE] rounded-[24px] p-6 shadow-sm flex flex-col lg:flex-row items-center justify-between gap-6">
        <h2 class="text-lg font-bold text-[#172554] tracking-tight shrink-0 whitespace-nowrap">Cara Memesan</h2>
        
        <div class="flex-1 flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 sm:gap-4 lg:gap-6 w-full">
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-[#DBEAFE]">
                <span class="text-[#2563EB] font-bold text-xs">01</span>
                <span class="text-[13px] font-medium text-[#1E3A8A]">Pilih Produk</span>
            </div>
            <span class="hidden sm:block text-[#93C5FD]">&rarr;</span>
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-[#DBEAFE]">
                <span class="text-[#2563EB] font-bold text-xs">02</span>
                <span class="text-[13px] font-medium text-[#1E3A8A]">Hubungi Penjual</span>
            </div>
            <span class="hidden sm:block text-[#93C5FD]">&rarr;</span>
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-[#DBEAFE]">
                <span class="text-[#2563EB] font-bold text-xs">03</span>
                <span class="text-[13px] font-medium text-[#1E3A8A]">Bayar</span>
            </div>
            <span class="hidden sm:block text-[#93C5FD]">&rarr;</span>
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-[#DBEAFE]">
                <span class="text-[#2563EB] font-bold text-xs">04</span>
                <span class="text-[13px] font-medium text-[#1E3A8A]">Ambil</span>
            </div>
        </div>

        <a href="{{ route('public.cara_pemesanan') }}" class="shrink-0 text-sm font-semibold text-white bg-[#2563EB] hover:bg-[#1D4ED8] px-5 py-2.5 rounded-[14px] transition-all flex items-center gap-2 shadow-sm w-full lg:w-auto justify-center">
            Lihat detailnya &rarr;
        </a>
    </div>

    {{-- ─── Simple Footer ────────────────────────────────────────────────── --}}
    <footer class="mt-12 text-center pb-6">
        <p class="text-sm font-semibold text-[#172554]">© 2026 SiswaMart</p>
        <p class="text-xs font-medium text-[#64748B] mt-1">Media promosi produk kreatif siswa di lingkungan sekolah.</p>
    </footer>

</div>

@endsection
