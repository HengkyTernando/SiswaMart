@extends('layouts.public')

@section('title', $produk->nama . ' — SiswaMart')
@section('meta_description', 'Beli ' . $produk->nama . ' dari ' . ($produk->penjual->nama_toko ?? 'SiswaMart') . '. ' . \Illuminate\Support\Str::limit($produk->deskripsi ?? '', 120))

@section('content')

<main class="max-w-[1400px] mx-auto px-6 lg:px-[60px] py-12 lg:py-16">

    {{-- ─── Breadcrumb ──────────────────────────────────────────── --}}
    <nav class="flex flex-wrap items-center gap-2 text-sm text-[var(--color-text-muted)] font-bold mb-8 uppercase tracking-widest" aria-label="Breadcrumb">
        <a href="{{ route('public.produk.index') }}"
           class="hover:text-[var(--color-primary)] transition-colors">BERANDA</a>
        <span class="text-[var(--color-border)]">/</span>
        @if($produk->kategori)
            <a href="{{ route('public.produk.index', ['kategori' => $produk->kategori->slug]) }}"
               class="hover:text-[var(--color-primary)] transition-colors">
                {{ $produk->kategori->nama }}
            </a>
            <span class="text-[var(--color-border)]">/</span>
        @endif
        <span class="text-[var(--color-text)] truncate max-w-[200px] sm:max-w-xs">{{ $produk->nama }}</span>
    </nav>

    {{-- ─── Product Layout ────────────────────────────────────────── --}}
    <div class="bg-[var(--color-surface)] border-4 border-[var(--color-border)] rounded-[40px] overflow-hidden shadow-solid-lg mb-16 relative z-10">
        <div class="flex flex-col lg:flex-row">

            {{-- ── Foto Produk ───────────────────────────────────── --}}
            <div class="lg:w-[45%] xl:w-[50%] bg-[#FFD84D] relative flex items-center justify-center min-h-[400px] lg:min-h-[600px] p-8 lg:p-12 border-b-4 lg:border-b-0 lg:border-r-4 border-[var(--color-border)]">
                @if($produk->foto_utama)
                    <img src="{{ asset('storage/' . $produk->foto_utama) }}"
                         alt="{{ $produk->nama }}"
                         class="max-w-full max-h-[500px] object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-500"
                         loading="eager">
                @else
                    <div class="w-64 h-64 bg-white rounded-full flex flex-col items-center justify-center gap-4 border-4 border-[var(--color-border)] shadow-solid-md">
                        @php
                            $slug  = $produk->kategori->slug ?? '';
                            $catIcons = [
                                'makanan' => 'food.svg',
                                'minuman' => 'drink.svg',
                                'snack' => 'snack.svg',
                                'dessert' => 'dessert.svg',
                            ];
                            $iconFile = $catIcons[$slug] ?? 'bag.svg';
                        @endphp
                        <div class="w-20 h-20 opacity-50 grayscale">
                            <img src="{{ asset('images/icons/' . $iconFile) }}" alt="Placeholder" class="w-full h-full object-contain">
                        </div>
                        <span class="text-sm font-black text-[var(--color-text-muted)] uppercase tracking-wider">Tanpa Foto</span>
                    </div>
                @endif

                {{-- Label promosi badge --}}
                @if($produk->label_promosi)
                    <div class="absolute top-6 left-6 rotate-[-5deg]">
                        <span class="inline-block bg-[var(--color-primary)] text-white border-2 border-[var(--color-border)] shadow-solid-sm text-sm font-black uppercase tracking-widest px-4 py-2 rounded-full">
                            {{ $produk->label_promosi }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- ── Detail Produk ─────────────────────────────────── --}}
            <div class="lg:w-[55%] xl:w-[50%] p-8 md:p-12 xl:p-16 flex flex-col bg-white">

                {{-- Kategori --}}
                <div class="mb-4">
                    <a href="{{ route('public.produk.index', ['kategori' => $produk->kategori->slug ?? '']) }}"
                       class="inline-flex items-center text-xs font-black uppercase tracking-widest text-[var(--color-text)] bg-[#A3D9C9] border-2 border-[var(--color-border)] shadow-[2px_2px_0px_0px_var(--color-border)] px-4 py-1.5 rounded-full hover:translate-x-0.5 hover:-translate-y-0.5 transition-transform">
                        {{ $produk->kategori->nama ?? 'Umum' }}
                    </a>
                </div>

                {{-- Nama --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-[var(--color-text)] leading-[1.1] mb-6 uppercase tracking-tighter">
                    {{ $produk->nama }}
                </h1>

                {{-- Harga --}}
                <p class="text-4xl md:text-5xl font-black text-[var(--color-primary)] mb-8 drop-shadow-sm">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                {{-- Status + Views + Rating Summary Mini --}}
                <div class="flex flex-wrap items-center gap-4 mb-10">
                    @if($produk->stok === 'ready')
                        <span class="inline-flex items-center gap-2 text-sm font-black text-[#16A34A] bg-[#BBF7D0] border-2 border-[#16A34A] shadow-[2px_2px_0px_0px_#16A34A] px-4 py-2 rounded-full uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Tersedia
                        </span>
                    @elseif($produk->stok === 'po')
                        <span class="inline-flex items-center gap-2 text-sm font-black text-[#92400E] bg-[#FDE68A] border-2 border-[#92400E] shadow-[2px_2px_0px_0px_#92400E] px-4 py-2 rounded-full uppercase tracking-wider">
                            Pre-Order
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-sm font-black text-white bg-[#DC2626] border-2 border-[var(--color-border)] shadow-[2px_2px_0px_0px_var(--color-border)] px-4 py-2 rounded-full uppercase tracking-wider">
                            Stok Habis
                        </span>
                    @endif

                    @if($produk->review_count > 0)
                        <div class="flex items-center gap-1.5 bg-white px-4 py-2 rounded-full border-2 border-[var(--color-border)] shadow-[2px_2px_0px_0px_var(--color-border)]">
                            <span class="text-yellow-400 text-lg leading-none">★</span>
                            <span class="text-sm font-black text-[var(--color-text)]">{{ number_format($produk->average_rating, 1) }}</span>
                            <span class="text-sm font-bold text-[var(--color-text-muted)]">({{ $produk->review_count }})</span>
                        </div>
                    @endif
                    
                    @if($produk->views > 0)
                        <span class="inline-flex items-center gap-1.5 text-sm font-bold text-[var(--color-text-muted)]">
                            👁️ {{ number_format($produk->views, 0, ',', '.') }} views
                        </span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                @if($produk->deskripsi)
                    <div class="mb-10 bg-[var(--color-bg)] p-6 rounded-3xl border-2 border-[var(--color-border)] shadow-solid-sm">
                        <h2 class="text-sm font-black text-[var(--color-text)] uppercase tracking-widest mb-3">TENTANG PRODUK INI</h2>
                        <p class="text-base font-bold text-[var(--color-text-muted)] leading-relaxed whitespace-pre-wrap">{{ $produk->deskripsi }}</p>
                    </div>
                @endif

                {{-- Seller Info + CTA --}}
                <div class="mt-auto">
                    {{-- Toko card --}}
                    <div class="flex items-center gap-4 mb-8 p-4 bg-[#D4C4FB] border-2 border-[var(--color-border)] rounded-[24px] shadow-solid-sm transform rotate-1">
                        <div class="w-16 h-16 rounded-full bg-white border-2 border-[var(--color-border)] flex items-center justify-center text-[var(--color-text)] font-black text-2xl flex-shrink-0 shadow-sm">
                            {{ strtoupper(substr($produk->penjual->nama_toko ?? '?', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-xs font-black text-[var(--color-text)] opacity-70 uppercase tracking-widest mb-1">DIJUAL OLEH</h2>
                            <div class="font-black text-[var(--color-text)] text-xl leading-snug uppercase">
                                {{ $produk->penjual->nama_toko ?? '-' }}
                            </div>
                            @if($produk->penjual->lokasi_kelas)
                                <div class="flex items-center gap-1 text-sm font-bold text-[var(--color-text-muted)] mt-1">
                                    📍 {{ $produk->penjual->lokasi_kelas }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- WhatsApp CTA --}}
                    @php
                        $waNumber = $produk->penjual->nomor_whatsapp ?? '';
                        if (str_starts_with($waNumber, '0')) {
                            $waNumber = '62' . substr($waNumber, 1);
                        } elseif (str_starts_with($waNumber, '+')) {
                            $waNumber = substr($waNumber, 1);
                        }
                        $waMsg  = "Halo, saya tertarik dengan produk:\n*" . $produk->nama . "*\n\nApakah produk ini masih tersedia?";
                        $waLink = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waMsg);
                    @endphp

                    <a href="{{ $waLink }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn-primary w-full flex items-center justify-center gap-3 bg-[#25D366] text-white hover:bg-[#128C7E] py-5 px-6 rounded-2xl text-lg uppercase tracking-wider mb-4 border-2 border-[var(--color-border)] shadow-solid-md hover:shadow-solid-lg"
                       aria-label="Hubungi {{ $produk->penjual->nama_toko ?? 'penjual' }} melalui WhatsApp">
                        💬 HUBUNGI VIA WHATSAPP
                    </a>

                    <p class="text-xs font-bold text-[var(--color-text-muted)] text-center leading-relaxed">
                        Transaksi dilakukan langsung dengan penjual di luar platform.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            {{-- ─── Rating & Ulasan ─────────────────────────────────────────── --}}
            <div class="bg-[var(--color-surface)] border-4 border-[var(--color-border)] rounded-[40px] p-8 lg:p-12 shadow-solid-md relative">
                {{-- Decorative Blob --}}
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-[#FFB084] border-4 border-[var(--color-border)] rounded-full shadow-solid-sm z-0 flex items-center justify-center text-3xl transform rotate-12">
                    ⭐
                </div>

                <h2 class="text-3xl font-black text-[var(--color-text)] mb-8 uppercase tracking-tighter relative z-10">Kata Mereka</h2>

                {{-- Summary --}}
                <div class="flex flex-col sm:flex-row items-center gap-8 mb-10 p-8 bg-white rounded-3xl border-2 border-[var(--color-border)] shadow-solid-sm relative z-10">
                    <div class="text-center sm:text-left">
                        <div class="text-6xl font-black text-[var(--color-text)]">{{ number_format($produk->average_rating, 1) }}</div>
                        <div class="text-sm font-bold text-[var(--color-text-muted)] uppercase tracking-wider mt-2">{{ $produk->review_count }} ULASAN</div>
                    </div>
                    <div class="hidden sm:block w-0.5 h-16 bg-[var(--color-border)]"></div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <div class="flex text-yellow-400 text-xl tracking-tighter">★★★★★</div>
                        </div>
                    </div>
                </div>

                {{-- List --}}
                @if($ulasan->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-lg font-bold text-[var(--color-text-muted)]">Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
                    </div>
                @else
                    <div class="space-y-6 relative z-10">
                        @foreach($ulasan as $rev)
                            <div class="bg-white p-6 rounded-3xl border-2 border-[var(--color-border)] shadow-[4px_4px_0px_0px_var(--color-border)]">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="font-black text-[var(--color-text)] uppercase text-lg">{{ $rev->guest_username }}</div>
                                    <div class="flex text-yellow-400 text-sm tracking-tighter">
                                        @for($i=1; $i<=5; $i++)
                                            {{ $i <= $rev->rating ? '★' : '☆' }}
                                        @endfor
                                    </div>
                                </div>
                                @if($rev->komentar)
                                    <p class="text-base font-bold text-[var(--color-text-muted)] mb-3">{{ $rev->komentar }}</p>
                                @endif
                                <div class="text-xs font-bold text-[var(--color-text-muted)] opacity-50 uppercase tracking-widest">{{ $rev->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            {{-- Form Review --}}
            <div class="bg-[#FFF8E8] border-4 border-[var(--color-border)] rounded-[40px] p-8 lg:p-12 shadow-solid-md transform -rotate-1">
                <h3 class="text-2xl font-black text-[var(--color-text)] mb-6 uppercase tracking-tighter">Beri Penilaianmu!</h3>
                
                @if(session('success'))
                    <div class="bg-[#BBF7D0] border-2 border-[#16A34A] text-[#16A34A] font-bold px-4 py-3 rounded-2xl mb-6 shadow-solid-sm">
                        🎉 {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('public.ulasan.store', $produk->slug) }}" method="POST" x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0 }">
                    @csrf
                    {{-- Star Selector --}}
                    <div class="mb-6">
                        <label class="block text-sm font-black text-[var(--color-text)] uppercase tracking-widest mb-3">Bintang <span class="text-red-500">*</span></label>
                        <div class="flex gap-2 cursor-pointer" @mouseleave="hoverRating = 0">
                            <template x-for="i in 5">
                                <span @click="rating = i" @mouseenter="hoverRating = i" 
                                      class="text-4xl transition-transform hover:scale-110 select-none" 
                                      :class="{'text-yellow-400 drop-shadow-sm': i <= (hoverRating || rating), 'text-gray-300 grayscale': i > (hoverRating || rating)}">
                                    ★
                                </span>
                            </template>
                        </div>
                        <input type="hidden" name="rating" x-model="rating">
                        @error('rating') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-6">
                        <label class="block text-sm font-black text-[var(--color-text)] uppercase tracking-widest mb-2">Namamu <span class="text-red-500">*</span></label>
                        <input type="text" name="guest_username" value="{{ old('guest_username') }}" required maxlength="100" class="w-full px-4 py-3 text-base font-bold bg-white border-2 border-[var(--color-border)] rounded-2xl shadow-[4px_4px_0px_0px_var(--color-border)] focus:outline-none focus:translate-x-1 focus:translate-y-1 focus:shadow-none transition-all" placeholder="Siapa namamu?">
                        @error('guest_username') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-8">
                        <label class="block text-sm font-black text-[var(--color-text)] uppercase tracking-widest mb-2">Komentar</label>
                        <textarea name="komentar" rows="3" maxlength="1000" class="w-full px-4 py-3 text-base font-bold bg-white border-2 border-[var(--color-border)] rounded-2xl shadow-[4px_4px_0px_0px_var(--color-border)] focus:outline-none focus:translate-x-1 focus:translate-y-1 focus:shadow-none transition-all" placeholder="Gimana rasanya?">{{ old('komentar') }}</textarea>
                        @error('komentar') <span class="text-xs font-bold text-red-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full py-4 text-lg bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)]">
                        KIRIM ULASAN SEKARANG
                    </button>
                </form>
            </div>
        </div>
        
        <div class="lg:col-span-1">
             {{-- ─── Cara Pemesanan Mini Section ─────────────────────────────── --}}
            <div class="bg-[#A3D9C9] border-4 border-[var(--color-border)] rounded-[40px] p-8 shadow-solid-md transform rotate-1 sticky top-24">
                <div class="w-16 h-16 bg-white border-4 border-[var(--color-border)] rounded-full flex items-center justify-center text-3xl mb-6 shadow-[4px_4px_0px_0px_var(--color-border)] transform -rotate-12">
                    🛒
                </div>
                <h2 class="text-2xl font-black text-[var(--color-text)] mb-6 uppercase tracking-tighter">Cara Beli</h2>
                <ol class="list-decimal list-inside space-y-4 text-base font-bold text-[var(--color-text)] mb-8">
                    <li><span class="bg-white px-2 py-0.5 border border-[var(--color-border)] rounded-md shadow-sm">Chat Penjual</span> via WA.</li>
                    <li>Tanya produk masih ada/nggak.</li>
                    <li>Janji ketemu di sekolah buat transaksi.</li>
                    <li>Bayar pakai uang pas ya!</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- ─── Produk Terkait ─────────────────────────────────────────── --}}
    @if($produkTerkait && $produkTerkait->isNotEmpty())
        <div class="mt-24 pt-16 border-t-4 border-[var(--color-border)]">
            <h2 class="text-4xl font-black text-[var(--color-text)] mb-10 uppercase tracking-tighter text-center">Boleh Dicoba Juga Nih</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($produkTerkait as $item)
                    <x-public.product-card :produk="$item" />
                @endforeach
            </div>
        </div>
    @endif

</main>

@endsection
