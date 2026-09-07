@extends('layouts.public')

@section('title', $kategori->nama . ' | Katalog SiswaMart')
@section('meta_description', 'Jelajahi produk ' . strtolower($kategori->nama) . ' karya siswa di SiswaMart.')

@section('content')

<style>
.range-slider input[type="range"]::-webkit-slider-thumb {
    pointer-events: auto;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: transparent;
    cursor: pointer;
    -webkit-appearance: none;
}
.range-slider input[type="range"]::-moz-range-thumb {
    pointer-events: auto;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: transparent;
    cursor: pointer;
    border: none;
}
</style>

<div class="bg-[#F8FAFC] min-h-screen pb-16 pt-8" x-data="{
    q: '{{ $search ?? '' }}',
    sort: '{{ $sort ?? 'terbaru' }}',
    min_price: '{{ $minPrice ?? '' }}',
    max_price: '{{ $maxPrice ?? '' }}',
    get sliderMin() {
        return this.min_price === '' ? 0 : parseInt(this.min_price);
    },
    set sliderMin(val) {
        this.min_price = val;
    },
    get sliderMax() {
        return this.max_price === '' ? 50000 : parseInt(this.max_price);
    },
    set sliderMax(val) {
        this.max_price = val;
    },
    validateInput() {
        let min = parseInt(this.min_price);
        let max = parseInt(this.max_price);
        if (isNaN(min) || min < 0) min = 0;
        if (isNaN(max) || max > 50000) max = 50000;
        if (min > max) {
            let tmp = min;
            min = max;
            max = tmp;
        }
        this.min_price = min;
        this.max_price = max;
    },
    submitForm() {
        this.validateInput();
        if (this.min_price == 0) this.min_price = '';
        if (this.max_price == 50000) this.max_price = '';
        $refs.mainForm.submit();
    },
    resetFilter() {
        this.min_price = '';
        this.max_price = '';
        this.submitForm();
    }
}">
    
    <form x-ref="mainForm" action="{{ route('public.kategori.show', $kategori->slug) }}" method="GET" class="hidden">
        <input type="hidden" name="q" x-model="q">
        <input type="hidden" name="sort" x-model="sort">
        <input type="hidden" name="min_price" x-model="min_price">
        <input type="hidden" name="max_price" x-model="max_price">
    </form>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ─── Breadcrumb ────────────────────────────────────────────── --}}
        <nav class="flex items-center gap-2 text-sm text-[#64748B] mb-6" aria-label="Breadcrumb">
            <a href="{{ route('public.home') }}" class="hover:text-[#2563EB] transition-colors">Beranda</a>
            <svg class="w-4 h-4 text-[#CBD5E1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('public.kategori.index') }}" class="hover:text-[#2563EB] transition-colors">Kategori</a>
            <svg class="w-4 h-4 text-[#CBD5E1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#172033] font-medium">{{ $kategori->nama }}</span>
        </nav>

        {{-- ─── Header Section ────────────────────────────────────────── --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8 border-b border-[#E2E8F0] pb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#172033] mb-2">{{ $kategori->nama }}</h1>
                <p class="text-sm text-[#64748B]">Temukan berbagai {{ strtolower($kategori->nama) }} lezat pilihan siswa.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                <span class="text-sm text-[#64748B] whitespace-nowrap">{{ $produk->total() }} produk ditemukan</span>
                

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <span class="text-sm text-[#64748B] whitespace-nowrap">Urutkan:</span>
                    <select x-model="sort" @change="submitForm()"
                            class="w-full sm:w-auto pl-3 pr-8 py-2 text-sm font-medium border border-[#E2E8F0] bg-white rounded-lg focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB] outline-none appearance-none cursor-pointer">
                        <option value="terbaru">Terbaru</option>
                        <option value="terpopuler">Terpopuler</option>
                        <option value="termurah">Termurah</option>
                        <option value="termahal">Termahal</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ─── Mobile Category Horizontal Scroll ─────────────────── --}}
            <div class="lg:hidden w-full overflow-x-auto scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-0">
                <div class="flex gap-2 w-max pb-2">
                    <a href="{{ route('public.kategori.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-[#64748B] border border-[#E2E8F0] bg-white hover:bg-[#F8FAFC] hover:text-[#172033] transition-colors shadow-sm">
                        Semua Kategori
                        <span class="text-xs bg-[#F1F5F9] text-[#64748B] px-1.5 py-0.5 rounded-md">{{ $totalSemua }}</span>
                    </a>
                    @foreach($kategoriList as $kat)
                        @if($kat->produk_count > 0)
                            @if($kat->id === $kategori->id)
                                <a href="{{ route('public.kategori.show', $kat->slug) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-colors bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE]">
                                    {{ $kat->nama }}
                                    <span class="text-xs bg-[#DBEAFE] text-[#1D4ED8] px-1.5 py-0.5 rounded-md">{{ $kat->produk_count }}</span>
                                </a>
                            @else
                                <a href="{{ route('public.kategori.show', $kat->slug) }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-[#64748B] border border-[#E2E8F0] bg-white hover:bg-[#F8FAFC] hover:text-[#172033] transition-colors shadow-sm">
                                    {{ $kat->nama }}
                                    <span class="text-xs bg-[#F1F5F9] text-[#64748B] px-1.5 py-0.5 rounded-md">{{ $kat->produk_count }}</span>
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- ─── Sidebar (Desktop) ──────────────────────── --}}
            <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    
                    {{-- Card Kategori --}}
                    <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-sm p-4">
                        <h2 class="text-sm font-bold text-[#172033] mb-4">Kategori</h2>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('public.kategori.index') }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#2563EB] border-l-4 border-transparent transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 bg-[#F1F5F9] rounded-full flex items-center justify-center p-1.5 flex-shrink-0">
                                            <img src="{{ asset('images/icons/bag.svg') }}" alt="Semua Kategori" class="w-full h-full object-contain">
                                        </div>
                                        <span class="group-hover:font-semibold">Semua Kategori</span>
                                    </div>
                                    <span class="text-xs font-medium group-hover:font-semibold">{{ $totalSemua }}</span>
                                </a>
                            </li>
                            @foreach($kategoriList as $kat)
                                @if($kat->produk_count > 0)
                                    @php
                                        $catData = [
                                            'makanan' => ['icon'=>'food.svg', 'bg'=>'bg-[#FEE2E2]'],
                                            'minuman' => ['icon'=>'drink.svg', 'bg'=>'bg-[#DBEAFE]'],
                                            'snack' => ['icon'=>'snack.svg', 'bg'=>'bg-[#FEF08A]'],
                                            'dessert' => ['icon'=>'dessert.svg', 'bg'=>'bg-[#F3E8FF]'],
                                        ];
                                        $data = $catData[$kat->slug] ?? ['icon'=>'bag.svg', 'bg'=>'bg-[#F1F5F9]'];
                                        $isActive = $kat->id === $kategori->id;
                                    @endphp
                                    <li>
                                        <a href="{{ route('public.kategori.show', $kat->slug) }}"
                                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors group
                                           {{ $isActive ? 'font-semibold bg-[#EFF6FF] text-[#2563EB] border-l-4 border-[#2563EB]' : 'font-medium text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#2563EB] border-l-4 border-transparent' }}">
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 {{ $data['bg'] }} rounded-full flex items-center justify-center p-1.5 flex-shrink-0">
                                                    <img src="{{ asset('images/icons/' . $data['icon']) }}" alt="{{ $kat->nama }}" class="w-full h-full object-contain">
                                                </div>
                                                <span class="{{ !$isActive ? 'group-hover:font-semibold' : '' }}">{{ $kat->nama }}</span>
                                            </div>
                                            <span class="text-xs {{ $isActive ? 'font-semibold bg-[#DBEAFE] text-[#1D4ED8]' : 'font-medium group-hover:font-semibold' }} px-1.5 py-0.5 rounded-md">{{ $kat->produk_count }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    {{-- Card Filter Harga --}}
                    <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-sm p-5">
                        <h2 class="text-sm font-bold text-[#172033] mb-4">Filter Harga</h2>
                        
                        {{-- Range visualization --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-[#94A3B8] mb-2">
                                <span>Rentang Harga</span>
                                <span>Rp0 - Rp50.000</span>
                            </div>
                            <div class="relative h-1.5 bg-[#E2E8F0] rounded-full range-slider">
                                <div class="absolute top-0 h-full bg-[#2563EB] rounded-full"
                                     x-bind:style="`left: ${(sliderMin / 50000) * 100}%; right: ${100 - (sliderMax / 50000) * 100}%;`"></div>
                                
                                <input type="range" min="0" max="50000" step="1000" 
                                       x-model="sliderMin" 
                                       @input="if(sliderMin > sliderMax) sliderMin = sliderMax"
                                       class="absolute w-full h-1.5 opacity-0 cursor-pointer pointer-events-none appearance-none z-20">
                                       
                                <input type="range" min="0" max="50000" step="1000" 
                                       x-model="sliderMax" 
                                       @input="if(sliderMax < sliderMin) sliderMax = sliderMin"
                                       class="absolute w-full h-1.5 opacity-0 cursor-pointer pointer-events-none appearance-none z-20">
                                       
                                <div class="absolute top-1/2 -translate-y-1/2 w-3.5 h-3.5 bg-[#2563EB] rounded-full shadow pointer-events-none z-10"
                                     x-bind:style="`left: calc(${(sliderMin / 50000) * 100}% - 7px);`"></div>
                                
                                <div class="absolute top-1/2 -translate-y-1/2 w-3.5 h-3.5 bg-[#2563EB] rounded-full shadow pointer-events-none z-10"
                                     x-bind:style="`left: calc(${(sliderMax / 50000) * 100}% - 7px);`"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex-1">
                                <label class="text-xs text-[#64748B] block mb-1">Rp Min</label>
                                <input type="text" x-model="min_price" @input="min_price = min_price.toString().replace(/[^0-9]/g, '')" @change="validateInput()" placeholder="0" class="w-full px-2 py-1.5 text-sm border border-[#E2E8F0] rounded-md focus:border-[#2563EB] outline-none">
                            </div>
                            <div class="flex-1">
                                <label class="text-xs text-[#64748B] block mb-1">Rp Max</label>
                                <input type="text" x-model="max_price" @input="max_price = max_price.toString().replace(/[^0-9]/g, '')" @change="validateInput()" placeholder="50000" class="w-full px-2 py-1.5 text-sm border border-[#E2E8F0] rounded-md focus:border-[#2563EB] outline-none">
                            </div>
                        </div>

                        <button @click="submitForm()" class="w-full bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-semibold py-2 rounded-lg transition-colors mb-3">
                            Terapkan Filter
                        </button>
                        <button @click="resetFilter()" class="w-full text-center text-xs font-semibold text-[#2563EB] hover:text-[#1D4ED8] transition-colors">
                            Reset Filter
                        </button>
                    </div>

                </div>
            </aside>

            {{-- ─── Main Content ──────────────────────────────────────── --}}
            <main class="flex-1 min-w-0">
                
                {{-- Product Grid --}}
                @if($produk->isEmpty())
                    <div class="bg-white border border-[#E2E8F0] rounded-xl p-12 lg:p-16 text-center shadow-sm">
                        <div class="w-16 h-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#E2E8F0]">
                            <svg class="w-8 h-8 text-[#94A3B8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#172033] mb-2">Belum ada produk</h3>
                        <p class="text-[#64748B] text-sm mb-6 max-w-sm mx-auto">
                            @if($search || $minPrice || $maxPrice)
                                Tidak ada produk aktif yang cocok dengan filter pencarian Anda.
                            @else
                                Belum ada produk aktif yang tersedia dalam kategori ini.
                            @endif
                        </p>
                        <a href="{{ route('public.kategori.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] px-6 py-2.5 rounded-lg transition-colors shadow-soft hover:shadow-md">
                            Lihat Semua Produk
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
                        @foreach($produk as $item)
                            <x-public.product-card :produk="$item" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-10">
                        {{ $produk->links() }}
                    </div>
                @endif

            </main>
        </div>
    </div>
</div>

@endsection
