{{--
    Product Card — Public Catalog
    Storefront-style: foto dominan, typography bold, organic playful vibe.
--}}
@props(['produk'])

<a href="{{ route('public.produk.show', $produk->slug) }}"
   id="produk-card-{{ $produk->id }}"
   class="product-card group flex flex-col focus:outline-none"
   aria-label="Lihat detail {{ $produk->nama }}">

    {{-- ── Foto Produk ──────────────────────────────────────── --}}
    <div class="relative w-full aspect-square overflow-hidden bg-white border-b-2 border-[var(--color-border)]">
        @if($produk->foto_utama)
            <img src="{{ asset('storage/' . $produk->foto_utama) }}"
                 alt="{{ $produk->nama }}"
                 class="w-full h-full object-cover group-hover:scale-[1.05] transition-transform duration-500 ease-out"
                 loading="lazy">
        @else
            <div class="img-placeholder w-full h-full gap-3 bg-[var(--color-bg)]">
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
                <div class="w-16 h-16 opacity-40 grayscale">
                    <img src="{{ asset('images/icons/' . $iconFile) }}" alt="Placeholder" class="w-full h-full object-contain">
                </div>
            </div>
        @endif

        {{-- Status / Promo badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @php
                $badge = null;
                $labelPromosi = $produk->label_promosi ? strtoupper(trim($produk->label_promosi)) : '';
                $isLabelPromoPerformance = in_array($labelPromosi, ['BEST SELLER', 'TERLARIS', 'HITS', 'FAVORIT', 'BARU', 'PRE-ORDER', 'PRE ORDER']);

                if ($produk->stok === 'habis') {
                    $badge = ['text' => 'HABIS', 'bg' => 'bg-[var(--color-danger)]', 'textCol' => 'text-white'];
                } elseif ($produk->stok === 'po') {
                    $badge = ['text' => 'PRE-ORDER', 'bg' => 'bg-[var(--color-warning)]', 'textCol' => 'text-[var(--color-text)]'];
                } elseif ($produk->views >= 500) {
                    $badge = ['text' => 'BEST SELLER', 'bg' => 'bg-[var(--color-danger)]', 'textCol' => 'text-white'];
                } elseif ($produk->views >= 100) {
                    $badge = ['text' => 'HITS', 'bg' => 'bg-[var(--color-warning)]', 'textCol' => 'text-[var(--color-text)]'];
                } elseif ($produk->views >= 50) {
                    $badge = ['text' => 'FAVORIT', 'bg' => 'bg-[var(--color-primary)]', 'textCol' => 'text-white'];
                } elseif ($produk->created_at && $produk->created_at->diffInDays(now()) <= 14) {
                    $badge = ['text' => 'BARU', 'bg' => 'bg-[var(--color-success)]', 'textCol' => 'text-white'];
                } elseif ($produk->label_promosi && !$isLabelPromoPerformance) {
                    $badge = ['text' => $produk->label_promosi, 'bg' => 'bg-white', 'textCol' => 'text-[var(--color-text)]'];
                }
            @endphp

            @if($badge)
                <span class="inline-block {{ $badge['bg'] }} {{ $badge['textCol'] }} border-2 border-[var(--color-border)] text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider shadow-solid-sm transform -rotate-2">
                    {{ $badge['text'] }}
                </span>
            @endif
        </div>
    </div>

    {{-- ── Info Produk ───────────────────────────────────────── --}}
    <div class="p-5 flex flex-col flex-1 bg-[var(--color-surface)] relative">
        {{-- Harga --}}
        <p class="text-xl font-extrabold text-[var(--color-primary)] mb-1">
            Rp {{ number_format($produk->harga, 0, ',', '.') }}
        </p>

        {{-- Nama --}}
        <h3 class="text-lg font-bold text-[var(--color-text)] leading-snug line-clamp-2 mb-3 flex-1 group-hover:text-[var(--color-primary)] transition-colors duration-150">
            {{ $produk->nama }}
        </h3>

        <div class="mt-auto flex flex-col gap-3 pt-3 border-t-2 border-[var(--color-border)] border-dashed">
            {{-- Toko & Kategori --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5 overflow-hidden">
                    <svg class="w-4 h-4 text-[var(--color-primary)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-xs font-bold text-[var(--color-text)] truncate uppercase">
                        {{ $produk->penjual->nama_toko ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- Rating & Views --}}
            <div class="flex items-center justify-between mt-0.5">
                <div class="flex items-center gap-1.5">
                    @if($produk->review_count > 0)
                        <svg class="w-4 h-4 text-[var(--color-warning)] drop-shadow-[1px_1px_0_rgba(36,26,20,1)]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-xs font-bold text-[var(--color-text)]">{{ number_format($produk->average_rating, 1) }}</span>
                    @else
                        <svg class="w-4 h-4 text-[var(--color-text-muted)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="text-[10px] font-bold text-[var(--color-text-muted)] uppercase">No Rating</span>
                    @endif
                </div>

                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-[var(--color-text-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="text-[10px] font-bold text-[var(--color-text-muted)] uppercase">{{ number_format($produk->views, 0, ',', '.') }} Views</span>
                </div>
            </div>
            
            {{-- Circular hover action button --}}
            <div class="absolute -bottom-4 right-4 bg-[var(--color-primary)] text-white w-10 h-10 rounded-full flex items-center justify-center border-2 border-[var(--color-border)] shadow-solid-sm opacity-0 group-hover:opacity-100 group-hover:bottom-4 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </div>
        </div>
    </div>
</a>
