@extends('layouts.app')
@section('title', 'Kelola Produk – Seller SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('seller.dashboard') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Dashboard</a>
            <h1 class="text-2xl font-black text-gray-900 mt-2">📦 Kelola Produk</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola daftar produk jualan kamu</p>
        </div>
        <a href="{{ route('seller.products.create') }}"
           class="bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition shadow-sm text-sm flex items-center gap-2">
            <span>+</span> Tambah Produk
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600">Produk</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Harga</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Stok</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">📦</div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900 line-clamp-1">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">ID: {{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $product->category->icon ?? '' }} {{ $product->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-indigo-600">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $product->stock > 5 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                   class="text-xs font-semibold text-gray-600 hover:text-indigo-600 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-indigo-300 transition">
                                    Lihat
                                </a>
                                <a href="{{ route('seller.products.edit', $product) }}"
                                   class="text-xs font-semibold text-gray-600 hover:text-indigo-600 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-indigo-300 transition">
                                    Edit
                                </a>
                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-semibold text-red-500 hover:text-red-700 px-3 py-1.5 rounded-lg border border-red-200 hover:border-red-400 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            Belum ada produk. <a href="{{ route('seller.products.create') }}" class="text-indigo-600 hover:underline">Mulai jualan!</a>
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
