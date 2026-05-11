@extends('layouts.app')
@section('title', 'Pesanan Saya – SiswaMart')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-7">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white">Pesanan Saya</h1>
            <p class="text-sm" style="color:var(--clr-muted)">Riwayat semua transaksi kamu di SiswaMart</p>
        </div>
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
            'pending'    => ['label'=>'Pending',    'bg'=>'rgba(251,191,36,.12)',  'color'=>'#fbbf24', 'border'=>'rgba(251,191,36,.25)',  'icon'=>'⏳'],
            'processing' => ['label'=>'Diproses',   'bg'=>'rgba(59,130,246,.12)', 'color'=>'#60a5fa', 'border'=>'rgba(59,130,246,.25)', 'icon'=>'⚙️'],
            'shipped'    => ['label'=>'Dikirim',    'bg'=>'rgba(139,92,246,.12)', 'color'=>'#a78bfa', 'border'=>'rgba(139,92,246,.25)', 'icon'=>'🚚'],
            'delivered'  => ['label'=>'Selesai',    'bg'=>'rgba(52,211,153,.12)', 'color'=>'#34d399', 'border'=>'rgba(52,211,153,.25)', 'icon'=>'✅'],
            'cancelled'  => ['label'=>'Dibatalkan', 'bg'=>'rgba(248,113,113,.08)','color'=>'#f87171', 'border'=>'rgba(248,113,113,.2)', 'icon'=>'❌'],
        ];
    @endphp

    @if($orders->isEmpty())
        {{-- Empty state --}}
        <div class="text-center py-24 rounded-3xl" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-black text-white mb-2">Belum Ada Pesanan</h3>
            <p class="text-sm mb-6" style="color:var(--clr-muted)">Yuk mulai belanja perlengkapan sekolah!</p>
            <a href="{{ route('home') }}" class="btn-primary px-6 py-2.5 rounded-xl inline-block font-semibold">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            @php
                $cfg = $statusConfig[$order->status] ?? $statusConfig['pending'];
                $unreadCount = $order->messages->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
            @endphp

            <div class="rounded-2xl overflow-hidden transition"
                 style="background:var(--clr-card);border:1px solid var(--clr-border)"
                 onmouseover="this.style.borderColor='var(--clr-purple-d)'"
                 onmouseout="this.style.borderColor='var(--clr-border)'">

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
                                    {{ $unreadCount }} pesan baru
                                </span>
                                @endif
                            </div>
                            <p class="text-xs" style="color:var(--clr-muted)">
                                {{ $order->created_at->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold"
                          style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};border:1px solid {{ $cfg['border'] }}">
                        {{ $cfg['label'] }}
                    </span>
                </div>

                {{-- Items preview --}}
                <div class="px-5 py-4">
                    <div class="flex gap-3 flex-wrap mb-4">
                        @foreach($order->items->take(3) as $item)
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0"
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
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-white line-clamp-1 max-w-32">
                                    {{ $item->product?->name ?? 'Produk dihapus' }}
                                </p>
                                <p class="text-xs" style="color:var(--clr-muted)">×{{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                        @if($order->items->count() > 3)
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg text-xs font-bold"
                                 style="background:var(--clr-surface);color:var(--clr-muted);border:1px solid var(--clr-border)">
                                +{{ $order->items->count() - 3 }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="text-xs" style="color:var(--clr-muted)">
                            {{ $order->items->count() }} produk
                        </div>
                        <div class="flex items-center gap-2 flex-wrap justify-end">
                            <div class="text-right mr-1">
                                <p class="text-xs" style="color:var(--clr-muted)">Total Bayar</p>
                                <p class="font-black grad-text">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            {{-- Detail button --}}
                            <button onclick="toggleDetail('order-{{ $order->id }}')"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-xl transition"
                                    style="border:1px solid var(--clr-border);color:var(--clr-muted)"
                                    onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                                    onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                Detail
                            </button>

                            {{-- Chat Seller --}}
                            <a href="{{ route('customer.chat.show', $order) }}"
                               class="relative flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-xl transition"
                               style="border:1px solid var(--clr-border);color:var(--clr-muted)"
                               onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                               onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 3H3v13h5l4 4 4-4h5V3z"/>
                                </svg>
                                Chat Seller
                                @if($unreadCount > 0)
                                <span class="absolute -top-1.5 -right-1.5 w-4 h-4 rounded-full text-white flex items-center justify-center"
                                      style="background:#ef4444;font-size:9px;font-weight:900">{{ $unreadCount }}</span>
                                @endif
                            </a>

                            {{-- Selesaikan Pesanan (hanya jika shipped) --}}
                            @if($order->status === 'shipped')
                            <form action="{{ route('customer.orders.complete', $order) }}" method="POST"
                                  onsubmit="return confirm('Konfirmasi bahwa pesananmu sudah diterima?')">
                                @csrf
                                <button type="submit"
                                        class="btn-primary flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-xl glow">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Selesaikan Pesanan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Expandable detail --}}
                <div id="order-{{ $order->id }}" class="hidden px-5 pb-5"
                     style="border-top:1px solid var(--clr-border)">
                    <div class="pt-4 space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white">{{ $item->product?->name ?? 'Produk dihapus' }}</span>
                            <div class="text-right">
                                <span style="color:var(--clr-muted)">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                <span class="ml-3 font-bold text-white">= Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                        <div class="pt-3 border-t text-sm" style="border-color:var(--clr-border)">
                            <p class="mb-1" style="color:var(--clr-muted)">
                                <span class="font-semibold text-white">Alamat:</span>
                                {{ $order->shipping_address }}
                            </p>
                            @if($order->notes)
                            <p style="color:var(--clr-muted)">
                                <span class="font-semibold text-white">Catatan:</span>
                                {{ $order->notes }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleDetail(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
}
</script>
@endpush
@endsection
