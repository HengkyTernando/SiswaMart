@extends('layouts.app')
@section('title', 'Dashboard Seller – SiswaMart')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
            <span class="text-white text-lg">🏪</span>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white">Dashboard Seller</h1>
            <p class="text-sm" style="color:var(--clr-muted)">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    @php
        $productCount = auth()->user()->products()->count();
        $sellerProductIds = auth()->user()->products()->pluck('id');
        $orderIds = \App\Models\OrderItem::whereIn('product_id', $sellerProductIds)->pluck('order_id')->unique();
        $orderCount = \App\Models\Order::whereIn('id', $orderIds)->count();
        $pendingCount = \App\Models\Order::whereIn('id', $orderIds)->where('status', 'pending')->count();
        $unreadCount = \App\Models\Message::whereIn('order_id', $orderIds)->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
    @endphp

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['icon'=>'📦','value'=>$productCount,'label'=>'Produk','color'=>'#a78bfa'],
            ['icon'=>'🛒','value'=>$orderCount,'label'=>'Total Pesanan','color'=>'#60a5fa'],
            ['icon'=>'⏳','value'=>$pendingCount,'label'=>'Pesanan Baru','color'=>'#fbbf24'],
            ['icon'=>'💬','value'=>$unreadCount,'label'=>'Pesan Baru','color'=>'#34d399'],
        ] as $stat)
        <div class="rounded-2xl p-4" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="text-2xl mb-2">{{ $stat['icon'] }}</div>
            <div class="text-2xl font-black" style="color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-xs mt-0.5" style="color:var(--clr-muted)">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl p-5" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="text-3xl mb-3">📦</div>
            <h3 class="font-bold text-white mb-1">Produk Saya</h3>
            <p class="text-sm mb-4" style="color:var(--clr-muted)">Tambah, edit, dan kelola produk kamu</p>
            <div class="flex gap-2">
                <a href="{{ route('seller.products.index') }}"
                   class="flex-1 text-center text-sm font-semibold px-3 py-2 rounded-xl transition"
                   style="border:1px solid var(--clr-border);color:var(--clr-muted)"
                   onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                   onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                    Lihat Produk
                </a>
                <a href="{{ route('seller.products.create') }}"
                   class="btn-primary flex-1 text-center text-sm font-bold px-3 py-2 rounded-xl">
                    + Tambah
                </a>
            </div>
        </div>

        <div class="rounded-2xl p-5 relative overflow-hidden" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            @if($pendingCount > 0 || $unreadCount > 0)
            <div class="absolute top-3 right-3 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-black"
                 style="background:linear-gradient(135deg,#7c3aed,#c084fc)">
                {{ $pendingCount + $unreadCount }}
            </div>
            @endif
            <div class="text-3xl mb-3">🛒</div>
            <h3 class="font-bold text-white mb-1">Pesanan Masuk</h3>
            <p class="text-sm mb-4" style="color:var(--clr-muted)">
                @if($pendingCount > 0)
                    <span class="font-semibold" style="color:#fbbf24">{{ $pendingCount }} pesanan baru</span> menunggu diproses
                @else
                    Kelola dan update status pesanan dari pembeli
                @endif
            </p>
            <a href="{{ route('seller.orders') }}"
               class="btn-primary w-full text-center text-sm font-bold px-3 py-2 rounded-xl block glow">
                Lihat Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
