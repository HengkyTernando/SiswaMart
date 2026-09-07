<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Tampilkan katalog produk untuk pengunjung.
     */
    public function index(Request $request): View
    {
        $search          = $request->query('q');
        $selectedKategori = $request->query('kategori');

        // ── Query utama: produk aktif ──────────────────────────────────────
        $query = Produk::with(['kategori', 'penjual'])
            ->where('status', 'aktif')
            ->latest();

        // Pencarian (q)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter Kategori (kategori)
        if ($selectedKategori) {
            $query->whereHas('kategori', function ($q) use ($selectedKategori) {
                $q->where('slug', $selectedKategori);
            });
        }

        $produk = $query->paginate(12)->withQueryString();
        $kategoriList = Kategori::withCount(['produk' => function ($q) {
            $q->where('status', 'aktif');
        }])->orderBy('nama')->get();

        return view('public.produk.index', compact(
            'produk',
            'kategoriList',
            'selectedKategori',
            'search'
        ));
    }

    /**
     * Tampilkan detail produk.
     * Hanya produk aktif yang dapat diakses; increment views untuk produk aktif.
     */
    public function show(Produk $produk): View
    {
        // Pastikan hanya produk aktif yang bisa diakses
        abort_if($produk->status !== 'aktif', 404);

        // Tambah counter view (hanya produk aktif, dari halaman public)
        $produk->increment('views');

        $produk->load(['kategori', 'penjual.user']);

        // Ulasan yang disetujui
        $ulasan = $produk->ulasan()
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        // Produk Terkait (kategori sama, aktif, tidak termasuk diri sendiri)
        $produkTerkait = Produk::with(['kategori', 'penjual'])
            ->withAvg(['ulasan' => fn($q) => $q->where('status', 'disetujui')], 'rating')
            ->where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->where('status', 'aktif')
            ->latest()
            ->limit(4)
            ->get();

        return view('public.produk.show', compact('produk', 'ulasan', 'produkTerkait'));
    }
}
