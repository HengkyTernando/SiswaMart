<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Pastikan User login memiliki profil Penjual.
     */
    private function getPenjualId()
    {
        $penjual = auth()->user()->penjual;
        abort_unless($penjual, 403, 'Profil penjual tidak ditemukan.');
        return $penjual->id;
    }

    /**
     * Tampilkan daftar produk milik penjual.
     */
    public function index(): View
    {
        $penjualId = $this->getPenjualId();

        $produk = Produk::with('kategori')
            ->where('penjual_id', $penjualId)
            ->latest()
            ->paginate(15);

        return view('penjual.produk.index', compact('produk'));
    }

    /**
     * Tampilkan form tambah produk.
     */
    public function create(): View
    {
        // Pastikan punya profil penjual
        $this->getPenjualId();

        $kategori = Kategori::orderBy('nama')->get();

        return view('penjual.produk.create', compact('kategori'));
    }

    /**
     * Hasilkan slug unik.
     */
    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $slug = Str::slug($nama);
        $originalSlug = $slug;
        $count = 1;

        while (Produk::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $penjualId = $this->getPenjualId();

        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'kategori_id'   => ['required', 'exists:kategori,id'],
            'deskripsi'     => ['required', 'string'],
            'harga'         => ['required', 'numeric', 'min:0'],
            'stok'          => ['required', 'in:tersedia,habis'],
            'label_promosi' => ['nullable', 'string', 'max:100'],
            'foto_utama'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['penjual_id'] = $penjualId;
        $validated['slug']       = $this->generateUniqueSlug($request->nama);
        $validated['status']     = 'pending';

        // Konversi nilai 'tersedia' ke 'ready' dan 'habis' ke 'habis' sesuai enum db
        // Enum stok: 'ready', 'po', 'habis' -> user instruksinya tersedia/habis, 
        // kita mapping tersedia -> ready.
        $stokMapping = ['tersedia' => 'ready', 'habis' => 'habis'];
        $validated['stok'] = $stokMapping[$request->stok];

        if ($request->hasFile('foto_utama')) {
            $validated['foto_utama'] = $request->file('foto_utama')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan dan menunggu moderasi.');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Produk $produk): View
    {
        $penjualId = $this->getPenjualId();
        abort_unless($produk->penjual_id === $penjualId, 403, 'Akses ditolak.');

        $kategori = Kategori::orderBy('nama')->get();

        return view('penjual.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $penjualId = $this->getPenjualId();
        abort_unless($produk->penjual_id === $penjualId, 403, 'Akses ditolak.');

        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'kategori_id'   => ['required', 'exists:kategori,id'],
            'deskripsi'     => ['required', 'string'],
            'harga'         => ['required', 'numeric', 'min:0'],
            'stok'          => ['required', 'in:tersedia,habis'],
            'label_promosi' => ['nullable', 'string', 'max:100'],
            'foto_utama'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->nama !== $produk->nama) {
            $validated['slug'] = $this->generateUniqueSlug($request->nama, $produk->id);
        }

        $stokMapping = ['tersedia' => 'ready', 'habis' => 'habis'];
        $validated['stok'] = $stokMapping[$request->stok];

        if ($request->hasFile('foto_utama')) {
            if ($produk->foto_utama) {
                Storage::disk('public')->delete($produk->foto_utama);
            }
            $validated['foto_utama'] = $request->file('foto_utama')->store('produk', 'public');
        }

        // Jika sebelumnya aktif atau ditolak, ubah kembali ke pending
        if (in_array($produk->status, ['aktif', 'ditolak'])) {
            $validated['status'] = 'pending';
        }

        $produk->update($validated);

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        $penjualId = $this->getPenjualId();
        abort_unless($produk->penjual_id === $penjualId, 403, 'Akses ditolak.');

        if ($produk->foto_utama) {
            Storage::disk('public')->delete($produk->foto_utama);
        }

        $produk->delete();

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
