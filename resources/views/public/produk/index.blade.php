@extends('layouts.public')

@section('title', 'Katalog Produk | SiswaMart')
@section('meta_description', 'Cari dan temukan berbagai produk karya siswa di SiswaMart.')

@section('content')

{{-- Filter + breadcrumb header --}}
<div class="bg-white border-b border-[#E2E8F0] shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Search row --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 py-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-base sm:text-lg font-bold text-[#172033] truncate">
                    @if($search && $selectedKategori)
                        "<span class="text-[#2563EB]">{{ $search }}</span>"
                        di <span class="text-[#2563EB]">{{ $kategoriList->firstWhere('slug', $selectedKategori)?->nama ?? $selectedKategori }}</span>
                    @elseif($search)
                        Hasil Pencarian: "<span class="text-[#2563EB]">{{ $search }}</span>"
                    @elseif($selectedKategori)
                        Kategori: <span class="text-[#2563EB]">{{ $kategoriList->firstWhere('slug', $selectedKategori)?->nama ?? $selectedKategori }}</span>
                    @else
                        Semua Produk
                    @endif
                </h1>
                <p class="text-sm text-[#64748B]">{{ $produk->total() }} produk ditemukan</p>
            </div>
        </div>

        {{-- Kategori chips --}}
        <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide pb-3">
            <a href="{{ route('public.produk.index', array_filter(['q' => $search])) }}"
               id="chip-all"
               class="cat-chip {{ !$selectedKategori ? 'active' : '' }} flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold border border-[#E2E8F0] transition whitespace-nowrap">
                🛍️ Semua
            </a>
            @foreach($kategoriList as $kat)
                <a href="{{ route('public.produk.index', array_filter(['kategori' => $kat->slug, 'q' => $search])) }}"
                   id="chip-{{ $kat->slug }}"
                   class="cat-chip {{ $selectedKategori === $kat->slug ? 'active' : '' }} flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold border border-[#E2E8F0] transition whitespace-nowrap">
                    {{ $kat->nama }}
                </a>
            @endforeach
        </div>

    </div>
</div>

{{-- Results Grid --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if($produk->isEmpty())
        <div class="bg-white border border-[#E2E8F0] rounded-xl p-16 text-center shadow-sm">
            <div class="w-16 h-16 bg-[#EFF6FF] rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-[#172033] mb-2">Produk tidak ditemukan</h3>
            <p class="text-[#64748B] text-sm mb-6 max-w-xs mx-auto">
                @if($search)
                    Tidak ada produk yang cocok dengan "<strong>{{ $search }}</strong>". Coba gunakan kata kunci lain.
                @else
                    Belum ada produk aktif di kategori ini.
                @endif
            </p>
            <a href="{{ route('public.produk.index') }}"
               id="btn-kembali-katalog"
               class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-[#2563EB] hover:bg-[#1D4ED8] px-5 py-2.5 rounded-lg transition-colors">
                Reset Pencarian
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($produk as $item)
                <x-public.product-card :produk="$item" />
            @endforeach
        </div>
        <div class="mt-10">{{ $produk->links() }}</div>
    @endif
</main>

@endsection
