<?php

namespace Tests\Feature\Penjual;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPromosiTest extends TestCase
{
    use RefreshDatabase;

    private function makePenjual(string $email = 'penjual@test.com', string $namaToko = 'Toko Test'): User
    {
        $user = User::factory()->create(['role' => 'penjual', 'email' => $email, 'is_active' => true]);
        Penjual::create([
            'user_id' => $user->id,
            'nama_toko' => $namaToko,
            'nomor_whatsapp' => '08000000',
            'lokasi_kelas' => 'X',
        ]);
        return $user;
    }

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_active' => true]);
    }

    private function makeProduk($penjualId, $status = 'aktif', $views = 0): Produk
    {
        $kategori = Kategori::firstOrCreate(['nama' => 'Makanan', 'slug' => 'makanan']);
        return Produk::create([
            'penjual_id' => $penjualId,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk Test ' . uniqid(),
            'slug' => 'produk-test-' . uniqid(),
            'deskripsi' => 'Deskripsi',
            'harga' => 1000,
            'stok' => 'ready',
            'status' => $status,
            'views' => $views,
        ]);
    }

    public function test_guest_cannot_access_dashboard_penjual(): void
    {
        $this->get('/penjual/dashboard')->assertRedirect('/login');
    }

    public function test_user_non_penjual_cannot_access_dashboard_penjual(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get('/penjual/dashboard')->assertForbidden();
    }

    public function test_penjual_can_access_dashboard(): void
    {
        $penjual = $this->makePenjual();
        $this->actingAs($penjual)->get('/penjual/dashboard')->assertOk();
    }

    public function test_total_produk_and_views_hanya_menghitung_milik_penjual(): void
    {
        $penjual1 = $this->makePenjual('p1@test.com');
        $penjual2 = $this->makePenjual('p2@test.com');

        $this->makeProduk($penjual1->penjual->id, 'aktif', 10);
        $this->makeProduk($penjual1->penjual->id, 'pending', 5);
        $this->makeProduk($penjual2->penjual->id, 'aktif', 888);

        $response = $this->actingAs($penjual1)->get('/penjual/dashboard');
        
        $response->assertOk();
        // Total Produk p1: 2, Produk Aktif p1: 1, Pending: 1, Total Views: 15
        $response->assertSee('2'); // Total Produk
        $response->assertSee('15'); // Total Dilihat (10 + 5)
        $response->assertDontSee('888'); // Views punya P2
    }

    public function test_view_produk_aktif_bertambah_ketika_halaman_publik_dibuka(): void
    {
        $penjual = $this->makePenjual();
        $produk = $this->makeProduk($penjual->penjual->id, 'aktif', 0);

        $this->assertEquals(0, $produk->fresh()->views);

        $this->get("/produk/{$produk->slug}");

        $this->assertEquals(1, $produk->fresh()->views);
    }

    public function test_view_produk_pending_atau_ditolak_tidak_bertambah(): void
    {
        $penjual = $this->makePenjual();
        $pending = $this->makeProduk($penjual->penjual->id, 'pending', 0);
        $ditolak = $this->makeProduk($penjual->penjual->id, 'ditolak', 0);

        $this->get("/produk/{$pending->slug}")->assertNotFound();
        $this->get("/produk/{$ditolak->slug}")->assertNotFound();

        $this->assertEquals(0, $pending->fresh()->views);
        $this->assertEquals(0, $ditolak->fresh()->views);
    }

    public function test_view_dari_halaman_management_penjual_tidak_menambah_counter(): void
    {
        $penjual = $this->makePenjual();
        $produk = $this->makeProduk($penjual->penjual->id, 'aktif', 0);

        $this->actingAs($penjual)->get("/penjual/produk/{$produk->id}/edit")->assertOk();

        $this->assertEquals(0, $produk->fresh()->views);
    }

    public function test_penjual_dapat_melihat_laporan_promosinya(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual->penjual->id, 'aktif', 425);

        $this->actingAs($penjual)
             ->get('/penjual/laporan')
             ->assertOk()
             ->assertSee('Laporan Promosi')
             ->assertSee('425');
    }

    public function test_produk_terpopuler_diurutkan_berdasarkan_views_desc(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual->penjual->id, 'aktif', 10);
        $this->makeProduk($penjual->penjual->id, 'aktif', 100);
        $this->makeProduk($penjual->penjual->id, 'aktif', 50);

        $response = $this->actingAs($penjual)->get('/penjual/laporan');
        
        $response->assertOk();
        // Since we can't easily assert view order via string, we assert the variable passed to view
        $produkList = $response->viewData('produk');
        
        $this->assertEquals(100, $produkList[0]->views);
        $this->assertEquals(50, $produkList[1]->views);
        $this->assertEquals(10, $produkList[2]->views);
    }
}
