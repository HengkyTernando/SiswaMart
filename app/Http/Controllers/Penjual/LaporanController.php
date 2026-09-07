<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan promosi.
     */
    public function index(Request $request): View
    {
        $penjualId = auth()->user()->penjual->id;
        $status = $request->query('status', 'aktif'); // default 'aktif'

        $query = \App\Models\Produk::with('kategori')->where('penjual_id', $penjualId);

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $produk = $query->orderByDesc('views')->paginate(15)->withQueryString();

        $totalProduk = \App\Models\Produk::where('penjual_id', $penjualId)->count();
        $totalViews = \App\Models\Produk::where('penjual_id', $penjualId)->sum('views');

        return view('penjual.laporan.index', compact('produk', 'status', 'totalProduk', 'totalViews'));
    }
}
