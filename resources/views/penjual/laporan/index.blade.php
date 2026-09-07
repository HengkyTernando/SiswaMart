@extends('layouts.penjual')

@section('title', 'Laporan Promosi')
@section('page-title', 'Laporan Promosi')

@section('content')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[var(--text-main)]">Laporan Promosi</h2>
        <p class="text-[var(--text-muted)] mt-1 text-sm">Pantau seberapa sering produk Anda dilihat oleh pengunjung SiswaMart.</p>
    </div>

    {{-- Overview Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="stat-card flex items-center gap-5">
            <div class="w-14 h-14 bg-[#e8f0fe] text-[#1a73e8] rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-[var(--text-muted)]">Total Produk Keseluruhan</p>
                <p class="text-3xl font-display font-bold text-[var(--text-main)]">{{ number_format($totalProduk) }}</p>
            </div>
        </div>
        <div class="stat-card flex items-center gap-5">
            <div class="w-14 h-14 bg-[#e6f4ea] text-[#137333] rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-[var(--text-muted)]">Total Produk Dilihat</p>
                <p class="text-3xl font-display font-bold text-[var(--text-main)]">{{ number_format($totalViews) }} <span class="text-sm font-normal text-[var(--text-muted)]">kali</span></p>
            </div>
        </div>
    </div>

    {{-- Daftar Performa --}}
    <div class="admin-card">
        
        <div class="admin-card-header bg-[var(--bg-hover)] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="font-display font-semibold text-[var(--text-main)] text-base">Produk Terpopuler</h3>
            
            {{-- Filter Status --}}
            <div class="flex gap-1 bg-[var(--bg-body)] p-1 rounded-xl border border-[var(--border-color)]">
                <a href="{{ route('penjual.laporan', ['status' => 'semua']) }}" 
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg transition {{ $status === 'semua' ? 'bg-[var(--bg-surface)] text-[var(--text-main)] shadow-sm' : 'text-[var(--text-muted)] hover:text-[var(--text-main)]' }}">
                   Semua
                </a>
                <a href="{{ route('penjual.laporan', ['status' => 'aktif']) }}" 
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg transition {{ $status === 'aktif' ? 'bg-[var(--bg-surface)] text-[var(--text-main)] shadow-sm' : 'text-[var(--text-muted)] hover:text-[var(--text-main)]' }}">
                   Aktif
                </a>
                <a href="{{ route('penjual.laporan', ['status' => 'pending']) }}" 
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg transition {{ $status === 'pending' ? 'bg-[var(--bg-surface)] text-[var(--text-main)] shadow-sm' : 'text-[var(--text-muted)] hover:text-[var(--text-main)]' }}">
                   Pending
                </a>
                <a href="{{ route('penjual.laporan', ['status' => 'ditolak']) }}" 
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg transition {{ $status === 'ditolak' ? 'bg-[var(--bg-surface)] text-[var(--text-main)] shadow-sm' : 'text-[var(--text-muted)] hover:text-[var(--text-main)]' }}">
                   Ditolak
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="border-b border-[var(--border-color)] bg-[var(--bg-surface)]">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider w-16 text-center">Rank</th>
                        <th class="px-6 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider text-right">Views</th>
                        <th class="px-6 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    @forelse($produk as $idx => $item)
                    <tr class="hover:bg-[var(--bg-hover)] transition-colors">
                        <td class="px-6 py-4 text-center">
                            @php
                                $rank = $produk->firstItem() + $idx;
                            @endphp
                            @if($rank == 1) <span class="text-2xl" title="Peringkat 1">🥇</span>
                            @elseif($rank == 2) <span class="text-2xl" title="Peringkat 2">🥈</span>
                            @elseif($rank == 3) <span class="text-2xl" title="Peringkat 3">🥉</span>
                            @else <span class="text-[var(--text-muted)] font-semibold text-sm">#{{ $rank }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[var(--text-main)]">{{ $item->nama }}</div>
                        </td>
                        <td class="px-6 py-4 text-[var(--text-muted)] text-xs">{{ $item->kategori->nama }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center gap-1.5 text-[#1a73e8] font-bold">
                                {{ number_format($item->views) }} <span class="text-[10px] text-[var(--text-muted)] font-normal">dilihat</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="badge badge-{{ $item->status === 'aktif' ? 'aktif' : ($item->status === 'pending' ? 'pending' : ($item->status === 'ditolak' ? 'ditolak' : 'draft')) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-[var(--text-muted)]">
                            Belum ada data produk untuk ditampilkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-[var(--border-color)] bg-[var(--bg-surface)]">
            {{ $produk->links() }}
        </div>
    </div>

@endsection