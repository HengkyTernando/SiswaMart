@extends('layouts.app')
@section('title', 'Kelola Kategori – Admin SiswaMart')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">📂 Kelola Kategori</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $categories->total() }} kategori terdaftar</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition text-sm flex items-center gap-2">
            <span>+</span> Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Icon</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Nama</th>
                    <th class="text-left px-6 py-4 font-semibold text-gray-600">Slug</th>
                    <th class="text-right px-6 py-4 font-semibold text-gray-600">Produk</th>
                    <th class="text-right px-6 py-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($categories as $cat)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <x-category-icon :icon="$cat->icon ?? 'category'" class="w-7 h-7 text-gray-700" />
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $cat->name }}</td>
                    <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $cat->slug }}</td>
                    <td class="px-6 py-4 text-right font-bold text-indigo-600">{{ $cat->products_count }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}"
                               class="text-xs font-semibold text-gray-600 hover:text-indigo-600 px-3 py-1.5 rounded-lg border border-gray-200 hover:border-indigo-300 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-500 hover:text-red-700 px-3 py-1.5 rounded-lg border border-red-200 hover:border-red-400 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
</div>
@endsection
