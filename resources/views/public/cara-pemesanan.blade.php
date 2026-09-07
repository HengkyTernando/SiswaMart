@extends('layouts.public')

@section('title', 'Cara Pemesanan — SiswaMart')
@section('meta_description', 'Cara mudah memesan produk dari siswa melalui SiswaMart. Cari produk, lihat detail, hubungi penjual, dan pesan langsung.')

@section('content')

{{-- ─── Breadcrumb ──────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-0">
    <nav class="flex items-center gap-1.5 text-sm text-[#64748B]" aria-label="Breadcrumb">
        <a href="{{ route('public.home') }}" class="hover:text-[#2563EB] transition-colors">Beranda</a>
        <span class="text-[#CBD5E1]">/</span>
        <span class="text-[#172033] font-medium truncate max-w-[200px] sm:max-w-xs">Cara Pemesanan</span>
    </nav>
</div>

{{-- ─── Cara Pemesanan ─────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
    <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
        <h1 class="text-3xl lg:text-4xl font-bold text-[#172033] mb-4">Cara Pemesanan</h1>
        <p class="text-[#64748B] text-base lg:text-lg">Temukan produk kreatif yang kamu inginkan dan hubungi penjual secara langsung melalui WhatsApp.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 relative">
        {{-- Decorative Line for Desktop --}}
        <div class="hidden lg:block absolute top-[52px] left-10 right-10 h-px bg-[#E2E8F0] z-0"></div>

        {{-- Step 1 --}}
        <div class="flex-1 bg-white border border-[#E2E8F0] p-8 rounded-2xl relative z-10 text-center lg:text-left shadow-sm">
            <div class="w-16 h-16 bg-[#EFF6FF] text-[#2563EB] rounded-2xl flex items-center justify-center text-3xl mb-6 mx-auto lg:mx-0 shadow-sm border border-[#BFDBFE]">
                🔎
            </div>
            <div class="text-[#2563EB] text-sm font-bold tracking-widest mb-3">01</div>
            <h3 class="text-xl font-bold text-[#172033] mb-3">Cari Produk</h3>
            <p class="text-[#64748B] text-base leading-relaxed">
                Gunakan fitur pencarian atau pilih dari berbagai kategori untuk menemukan produk karya siswa yang kamu inginkan.
            </p>
        </div>

        {{-- Decorative Vertical Line for Mobile --}}
        <div class="lg:hidden w-px h-6 bg-[#E2E8F0] mx-auto -my-2 relative z-0"></div>

        {{-- Step 2 --}}
        <div class="flex-1 bg-white border border-[#E2E8F0] p-8 rounded-2xl relative z-10 text-center lg:text-left shadow-sm">
            <div class="w-16 h-16 bg-[#EFF6FF] text-[#2563EB] rounded-2xl flex items-center justify-center text-3xl mb-6 mx-auto lg:mx-0 shadow-sm border border-[#BFDBFE]">
                👀
            </div>
            <div class="text-[#2563EB] text-sm font-bold tracking-widest mb-3">02</div>
            <h3 class="text-xl font-bold text-[#172033] mb-3">Lihat Detail</h3>
            <p class="text-[#64748B] text-base leading-relaxed">
                Periksa informasi produk, harga, status ketersediaan (Ready/PO), ulasan, dan profil toko penjual dengan seksama.
            </p>
        </div>

        {{-- Decorative Vertical Line for Mobile --}}
        <div class="lg:hidden w-px h-6 bg-[#E2E8F0] mx-auto -my-2 relative z-0"></div>

        {{-- Step 3 --}}
        <div class="flex-1 bg-white border border-[#E2E8F0] p-8 rounded-2xl relative z-10 text-center lg:text-left shadow-sm">
            <div class="w-16 h-16 bg-[#EFF6FF] text-[#2563EB] rounded-2xl flex items-center justify-center text-3xl mb-6 mx-auto lg:mx-0 shadow-sm border border-[#BFDBFE]">
                💬
            </div>
            <div class="text-[#2563EB] text-sm font-bold tracking-widest mb-3">03</div>
            <h3 class="text-xl font-bold text-[#172033] mb-3">Hubungi Penjual</h3>
            <p class="text-[#64748B] text-base leading-relaxed">
                Klik tombol "Hubungi Penjual via WhatsApp" pada halaman detail produk untuk terhubung langsung dengan siswa pembuatnya.
            </p>
        </div>

        {{-- Decorative Vertical Line for Mobile --}}
        <div class="lg:hidden w-px h-6 bg-[#E2E8F0] mx-auto -my-2 relative z-0"></div>

        {{-- Step 4 --}}
        <div class="flex-1 bg-white border border-[#E2E8F0] p-8 rounded-2xl relative z-10 text-center lg:text-left shadow-sm">
            <div class="w-16 h-16 bg-[#EFF6FF] text-[#2563EB] rounded-2xl flex items-center justify-center text-3xl mb-6 mx-auto lg:mx-0 shadow-sm border border-[#BFDBFE]">
                🤝
            </div>
            <div class="text-[#2563EB] text-sm font-bold tracking-widest mb-3">04</div>
            <h3 class="text-xl font-bold text-[#172033] mb-3">Pesan Langsung</h3>
            <p class="text-[#64748B] text-base leading-relaxed">
                Diskusikan ketersediaan, waktu pengambilan, dan detail pesanan. Transaksi diselesaikan langsung dengan penjual.
            </p>
        </div>
    </div>
</section>

{{-- ─── CTA Bottom ──────────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-10">
    <div class="bg-[#EFF6FF] border border-[#BFDBFE] rounded-2xl px-8 py-10 text-center shadow-sm">
        <h2 class="text-2xl font-bold text-[#172033] mb-3">
            Siap untuk mulai mencari?
        </h2>
        <p class="text-[#64748B] text-sm sm:text-base mb-6 max-w-md mx-auto">
            Dukung kreativitas teman-teman sekolahmu dengan membeli produk karya mereka.
        </p>
        <a href="{{ route('public.produk.index') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-3 rounded-xl shadow-soft">
            Jelajahi Produk Sekarang
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

@endsection
