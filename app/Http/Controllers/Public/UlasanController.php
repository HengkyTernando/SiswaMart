<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UlasanController extends Controller
{
    /**
     * Simpan ulasan guest baru (status = pending).
     */
    public function store(Request $request, Produk $produk): RedirectResponse
    {
        abort_if($produk->status !== 'aktif', 404);

        $validated = $request->validate([
            'guest_username' => ['required', 'string', 'max:100'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'komentar'       => ['nullable', 'string', 'max:1000'],
        ]);

        Ulasan::create([
            'produk_id'      => $produk->id,
            'guest_username' => $validated['guest_username'],
            'rating'         => $validated['rating'],
            'komentar'       => $validated['komentar'],
            'status'         => 'disetujui',
        ]);

        return redirect()->route('public.produk.show', $produk->slug)
            ->with('success', 'Ulasan berhasil dikirim.');
    }
}
