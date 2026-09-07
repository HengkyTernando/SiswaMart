@extends('layouts.admin')

@section('title', 'Moderasi Ulasan')

@section('header')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Moderasi Ulasan</h2>
        <p class="mt-1 text-sm text-gray-600">
            Kelola ulasan dari pengunjung sebelum ditampilkan di halaman publik.
        </p>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start gap-3">
        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-900 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Produk</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Pengunjung & Rating</th>
                    <th scope="col" class="px-6 py-4 font-semibold w-1/3">Komentar</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Waktu</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($ulasan as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 align-top">
                            <div class="font-medium text-gray-900 truncate max-w-[150px]" title="{{ $item->produk->nama ?? 'Produk dihapus' }}">
                                {{ $item->produk->nama ?? 'Produk dihapus' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <div class="font-medium text-gray-900 mb-1">{{ $item->guest_username }}</div>
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $item->rating ? 'text-amber-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <div class="text-gray-600 line-clamp-3" title="{{ $item->komentar }}">
                                {{ $item->komentar ?: '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 align-top whitespace-nowrap text-xs text-gray-500">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 align-top whitespace-nowrap">
                            @if($item->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    Pending
                                </span>
                            @elseif($item->status === 'disetujui')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 align-top text-right whitespace-nowrap space-x-2">
                            @if($item->status === 'pending')
                                <form action="{{ route('admin.ulasan.approve', $item) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                                        Setujui
                                    </button>
                                </form>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('admin.ulasan.reject', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak ulasan ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">Termoderasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Belum ada ulasan yang masuk.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($ulasan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $ulasan->links() }}
        </div>
    @endif
</div>

@endsection
