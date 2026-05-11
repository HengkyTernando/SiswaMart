@extends('layouts.app')
@section('title', 'Edit Produk – Seller SiswaMart')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('seller.products.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Kembali ke Daftar Produk</a>
        <h1 class="text-2xl font-black text-gray-900 mt-2">Edit Produk: {{ $product->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Produk</label>
                    <select name="is_active" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                        <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                        <option value="0" {{ old('is_active', $product->is_active) ? '' : 'selected' }}>Nonaktif (Disembunyikan)</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Produk</label>
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$product->image) }}" class="h-32 rounded-xl object-cover border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks. 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk</label>
                    <textarea name="description" rows="5"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50 resize-y">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
