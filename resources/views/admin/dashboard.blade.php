@extends('layouts.app')
@section('title', 'Dashboard Admin – SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-black text-gray-900 mb-2">👑 Dashboard Admin</h1>
    <p class="text-gray-500 mb-8">Kelola seluruh ekosistem SiswaMart</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="text-4xl mb-3">📂</div>
            <div class="text-2xl font-black text-gray-900">{{ \App\Models\Category::count() }}</div>
            <div class="text-gray-500 text-sm">Total Kategori</div>
            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:underline">Kelola →</a>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="text-4xl mb-3">📦</div>
            <div class="text-2xl font-black text-gray-900">{{ \App\Models\Product::count() }}</div>
            <div class="text-gray-500 text-sm">Total Produk</div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="text-4xl mb-3">👥</div>
            <div class="text-2xl font-black text-gray-900">{{ \App\Models\User::count() }}</div>
            <div class="text-gray-500 text-sm">Total User</div>
        </div>
    </div>
</div>
@endsection
