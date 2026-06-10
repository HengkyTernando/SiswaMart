@extends('layouts.app')
@section('title', 'Dashboard Seller – SiswaMart')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
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
        @php
        $stats = [
            ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>', 'value'=>$productCount, 'label'=>'Produk', 'color'=>'#a78bfa'],
            ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>', 'value'=>$orderCount, 'label'=>'Total Pesanan', 'color'=>'#60a5fa'],
            ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', 'value'=>$pendingCount, 'label'=>'Pesanan Baru', 'color'=>'#fbbf24'],
            ['svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>', 'value'=>$unreadCount, 'label'=>'Pesan Baru', 'color'=>'#34d399'],
        ];
        @endphp
        @foreach($stats as $stat)
        <div class="rounded-2xl p-4" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-2" style="color:{{ $stat['color'] }}">{!! $stat['svg'] !!}</div>
            <div class="text-2xl font-black" style="color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-xs mt-0.5" style="color:var(--clr-muted)">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="rounded-2xl p-5" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3" style="color:var(--clr-purple-l)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="32" height="32"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
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
            <div class="mb-3" style="color:var(--clr-purple-l)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="32" height="32"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </div>
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
