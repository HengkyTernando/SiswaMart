@extends('layouts.app')
@section('title', 'SiswaMart – Marketplace Perlengkapan Sekolah Terlengkap')

@section('content')

{{-- ══ HERO ════════════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden"
         style="background:linear-gradient(135deg,#0d0d18 0%,#130826 50%,#1a0a2e 100%);min-height:340px">

    {{-- Glow blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-20 left-1/3 w-96 h-96 rounded-full opacity-25"
             style="background:radial-gradient(circle,#7c3aed,transparent 70%);filter:blur(80px)"></div>
        <div class="absolute bottom-0 right-10 w-72 h-72 rounded-full opacity-15"
             style="background:radial-gradient(circle,#c084fc,transparent 70%);filter:blur(60px)"></div>
    </div>
    {{-- Grid --}}
    <div class="absolute inset-0 opacity-[0.04]"
         style="background-image:linear-gradient(var(--clr-purple) 1px,transparent 1px),linear-gradient(90deg,var(--clr-purple) 1px,transparent 1px);background-size:36px 36px"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 relative">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-center">

            {{-- Text col (3/5) --}}
            <div class="lg:col-span-3">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold mb-5"
                     style="background:rgba(139,92,246,.15);border:1px solid rgba(139,92,246,.3);color:#a78bfa">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block" width="13" height="13" style="vertical-align:-1px"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Marketplace #1 untuk Pelajar Indonesia
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-4">
                    Semua Kebutuhan<br><span class="grad-text">Sekolah</span> Ada di Sini!
                </h1>
                <p class="text-base mb-7 max-w-lg" style="color:#9d8fc4">
                    Dari alat tulis, buku, tas sekolah, hingga seragam — temukan harga terbaik langsung dari penjual terpercaya.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#produk" class="btn-primary px-6 py-2.5 rounded-xl flex items-center gap-2 glow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15" style="vertical-align:-2px"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Mulai Belanja
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition text-sm"
                       style="background:rgba(255,255,255,.06);border:1px solid rgba(139,92,246,.3);color:#c4b5fd"
                       onmouseover="this.style.background='rgba(139,92,246,.15)'"
                       onmouseout="this.style.background='rgba(255,255,255,.06)'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15" style="vertical-align:-2px"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Buka Toko
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex gap-6 mt-8">
                    <div class="px-4 py-3 rounded-2xl" style="background:rgba(255,255,255,.05);border:1px solid var(--clr-border)">
                        <div class="text-2xl font-black text-white">{{ $products->total() }}</div>
                        <div class="text-xs" style="color:var(--clr-muted)">Total Produk</div>
                    </div>
                    <div class="px-4 py-3 rounded-2xl" style="background:rgba(255,255,255,.05);border:1px solid var(--clr-border)">
                        <div class="text-2xl font-black text-white">{{ $categories->count() }}</div>
                        <div class="text-xs" style="color:var(--clr-muted)">Kategori</div>
                    </div>
                    <div class="px-4 py-3 rounded-2xl" style="background:rgba(255,255,255,.05);border:1px solid var(--clr-border)">
                        <div class="text-2xl font-black text-white">50+</div>
                        <div class="text-xs" style="color:var(--clr-muted)">Seller Aktif</div>
                    </div>
                </div>
            </div>

            {{-- Glass card col (2/5) --}}
            <div class="lg:col-span-2 hidden lg:block">
                <div class="rounded-3xl p-5 glass">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background:linear-gradient(135deg,#7c3aed,#c084fc)">
                            <x-category-icon icon="book" class="w-4 h-4" style="color:white" />
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Produk Terlaris</p>
                            <p class="text-xs" style="color:var(--clr-muted)">Update harian</p>
                        </div>
                    </div>
                    @foreach($featured->take(3) as $fp)
                    @php $fp_img = $fp->image ? (str_starts_with($fp->image,'http') ? $fp->image : asset('storage/'.$fp->image)) : null; @endphp
                    <div class="flex items-center gap-3 mb-3 p-2.5 rounded-xl transition"
                         style="background:rgba(255,255,255,.03)"
                         onmouseover="this.style.background='rgba(124,58,237,.1)'"
                         onmouseout="this.style.background='rgba(255,255,255,.03)'">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0"
                             style="background:var(--clr-surface)">
                            @if($fp_img)<img src="{{ $fp_img }}" class="w-full h-full object-cover">@endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-xs font-semibold truncate">{{ $fp->name }}</p>
                            <p class="text-xs grad-text font-bold">{{ $fp->formatted_price }}</p>
                        </div>
                    </div>
                    @endforeach
                    <a href="#produk" class="mt-2 w-full btn-primary text-sm py-2 rounded-xl flex items-center justify-center gap-2">
                        Lihat Semua →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ CATEGORIES ══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-black text-white">Kategori</h2>
    </div>
    <div class="flex gap-3 overflow-x-auto pb-1 scrollbar-hide">
        <a href="{{ route('home') }}"
           class="flex-shrink-0 flex flex-col items-center gap-2 px-4 py-3 rounded-2xl transition min-w-[72px]
                  {{ !request('category') ? 'pill-active' : 'pill-inactive' }}">
            <span class="w-7 h-7 flex items-center justify-center">
                <x-category-icon icon="store" class="w-6 h-6" />
            </span>
            <span class="text-xs font-semibold whitespace-nowrap">Semua</span>
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('home', ['category' => $cat->slug]) }}"
           class="flex-shrink-0 flex flex-col items-center gap-2 px-4 py-3 rounded-2xl transition min-w-[80px]
                  {{ request('category') === $cat->slug ? 'pill-active' : 'pill-inactive' }}">
            <span class="w-7 h-7 flex items-center justify-center">
                <x-category-icon :icon="$cat->icon" class="w-6 h-6" />
            </span>
            <span class="text-xs font-semibold whitespace-nowrap">{{ Str::words($cat->name, 1, '') }}</span>
        </a>
        @endforeach
    </div>
</section>

{{-- ══ FEATURED / NEW ══════════════════════════════════════════════════════════ --}}
@if(!request('search') && !request('category') && $featured->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-black text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="color:#a78bfa"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            Produk Terbaru
        </h2>
        <a href="#produk" class="text-xs font-semibold" style="color:var(--clr-purple-l)">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach($featured as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif

{{-- ══ ALL PRODUCTS ════════════════════════════════════════════════════════════ --}}
<section id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-lg font-black text-white">
                @if(request('search'))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="color:#a78bfa;vertical-align:-3px"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    "{{ request('search') }}"
                @elseif(request('category')) {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Kategori' }}
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="color:#a78bfa;vertical-align:-3px"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Semua Produk
                @endif
            </h2>
            <p class="text-xs mt-0.5" style="color:var(--clr-muted)">{{ $products->total() }} produk ditemukan</p>
        </div>
        <form action="{{ route('home') }}" method="GET">
            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            <select name="sort" onchange="this.form.submit()"
                    class="text-sm rounded-xl px-3 py-2 focus:outline-none"
                    style="background:var(--clr-card);border:1px solid var(--clr-border);color:var(--clr-text)">
                <option value="latest"     {{ request('sort','latest')==='latest'    ? 'selected':'' }}>Terbaru</option>
                <option value="price_asc"  {{ request('sort')==='price_asc'          ? 'selected':'' }}>Termurah</option>
                <option value="price_desc" {{ request('sort')==='price_desc'         ? 'selected':'' }}>Termahal</option>
            </select>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="text-center py-20 rounded-3xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div style="display:flex;justify-content:center;margin-bottom:12px">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="56" height="56" style="color:#4c4878"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <p class="font-bold text-white mb-1">Produk tidak ditemukan</p>
            <p class="text-sm mb-4" style="color:var(--clr-muted)">Coba kata kunci lain</p>
            <a href="{{ route('home') }}" class="btn-primary px-5 py-2 rounded-xl inline-block text-sm">Lihat Semua</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        @if($products->hasPages())
            <div class="mt-8 flex justify-center">{{ $products->links() }}</div>
        @endif
    @endif
</section>

@endsection
