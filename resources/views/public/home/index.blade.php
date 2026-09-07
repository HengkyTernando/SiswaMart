@extends('layouts.public')

@section('title', 'SiswaMart')
@section('meta_description', 'SiswaMart — Temukan produk kreatif siswa: makanan, minuman, snack, dan berbagai produk karya siswa di lingkungan sekolah.')

@section('content')

<div class="max-w-[1400px] mx-auto px-6 lg:px-[60px] pb-20">
    
    {{-- ─── 1. HERO SECTION ────────────────────────────────────────── --}}
    <div class="relative py-16 md:py-24 flex flex-col md:flex-row items-center justify-between gap-12 mt-4 md:mt-8 mb-12">
        {{-- Organic Blob Background --}}
        <div class="absolute top-[-10%] right-[-5%] w-[300px] h-[300px] md:w-[600px] md:h-[600px] bg-[var(--color-primary-light)] rounded-full mix-blend-multiply filter blur-3xl opacity-80 pointer-events-none z-[-1]"></div>
        
        <div class="w-full md:w-3/5 relative z-10">
            <h1 class="text-6xl md:text-7xl lg:text-[90px] font-extrabold text-[var(--color-text)] leading-[0.9] tracking-tighter mb-6 uppercase">
                MAKAN <span class="text-[var(--color-primary)]">ENAK.</span><br>
                BUATAN TEMAN SENDIRI.
            </h1>
            <p class="text-lg md:text-2xl font-bold text-[var(--color-text-muted)] max-w-xl mb-10 leading-snug">
                Marketplace makanan sekolah paling seru. Cari jajan, makanan berat, atau minuman segar langsung dari kelas sebelah.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('public.produk.index') }}" class="btn-primary px-8 py-4 text-lg bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)]">
                    JELAJAHI SEKARANG
                </a>
            </div>
        </div>
        
        <div class="w-full md:w-2/5 relative z-10 hidden md:block">
            <div class="relative w-full aspect-square bg-[var(--color-warning)] rounded-full border-4 border-[var(--color-border)] shadow-solid-lg overflow-hidden transform rotate-3 hover:rotate-0 transition-transform duration-500">
                <img src="{{ asset('images/hero-bg.png') }}" alt="Makanan Enak" class="w-full h-full object-cover mix-blend-multiply opacity-90 p-4">
                <div class="absolute inset-0 flex items-center justify-center text-[100px] drop-shadow-md">
                    🍔
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-12 items-start">
        
        {{-- ─── LEFT COLUMN: Kategori & Statistik (Span 4/12) ──────────── --}}
        <div class="w-full lg:w-4/12 flex flex-col gap-12">
            
            {{-- Kategori --}}
            <div>
                <h2 class="text-4xl font-extrabold text-[var(--color-text)] tracking-tighter uppercase mb-6">PILIHAN KATEGORI</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($kategoriList->take(4) as $kat)
                        @php
                            $catData = [
                                'makanan' => ['icon'=>'food.svg', 'bg'=>'bg-[#FFB084]', 'text'=>'text-[var(--color-text)]'],
                                'minuman' => ['icon'=>'drink.svg', 'bg'=>'bg-[#A3D9C9]', 'text'=>'text-[var(--color-text)]'],
                                'snack' => ['icon'=>'snack.svg', 'bg'=>'bg-[#FFD84D]', 'text'=>'text-[var(--color-text)]'],
                                'dessert' => ['icon'=>'dessert.svg', 'bg'=>'bg-[#D4C4FB]', 'text'=>'text-[var(--color-text)]'],
                            ];
                            $data = $catData[$kat->slug] ?? ['icon'=>'bag.svg', 'bg'=>'bg-[#FFF8E8]', 'text'=>'text-[var(--color-text)]'];
                        @endphp
                        <a href="{{ route('public.kategori.show', $kat->slug) }}" class="category-card flex flex-col items-center justify-center p-6 {{ $data['bg'] }} aspect-square group">
                            <div class="w-16 h-16 mb-4 drop-shadow-[2px_2px_0_rgba(36,26,20,1)] group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('images/icons/' . $data['icon']) }}" alt="{{ $kat->nama }}" class="w-full h-full object-contain">
                            </div>
                            <span class="text-lg font-extrabold {{ $data['text'] }} text-center uppercase">{{ $kat->nama }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Statistik Compact --}}
            <div class="bg-[var(--color-surface)] border-2 border-[var(--color-border)] rounded-[32px] p-8 shadow-solid-lg">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="text-4xl font-black text-[var(--color-primary)]">{{ number_format($totalProduk) }}</div>
                        <div class="text-xs font-bold text-[var(--color-text)] uppercase tracking-widest mt-1">PRODUK</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-[var(--color-success)]">{{ number_format($totalPenjual) }}</div>
                        <div class="text-xs font-bold text-[var(--color-text)] uppercase tracking-widest mt-1">PENJUAL</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-[var(--color-warning)]">{{ number_format($totalKategori) }}</div>
                        <div class="text-xs font-bold text-[var(--color-text)] uppercase tracking-widest mt-1">KATEGORI</div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('public.produk.index') }}" class="text-lg font-black text-[var(--color-text)] hover:text-[var(--color-primary)] flex items-center gap-2 group">
                            KATALOG 
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- ─── RIGHT COLUMN: Produk Rekomendasi (Span 8/12) ────────────── --}}
        <div class="w-full lg:w-8/12">
            <div class="flex items-end justify-between mb-8">
                <h2 class="text-4xl md:text-5xl font-extrabold text-[var(--color-text)] tracking-tighter uppercase leading-none">
                    YANG LAGI <br><span class="text-[var(--color-primary)]">DICARI.</span>
                </h2>
                <a href="{{ route('public.produk.index') }}" class="btn-primary px-6 py-2 text-sm bg-white hover:bg-[var(--color-surface)]">
                    LIHAT SEMUA
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($produkRekomendasi->take(6) as $item)
                    <x-public.product-card :produk="$item" />
                @endforeach
            </div>
            
            @if($produkRekomendasi->isEmpty())
                <div class="bg-[var(--color-surface)] border-2 border-dashed border-[var(--color-border)] rounded-3xl p-12 text-center text-[var(--color-text-muted)] font-bold uppercase">
                    Belum ada produk saat ini.
                </div>
            @endif
        </div>

    </div>

    {{-- ─── SECTION: CARA MEMESAN ────────────────────────────────────── --}}
    <div class="mt-24 bg-[var(--color-success)] border-2 border-[var(--color-border)] rounded-[40px] p-8 md:p-16 shadow-solid-lg text-white">
        <div class="flex flex-col lg:flex-row gap-12 items-center justify-between">
            <div class="lg:w-1/3 text-center lg:text-left">
                <h2 class="text-5xl md:text-6xl font-black uppercase tracking-tighter leading-none mb-4 drop-shadow-[2px_2px_0_rgba(36,26,20,1)]">
                    GAMPANG<br>BANGET.
                </h2>
                <p class="text-lg font-bold opacity-90 max-w-sm mx-auto lg:mx-0">
                    Nggak perlu ribet, pesan makanan favoritmu cuma butuh beberapa langkah mudah.
                </p>
                <a href="{{ route('public.cara_pemesanan') }}" class="btn-primary inline-flex mt-8 px-8 py-3 bg-[var(--color-bg)] text-[var(--color-text)] hover:bg-[var(--color-warning)] text-sm border-2 border-[var(--color-border)] shadow-solid-sm">
                    BACA DETAILNYA
                </a>
            </div>
            
            <div class="lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                <div class="bg-white text-[var(--color-text)] p-6 rounded-[24px] border-2 border-[var(--color-border)] shadow-solid-sm transform -rotate-1 hover:rotate-0 transition-transform">
                    <div class="text-4xl font-black text-[var(--color-primary)] mb-2">01</div>
                    <div class="text-xl font-extrabold uppercase">Pilih Makanan</div>
                </div>
                <div class="bg-white text-[var(--color-text)] p-6 rounded-[24px] border-2 border-[var(--color-border)] shadow-solid-sm transform rotate-1 hover:rotate-0 transition-transform">
                    <div class="text-4xl font-black text-[var(--color-warning)] mb-2">02</div>
                    <div class="text-xl font-extrabold uppercase">Hubungi Penjual</div>
                </div>
                <div class="bg-white text-[var(--color-text)] p-6 rounded-[24px] border-2 border-[var(--color-border)] shadow-solid-sm transform rotate-2 hover:rotate-0 transition-transform">
                    <div class="text-4xl font-black text-[var(--color-success)] mb-2">03</div>
                    <div class="text-xl font-extrabold uppercase">Bayar Pesanan</div>
                </div>
                <div class="bg-white text-[var(--color-text)] p-6 rounded-[24px] border-2 border-[var(--color-border)] shadow-solid-sm transform -rotate-2 hover:rotate-0 transition-transform">
                    <div class="text-4xl font-black text-[var(--color-text-muted)] mb-2">04</div>
                    <div class="text-xl font-extrabold uppercase">Ambil & Nikmati</div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
