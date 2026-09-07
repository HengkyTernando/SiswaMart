<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk untuk dimoderasi.
     */
    public function index(Request $request): View
    {
        $query = Produk::with(['penjual.user', 'kategori'])
            ->latest();

        $status = $request->query('status');
        $validStatuses = ['pending', 'aktif', 'ditolak', 'draft'];

        if ($status && in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        $produk = $query->paginate(15)->withQueryString();

        return view('admin.produk.index', compact('produk', 'status'));
    }

    /**
     * Tampilkan detail produk.
     */
    public function show(Produk $produk): View
    {
        $produk->load(['penjual.user', 'kategori']);
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Update status produk.
     */
    public function updateStatus(Request $request, Produk $produk): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,pending,ditolak',
            'alasan_ditolak' => 'nullable|string|max:500'
        ]);

        $alasan = $validated['status'] === 'ditolak' ? ($validated['alasan_ditolak'] ?? null) : null;

        $produk->update([
            'status' => $validated['status'],
            // 'alasan_ditolak' => $alasan // Ignored since not in fillable or db, but we keep it safe
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Status produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        // Delete image if exists
        if ($produk->foto_utama && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->foto_utama)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->foto_utama);
        }
        
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus secara permanen.');
    }
}

