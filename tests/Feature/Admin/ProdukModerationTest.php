<?php

namespace Tests\Feature\Admin;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukModerationTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_active' => true]);
    }

    private function makePenjual(string $email = 'penjual@test.com'): User
    {
        $user = User::factory()->create(['role' => 'penjual', 'email' => $email, 'is_active' => true]);
        Penjual::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko ' . $user->id,
            'nomor_whatsapp' => '0800',
            'lokasi_kelas' => 'X',
        ]);
        return $user;
    }

    private function makeProduk($penjualUser, $status = 'pending', $nama = 'Produk Test'): Produk
    {
        $kategori = Kategori::firstOrCreate(['nama' => 'Food', 'slug' => 'food']);
        return Produk::create([
            'penjual_id' => $penjualUser->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => $nama,
            'slug' => \Illuminate\Support\Str::slug($nama) . '-' . uniqid(),
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
            'status' => $status,
        ]);
    }

    public function test_guest_cannot_access_moderasi_produk(): void
    {
        $this->get('/admin/produk')->assertRedirect('/login');
    }

    public function test_penjual_gets_403_when_accessing_admin_moderation(): void
    {
        $penjual = $this->makePenjual();
        $this->actingAs($penjual)->get('/admin/produk')->assertForbidden();
    }

    public function test_admin_can_view_daftar_produk(): void
    {
        $admin = $this->makeAdmin();
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'pending', 'Es Teh');

        $this->actingAs($admin)->get('/admin/produk')
            ->assertOk()
            ->assertSee('Es Teh');
    }

    public function test_admin_can_filter_produk_by_status(): void
    {
        $admin = $this->makeAdmin();
        $penjual = $this->makePenjual();
        
        $this->makeProduk($penjual, 'pending', 'Produk Pending');
        $this->makeProduk($penjual, 'aktif', 'Produk Aktif');

        $this->actingAs($admin)->get('/admin/produk?status=pending')
            ->assertOk()
            ->assertSee('Produk Pending')
            ->assertDontSee('Produk Aktif');
    }

    public function test_admin_can_view_produk_detail(): void
    {
        $admin = $this->makeAdmin();
        $penjual = $this->makePenjual();
        $produk = $this->makeProduk($penjual, 'pending', 'Produk Unik Detail');

        $this->actingAs($admin)->get("/admin/produk/{$produk->id}")
            ->assertOk()
            ->assertSee('Produk Unik Detail')
            ->assertSee('Simpan Keputusan');
    }

    public function test_admin_can_approve_pending_produk(): void
    {
        $admin = $this->makeAdmin();
        $penjual = $this->makePenjual();
        $produk = $this->makeProduk($penjual, 'pending');

        $this->actingAs($admin)->patch("/admin/produk/{$produk->id}/update-status", ['status' => 'aktif'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertEquals('aktif', $produk->fresh()->status);
    }

    public function test_admin_can_reject_pending_produk(): void
    {
        $admin = $this->makeAdmin();
        $penjual = $this->makePenjual();
        $produk = $this->makeProduk($penjual, 'pending');

        $this->actingAs($admin)->patch("/admin/produk/{$produk->id}/update-status", ['status' => 'ditolak', 'alasan_ditolak' => 'Tidak layak'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertEquals('ditolak', $produk->fresh()->status);
    }

    public function test_admin_can_moderate_products_from_different_penjuals(): void
    {
        $admin = $this->makeAdmin();
        $penjual1 = $this->makePenjual('p1@test.com');
        $penjual2 = $this->makePenjual('p2@test.com');
        
        $produk1 = $this->makeProduk($penjual1, 'pending', 'P1 Produk');
        $produk2 = $this->makeProduk($penjual2, 'pending', 'P2 Produk');

        $this->actingAs($admin)->patch("/admin/produk/{$produk1->id}/update-status", ['status' => 'aktif']);
        $this->actingAs($admin)->patch("/admin/produk/{$produk2->id}/update-status", ['status' => 'ditolak']);

        $this->assertEquals('aktif', $produk1->fresh()->status);
        $this->assertEquals('ditolak', $produk2->fresh()->status);
    }
}
