@extends('layouts.app')
@section('title', 'Akun Saya – SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-black text-white mb-2 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="28" height="28"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Akun Saya
    </h1>
    <p style="color:var(--clr-muted)" class="mb-8">Selamat datang, {{ auth()->user()->name }}!</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
            </div>
            <div class="text-sm font-semibold mb-1" style="color:var(--clr-muted)">Pesanan Saya</div>
            <div class="text-2xl font-black text-white">{{ auth()->user()->orders()->count() }}</div>
            <a href="{{ route('customer.orders') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition">Lihat Semua →</a>
        </div>
        <div class="rounded-2xl p-6" style="background:var(--clr-card);border:1px solid var(--clr-border)">
            <div class="mb-3 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
            <div class="text-sm font-semibold mb-3" style="color:var(--clr-muted)">Mulai belanja</div>
            <a href="{{ route('home') }}"
               class="inline-block bg-indigo-600 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                Belanja Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
