@extends('layouts.app')
@section('title', 'Pesanan Masuk – SiswaMart Seller')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-7">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white">Pesanan Masuk</h1>
                <p class="text-sm" style="color:var(--clr-muted)">Kelola pesanan dari pembeli</p>
            </div>
        </div>
        <a href="{{ route('seller.products.index') }}"
           class="text-sm font-semibold px-4 py-2 rounded-xl transition"
           style="border:1px solid var(--clr-border);color:var(--clr-muted)"
           onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
           onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" style="display:inline-block;vertical-align:-2px;margin-right:4px"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            Produk Saya
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('order_success'))
        <div class="mb-5 p-4 rounded-2xl text-sm font-semibold flex items-center gap-2"
             style="background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.2);color:#34d399">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('order_success') }}
        </div>
    @endif
    @if(session('order_error'))
        <div class="mb-5 p-4 rounded-2xl text-sm font-semibold"
             style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);color:#f87171">
            {{ session('order_error') }}
        </div>
    @endif

    @php
        $statusConfig = [
            'pending'    => ['label'=>'Pending',   'color'=>'#fbbf24','bg'=>'rgba(251,191,36,.12)','border'=>'rgba(251,191,36,.25)', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'],
            'processing' => ['label'=>'Diproses',  'color'=>'#60a5fa','bg'=>'rgba(59,130,246,.12)','border'=>'rgba(59,130,246,.25)', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>'],
            'shipped'    => ['label'=>'Dikirim',   'color'=>'#a78bfa','bg'=>'rgba(139,92,246,.12)','border'=>'rgba(139,92,246,.25)', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>'],
            'delivered'  => ['label'=>'Selesai',   'color'=>'#34d399','bg'=>'rgba(52,211,153,.12)','border'=>'rgba(52,211,153,.25)', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'],
            'cancelled'  => ['label'=>'Dibatalkan','color'=>'#f87171','bg'=>'rgba(248,113,113,.08)','border'=>'rgba(248,113,113,.2)', 'icon'=>'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>'],
        ];
        $nextStatus = [
            'pending'    => 'processing',
            'processing' => 'shipped',
        ];
        $nextLabel = [
            'pending'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg> Proses Pesanan',
            'processing' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg> Tandai Dikirim',
        ];
    @endphp

    @if($orders->isEmpty())
        <div class="text-center py-24 rounded-3xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div style="display:flex;justify-content:center;margin-bottom:16px">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="64" height="64" style="color:#4c4878"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <h3 class="text-xl font-black text-white mb-2">Belum Ada Pesanan</h3>
            <p class="text-sm mb-6" style="color:var(--clr-muted)">Pesanan dari pembeli akan muncul di sini</p>
            <a href="{{ route('seller.products.index') }}" class="btn-primary px-6 py-2.5 rounded-xl inline-block font-semibold">
                Kelola Produk
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            @php
                $cfg = $statusConfig[$order->status] ?? $statusConfig['pending'];
                // Filter item milik seller ini
                $myItems = $order->items->whereIn('product_id', $sellerProductIds);
                $unreadCount = $order->messages->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
            @endphp

            <div class="rounded-2xl overflow-hidden"
                 style="background:var(--clr-card);border:1px solid var(--clr-border)">

                {{-- Order header --}}
                <div class="flex items-center justify-between px-5 py-4"
                     style="border-bottom:1px solid var(--clr-border)">
                    <div class="flex items-center gap-3">
                        <div class="text-xl" style="color:{{ $cfg['color'] }}">{!! $cfg['icon'] !!}</div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="font-black grad-text text-sm">{{ $order->order_code }}</p>
                                @if($unreadCount > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-xs font-black text-white"
                                      style="background:linear-gradient(135deg,#7c3aed,#c084fc);font-size:10px">
                                    {{ $unreadCount }} baru
                                </span>
                                @endif
                            </div>
                            <p class="text-xs" style="color:var(--clr-muted)">
                                {{ $order->created_at->format('d M Y, H:i') }} ·
                                Pembeli: <span class="text-white font-semibold">{{ $order->user->name }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Status badge --}}
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold"
                              style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};border:1px solid {{ $cfg['border'] }}">
                            {{ $cfg['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="px-5 py-4">
                    <div class="flex flex-wrap gap-3 mb-4">
                        @foreach($myItems as $item)
                        <div class="flex items-center gap-2 rounded-xl px-3 py-2"
                             style="background:var(--clr-surface);border:1px solid var(--clr-border)">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0"
                                 style="background:var(--clr-card)">
                                @if($item->product?->image)
                                    @php $src = str_starts_with($item->product->image,'http') ? $item->product->image : asset('storage/'.$item->product->image); @endphp
                                    <img src="{{ $src }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="color:rgba(139,92,246,.35)">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-white max-w-40 truncate">{{ $item->product?->name }}</p>
                                <p class="text-xs" style="color:var(--clr-muted)">
                                    ×{{ $item->quantity }} · Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Address --}}
                    <div class="text-xs mb-4 flex items-start gap-1.5" style="color:var(--clr-muted)">
                        <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $order->shipping_address }}</span>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="font-black grad-text text-lg">
                            Rp {{ number_format($myItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- Chat button --}}
                            <a href="{{ route('seller.chat.show', $order) }}"
                               class="relative flex items-center gap-1.5 text-xs font-semibold px-3 py-2 rounded-xl transition"
                               style="border:1px solid var(--clr-border);color:var(--clr-muted)"
                               onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                               onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 3H3v13h5l4 4 4-4h5V3z"/>
                                </svg>
                                Chat
                                @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full text-white flex items-center justify-center"
                                      style="background:#ef4444;font-size:9px;font-weight:900">{{ $unreadCount }}</span>
                                @endif
                            </a>

                            {{-- Update status --}}
                            @if(isset($nextStatus[$order->status]))
                            <form action="{{ route('seller.orders.status', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $nextStatus[$order->status] }}">
                                <button type="submit"
                                        class="btn-primary text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5">
                                    {!! $nextLabel[$order->status] !!}
                                </button>
                            </form>
                            @endif

                            {{-- Cancel --}}
                            @if(in_array($order->status, ['pending','processing']))
                            <form action="{{ route('seller.orders.status', $order) }}" method="POST"
                                  onsubmit="return confirm('Yakin batalkan pesanan ini?')">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-2 rounded-xl transition"
                                        style="border:1px solid rgba(248,113,113,.3);color:#f87171"
                                        onmouseover="this.style.background='rgba(248,113,113,.1)'"
                                        onmouseout="this.style.background='transparent'">
                                    Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    @endif
</div>
@endsection
