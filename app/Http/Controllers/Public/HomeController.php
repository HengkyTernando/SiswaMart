<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (storefront promosi).
     */
    public function index(): View
    {
        // 1. Kategori
        $kategoriList = Kategori::orderBy('nama')->get();

        // 2. Rekomendasi Produk (5 item)
        $produkRekomendasi = Produk::with(['kategori', 'penjual'])
            ->withAvg(['ulasan' => fn($q) => $q->where('status', 'disetujui')], 'rating')
            ->where('status', 'aktif')
            ->orderByDesc('ulasan_avg_rating')
            ->orderByDesc('views')
            ->latest()
            ->limit(5)
            ->get();
            
        // 3. Produk Populer (Top 3 views)
        $produkPopuler = Produk::with(['kategori', 'penjual'])
            ->where('status', 'aktif')
            ->orderByDesc('views')
            ->limit(3)
            ->get();
            
        // 4. Statistik Dashboard
        $totalProduk = Produk::where('status', 'aktif')->count();
        $totalPenjual = Penjual::count();
        $totalKategori = Kategori::count();

        return view('public.home.index', compact(
            'kategoriList', 
            'produkRekomendasi', 
            'produkPopuler',
            'totalProduk',
            'totalPenjual',
            'totalKategori'
        ));
    }
}
