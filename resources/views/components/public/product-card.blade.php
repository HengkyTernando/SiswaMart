{{--
    Product Card — Public Catalog
    Storefront-style: foto dominan, typography clean, minimal decoration.
--}}
@props(['produk'])

<a href="{{ route('public.produk.show', $produk->slug) }}"
   id="produk-card-{{ $produk->id }}"
   class="product-card group bg-white rounded-xl border border-[#E2E8F0] overflow-hidden flex flex-col focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:ring-offset-2"
   aria-label="Lihat detail {{ $produk->nama }}">

    {{-- ── Foto Produk ──────────────────────────────────────── --}}
    <div class="relative w-full aspect-square overflow-hidden bg-[#F8FAFF]">
        @if($produk->foto_utama)
            <img src="{{ asset('storage/' . $produk->foto_utama) }}"
                 alt="{{ $produk->nama }}"
                 class="w-full h-full object-cover group-hover:scale-[1.04] transition-transform duration-300 ease-out"
                 loading="lazy">
        @else
            <div class="img-placeholder w-full h-full gap-3">
                @php
                    $slug  = $produk->kategori->slug ?? '';
                    $catIcons = [
                        'makanan' => 'food.svg',
                        'minuman' => 'drink.svg',
                        'snack' => 'snack.svg',
                        'dessert' => 'dessert.svg',
                    ];
                    $iconFile = $catIcons[$slug] ?? 'bag.svg';
                @endphp
                <div class="w-12 h-12 opacity-50 grayscale">
                    <img src="{{ asset('images/icons/' . $iconFile) }}" alt="Placeholder" class="w-full h-full object-contain">
                </div>
                <span class="text-[11px] text-[#94A3B8] font-medium">Belum ada foto</span>
            </div>
        @endif

        {{-- Status / Promo badges --}}
        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1.5">
            @php
                $badge = null;
                $labelPromosi = $produk->label_promosi ? strtoupper(trim($produk->label_promosi)) : '';
                $isLabelPromoPerformance = in_array($labelPromosi, ['BEST SELLER', 'TERLARIS', 'HITS', 'FAVORIT', 'BARU', 'PRE-ORDER', 'PRE ORDER']);

                if ($produk->stok === 'habis') {
                    $badge = ['text' => 'HABIS', 'bg' => 'bg-[#DC2626]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->stok === 'po') {
                    $badge = ['text' => 'PRE-ORDER', 'bg' => 'bg-[#F59E0B]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->views >= 500) {
                    $badge = ['text' => 'BEST SELLER', 'bg' => 'bg-[#DC2626]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->views >= 100) {
                    $badge = ['text' => 'HITS', 'bg' => 'bg-[#F59E0B]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->views >= 50) {
                    $badge = ['text' => 'FAVORIT', 'bg' => 'bg-[#2563EB]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->created_at && $produk->created_at->diffInDays(now()) <= 14) {
                    $badge = ['text' => 'BARU', 'bg' => 'bg-[#10B981]', 'textCol' => 'text-white', 'border' => 'border-transparent'];
                } elseif ($produk->label_promosi && !$isLabelPromoPerformance) {
                    $badge = ['text' => $produk->label_promosi, 'bg' => 'bg-[#EFF6FF]', 'textCol' => 'text-[#2563EB]', 'border' => 'border-[#BFDBFE]'];
                }
            @endphp

            @if($badge)
                <span class="inline-block {{ $badge['bg'] }} {{ $badge['textCol'] }} {{ $badge['border'] !== 'border-transparent' ? 'border ' . $badge['border'] : '' }} text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide shadow-sm">
                    {{ $badge['text'] }}
                </span>
            @endif
        </div>
    </div>

    {{-- ── Info Produk ───────────────────────────────────────── --}}
    <div class="p-4 flex flex-col flex-1">
        {{-- Nama --}}
        <h3 class="text-[15px] font-bold text-[#172033] leading-snug line-clamp-2 mb-2 flex-1 group-hover:text-[#2563EB] transition-colors duration-150">
            {{ $produk->nama }}
        </h3>

        <div class="mt-auto flex flex-col gap-2">
            {{-- Harga --}}
            <p class="text-base font-bold text-[#2563EB]">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>

            {{-- Rating --}}
            <div class="flex items-center gap-1.5">
                @if($produk->review_count > 0)
                    <svg class="w-4 h-4 text-[#F59E0B]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs font-semibold text-[#475569]">{{ number_format($produk->average_rating, 1) }}</span>
                    <span class="text-xs text-[#94A3B8]">({{ $produk->review_count }})</span>
                @else
                    <svg class="w-4 h-4 text-[#CBD5E1]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs text-[#94A3B8]">Belum ada rating</span>
                @endif
            </div>

            {{-- Toko --}}
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-[#94A3B8] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="text-xs text-[#64748B] truncate">
                    {{ $produk->penjual->nama_toko ?? '-' }}
                </span>
            </div>

            {{-- Views --}}
            <div class="flex items-center justify-between mt-1">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#94A3B8] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="text-xs text-[#64748B]">{{ number_format($produk->views, 0, ',', '.') }} dilihat</span>
                </div>
                
                <span class="text-xs font-bold text-[#2563EB] opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>
</a>
