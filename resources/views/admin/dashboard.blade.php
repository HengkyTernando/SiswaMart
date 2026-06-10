@extends('layouts.app')
@section('title', 'Dashboard Admin – SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-black text-white mb-2 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="28" height="28"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
        Dashboard Admin
    </h1>
    <p style="color:var(--clr-muted)" class="mb-8">Kelola seluruh ekosistem SiswaMart</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="text-2xl font-black text-white">{{ \App\Models\Category::count() }}</div>
            <div class="text-sm mt-0.5" style="color:var(--clr-muted)">Total Kategori</div>
            <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition">Kelola →</a>
        </div>
        <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
            <div class="text-2xl font-black text-white">{{ \App\Models\Product::count() }}</div>
            <div class="text-sm mt-0.5" style="color:var(--clr-muted)">Total Produk</div>
        </div>
        <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="text-2xl font-black text-white">{{ \App\Models\User::count() }}</div>
            <div class="text-sm mt-0.5" style="color:var(--clr-muted)">Total User</div>
        </div>
    </div>
</div>
@endsection
