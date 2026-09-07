<?php

namespace Tests\Feature\Admin;

use App\Models\Penjual;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PenjualManagementTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helper: buat Admin ───────────────────────────────────────────────────
    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_active' => true]);
    }

    // ─── Helper: buat Penjual dengan profil ──────────────────────────────────
    private function makePenjual(array $overrides = []): User
    {
        $user = User::factory()->create(array_merge([
            'role'      => 'penjual',
            'is_active' => true,
        ], $overrides));

        Penjual::create([
            'user_id'        => $user->id,
            'nama_toko'      => 'Toko Test',
            'nomor_whatsapp' => '08123456789',
            'lokasi_kelas'   => 'X RPL 1',
        ]);

        return $user;
    }

    // ─── Helper: payload untuk store ─────────────────────────────────────────
    private function penjualPayload(array $overrides = []): array
    {
        return array_merge([
            'name'           => 'Penjual Baru',
            'email'          => 'penjualbaru@test.test',
            'password'       => 'password123',
            'nama_toko'      => 'Toko Baru',
            'deskripsi_toko' => 'Deskripsi toko',
            'nomor_whatsapp' => '08999999999',
            'lokasi_kelas'   => 'XI TKJ 2',
        ], $overrides);
    }

    // ─── Test 1: Guest tidak bisa akses /admin/penjual ────────────────────────
    public function test_guest_cannot_access_penjual_management(): void
    {
        $this->get('/admin/penjual')->assertRedirect('/login');
    }

    // ─── Test 2: Penjual tidak bisa akses fitur Admin ────────────────────────
    public function test_penjual_cannot_access_penjual_management(): void
    {
        $penjual = $this->makePenjual();
        $this->actingAs($penjual)->get('/admin/penjual')->assertForbidden();
    }

    // ─── Test 3: Admin bisa melihat daftar Penjual ───────────────────────────
    public function test_admin_can_view_penjual_list(): void
    {
        $admin = $this->makeAdmin();
        $this->makePenjual();

        $this->actingAs($admin)
            ->get('/admin/penjual')
            ->assertOk()
            ->assertSee('Manajemen Penjual');
    }

    // ─── Test 4 & 5: Admin bisa membuat Penjual, data tersimpan di dua tabel ─
    public function test_admin_can_create_penjual_with_both_tables(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->post('/admin/penjual', $this->penjualPayload())
            ->assertRedirect(route('admin.penjual.index'));

        // Cek tabel users
        $this->assertDatabaseHas('users', [
            'email' => 'penjualbaru@test.test',
            'role'  => 'penjual',
        ]);

        // Cek tabel penjual
        $user = User::where('email', 'penjualbaru@test.test')->first();
        $this->assertDatabaseHas('penjual', [
            'user_id'   => $user->id,
            'nama_toko' => 'Toko Baru',
        ]);
    }

    // ─── Test 6: Password tersimpan dalam bentuk hash ────────────────────────
    public function test_password_is_stored_hashed(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)
            ->post('/admin/penjual', $this->penjualPayload(['password' => 'secret123']));

        $user = User::where('email', 'penjualbaru@test.test')->first();
        $this->assertTrue(Hash::check('secret123', $user->password));
        $this->assertNotEquals('secret123', $user->password);
    }

    // ─── Test 7: Admin bisa mengedit Penjual ─────────────────────────────────
    public function test_admin_can_update_penjual(): void
    {
        $admin   = $this->makeAdmin();
        $penjual = $this->makePenjual();

        $this->actingAs($admin)
            ->put("/admin/penjual/{$penjual->id}", $this->penjualPayload([
                'email'    => $penjual->email,
                'name'     => 'Nama Diubah',
                'nama_toko'=> 'Toko Diubah',
            ]))
            ->assertRedirect(route('admin.penjual.index'));

        $this->assertDatabaseHas('users', ['id' => $penjual->id, 'name' => 'Nama Diubah']);
        $this->assertDatabaseHas('penjual', ['user_id' => $penjual->id, 'nama_toko' => 'Toko Diubah']);
    }

    // ─── Test 8: Password tidak berubah jika input kosong ────────────────────
    public function test_password_unchanged_when_not_provided_on_update(): void
    {
        $admin          = $this->makeAdmin();
        $penjual        = $this->makePenjual();
        $oldPasswordHash = $penjual->password;

        $this->actingAs($admin)
            ->put("/admin/penjual/{$penjual->id}", $this->penjualPayload([
                'email'    => $penjual->email,
                'password' => '',   // kosong = tidak diubah
            ]));

        $this->assertEquals($oldPasswordHash, $penjual->fresh()->password);
    }

    // ─── Test 9: Admin dapat menonaktifkan Penjual ───────────────────────────
    public function test_admin_can_deactivate_penjual(): void
    {
        $admin   = $this->makeAdmin();
        $penjual = $this->makePenjual(['is_active' => true]);

        $this->actingAs($admin)
            ->patch("/admin/penjual/{$penjual->id}/toggle-status")
            ->assertRedirect(route('admin.penjual.index'));

        $this->assertFalse((bool) $penjual->fresh()->is_active);
    }

    // ─── Test 10: Penjual nonaktif tidak bisa login ───────────────────────────
    public function test_deactivated_penjual_cannot_login(): void
    {
        $penjual = $this->makePenjual(['is_active' => false]);

        $this->post('/login', [
            'email'    => $penjual->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    // ─── Test 11: Admin dapat mengaktifkan kembali Penjual ────────────────────
    public function test_admin_can_reactivate_penjual(): void
    {
        $admin   = $this->makeAdmin();
        $penjual = $this->makePenjual(['is_active' => false]);

        $this->actingAs($admin)
            ->patch("/admin/penjual/{$penjual->id}/toggle-status")
            ->assertRedirect(route('admin.penjual.index'));

        $this->assertTrue((bool) $penjual->fresh()->is_active);
    }

    // ─── Test 12: Penghapusan Penjual aman, tidak ada data orphan ─────────────
    public function test_deleting_penjual_cascades_cleanly(): void
    {
        $admin   = $this->makeAdmin();
        $penjual = $this->makePenjual();
        $userId  = $penjual->id;

        $this->actingAs($admin)
            ->delete("/admin/penjual/{$userId}")
            ->assertRedirect(route('admin.penjual.index'));

        // User terhapus
        $this->assertDatabaseMissing('users', ['id' => $userId]);

        // Profil penjual juga terhapus (CASCADE)
        $this->assertDatabaseMissing('penjual', ['user_id' => $userId]);
    }
}
