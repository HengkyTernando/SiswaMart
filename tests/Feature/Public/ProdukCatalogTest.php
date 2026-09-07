<?php

namespace Tests\Feature\Public;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukCatalogTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helpers ────────────────────────────────────────────────────────────

    private function makePenjual(array $overrides = []): Penjual
    {
        $user = User::factory()->create(['role' => 'penjual', 'is_active' => true]);
        return Penjual::create(array_merge([
            'user_id'          => $user->id,
            'nama_toko'        => 'Toko Public Test',
            'nomor_whatsapp'   => '08123456789',
            'lokasi_kelas'     => 'X',
        ], $overrides));
    }

    private function makeProduk(
        Penjual $penjual,
        string $status  = 'aktif',
        string $nama    = 'Produk Test',
        ?int   $kategoriId = null,
        string $deskripsi  = 'Deskripsi Test',
        int    $views   = 0
    ): Produk {
        $kategoriId = $kategoriId ?? Kategori::firstOrCreate(
            ['slug' => 'food'],
            ['nama' => 'Food']
        )->id;

        return Produk::create([
            'penjual_id'  => $penjual->id,
            'kategori_id' => $kategoriId,
            'nama'        => $nama,
            'slug'        => \Illuminate\Support\Str::slug($nama) . '-' . uniqid(),
            'deskripsi'   => $deskripsi,
            'harga'       => 1000,
            'stok'        => 'ready',
            'status'      => $status,
            'views'       => $views,
        ]);
    }

    // ─── Test 1: Guest dapat membuka homepage ───────────────────────────────

    public function test_guest_can_access_katalog_publik(): void
    {
        $this->get('/produk')->assertOk()->assertSee('Katalog Produk | SiswaMart');
    }

    // ─── Test 2: Homepage hanya menampilkan produk aktif ────────────────────

    public function test_only_aktif_produk_appear_in_katalog(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'aktif', 'Produk Aktif');
        $this->get('/produk')->assertSee('Produk Aktif');
    }

    // ─── Test 3: Produk pending tidak muncul ────────────────────────────────

    public function test_pending_produk_do_not_appear_in_katalog(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'pending', 'Produk Pending');

        $this->get('/produk')->assertDontSee('Produk Pending');
    }

    // ─── Test 4: Produk ditolak tidak muncul ────────────────────────────────

    public function test_ditolak_produk_do_not_appear_in_katalog(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'ditolak', 'Produk Ditolak');

        $this->get('/produk')->assertDontSee('Produk Ditolak');
    }

    // ─── Test 5: Search by nama bekerja ─────────────────────────────────────

    public function test_search_by_name_works(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'aktif', 'Nasi Goreng Spesial');
        $this->makeProduk($penjual, 'aktif', 'Mie Ayam Spesial');

        $this->get('/produk?q=Nasi+Goreng')
            ->assertSee('Nasi Goreng Spesial')
            ->assertDontSee('Mie Ayam Spesial');
    }

    // ─── Test 6: Search hanya mencari produk aktif ───────────────────────────

    public function test_search_only_finds_aktif_produk(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'aktif',   'Es Teh Aktif');
        $this->makeProduk($penjual, 'pending',  'Es Teh Pending');
        $this->makeProduk($penjual, 'ditolak',  'Es Teh Ditolak');

        $response = $this->get('/produk?q=Es+Teh');
        $response->assertSee('Es Teh Aktif');
        $response->assertDontSee('Es Teh Pending');
        $response->assertDontSee('Es Teh Ditolak');
    }

    // ─── Test 7: Filter kategori bekerja ────────────────────────────────────

    public function test_filter_by_kategori_works(): void
    {
        $penjual  = $this->makePenjual();
        $katFood  = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);
        $katDrink = Kategori::create(['nama' => 'Minuman', 'slug' => 'minuman']);

        $this->makeProduk($penjual, 'aktif', 'Ayam Geprek', $katFood->id);
        $this->makeProduk($penjual, 'aktif', 'Es Teh Manis', $katDrink->id);

        $this->get('/produk?kategori=makanan')
            ->assertSee('Ayam Geprek')
            ->assertDontSee('Es Teh Manis');
    }

    // ─── Test 8: Search + kategori dapat digunakan bersamaan ────────────────

    public function test_search_dan_kategori_dapat_digunakan_bersamaan(): void
    {
        $penjual  = $this->makePenjual();
        $katFood  = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);
        $katDrink = Kategori::create(['nama' => 'Minuman', 'slug' => 'minuman']);

        $this->makeProduk($penjual, 'aktif', 'Nasi Teh', $katFood->id);   // makanan + "teh"
        $this->makeProduk($penjual, 'aktif', 'Es Teh Manis', $katDrink->id); // minuman + "teh"
        $this->makeProduk($penjual, 'aktif', 'Nasi Goreng', $katFood->id);   // makanan, bukan "teh"

        // Harus tampil: hanya "Nasi Teh" (kategori makanan & mengandung "teh")
        $this->get('/produk?kategori=makanan&q=teh')
            ->assertSee('Nasi Teh')
            ->assertDontSee('Es Teh Manis')
            ->assertDontSee('Nasi Goreng');
    }

    // ─── Test 9: Detail produk aktif dapat dibuka ───────────────────────────

    public function test_detail_produk_aktif_can_be_accessed_via_slug(): void
    {
        $penjual = $this->makePenjual();
        $produk  = $this->makeProduk($penjual, 'aktif', 'Sate Ayam');

        $this->get("/produk/{$produk->slug}")
            ->assertOk()
            ->assertSee('Sate Ayam')
            ->assertSee('Toko Public Test');
    }

    // ─── Test 10: Detail produk nonaktif menghasilkan 404 ───────────────────

    public function test_detail_produk_nonaktif_returns_404(): void
    {
        $penjual = $this->makePenjual();
        $pending  = $this->makeProduk($penjual, 'pending', 'Pending');
        $ditolak  = $this->makeProduk($penjual, 'ditolak', 'Ditolak');

        $this->get("/produk/{$pending->slug}")->assertNotFound();
        $this->get("/produk/{$ditolak->slug}")->assertNotFound();
    }

    // ─── Test 11: View counter bertambah saat produk aktif dibuka ───────────

    public function test_view_counter_bertambah_saat_produk_aktif_dibuka(): void
    {
        $penjual = $this->makePenjual();
        $produk  = $this->makeProduk($penjual, 'aktif', 'Produk View Test', views: 10);

        $this->get("/produk/{$produk->slug}")->assertOk();

        $this->assertDatabaseHas('produk', [
            'id'    => $produk->id,
            'views' => 11,
        ]);
    }

    // ─── Test 12: View produk nonaktif tidak bertambah ──────────────────────

    public function test_view_counter_tidak_bertambah_untuk_produk_nonaktif(): void
    {
        $penjual = $this->makePenjual();
        $pending = $this->makeProduk($penjual, 'pending', 'Produk Pending Views', views: 5);

        // Harus 404, views tidak berubah
        $this->get("/produk/{$pending->slug}")->assertNotFound();

        $this->assertDatabaseHas('produk', [
            'id'    => $pending->id,
            'views' => 5,
        ]);
    }

    // ─── Test 13: Produk populer berdasarkan views ──────────────────────────

    public function test_produk_populer_berdasarkan_views(): void
    {
        $penjual = $this->makePenjual();
        $biasa   = $this->makeProduk($penjual, 'aktif', 'Produk Biasa',   views: 5);
        $populer = $this->makeProduk($penjual, 'aktif', 'Produk Populer', views: 500);

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Produk Populer');
    }

    // ─── Test 14: WhatsApp link dibuat dengan benar ──────────────────────────

    public function test_whatsapp_link_is_formatted_correctly(): void
    {
        $penjual = $this->makePenjual();
        // nomor_whatsapp = '08123456789' → harus jadi '628123456789'
        $produk  = $this->makeProduk($penjual, 'aktif', 'WA Test');

        $expectedWaLinkPart = 'https://wa.me/628123456789';

        $response = $this->get("/produk/{$produk->slug}");
        $this->assertTrue(
            str_contains($response->getContent(), $expectedWaLinkPart),
            "WhatsApp link '$expectedWaLinkPart' tidak ditemukan di halaman detail produk."
        );
    }

    // ─── Test 15: Penjual/toko ditampilkan dengan benar ─────────────────────

    public function test_penjual_info_ditampilkan_di_detail(): void
    {
        $penjual = $this->makePenjual(['nama_toko' => 'Kantin RPL', 'lokasi_kelas' => 'XI RPL 2']);
        $produk  = $this->makeProduk($penjual, 'aktif', 'Seblak Pedas');

        $response = $this->get("/produk/{$produk->slug}");
        $response->assertOk();
        $response->assertSee('Kantin RPL');
        $response->assertSee('XI RPL 2');
    }

    // ─── Test 16: Empty search result tidak menyebabkan error ───────────────

    public function test_empty_search_result_tidak_menyebabkan_error(): void
    {
        // Tanpa produk sama sekali
        $this->get('/produk?q=produk+yang+tidak+ada+sama+sekali+xyz')
            ->assertOk()
            ->assertSee('Produk tidak ditemukan');
    }

    // ─── Test legacy: search by description ─────────────────────────────────

    public function test_search_by_description_works(): void
    {
        $penjual = $this->makePenjual();
        $this->makeProduk($penjual, 'aktif', 'Buku Tulis', deskripsi: 'Buku tulis garis isi 38 lembar');
        $this->makeProduk($penjual, 'aktif', 'Pulpen Hitam', deskripsi: 'Tinta tebal');

        $this->get('/produk?q=38+lembar')
            ->assertSee('Buku Tulis')
            ->assertDontSee('Pulpen Hitam');
    }

    // ─── Test legacy: pagination ─────────────────────────────────────────────

    public function test_pagination_works(): void
    {
        $penjual = $this->makePenjual();
        for ($i = 0; $i < 13; $i++) {
            $this->makeProduk($penjual, 'aktif', 'Produk Item ' . $i);
        }

        $this->get('/produk')
            ->assertOk()
            ->assertSee('Produk Item 0');
    }
}
