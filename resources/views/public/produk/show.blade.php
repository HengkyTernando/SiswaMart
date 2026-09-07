@extends('layouts.public')

@section('title', $produk->nama . ' — SiswaMart')
@section('meta_description', 'Beli ' . $produk->nama . ' dari ' . ($produk->penjual->nama_toko ?? 'SiswaMart') . '. ' . \Illuminate\Support\Str::limit($produk->deskripsi ?? '', 120))

@section('content')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">

    {{-- ─── Breadcrumb ──────────────────────────────────────────── --}}
    <nav class="flex items-center gap-1.5 text-sm text-[#64748B] mb-8" aria-label="Breadcrumb">
        <a href="{{ route('public.produk.index') }}"
           class="hover:text-[#2563EB] transition-colors">Beranda</a>
        <span class="text-[#CBD5E1]">/</span>
        @if($produk->kategori)
            <a href="{{ route('public.produk.index', ['kategori' => $produk->kategori->slug]) }}"
               class="hover:text-[#2563EB] transition-colors">
                {{ $produk->kategori->nama }}
            </a>
            <span class="text-[#CBD5E1]">/</span>
        @endif
        <span class="text-[#172033] font-medium truncate max-w-[200px] sm:max-w-xs">{{ $produk->nama }}</span>
    </nav>

    {{-- ─── Product Layout ────────────────────────────────────────── --}}
    <div class="bg-white border border-[#E2E8F0] rounded-2xl overflow-hidden shadow-sm">
        <div class="flex flex-col md:flex-row">

            {{-- ── Foto Produk ───────────────────────────────────── --}}
            <div class="md:w-[48%] bg-[#F8FAFF] relative flex items-center justify-center min-h-[300px] md:min-h-[520px] p-8 lg:p-12">
                @if($produk->foto_utama)
                    <img src="{{ asset('storage/' . $produk->foto_utama) }}"
                         alt="{{ $produk->nama }}"
                         class="max-w-full max-h-[440px] object-contain rounded-xl"
                         loading="eager">
                @else
                    <div class="img-placeholder w-64 h-64 rounded-2xl gap-4 border border-[#E2E8F0] bg-white shadow-soft">
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
                        <span class="text-sm font-medium text-[#94A3B8]">Belum ada foto produk</span>
                    </div>
                @endif

                {{-- Label promosi badge --}}
                @if($produk->label_promosi)
                    <div class="absolute top-4 left-4">
                        <span class="inline-block bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE] text-xs font-bold px-3 py-1 rounded-lg">
                            {{ $produk->label_promosi }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- ── Detail Produk ─────────────────────────────────── --}}
            <div class="md:w-[52%] p-7 md:p-9 lg:p-11 flex flex-col">

                {{-- Kategori --}}
                <div class="mb-4">
                    <a href="{{ route('public.produk.index', ['kategori' => $produk->kategori->slug ?? '']) }}"
                       class="inline-flex items-center text-xs font-bold uppercase tracking-widest text-[#2563EB] bg-[#EFF6FF] border border-[#BFDBFE] px-3 py-1 rounded-lg hover:bg-[#DBEAFE] transition-colors">
                        {{ $produk->kategori->nama ?? 'Umum' }}
                    </a>
                </div>

                {{-- Nama --}}
                <h1 class="text-2xl sm:text-3xl font-bold text-[#172033] leading-tight mb-4">
                    {{ $produk->nama }}
                </h1>

                {{-- Harga --}}
                <p class="text-3xl sm:text-4xl font-bold text-[#1D4ED8] mb-5">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                {{-- Status + Views --}}
                <div class="flex flex-wrap items-center gap-2.5 mb-7">
                    @if($produk->stok === 'ready')
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#16A34A] bg-[#F0FDF4] border border-[#BBF7D0] px-3 py-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Tersedia
                        </span>
                    @elseif($produk->stok === 'po')
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#92400E] bg-[#FFFBEB] border border-[#FDE68A] px-3 py-1.5 rounded-lg">
                            Pre-Order
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#DC2626] bg-[#FEF2F2] border border-[#FECACA] px-3 py-1.5 rounded-lg">
                            Stok Habis
                        </span>
                    @endif

                    @if($produk->views > 0)
                        <span class="inline-flex items-center gap-1.5 text-sm text-[#64748B]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($produk->views, 0, ',', '.') }} kali dilihat
                        </span>
                    @endif
                </div>

                {{-- Rating Summary Mini --}}
                <div class="flex items-center gap-2 mb-7">
                    @if($produk->review_count > 0)
                        <div class="flex items-center gap-1 bg-[#FFFBEB] px-3 py-1.5 rounded-lg border border-[#FEF3C7]">
                            <svg class="w-4 h-4 text-[#F59E0B]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm font-bold text-[#92400E]">{{ number_format($produk->average_rating, 1) }}</span>
                            <span class="text-sm text-[#B45309]">({{ $produk->review_count }} ulasan)</span>
                        </div>
                    @else
                        <span class="text-sm text-[#94A3B8]">Belum ada rating</span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                @if($produk->deskripsi)
                    <div class="mb-8">
                        <h2 class="text-xs font-bold text-[#64748B] uppercase tracking-widest mb-2.5">Deskripsi Produk</h2>
                        <p class="text-sm text-[#64748B] leading-relaxed whitespace-pre-wrap">{{ $produk->deskripsi }}</p>
                    </div>
                @endif

                {{-- Seller Info + CTA --}}
                <div class="border-t border-[#E2E8F0] pt-7 mt-auto">
                    <h2 class="text-xs font-bold text-[#64748B] uppercase tracking-widest mb-4">Dijual oleh</h2>

                    {{-- Toko card --}}
                    <div class="flex items-start gap-3.5 mb-7 p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl">
                        <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] border border-[#DBEAFE] flex items-center justify-center text-[#2563EB] font-bold text-xl flex-shrink-0">
                            {{ strtoupper(substr($produk->penjual->nama_toko ?? '?', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-[#172033] text-base leading-snug">
                                {{ $produk->penjual->nama_toko ?? '-' }}
                            </div>
                            @if($produk->penjual->user)
                                <div class="text-sm text-[#64748B] mt-0.5">
                                    Pemilik: {{ $produk->penjual->user->name }}
                                </div>
                            @endif
                            @if($produk->penjual->lokasi_kelas)
                                <div class="flex items-center gap-1.5 text-sm text-[#64748B] mt-0.5">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Lokasi: {{ $produk->penjual->lokasi_kelas }}
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
                       id="btn-hubungi-penjual"
                       class="wa-btn w-full flex items-center justify-center gap-3 text-white font-bold py-4 px-6 rounded-xl text-base mb-3 shadow-sm"
                       aria-label="Hubungi {{ $produk->penjual->nama_toko ?? 'penjual' }} melalui WhatsApp">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 3.825 0 6.938 3.112 6.938 6.937 0 3.825-3.113 6.938-6.938 6.938z"/>
                        </svg>
                        Hubungi Penjual via WhatsApp
                    </a>

                    <p class="text-xs text-[#94A3B8] text-center leading-relaxed">
                        Hubungi penjual untuk menanyakan ketersediaan dan pemesanan. Transaksi dilakukan langsung dengan penjual.
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- ─── Cara Pemesanan Mini Section ─────────────────────────────── --}}
    <div class="mt-6 bg-[#EFF6FF] border border-[#BFDBFE] rounded-2xl p-6 lg:p-8 flex flex-col md:flex-row gap-6 items-start shadow-sm">
        <div class="w-12 h-12 bg-white text-[#2563EB] rounded-xl flex items-center justify-center text-2xl flex-shrink-0 shadow-sm border border-[#DBEAFE]">
            💡
        </div>
        <div>
            <h2 class="text-lg font-bold text-[#1D4ED8] mb-3">Cara Pemesanan</h2>
            <ol class="list-decimal list-inside space-y-2 text-sm text-[#1E3A8A] mb-4">
                <li><span class="font-medium text-[#172033]">Hubungi penjual</span> melalui WhatsApp.</li>
                <li><span class="font-medium text-[#172033]">Tanyakan ketersediaan</span> produk.</li>
                <li><span class="font-medium text-[#172033]">Tentukan jumlah dan waktu pengambilan</span>/pemesanan dengan penjual.</li>
                <li><span class="font-medium text-[#172033]">Ikuti kesepakatan pemesanan</span> yang diberikan oleh penjual.</li>
            </ol>
            <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-[#DBEAFE] text-xs font-semibold text-[#2563EB]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Transaksi dan pembayaran dilakukan langsung dengan penjual di luar SiswaMart.
            </div>
        </div>
    </div>

    {{-- ─── Rating & Ulasan ─────────────────────────────────────────── --}}
    <div class="mt-8 bg-white border border-[#E2E8F0] rounded-2xl p-6 lg:p-10 shadow-sm">
        <h2 class="text-xl font-bold text-[#172033] mb-6">Rating & Ulasan</h2>

        <div class="flex flex-col lg:flex-row gap-10">
            {{-- Bagian Summary & List --}}
            <div class="lg:w-7/12">
                {{-- Summary --}}
                <div class="flex items-center gap-6 mb-8 p-6 bg-[#F8FAFF] rounded-xl border border-[#E2E8F0]">
                    <div class="text-center">
                        <div class="text-4xl font-black text-[#172033]">{{ number_format($produk->average_rating, 1) }} <span class="text-xl text-[#94A3B8] font-medium">/ 5</span></div>
                        <div class="flex text-[#F59E0B] my-1 justify-center">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($produk->average_rating) ? 'text-[#F59E0B]' : 'text-[#CBD5E1]' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <div class="text-sm text-[#64748B]">{{ $produk->review_count }} ulasan</div>
                    </div>
                </div>

                {{-- List --}}
                @if($ulasan->isEmpty())
                    <p class="text-[#64748B] text-sm italic">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan penilaian!</p>
                @else
                    <div class="space-y-6">
                        @foreach($ulasan as $rev)
                            <div class="border-b border-[#F1F5F9] pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex text-[#F59E0B]">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $rev->rating ? 'text-[#F59E0B]' : 'text-[#CBD5E1]' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-[#94A3B8]">{{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                                @if($rev->komentar)
                                    <p class="text-sm text-[#475569] mb-2">{{ $rev->komentar }}</p>
                                @endif
                                <div class="text-xs font-semibold text-[#172033]">&mdash; {{ $rev->guest_username }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Form Review --}}
            <div class="lg:w-5/12">
                <div class="bg-[#F8FAFF] p-6 rounded-xl border border-[#E2E8F0]">
                    <h3 class="font-bold text-[#172033] mb-4">Bagikan pengalamanmu</h3>
                    
                    @if(session('success'))
                        <div class="bg-[#F0FDF4] border border-[#BBF7D0] text-[#16A34A] px-4 py-3 rounded-lg text-sm font-medium mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('public.ulasan.store', $produk->slug) }}" method="POST" x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0 }">
                        @csrf
                        {{-- Star Selector --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[#64748B] mb-2">Penilaian <span class="text-red-500">*</span></label>
                            <div class="flex gap-1 cursor-pointer" @mouseleave="hoverRating = 0">
                                <template x-for="i in 5">
                                    <svg @click="rating = i" @mouseenter="hoverRating = i" 
                                         class="w-8 h-8 transition-colors" 
                                         :class="{'text-[#F59E0B]': i <= (hoverRating || rating), 'text-[#CBD5E1]': i > (hoverRating || rating)}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </template>
                            </div>
                            <input type="hidden" name="rating" x-model="rating">
                            @error('rating') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[#64748B] mb-1">Nama Kamu <span class="text-red-500">*</span></label>
                            <input type="text" name="guest_username" value="{{ old('guest_username') }}" required maxlength="100" class="w-full px-3 py-2 text-sm border border-[#E2E8F0] rounded-lg focus:ring-[#2563EB] focus:border-[#2563EB]" placeholder="Nama atau julukan">
                            @error('guest_username') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-[#64748B] mb-1">Komentar (Opsional)</label>
                            <textarea name="komentar" rows="3" maxlength="1000" class="w-full px-3 py-2 text-sm border border-[#E2E8F0] rounded-lg focus:ring-[#2563EB] focus:border-[#2563EB]" placeholder="Tulis pengalaman atau pendapatmu...">{{ old('komentar') }}</textarea>
                            @error('komentar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-primary w-full py-2.5 text-sm font-semibold rounded-lg shadow-soft">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Produk Terkait ─────────────────────────────────────────── --}}
    @if($produkTerkait && $produkTerkait->isNotEmpty())
        <div class="mt-12">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-[#172033]">Produk Lainnya</h2>
                    <p class="text-[#64748B] text-sm mt-1">Mungkin kamu juga suka dari kategori yang sama</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
                @foreach($produkTerkait as $item)
                    <x-public.product-card :produk="$item" />
                @endforeach
            </div>
        </div>
    @endif

</main>

@endsection
