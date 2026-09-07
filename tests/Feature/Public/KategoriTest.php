<?php

namespace Tests\Feature\Public;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    private function makePenjual(): Penjual
    {
        $user = User::factory()->create(['role' => 'penjual', 'is_active' => true]);
        return Penjual::create([
            'user_id'          => $user->id,
            'nama_toko'        => 'Toko Public Test',
            'nomor_whatsapp'   => '08123456789',
            'lokasi_kelas'     => 'X',
        ]);
    }

    public function test_kategori_index_can_be_accessed(): void
    {
        $penjual = $this->makePenjual();
        $k1 = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);
        $k2 = Kategori::create(['nama' => 'Minuman', 'slug' => 'minuman']);

        Produk::create(['penjual_id' => $penjual->id, 'kategori_id' => $k1->id, 'nama' => 'P1', 'slug' => 'p1', 'harga' => 1000, 'status' => 'aktif']);
        Produk::create(['penjual_id' => $penjual->id, 'kategori_id' => $k2->id, 'nama' => 'P2', 'slug' => 'p2', 'harga' => 1000, 'status' => 'aktif']);

        $response = $this->get('/kategori');
        $response->assertOk();
        $response->assertSee('Makanan');
        $response->assertSee('Minuman');
    }

    public function test_kategori_show_displays_active_products_only(): void
    {
        $kategori = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);
        $penjual = $this->makePenjual();

        Produk::create([
            'penjual_id' => $penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk Aktif',
            'slug' => 'produk-aktif',
            'harga' => 1000,
            'status' => 'aktif'
        ]);

        Produk::create([
            'penjual_id' => $penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk Pending',
            'slug' => 'produk-pending',
            'harga' => 1000,
            'status' => 'pending'
        ]);

        $response = $this->get('/kategori/' . $kategori->slug);
        $response->assertOk();
        $response->assertSee('Produk Aktif');
        $response->assertDontSee('Produk Pending');
    }
}
