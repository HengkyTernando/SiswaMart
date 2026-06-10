@extends('layouts.app')
@section('title', 'Chat – ' . $order->order_code . ' – SiswaMart')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6" style="height:calc(100vh - 64px);display:flex;flex-direction:column">

    {{-- ── Header ── --}}
    <div class="flex items-center gap-3 mb-4 flex-shrink-0">
        <a href="{{ auth()->user()->isSeller() ? route('seller.orders') : route('customer.orders') }}"
           class="w-9 h-9 rounded-xl flex items-center justify-center transition"
           style="background:var(--clr-card);border:1px solid var(--clr-border);color:var(--clr-muted)"
           onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
           onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Avatar partner --}}
        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-black flex-shrink-0"
             style="background:linear-gradient(135deg,#7c3aed,#c084fc)">
            {{ strtoupper(substr($partner?->name ?? '?', 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">
            <div class="font-bold text-white text-sm">
                {{ $partner?->name ?? (auth()->user()->isCustomer() ? 'Seller' : 'Pembeli') }}
                <span class="text-xs font-normal ml-1 px-2 py-0.5 rounded-full"
                      style="background:rgba(139,92,246,.15);color:var(--clr-purple-l)">
                    {{ auth()->user()->isCustomer() ? 'Seller' : 'Pembeli' }}
                </span>
            </div>
            <div class="text-xs" style="color:var(--clr-muted)">
                Pesanan {{ $order->order_code }}
                · {{ $order->items->count() }} produk
                · Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </div>
        </div>

        {{-- Status badge --}}
        @php
            $statusConfig = [
                'pending'    => ['label'=>'Pending',   'color'=>'#fbbf24','bg'=>'rgba(251,191,36,.12)'],
                'processing' => ['label'=>'Diproses',  'color'=>'#60a5fa','bg'=>'rgba(59,130,246,.12)'],
                'shipped'    => ['label'=>'Dikirim',   'color'=>'#a78bfa','bg'=>'rgba(139,92,246,.12)'],
                'delivered'  => ['label'=>'Selesai',   'color'=>'#34d399','bg'=>'rgba(52,211,153,.12)'],
                'cancelled'  => ['label'=>'Batal',     'color'=>'#f87171','bg'=>'rgba(248,113,113,.08)'],
            ];
            $scfg = $statusConfig[$order->status] ?? $statusConfig['pending'];
        @endphp
        <span class="text-xs font-bold px-2.5 py-1.5 rounded-full flex-shrink-0"
              style="background:{{ $scfg['bg'] }};color:{{ $scfg['color'] }}">
            {{ $scfg['label'] }}
        </span>
    </div>

    {{-- ── Product preview strip ── --}}
    <div class="flex gap-2 mb-4 overflow-x-auto pb-1 flex-shrink-0">
        @foreach($order->items->take(4) as $item)
        <div class="flex items-center gap-2 rounded-xl px-3 py-2 flex-shrink-0"
             style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="w-8 h-8 rounded-lg overflow-hidden" style="background:var(--clr-surface)">
                @if($item->product?->image)
                    @php $src = str_starts_with($item->product->image,'http') ? $item->product->image : asset('storage/'.$item->product->image); @endphp
                    <img src="{{ $src }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="color:rgba(139,92,246,.4)">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                    </div>
                @endif
            </div>
            <div>
                <div class="text-xs font-semibold text-white max-w-28 truncate">{{ $item->product?->name ?? 'Produk' }}</div>
                <div class="text-xs" style="color:var(--clr-muted)">×{{ $item->quantity }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Chat window ── --}}
    <div id="chat-box"
         class="flex-1 overflow-y-auto rounded-2xl p-4 space-y-3 mb-4"
         style="background:var(--clr-card);border:1px solid var(--clr-border);min-height:0">

        {{-- Pesan lama --}}
        @foreach($order->messages as $msg)
            @php $isMe = $msg->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} message-item" data-id="{{ $msg->id }}">
                @if(!$isMe)
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black flex-shrink-0 mr-2 self-end"
                     style="background:linear-gradient(135deg,#6d28d9,#9333ea)">
                    {{ strtoupper(substr($msg->sender->name, 0, 1)) }}
                </div>
                @endif
                <div class="max-w-xs lg:max-w-md">
                    @if(!$isMe)
                    <div class="text-xs mb-1 ml-1" style="color:var(--clr-muted)">{{ $msg->sender->name }}</div>
                    @endif
                    <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed"
                         style="{{ $isMe
                            ? 'background:linear-gradient(135deg,#7c3aed,#9333ea);color:#fff;border-radius:18px 4px 18px 18px'
                            : 'background:var(--clr-surface);color:var(--clr-text);border:1px solid var(--clr-border);border-radius:4px 18px 18px 18px' }}">
                        {{ $msg->body }}
                    </div>
                    <div class="text-xs mt-1 {{ $isMe ? 'text-right' : 'text-left' }}" style="color:var(--clr-muted)">
                        {{ $msg->created_at->format('H:i') }}
                        @if($isMe && $msg->is_read) · Dibaca @endif
                    </div>
                </div>
                @if($isMe)
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black flex-shrink-0 ml-2 self-end"
                     style="background:linear-gradient(135deg,#7c3aed,#c084fc)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                @endif
            </div>
        @endforeach

        {{-- Empty state --}}
        @if($order->messages->isEmpty())
        <div id="empty-chat" class="flex flex-col items-center justify-center h-full py-16 text-center">
            <div style="display:flex;justify-content:center;margin-bottom:12px">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="52" height="52" style="color:#4c4878"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <p class="text-sm font-semibold text-white mb-1">Belum ada pesan</p>
            <p class="text-xs" style="color:var(--clr-muted)">Mulai percakapan tentang pesanan ini</p>
        </div>
        @endif
    </div>

    {{-- ── Input area ── --}}
    <div class="flex-shrink-0">
        <div class="flex gap-3 items-end">
            <div class="flex-1 relative">
                <textarea id="msg-input"
                          placeholder="Ketik pesan..."
                          rows="1"
                          class="input-dark w-full px-4 py-3 rounded-2xl text-sm resize-none transition pr-12"
                          style="max-height:120px;overflow-y:auto"
                          onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMessage();}"></textarea>
            </div>
            <button id="send-btn" onclick="sendMessage()"
                    class="btn-primary w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 glow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </div>
        <p class="text-xs mt-2 text-center" style="color:var(--clr-muted)">
            Enter untuk kirim · Shift+Enter untuk baris baru
        </p>
    </div>
</div>

@push('scripts')
<script>
const chatBox    = document.getElementById('chat-box');
const msgInput   = document.getElementById('msg-input');
const sendBtn    = document.getElementById('send-btn');
const myId       = {{ auth()->id() }};
const myInitial  = '{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}';
const partnerInitial = '{{ strtoupper(substr($partner?->name ?? "?", 0, 1)) }}';
const storeUrl   = '{{ auth()->user()->isSeller() ? route("seller.chat.store", $order) : route("customer.chat.store", $order) }}';
const fetchUrl   = '{{ auth()->user()->isSeller() ? route("seller.chat.fetch", $order) : route("customer.chat.fetch", $order) }}';
const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

let lastId = {{ $order->messages->max('id') ?? 0 }};

/** Scroll ke bawah */
function scrollBottom(smooth = true) {
    chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: smooth ? 'smooth' : 'instant' });
}

/** Buat HTML bubble */
function buildBubble(msg) {
    const isMe = msg.sender_id === myId || msg.is_me;
    const initial = isMe ? myInitial : partnerInitial;

    const avatarLeft = isMe ? '' : `
        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black flex-shrink-0 mr-2 self-end"
             style="background:linear-gradient(135deg,#6d28d9,#9333ea)">${initial}</div>`;
    const avatarRight = isMe ? `
        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black flex-shrink-0 ml-2 self-end"
             style="background:linear-gradient(135deg,#7c3aed,#c084fc)">${initial}</div>` : '';

    const bubbleStyle = isMe
        ? 'background:linear-gradient(135deg,#7c3aed,#9333ea);color:#fff;border-radius:18px 4px 18px 18px'
        : 'background:var(--clr-surface);color:var(--clr-text);border:1px solid var(--clr-border);border-radius:4px 18px 18px 18px';

    const senderLabel = !isMe ? `<div class="text-xs mb-1 ml-1" style="color:var(--clr-muted)">${msg.sender}</div>` : '';

    return `
    <div class="flex ${isMe ? 'justify-end' : 'justify-start'} message-item" data-id="${msg.id}">
        ${avatarLeft}
        <div class="max-w-xs lg:max-w-md">
            ${senderLabel}
            <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed" style="${bubbleStyle}">${escapeHtml(msg.body)}</div>
            <div class="text-xs mt-1 ${isMe ? 'text-right' : 'text-left'}" style="color:var(--clr-muted)">${msg.created_at}</div>
        </div>
        ${avatarRight}
    </div>`;
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
              .replace(/"/g,'&quot;').replace(/'/g,'&#039;').replace(/\n/g,'<br>');
}

/** Kirim pesan */
async function sendMessage() {
    const body = msgInput.value.trim();
    if (!body) return;

    sendBtn.disabled = true;
    msgInput.value   = '';
    msgInput.style.height = '';

    // Hapus empty state jika ada
    const empty = document.getElementById('empty-chat');
    if (empty) empty.remove();

    try {
        const res = await fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ body }),
        });

        if (!res.ok) throw new Error('Gagal kirim');
        const msg = await res.json();
        lastId = Math.max(lastId, msg.id);
        chatBox.insertAdjacentHTML('beforeend', buildBubble(msg));
        scrollBottom();
    } catch(e) {
        msgInput.value = body; // kembalikan pesan
        alert('Gagal mengirim pesan. Coba lagi.');
    } finally {
        sendBtn.disabled = false;
        msgInput.focus();
    }
}

/** Polling pesan baru */
async function pollMessages() {
    try {
        const res = await fetch(`${fetchUrl}?after=${lastId}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        });
        if (!res.ok) return;
        const msgs = await res.json();
        if (msgs.length > 0) {
            const empty = document.getElementById('empty-chat');
            if (empty) empty.remove();

            msgs.forEach(msg => {
                if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                    chatBox.insertAdjacentHTML('beforeend', buildBubble(msg));
                }
                lastId = Math.max(lastId, msg.id);
            });
            scrollBottom();
        }
    } catch(e) { /* silent */ }
}

// Auto-resize textarea
msgInput.addEventListener('input', function() {
    this.style.height = '';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Init scroll
scrollBottom(false);

// Mulai polling setiap 3 detik
setInterval(pollMessages, 3000);
</script>
@endpush
@endsection
