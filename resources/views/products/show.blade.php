@extends('layouts.app')

@section('title', $product->name . ' - SiswaMart')

@section('content')

{{-- ══ BREADCRUMB ══════════════════════════════════════════════════════════════ --}}
<div style="background:var(--clr-surface);border-bottom:1px solid var(--clr-border)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-1.5 text-xs font-medium flex-wrap">

            {{-- Beranda --}}
            <a href="{{ route('home') }}"
               class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg transition"
               style="color:var(--clr-muted)"
               onmouseover="this.style.background='rgba(139,92,246,.12)';this.style.color='var(--clr-purple-l)'"
               onmouseout="this.style.background='transparent';this.style.color='var(--clr-muted)'">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Beranda
            </a>

            {{-- Chevron --}}
            <svg class="w-3 h-3 flex-shrink-0" style="color:var(--clr-border)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>

            {{-- Kategori --}}
            <a href="{{ route('home', ['category' => $product->category->slug]) }}"
               class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg transition"
               style="color:var(--clr-muted)"
               onmouseover="this.style.background='rgba(139,92,246,.12)';this.style.color='var(--clr-purple-l)'"
               onmouseout="this.style.background='transparent';this.style.color='var(--clr-muted)'">
                <x-category-icon :icon="$product->category->icon ?? 'category'" class="w-3 h-3" />
                {{ $product->category->name }}
            </a>

            {{-- Chevron --}}
            <svg class="w-3 h-3 flex-shrink-0" style="color:var(--clr-border)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>

            {{-- Produk (active) --}}
            <span class="px-2.5 py-1 rounded-lg font-semibold line-clamp-1 max-w-xs"
                  style="background:rgba(139,92,246,.15);color:var(--clr-purple-l);border:1px solid rgba(139,92,246,.25)">
                {{ $product->name }}
            </span>
        </nav>
    </div>
</div>

{{-- ══ PRODUCT DETAIL (single screen, compact) ════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
    <div class="rounded-2xl overflow-hidden" style="background:var(--clr-card);border:1px solid var(--clr-border)">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">

            {{-- ── LEFT: Image (compact, fixed height) ── --}}
            <div class="relative overflow-hidden flex items-center justify-center"
                 style="background:var(--clr-surface);min-height:340px;max-height:420px;border-right:1px solid var(--clr-border)">
                @php
                    $imgSrc = null;
                    if ($product->image) {
                        $imgSrc = str_starts_with($product->image, 'http')
                            ? $product->image
                            : asset('storage/' . $product->image);
                    }
                @endphp

                @if ($imgSrc)
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-contain"
                         style="max-height:420px">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center p-8">
                        <x-category-icon :icon="$product->category->icon ?? 'category'" class="w-20 h-20" style="color:rgba(139,92,246,.3)" />
                        <span class="text-xs mt-3" style="color:var(--clr-muted)">Tidak ada gambar</span>
                    </div>
                @endif

                {{-- Stock overlay badge --}}
                @if ($product->stock == 0)
                    <div class="absolute inset-0 flex items-center justify-center" style="background:rgba(0,0,0,.55)">
                        <span class="font-bold px-5 py-2.5 rounded-xl text-sm" style="background:var(--clr-card);color:#f87171;border:1px solid rgba(248,113,113,.3)">
                            Stok Habis
                        </span>
                    </div>
                @elseif ($product->stock <= 5)
                    <div class="absolute top-3 left-3 text-white text-xs font-bold px-2.5 py-1 rounded-lg" style="background:#d97706">
                        Sisa {{ $product->stock }} pcs!
                    </div>
                @endif
            </div>

            {{-- ── RIGHT: Info (compact, no scroll) ── --}}
            <div class="flex flex-col p-5 gap-4">

                {{-- Category + Title --}}
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold mb-2"
                          style="background:rgba(139,92,246,.15);color:var(--clr-purple-l);border:1px solid rgba(139,92,246,.25)">
                        <x-category-icon :icon="$product->category->icon ?? 'category'" class="w-3 h-3" />
                        {{ $product->category->name }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-black text-white leading-tight">
                        {{ $product->name }}
                    </h1>
                </div>

                {{-- Price --}}
                <div class="text-3xl font-black grad-text">
                    {{ $product->formatted_price }}
                </div>

                {{-- Stock info --}}
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-2 h-2 rounded-full {{ $product->stock > 5 ? 'bg-emerald-400' : ($product->stock > 0 ? 'bg-yellow-400' : 'bg-red-400') }}"></div>
                    <span style="color:var(--clr-muted)">Stok:</span>
                    <span class="font-bold {{ $product->stock > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                        {{ $product->stock > 0 ? $product->stock . ' pcs tersedia' : 'Habis' }}
                    </span>
                </div>

                {{-- Seller --}}
                <div class="flex items-center gap-3 py-3 px-3 rounded-xl" style="background:var(--clr-surface);border:1px solid var(--clr-border)">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                         style="background:linear-gradient(135deg,#059669,#10b981)">
                        {{ strtoupper(substr($product->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xs" style="color:var(--clr-muted)">Dijual oleh</div>
                        <div class="font-bold text-sm text-white flex items-center gap-1">
                            {{ $product->user->name }}
                            <svg class="w-3.5 h-3.5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="text-sm leading-relaxed line-clamp-3" style="color:var(--clr-muted)">
                    {{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}
                </div>

                {{-- Action --}}
                <div class="mt-auto pt-2">
                    @if ($product->stock > 0)
                        <form action="{{ route('customer.cart.add') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center rounded-xl overflow-hidden flex-shrink-0"
                                 style="background:var(--clr-surface);border:1px solid var(--clr-border)">
                                <button type="button" onclick="changeQty(-1)"
                                        class="w-9 h-10 flex items-center justify-center transition text-lg font-bold"
                                        style="color:var(--clr-muted)"
                                        onmouseover="this.style.color='var(--clr-purple-l)'"
                                        onmouseout="this.style.color='var(--clr-muted)'">−</button>
                                <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-10 h-10 text-center font-bold border-0 focus:outline-none text-sm"
                                       style="background:transparent;color:var(--clr-text)">
                                <button type="button" onclick="changeQty(1)"
                                        class="w-9 h-10 flex items-center justify-center transition text-lg font-bold"
                                        style="color:var(--clr-muted)"
                                        onmouseover="this.style.color='var(--clr-purple-l)'"
                                        onmouseout="this.style.color='var(--clr-muted)'">+</button>
                            </div>
                            <button type="submit"
                                    class="btn-primary flex-1 rounded-xl flex items-center justify-center gap-2 text-sm glow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                + Keranjang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full font-bold py-3 rounded-xl cursor-not-allowed text-sm"
                                style="background:var(--clr-surface);color:var(--clr-muted);border:1px solid var(--clr-border)">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ══ Related Products ════════════════════════════════════════════════════ --}}
    @if ($related->count() > 0)
        <div class="mt-8">
            <h2 class="text-lg font-black text-white mb-4">Produk Serupa</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($related as $relatedProduct)
                    @include('partials.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const val = parseInt(input.value) + delta;
    const max = parseInt(input.max);
    if (val >= 1 && val <= max) input.value = val;
}
</script>
@endpush

@endsection
