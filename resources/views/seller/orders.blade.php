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
            📦 Produk Saya
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
            'pending'    => ['label'=>'Pending',   'color'=>'#fbbf24','bg'=>'rgba(251,191,36,.12)','border'=>'rgba(251,191,36,.25)', 'icon'=>'⏳'],
            'processing' => ['label'=>'Diproses',  'color'=>'#60a5fa','bg'=>'rgba(59,130,246,.12)','border'=>'rgba(59,130,246,.25)', 'icon'=>'⚙️'],
            'shipped'    => ['label'=>'Dikirim',   'color'=>'#a78bfa','bg'=>'rgba(139,92,246,.12)','border'=>'rgba(139,92,246,.25)', 'icon'=>'🚚'],
            'delivered'  => ['label'=>'Selesai',   'color'=>'#34d399','bg'=>'rgba(52,211,153,.12)','border'=>'rgba(52,211,153,.25)', 'icon'=>'✅'],
            'cancelled'  => ['label'=>'Dibatalkan','color'=>'#f87171','bg'=>'rgba(248,113,113,.08)','border'=>'rgba(248,113,113,.2)', 'icon'=>'❌'],
        ];
        $nextStatus = [
            'pending'    => 'processing',
            'processing' => 'shipped',
        ];
        $nextLabel = [
            'pending'    => '⚙️ Proses Pesanan',
            'processing' => '🚚 Tandai Dikirim',
        ];
    @endphp

    @if($orders->isEmpty())
        <div class="text-center py-24 rounded-3xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="text-6xl mb-4">📭</div>
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
                        <div class="text-xl">{{ $cfg['icon'] }}</div>
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
                                    {{ $nextLabel[$order->status] }}
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
