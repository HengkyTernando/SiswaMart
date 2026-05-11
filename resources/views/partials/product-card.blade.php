<div class="group rounded-2xl overflow-hidden flex flex-col transition-all duration-300"
     style="background:var(--clr-card);border:1px solid var(--clr-border)"
     onmouseover="this.style.borderColor='rgba(124,58,237,.6)';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(124,58,237,.2)'"
     onmouseout="this.style.borderColor='var(--clr-border)';this.style.transform='';this.style.boxShadow=''">

    {{-- Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden"
       style="background:var(--clr-surface);aspect-ratio:1">
        @if($product->image)
            @php $src = str_starts_with($product->image,'http') ? $product->image : asset('storage/'.$product->image); @endphp
            <img src="{{ $src }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-full flex items-center justify-center"
                 style="background:linear-gradient(135deg,#12082a,#1a0a2e)">
                <x-category-icon :icon="$product->category?->icon ?? 'category'" class="w-12 h-12"
                                 style="color:rgba(139,92,246,.35)" />
            </div>
        @endif

        {{-- Category badge --}}
        <div class="absolute top-2 right-2 text-xs font-semibold px-2 py-0.5 rounded-lg"
             style="background:rgba(13,13,20,.75);color:var(--clr-purple-l);backdrop-filter:blur(8px);border:1px solid rgba(139,92,246,.25)">
            {{ Str::words($product->category?->name, 1, '') }}
        </div>

        @if($product->stock == 0)
            <div class="absolute inset-0 flex items-center justify-center" style="background:rgba(0,0,0,.6)">
                <span class="text-xs font-bold px-3 py-1 rounded-lg" style="background:var(--clr-card);color:#f87171">Habis</span>
            </div>
        @elseif($product->stock <= 5)
            <div class="absolute top-2 left-2 text-white text-xs font-bold px-2 py-0.5 rounded-lg" style="background:#d97706">
                Sisa {{ $product->stock }}
            </div>
        @endif
    </a>

    {{-- Info --}}
    <div class="p-3 flex flex-col flex-1">
        <a href="{{ route('products.show', $product->slug) }}"
           class="text-xs font-semibold leading-snug line-clamp-2 mb-2 transition"
           style="color:var(--clr-text)"
           onmouseover="this.style.color='var(--clr-purple-l)'"
           onmouseout="this.style.color='var(--clr-text)'">
            {{ $product->name }}
        </a>
        <div class="flex items-center justify-between gap-1 mt-auto">
            <div>
                <div class="text-sm font-black grad-text">{{ $product->formatted_price }}</div>
                <div class="text-xs" style="color:var(--clr-muted)">Stok {{ $product->stock }}</div>
            </div>
            @if($product->stock > 0)
                <form action="{{ route('customer.cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit"
                            class="w-8 h-8 flex items-center justify-center text-white rounded-xl transition active:scale-95"
                            style="background:linear-gradient(135deg,#7c3aed,#9333ea)"
                            onmouseover="this.style.boxShadow='0 0 16px rgba(124,58,237,.5)'"
                            onmouseout="this.style.boxShadow='none'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
