@extends('layouts.app')
@section('title', 'Akun Saya – SiswaMart')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-black text-gray-900 mb-2">🛒 Akun Saya</h1>
    <p class="text-gray-500 mb-8">Selamat datang, {{ auth()->user()->name }}!</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="text-4xl mb-3">📋</div>
            <div class="text-gray-700 text-sm font-semibold mb-1">Pesanan Saya</div>
            <div class="text-2xl font-black text-gray-900">{{ auth()->user()->orders()->count() }}</div>
            <a href="{{ route('customer.orders') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="text-4xl mb-3">🛍️</div>
            <div class="text-gray-700 text-sm font-semibold mb-3">Mulai belanja</div>
            <a href="{{ route('home') }}"
               class="inline-block bg-indigo-600 text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                Belanja Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
