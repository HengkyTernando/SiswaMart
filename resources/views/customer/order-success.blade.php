@extends('layouts.app')
@section('title', 'Pesanan Berhasil – SiswaMart')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Success Animation --}}
    <div class="text-center mb-8">
        <div class="relative inline-block mb-6">
            {{-- Outer ring pulse --}}
            <div class="absolute inset-0 rounded-full animate-ping"
                 style="background:rgba(139,92,246,.15);animation-duration:2s"></div>
            {{-- Icon --}}
            <div class="relative w-24 h-24 rounded-full flex items-center justify-center glow"
                 style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-black text-white mb-2">Pesanan Berhasil! 🎉</h1>
        <p style="color:var(--clr-muted)" class="text-sm">
            Terima kasih, <span class="font-semibold text-white">{{ auth()->user()->name }}</span>!<br>
            Pesananmu sedang kami proses.
        </p>
    </div>

    {{-- Order Card --}}
    <div class="rounded-2xl p-6 mb-5" style="background:var(--clr-card);border:1px solid var(--clr-border)">

        {{-- Order code & status --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-xs font-semibold mb-0.5" style="color:var(--clr-muted)">Kode Pesanan</p>
                <p class="text-lg font-black grad-text">{{ $order->order_code }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-xs font-bold"
                  style="background:rgba(251,191,36,.12);color:#fbbf24;border:1px solid rgba(251,191,36,.2)">
                ⏳ Pending
            </span>
        </div>

        <hr class="mb-5" style="border-color:var(--clr-border)">

        {{-- Items --}}
        <h3 class="text-sm font-bold text-white mb-3">Produk Dipesan</h3>
        <div class="space-y-3 mb-5">
            @foreach($order->items as $item)
            <div class="flex gap-3 items-center">
                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0"
                     style="background:var(--clr-surface)">
                    @if($item->product?->image)
                        @php
                            $src = str_starts_with($item->product->image, 'http')
                                ? $item->product->image
                                : asset('storage/'.$item->product->image);
                        @endphp
                        <img src="{{ $src }}" alt="{{ $item->product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="color:rgba(139,92,246,.35)">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white line-clamp-1">
                        {{ $item->product?->name ?? 'Produk tidak ditemukan' }}
                    </p>
                    <p class="text-xs mt-0.5" style="color:var(--clr-muted)">
                        {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-sm font-black grad-text flex-shrink-0">
                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>

        <hr class="mb-4" style="border-color:var(--clr-border)">

        {{-- Address & Total --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs font-semibold mb-1" style="color:var(--clr-muted)">Alamat Pengiriman</p>
                <p class="text-white leading-relaxed text-xs">{{ $order->shipping_address }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold mb-1" style="color:var(--clr-muted)">Total Pembayaran</p>
                <p class="text-2xl font-black grad-text">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p class="text-xs mt-0.5" style="color:var(--clr-muted)">Termasuk gratis ongkir</p>
            </div>
        </div>

        @if($order->notes)
        <div class="mt-4 pt-4 border-t" style="border-color:var(--clr-border)">
            <p class="text-xs font-semibold mb-1" style="color:var(--clr-muted)">Catatan</p>
            <p class="text-sm text-white">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Info Box --}}
    <div class="rounded-2xl p-4 mb-6 flex gap-3"
         style="background:rgba(139,92,246,.08);border:1px solid rgba(139,92,246,.2)">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:var(--clr-purple-l)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-sm" style="color:var(--clr-text)">
            <p class="font-semibold mb-1" style="color:var(--clr-purple-l)">Apa selanjutnya?</p>
            <p style="color:var(--clr-muted)">
                Seller akan segera memproses pesananmu. Kamu akan mendapatkan notifikasi saat pesanan dikirim.
                Pantau status pesanan di halaman <strong class="text-white">Pesanan Saya</strong>.
            </p>
        </div>
    </div>

    {{-- CTA Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('customer.orders') }}"
           class="btn-primary flex-1 py-3 rounded-xl font-bold flex items-center justify-center gap-2 glow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Lihat Pesanan Saya
        </a>
        <a href="{{ route('home') }}"
           class="flex-1 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition"
           style="border:1px solid var(--clr-border);color:var(--clr-muted)"
           onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
           onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
            🛍 Lanjut Belanja
        </a>
    </div>
</div>

@push('styles')
<style>
@keyframes ping {
    75%, 100% { transform: scale(2); opacity: 0; }
}
.animate-ping { animation: ping 2s cubic-bezier(0,0,.2,1) infinite; }
</style>
@endpush
@endsection
