@extends('layouts.public')

@section('title', 'Katalog Produk | SiswaMart')
@section('meta_description', 'Cari dan temukan berbagai produk karya siswa di SiswaMart.')

@section('content')

{{-- Filter + breadcrumb header --}}
<div class="bg-[var(--color-bg)] border-b-4 border-[var(--color-border)] shadow-solid-sm pt-8 pb-4">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-[60px]">

        {{-- Search row --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl sm:text-4xl font-black text-[var(--color-text)] truncate uppercase tracking-tighter">
                    @if($search && $selectedKategori)
                        "<span class="text-[var(--color-primary)]">{{ $search }}</span>"
                        di <span class="text-[var(--color-primary)]">{{ $kategoriList->firstWhere('slug', $selectedKategori)?->nama ?? $selectedKategori }}</span>
                    @elseif($search)
                        Hasil Pencarian: "<span class="text-[var(--color-primary)]">{{ $search }}</span>"
                    @elseif($selectedKategori)
                        Kategori: <span class="text-[var(--color-primary)]">{{ $kategoriList->firstWhere('slug', $selectedKategori)?->nama ?? $selectedKategori }}</span>
                    @else
                        Katalog Makanan
                    @endif
                </h1>
                <p class="text-sm font-bold text-[var(--color-text-muted)] uppercase tracking-wider mt-1">{{ $produk->total() }} PRODUK DITEMUKAN</p>
            </div>
            
            <a href="{{ route('public.kategori.index') }}" class="btn-primary shrink-0 text-sm bg-white hover:bg-[var(--color-surface)]">
                LIHAT FILTER LENGKAP
            </a>
        </div>

        {{-- Kategori chips --}}
        <div class="flex items-center gap-3 overflow-x-auto scrollbar-hide pb-2">
            <a href="{{ route('public.produk.index', array_filter(['q' => $search])) }}"
               id="chip-all"
               class="cat-chip {{ !$selectedKategori ? 'bg-[var(--color-primary)] text-white shadow-solid-sm -translate-y-1' : 'bg-white text-[var(--color-text)] shadow-sm hover:shadow-solid-sm hover:-translate-y-1' }} flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold border-2 border-[var(--color-border)] transition-all whitespace-nowrap uppercase tracking-wider">
                🛍️ Semua
            </a>
            @foreach($kategoriList as $kat)
                @php
                    $isActive = $selectedKategori === $kat->slug;
                    $bgColors = ['bg-[#FFB084]', 'bg-[#A3D9C9]', 'bg-[#FFD84D]', 'bg-[#D4C4FB]'];
                    $randomBg = $bgColors[$loop->index % count($bgColors)];
                @endphp
                <a href="{{ route('public.produk.index', array_filter(['kategori' => $kat->slug, 'q' => $search])) }}"
                   id="chip-{{ $kat->slug }}"
                   class="cat-chip {{ $isActive ? $randomBg . ' text-[var(--color-text)] shadow-solid-sm -translate-y-1' : 'bg-white text-[var(--color-text)] shadow-sm hover:shadow-solid-sm hover:-translate-y-1' }} flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold border-2 border-[var(--color-border)] transition-all whitespace-nowrap uppercase tracking-wider">
                    {{ $kat->nama }}
                </a>
            @endforeach
        </div>

    </div>
</div>

{{-- Results Grid --}}
<main class="max-w-[1400px] mx-auto px-6 lg:px-[60px] py-12 mb-20 bg-[var(--color-bg)] min-h-[50vh]">
    @if($produk->isEmpty())
        <div class="bg-[var(--color-surface)] border-2 border-dashed border-[var(--color-border)] rounded-[40px] p-16 text-center">
            <div class="text-[80px] mb-6 grayscale opacity-40">
                🔍
            </div>
            <h3 class="text-3xl font-black text-[var(--color-text)] mb-4 uppercase">Tidak Ketemu Nih</h3>
            <p class="text-lg font-bold text-[var(--color-text-muted)] mb-8 max-w-md mx-auto">
                @if($search)
                    Tidak ada produk yang cocok dengan "<strong>{{ $search }}</strong>". Coba gunakan kata kunci lain.
                @else
                    Belum ada produk aktif di kategori ini.
                @endif
            </p>
            <a href="{{ route('public.produk.index') }}"
               id="btn-kembali-katalog"
               class="btn-primary inline-flex px-8 py-3 bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)]">
                RESET PENCARIAN
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produk as $item)
                <x-public.product-card :produk="$item" />
            @endforeach
        </div>
        <div class="mt-16">{{ $produk->links() }}</div>
    @endif
</main>

@endsection
