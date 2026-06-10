@extends('layouts.app')
@section('title', 'Kelola Produk – Seller SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('seller.dashboard') }}" class="text-sm transition" style="color:var(--clr-muted)" onmouseover="this.style.color='var(--clr-purple-l)'" onmouseout="this.style.color='var(--clr-muted)'">← Dashboard</a>
            <h1 class="text-2xl font-black text-white mt-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                Kelola Produk
            </h1>
            <p style="color:var(--clr-muted)" class="text-sm mt-1">Kelola daftar produk jualan kamu</p>
        </div>
        <a href="{{ route('seller.products.create') }}"
           class="btn-primary font-semibold px-5 py-2.5 rounded-xl text-sm flex items-center gap-2 glow">
            <span>+</span> Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl text-sm font-medium flex items-center gap-2" style="background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.2);color:#34d399">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border overflow-hidden" style="background:var(--clr-card);border-color:var(--clr-border)">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead style="background:var(--clr-surface);border-bottom:1px solid var(--clr-border)">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-white">Produk</th>
                        <th class="px-6 py-4 font-semibold text-white">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-white">Harga</th>
                        <th class="px-6 py-4 font-semibold text-white">Stok</th>
                        <th class="px-6 py-4 font-semibold text-white">Status</th>
                        <th class="px-6 py-4 font-semibold text-white text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:var(--clr-border)">
                    @forelse ($products as $product)
                    <tr class="transition" onmouseover="this.style.background='var(--clr-surface)'" onmouseout="this.style.background='transparent'">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden" style="background:var(--clr-surface)">
                                    @if($product->image)
                                        @php $src = str_starts_with($product->image, 'http') ? $product->image : asset('storage/'.$product->image); @endphp
                                        <img src="{{ $src }}" class="w-full h-full object-cover">
                                    @else
                                        <div style="color:var(--clr-muted)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white line-clamp-1">{{ $product->name }}</div>
                                    <div class="text-xs mt-0.5" style="color:var(--clr-muted)">ID: {{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-white">
                            {{ $product->category->icon ?? '' }} {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-black grad-text">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4">
                            @if($product->stock > 5)
                                <span class="px-2 py-1 rounded text-xs font-bold" style="background:rgba(52,211,153,.12);color:#34d399">{{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span class="px-2 py-1 rounded text-xs font-bold" style="background:rgba(251,191,36,.12);color:#fbbf24">{{ $product->stock }}</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold" style="background:rgba(248,113,113,.12);color:#f87171">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="px-2 py-1 rounded text-xs font-bold" style="background:rgba(52,211,153,.12);color:#34d399">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold" style="background:rgba(248,113,113,.12);color:#f87171">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                   class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                   style="color:var(--clr-muted);border:1px solid var(--clr-border)"
                                   onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                    Lihat
                                </a>
                                <a href="{{ route('seller.products.edit', $product) }}"
                                   class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                   style="color:var(--clr-muted);border:1px solid var(--clr-border)"
                                   onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                    Edit
                                </a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                            style="color:#f87171;border:1px solid rgba(248,113,113,.2)"
                                            onmouseover="this.style.background='rgba(248,113,113,.1)'"
                                            onmouseout="this.style.background='transparent'">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center" style="color:var(--clr-muted)">
                            Belum ada produk. <a href="{{ route('seller.products.create') }}" style="color:var(--clr-purple-l)">Mulai jualan!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
