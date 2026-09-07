<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenjualController extends Controller
{
    /**
     * Tampilkan daftar seluruh Penjual.
     */
    public function index(): View
    {
        $penjual = User::with('penjual')
            ->where('role', 'penjual')
            ->latest()
            ->paginate(15);

        return view('admin.penjual.index', compact('penjual'));
    }

    /**
     * Tampilkan form tambah Penjual.
     */
    public function create(): View
    {
        return view('admin.penjual.create');
    }

    /**
     * Simpan akun Penjual baru menggunakan DB transaction.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:8'],
            'nama_toko'      => ['required', 'string', 'max:255'],
            'deskripsi_toko' => ['nullable', 'string'],
            'nomor_whatsapp' => ['required', 'string', 'max:20'],
            'lokasi_kelas'   => ['required', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'penjual',
                'is_active' => true,
            ]);

            $user->penjual()->create([
                'nama_toko'      => $request->nama_toko,
                'deskripsi_toko' => $request->deskripsi_toko,
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'lokasi_kelas'   => $request->lokasi_kelas,
            ]);
        });

        return redirect()
            ->route('admin.penjual.index')
            ->with('success', 'Akun Penjual berhasil dibuat.');
    }

    /**
     * Tampilkan form edit Penjual.
     */
    public function edit(User $penjual): View
    {
        abort_unless($penjual->role === 'penjual', 404);

        $penjual->load('penjual');

        return view('admin.penjual.edit', compact('penjual'));
    }

    /**
     * Perbarui data Penjual.
     */
    public function update(Request $request, User $penjual): RedirectResponse
    {
        abort_unless($penjual->role === 'penjual', 404);

        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', Rule::unique('users', 'email')->ignore($penjual->id)],
            'password'       => ['nullable', 'string', 'min:8'],
            'nama_toko'      => ['required', 'string', 'max:255'],
            'deskripsi_toko' => ['nullable', 'string'],
            'nomor_whatsapp' => ['required', 'string', 'max:20'],
            'lokasi_kelas'   => ['required', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($request, $penjual) {
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $penjual->update($userData);

            $penjual->penjual()->updateOrCreate(
                ['user_id' => $penjual->id],
                [
                    'nama_toko'      => $request->nama_toko,
                    'deskripsi_toko' => $request->deskripsi_toko,
                    'nomor_whatsapp' => $request->nomor_whatsapp,
                    'lokasi_kelas'   => $request->lokasi_kelas,
                ]
            );
        });

        return redirect()
            ->route('admin.penjual.index')
            ->with('success', 'Data Penjual berhasil diperbarui.');
    }

    /**
     * Toggle status aktif/nonaktif Penjual.
     * Hanya berlaku untuk user dengan role penjual.
     */
    public function toggleStatus(User $penjual): RedirectResponse
    {
        abort_unless($penjual->role === 'penjual', 404);

        $penjual->update(['is_active' => ! $penjual->is_active]);

        $status = $penjual->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.penjual.index')
            ->with('success', "Akun Penjual berhasil {$status}.");
    }

    /**
     * Hapus akun Penjual beserta profil dan produknya (CASCADE).
     * Aman karena penjual.user_id ON DELETE CASCADE dan
     * produk.penjual_id ON DELETE CASCADE sudah dikonfigurasi di migration.
     */
    public function destroy(User $penjual): RedirectResponse
    {
        abort_unless($penjual->role === 'penjual', 404);

        $penjual->delete();

        return redirect()
            ->route('admin.penjual.index')
            ->with('success', 'Akun Penjual beserta data terkait berhasil dihapus.');
    }
}
