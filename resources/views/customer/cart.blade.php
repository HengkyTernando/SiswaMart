@extends('layouts.app')
@section('title', 'Keranjang Belanja – SiswaMart')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-7">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white">Keranjang Belanja</h1>
            <p class="text-sm" style="color:var(--clr-muted)">{{ count($cart) }} item di keranjang</p>
        </div>
    </div>

    @if(empty($cart))
        {{-- Empty state --}}
        <div class="text-center py-24 rounded-3xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-black text-white mb-2">Keranjang Kosong</h3>
            <p class="text-sm mb-6" style="color:var(--clr-muted)">Belum ada produk di keranjang kamu</p>
            <a href="{{ route('home') }}" class="btn-primary px-6 py-2.5 rounded-xl inline-block font-semibold">
                Mulai Belanja
            </a>
        </div>

    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- ── Cart Items (2/3) ── --}}
            <div class="lg:col-span-2 space-y-3">

                {{-- Clear all --}}
                <div class="flex justify-end">
                    <form action="{{ route('customer.cart.clear') }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                style="color:#f87171;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2)"
                                onmouseover="this.style.background='rgba(248,113,113,.15)'"
                                onmouseout="this.style.background='rgba(248,113,113,.08)'">
                            🗑 Kosongkan Keranjang
                        </button>
                    </form>
                </div>

                @foreach($cart as $key => $item)
                <div class="flex gap-4 p-4 rounded-2xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">

                    {{-- Image --}}
                    <a href="{{ route('products.show', $item['slug']) }}"
                       class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0"
                       style="background:var(--clr-surface)">
                        @if($item['image'])
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center"
                                 style="color:rgba(139,92,246,.35)">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                            </div>
                        @endif
                    </a>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('products.show', $item['slug']) }}"
                           class="text-sm font-semibold text-white line-clamp-2 hover:text-purple-400 transition">
                            {{ $item['name'] }}
                        </a>
                        @if($item['category'])
                            <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block"
                                  style="background:rgba(139,92,246,.15);color:var(--clr-purple-l)">
                                {{ $item['category'] }}
                            </span>
                        @endif
                        <div class="text-sm font-black grad-text mt-1">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- Qty + Remove --}}
                    <div class="flex flex-col items-end justify-between gap-3 flex-shrink-0">
                        {{-- Remove --}}
                        <form action="{{ route('customer.cart.remove') }}" method="POST">
                            @csrf @method('DELETE')
                            <input type="hidden" name="product_id" value="{{ $key }}">
                            <button type="submit" class="p-1.5 rounded-lg transition"
                                    style="color:var(--clr-muted)"
                                    onmouseover="this.style.color='#f87171';this.style.background='rgba(248,113,113,.1)'"
                                    onmouseout="this.style.color='var(--clr-muted)';this.style.background='transparent'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>

                        {{-- Qty stepper --}}
                        <form action="{{ route('customer.cart.update') }}" method="POST" class="flex items-center gap-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="product_id" value="{{ $key }}">
                            <button type="submit" name="qty" value="{{ max(1, $item['qty']-1) }}"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center font-bold transition"
                                    style="background:var(--clr-surface);color:var(--clr-muted);border:1px solid var(--clr-border)">−</button>
                            <span class="w-8 text-center text-sm font-black text-white">{{ $item['qty'] }}</span>
                            <button type="submit" name="qty" value="{{ min($item['stock'], $item['qty']+1) }}"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center font-bold transition"
                                    style="background:var(--clr-surface);color:var(--clr-muted);border:1px solid var(--clr-border)">+</button>
                        </form>

                        {{-- Subtotal --}}
                        <div class="text-xs font-semibold" style="color:var(--clr-muted)">
                            = Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── Summary (1/3) ── --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl p-5 sticky top-20" style="background:var(--clr-card);border:1px solid var(--clr-border)">
                    <h3 class="font-black text-white mb-4">Ringkasan Pesanan</h3>

                    <div class="space-y-2.5 mb-4 text-sm">
                        <div class="flex justify-between">
                            <span style="color:var(--clr-muted)">Subtotal ({{ count($cart) }} item)</span>
                            <span class="font-semibold text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--clr-muted)">Ongkos Kirim</span>
                            <span class="font-semibold text-emerald-400">Gratis</span>
                        </div>
                    </div>

                    <div class="border-t pt-3 mb-5" style="border-color:var(--clr-border)">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white">Total</span>
                            <span class="text-xl font-black grad-text">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('customer.checkout') }}"
                            class="btn-primary w-full py-3 rounded-xl font-bold glow flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        Lanjut Checkout
                    </a>

                    <a href="{{ route('home') }}"
                       class="mt-3 w-full text-center text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 transition"
                       style="color:var(--clr-muted);border:1px solid var(--clr-border)"
                       onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                       onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                        ← Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
