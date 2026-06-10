@extends('layouts.app')
@section('title', 'Tambah Produk – Seller SiswaMart')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('seller.products.index') }}" class="text-sm transition" style="color:var(--clr-muted)" onmouseover="this.style.color='var(--clr-purple-l)'" onmouseout="this.style.color='var(--clr-muted)'">← Kembali ke Daftar Produk</a>
        <h1 class="text-2xl font-black text-white mt-2">Tambah Produk Baru</h1>
    </div>

    <div class="rounded-2xl border shadow-sm p-8" style="background:var(--clr-card);border-color:var(--clr-border)">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl text-sm font-semibold" style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);color:#f87171">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Nama Produk <span style="color:#f87171">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="input-dark w-full px-4 py-3 rounded-xl text-sm transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Kategori <span style="color:#f87171">*</span></label>
                    <select name="category_id" required
                            class="input-dark w-full px-4 py-3 rounded-xl text-sm transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Harga (Rp) <span style="color:#f87171">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                           class="input-dark w-full px-4 py-3 rounded-xl text-sm transition"
                           placeholder="Contoh: 15000">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Stok <span style="color:#f87171">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                           class="input-dark w-full px-4 py-3 rounded-xl text-sm transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Foto Produk</label>
                    <input type="file" name="image" accept="image/*"
                           class="input-dark w-full px-4 py-2.5 rounded-xl text-sm transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                    <p class="text-xs mt-1" style="color:var(--clr-muted)">Format: JPG, PNG. Maksimal 2MB.</p>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Deskripsi Produk</label>
                    <textarea name="description" rows="5"
                              class="input-dark w-full px-4 py-3 rounded-xl text-sm transition resize-y"
                              placeholder="Tuliskan detail produk, spesifikasi, dan kondisi barang di sini...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t" style="border-color:var(--clr-border)">
                <button type="submit" class="btn-primary w-full font-bold py-3.5 rounded-xl glow flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" style="display:inline-block;vertical-align:-2px"><path d="M4.14 15.08c-1.62.94-2.14 2.94-2.14 2.94s2-.52 2.94-2.14l11.41-11.42a2.83 2.83 0 0 0-4-4L4.14 15.08z"/><path d="M19 8.5L22 11.5L14.5 19L11.5 16L19 8.5z"/><path d="M2.5 21.5L5 19"/></svg>
                    Simpan & Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
