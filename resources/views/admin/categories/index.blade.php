@extends('layouts.app')
@section('title', 'Kelola Kategori – Admin SiswaMart')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                Kelola Kategori
            </h1>
            <p style="color:var(--clr-muted)" class="text-sm mt-1">{{ $categories->total() }} kategori terdaftar</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="btn-primary font-semibold px-5 py-2.5 rounded-xl text-sm flex items-center gap-2 glow">
            <span>+</span> Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-2xl text-sm font-medium flex items-center gap-2"
             style="background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.2);color:#34d399">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border overflow-hidden" style="background:var(--clr-card);border-color:var(--clr-border)">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead style="background:var(--clr-surface);border-bottom:1px solid var(--clr-border)">
                    <tr>
                        <th class="text-left px-6 py-4 font-semibold text-white">Icon</th>
                        <th class="text-left px-6 py-4 font-semibold text-white">Nama</th>
                        <th class="text-left px-6 py-4 font-semibold text-white">Slug</th>
                        <th class="text-right px-6 py-4 font-semibold text-white">Produk</th>
                        <th class="text-right px-6 py-4 font-semibold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color:var(--clr-border)">
                    @forelse ($categories as $cat)
                    <tr class="transition" onmouseover="this.style.background='var(--clr-surface)'" onmouseout="this.style.background='transparent'">
                        <td class="px-6 py-4">
                            <div style="color:var(--clr-purple-l)">
                                <x-category-icon :icon="$cat->icon ?? 'category'" class="w-7 h-7" />
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $cat->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs" style="color:var(--clr-muted)">{{ $cat->slug }}</td>
                        <td class="px-6 py-4 text-right font-black grad-text">{{ $cat->products_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                   style="color:var(--clr-muted);border:1px solid var(--clr-border)"
                                   onmouseover="this.style.borderColor='var(--clr-purple)';this.style.color='var(--clr-purple-l)'"
                                   onmouseout="this.style.borderColor='var(--clr-border)';this.style.color='var(--clr-muted)'">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                            style="color:#f87171;border:1px solid rgba(248,113,113,.2)"
                                            onmouseover="this.style.background='rgba(248,113,113,.1)'"
                                            onmouseout="this.style.background='transparent'">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center" style="color:var(--clr-muted)">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
</div>
@endsection
