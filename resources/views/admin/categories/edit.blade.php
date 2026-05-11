@extends('layouts.app')
@section('title', 'Edit Kategori – Admin SiswaMart')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Kembali</a>
        <h1 class="text-2xl font-black text-gray-900 mt-2">Edit Kategori</h1>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
                @foreach ($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Icon Key</label>
                <select name="icon" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50">
                    @foreach(['pencil' => 'Alat Tulis (pencil)', 'book' => 'Buku (book)', 'backpack' => 'Tas (backpack)', 'laptop' => 'Elektronik (laptop)', 'shirt' => 'Seragam (shirt)', 'sports' => 'Olahraga (sports)', 'category' => 'Lainnya (category)'] as $key => $label)
                        <option value="{{ $key }}" {{ old('icon', $category->icon) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-gray-50 resize-none">{{ old('description', $category->description) }}</textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition">
                Perbarui Kategori
            </button>
        </form>
    </div>
</div>
@endsection
