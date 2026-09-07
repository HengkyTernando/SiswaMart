@extends('layouts.admin')

@section('title', 'Manajemen Penjual')
@section('page-title', 'Manajemen Penjual')

@section('content')

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-[var(--text-main)]">Daftar Penjual</h2>
            <p class="text-sm text-[var(--text-muted)] mt-1">Kelola akun penjual yang terdaftar di sistem.</p>
        </div>
        <a href="{{ route('admin.penjual.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Penjual Baru
        </a>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[var(--bg-hover)] border-b border-[var(--border-color)]">
                    <tr>
                        <th class="px-5 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider">Toko / Penjual</th>
                        <th class="px-5 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider">Lokasi / Kontak</th>
                        <th class="px-5 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider">Status Akun</th>
                        <th class="px-5 py-4 text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    @forelse($penjual as $p)
                    <tr class="hover:bg-[var(--bg-hover)] transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#e8f0fe] text-[#1a73e8] font-bold text-sm flex items-center justify-center flex-shrink-0">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-[var(--text-main)]">{{ $p->penjual?->nama_toko ?? 'Toko Belum Diatur' }}</div>
                                    <div class="text-xs text-[var(--text-muted)] mt-0.5">{{ $p->name }}</div>
                                    <div class="text-[10px] text-[var(--text-muted)]">{{ $p->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-[var(--text-main)] font-medium text-sm">{{ $p->penjual?->lokasi_kelas ?? '-' }}</div>
                            <div class="text-xs text-[var(--text-muted)] mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3 text-[#34a853]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $p->penjual?->nomor_whatsapp ?? '-' }}
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($p->is_active)
                                <span class="badge badge-aktif">Aktif</span>
                            @else
                                <span class="badge badge-ditolak">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.penjual.toggleStatus', $p) }}"
                                      onsubmit="return confirm('Ubah status akun penjual ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" 
                                            class="btn-outline text-xs px-2.5 py-1 {{ $p->is_active ? 'text-[#ea4335] border-[#ea4335] hover:bg-[#fce8e6]' : 'text-[#34a853] border-[#34a853] hover:bg-[#e6f4ea]' }}">
                                        {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.penjual.edit', $p) }}"
                                   class="btn-outline text-xs px-2.5 py-1">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.penjual.destroy', $p) }}"
                                      onsubmit="return confirm('PERINGATAN: Menghapus penjual juga akan menghapus user dan produknya secara permanen. Lanjutkan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-outline text-xs px-2.5 py-1 text-[#ea4335] border-[#ea4335] hover:bg-[#fce8e6]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-[var(--text-muted)]">
                            Belum ada akun penjual.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[var(--border-color)]">
            {{ $penjual->links() }}
        </div>
    </div>

@endsection