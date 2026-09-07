<?php

namespace Tests\Feature\Admin;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use App\Models\Ulasan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UlasanModerationTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_active' => true]);
    }
    
    private function makePenjualUser(): User
    {
        return User::factory()->create(['role' => 'penjual', 'is_active' => true]);
    }

    private function createUlasan(): Ulasan
    {
        $user = User::factory()->create(['role' => 'penjual', 'is_active' => true]);
        $penjual = Penjual::create([
            'user_id'          => $user->id,
            'nama_toko'        => 'Toko',
            'nomor_whatsapp'   => '08123',
        ]);
        $kategori = Kategori::create(['nama' => 'Cat', 'slug' => 'cat']);
        $produk = Produk::create([
            'penjual_id' => $penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Prod',
            'slug' => 'prod',
            'harga' => 10,
            'status' => 'aktif'
        ]);

        return Ulasan::create([
            'produk_id' => $produk->id,
            'guest_username' => 'Guest',
            'rating' => 5,
            'komentar' => 'Pending comment',
            'status' => 'pending'
        ]);
    }

    public function test_admin_can_access_ulasan_index(): void
    {
        $admin = $this->makeAdmin();
        $ulasan = $this->createUlasan();

        $response = $this->actingAs($admin)->get('/admin/ulasan');
        $response->assertOk();
        $response->assertSee('Guest');
        $response->assertSee('Pending comment');
    }

    public function test_penjual_cannot_access_ulasan_index(): void
    {
        $penjual = $this->makePenjualUser();
        $this->actingAs($penjual)->get('/admin/ulasan')->assertForbidden();
    }

    public function test_guest_cannot_access_ulasan_index(): void
    {
        $this->get('/admin/ulasan')->assertRedirect('/login');
    }

    public function test_admin_can_approve_ulasan(): void
    {
        $admin = $this->makeAdmin();
        $ulasan = $this->createUlasan();

        $response = $this->actingAs($admin)->patch("/admin/ulasan/{$ulasan->id}/approve");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('ulasan', [
            'id' => $ulasan->id,
            'status' => 'disetujui'
        ]);
    }

    public function test_admin_can_reject_ulasan(): void
    {
        $admin = $this->makeAdmin();
        $ulasan = $this->createUlasan();

        $response = $this->actingAs($admin)->patch("/admin/ulasan/{$ulasan->id}/reject");
        $response->assertRedirect();
        
        $this->assertDatabaseHas('ulasan', [
            'id' => $ulasan->id,
            'status' => 'ditolak'
        ]);
    }
}
