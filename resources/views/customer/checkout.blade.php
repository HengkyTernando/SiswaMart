@extends('layouts.app')
@section('title', 'Checkout – SiswaMart')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
             style="background:linear-gradient(135deg,#7c3aed,#9333ea)">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-black text-white">Checkout</h1>
            <p class="text-sm" style="color:var(--clr-muted)">Lengkapi data pengiriman kamu</p>
        </div>
    </div>

    {{-- Step indicator --}}
    <div class="flex items-center gap-0 mb-8">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black text-white"
                 style="background:linear-gradient(135deg,#7c3aed,#9333ea)">1</div>
            <span class="text-sm font-semibold text-white hidden sm:block">Keranjang</span>
        </div>
        <div class="flex-1 h-px mx-3" style="background:linear-gradient(90deg,var(--clr-purple),var(--clr-border))"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black text-white glow"
                 style="background:linear-gradient(135deg,#7c3aed,#9333ea)">2</div>
            <span class="text-sm font-semibold grad-text hidden sm:block">Checkout</span>
        </div>
        <div class="flex-1 h-px mx-3" style="background:var(--clr-border)"></div>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-black"
                 style="background:var(--clr-card);border:1px solid var(--clr-border);color:var(--clr-muted)">3</div>
            <span class="text-sm font-semibold hidden sm:block" style="color:var(--clr-muted)">Selesai</span>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl text-sm font-semibold"
             style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);color:#fca5a5">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Terdapat kesalahan:
            </div>
            <ul class="list-disc list-inside space-y-0.5 ml-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Left: Form (2/3) ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Informasi Penerima --}}
                <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                             style="background:rgba(139,92,246,.2)">
                            <svg class="w-3.5 h-3.5" style="color:var(--clr-purple-l)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white">Informasi Penerima</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold mb-1.5" style="color:var(--clr-muted)">
                                Nama Penerima <span style="color:#f87171">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   placeholder="Nama lengkap penerima"
                                   class="input-dark w-full px-4 py-2.5 rounded-xl text-sm transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1.5" style="color:var(--clr-muted)">
                                Nomor Telepon <span style="color:#f87171">*</span>
                            </label>
                            <input type="text" name="phone" id="phone"
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="input-dark w-full px-4 py-2.5 rounded-xl text-sm transition">
                        </div>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                             style="background:rgba(139,92,246,.2)">
                            <svg class="w-3.5 h-3.5" style="color:var(--clr-purple-l)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white">Alamat Pengiriman</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--clr-muted)">
                            Alamat Lengkap <span style="color:#f87171">*</span>
                        </label>
                        <textarea name="shipping_address" id="shipping_address" rows="4"
                                  placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"
                                  class="input-dark w-full px-4 py-2.5 rounded-xl text-sm transition resize-none">{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                        <p class="text-xs mt-1.5" style="color:var(--clr-muted)">
                            Sertakan RT/RW, Kelurahan, Kecamatan, Kota, dan Kode Pos untuk pengiriman akurat.
                        </p>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                             style="background:rgba(139,92,246,.2)">
                            <svg class="w-3.5 h-3.5" style="color:var(--clr-purple-l)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white">Metode Pembayaran</h3>
                    </div>

                    <div class="space-y-3">
                        @php
                            $methods = [
                                ['id'=>'cod',      'icon'=>'💵', 'label'=>'Bayar di Tempat (COD)',     'desc'=>'Bayar saat paket tiba'],
                                ['id'=>'transfer',  'icon'=>'🏦', 'label'=>'Transfer Bank',              'desc'=>'BCA · BNI · Mandiri · BRI'],
                                ['id'=>'ewallet',   'icon'=>'📱', 'label'=>'E-Wallet',                   'desc'=>'GoPay · OVO · DANA · ShopeePay'],
                            ];
                        @endphp
                        @foreach($methods as $m)
                        <label for="pay_{{ $m['id'] }}"
                               class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition payment-option"
                               style="border:1px solid var(--clr-border);background:var(--clr-surface)"
                               data-value="{{ $m['id'] }}">
                            <input type="radio" name="payment_method" id="pay_{{ $m['id'] }}" value="{{ $m['id'] }}"
                                   class="hidden" {{ $loop->first ? 'checked' : '' }}>
                            <span class="text-2xl">{{ $m['icon'] }}</span>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-white">{{ $m['label'] }}</div>
                                <div class="text-xs" style="color:var(--clr-muted)">{{ $m['desc'] }}</div>
                            </div>
                            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 pay-check"
                                 style="border:2px solid var(--clr-border)">
                                <div class="w-2.5 h-2.5 rounded-full hidden pay-dot"
                                     style="background:var(--clr-purple)"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                             style="background:rgba(139,92,246,.2)">
                            <svg class="w-3.5 h-3.5" style="color:var(--clr-purple-l)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-white">Catatan Pesanan <span class="text-xs font-normal" style="color:var(--clr-muted)">(Opsional)</span></h3>
                    </div>
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Contoh: Tolong dikemas dengan aman, pagar warna merah, dll."
                              class="input-dark w-full px-4 py-2.5 rounded-xl text-sm transition resize-none">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- ── Right: Order Summary (1/3) ── --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl p-5 sticky top-20 space-y-4"
                     style="background:var(--clr-card);border:1px solid var(--clr-border)">

                    <h3 class="font-black text-white">Ringkasan Pesanan</h3>

                    {{-- Item list --}}
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                        <div class="flex gap-3 items-start">
                            <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0"
                                 style="background:var(--clr-surface)">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="color:rgba(139,92,246,.35)">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-white line-clamp-2">{{ $item['name'] }}</p>
                                <p class="text-xs mt-0.5" style="color:var(--clr-muted)">{{ $item['qty'] }} ×
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="text-xs font-black grad-text flex-shrink-0">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr style="border-color:var(--clr-border)">

                    {{-- Price breakdown --}}
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span style="color:var(--clr-muted)">Subtotal ({{ count($cart) }} item)</span>
                            <span class="font-semibold text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--clr-muted)">Ongkos Kirim</span>
                            <span class="font-semibold text-emerald-400">Gratis</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t" style="border-color:var(--clr-border)">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white">Total Bayar</span>
                            <span class="text-xl font-black grad-text">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <button type="submit" id="submit-btn"
                            class="btn-primary w-full py-3.5 rounded-xl font-bold glow flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="submit-label">Buat Pesanan</span>
                    </button>

                    <a href="{{ route('customer.cart') }}"
                       class="w-full text-center text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 transition"
                       style="color:var(--clr-muted);border:1px solid var(--clr-border)"
                       onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                       onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                        ← Kembali ke Keranjang
                    </a>

                    {{-- Trust badges --}}
                    <div class="pt-2 grid grid-cols-3 gap-2 text-center">
                        @foreach([['🔒','Transaksi Aman'],['📦','Pengiriman Cepat'],['↩️','Garansi Kembali']] as [$icon,$label])
                        <div class="p-2 rounded-xl" style="background:var(--clr-surface);border:1px solid var(--clr-border)">
                            <div class="text-lg">{{ $icon }}</div>
                            <div class="text-xs leading-tight mt-1" style="color:var(--clr-muted)">{{ $label }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Payment method selector
const options = document.querySelectorAll('.payment-option');
function selectPayment(label) {
    options.forEach(el => {
        const isSelected = el.dataset.value === label.dataset.value;
        el.style.borderColor = isSelected ? 'var(--clr-purple)' : 'var(--clr-border)';
        el.style.background   = isSelected ? 'rgba(124,58,237,.12)' : 'var(--clr-surface)';
        el.querySelector('.pay-check').style.borderColor = isSelected ? 'var(--clr-purple)' : 'var(--clr-border)';
        el.querySelector('.pay-dot').classList.toggle('hidden', !isSelected);
        el.querySelector('input').checked = isSelected;
    });
}

options.forEach(el => {
    // Set initial state for COD (first)
    if (el.querySelector('input').checked) selectPayment(el);
    el.addEventListener('click', () => selectPayment(el));
});

// Prevent double submit
document.getElementById('checkout-form').addEventListener('submit', function () {
    const btn   = document.getElementById('submit-btn');
    const label = document.getElementById('submit-label');
    btn.disabled = true;
    btn.style.opacity = '0.7';
    label.textContent = 'Memproses...';
});
</script>
@endpush
@endsection
