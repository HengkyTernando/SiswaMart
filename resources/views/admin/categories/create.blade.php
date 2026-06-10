@extends('layouts.app')
@section('title', 'Tambah Kategori – Admin SiswaMart')
@section('content')
<div class="max-w-xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm transition" style="color:var(--clr-muted)" onmouseover="this.style.color='var(--clr-purple-l)'" onmouseout="this.style.color='var(--clr-muted)'">← Kembali</a>
        <h1 class="text-2xl font-black text-white mt-2">Tambah Kategori</h1>
    </div>
    <div class="rounded-2xl border shadow-sm p-8" style="background:var(--clr-card);border-color:var(--clr-border)">
        @if ($errors->any())
            <div class="mb-5 p-4 rounded-xl text-sm font-semibold" style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);color:#f87171">
                @foreach ($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="input-dark w-full border rounded-xl px-4 py-3 text-sm transition">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Icon Key</label>
                <select name="icon" class="input-dark w-full border rounded-xl px-4 py-3 text-sm transition">
                    @foreach(['pencil' => 'Alat Tulis (pencil)', 'book' => 'Buku (book)', 'backpack' => 'Tas (backpack)', 'laptop' => 'Elektronik (laptop)', 'shirt' => 'Seragam (shirt)', 'sports' => 'Olahraga (sports)', 'category' => 'Lainnya (category)'] as $key => $label)
                        <option value="{{ $key }}" {{ old('icon') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2" style="color:var(--clr-muted)">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="input-dark w-full border rounded-xl px-4 py-3 text-sm transition resize-none">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn-primary w-full font-bold py-3 rounded-xl glow transition mt-2">
                Simpan Kategori
            </button>
        </form>
    </div>
</div>
@endsection
