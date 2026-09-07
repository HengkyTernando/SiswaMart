<?php

namespace Tests\Feature\Penjual;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProdukManagementTest extends TestCase
{
    use RefreshDatabase;

    private function makePenjual(string $email = 'penjual@test.test'): User
    {
        $user = User::factory()->create(['role' => 'penjual', 'email' => $email, 'is_active' => true]);
        Penjual::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko ' . $user->id,
            'nomor_whatsapp' => '08000000',
            'lokasi_kelas' => 'X',
        ]);
        return $user;
    }

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'is_active' => true]);
    }

    private function makeKategori(): Kategori
    {
        return Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);
    }

    public function test_guest_cannot_access_produk(): void
    {
        $this->get('/penjual/produk')->assertRedirect('/login');
    }

    public function test_admin_cannot_access_produk_penjual(): void
    {
        $admin = $this->makeAdmin();
        $this->actingAs($admin)->get('/penjual/produk')->assertForbidden();
    }

    public function test_penjual_can_view_own_produk_but_not_others(): void
    {
        $penjual1 = $this->makePenjual('p1@test.com');
        $penjual2 = $this->makePenjual('p2@test.com');
        $kategori = $this->makeKategori();

        Produk::create([
            'penjual_id' => $penjual1->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk P1',
            'slug' => 'produk-p1',
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
        ]);

        Produk::create([
            'penjual_id' => $penjual2->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk P2',
            'slug' => 'produk-p2',
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
        ]);

        $this->actingAs($penjual1)
            ->get('/penjual/produk')
            ->assertSee('Produk P1')
            ->assertDontSee('Produk P2');
    }

    public function test_penjual_can_create_produk_with_pending_status_and_correct_penjual_id(): void
    {
        Storage::fake('public');

        $penjual = $this->makePenjual();
        $kategori = $this->makeKategori();

        $file = UploadedFile::fake()->image('produk.jpg');

        $this->actingAs($penjual)->post('/penjual/produk', [
            'nama' => 'Es Teh Manis',
            'kategori_id' => $kategori->id,
            'deskripsi' => 'Segar',
            'harga' => 5000,
            'stok' => 'tersedia', // Sesuai form UI
            'foto_utama' => $file,
        ])->assertRedirect(route('penjual.produk.index'));

        $this->assertDatabaseHas('produk', [
            'penjual_id' => $penjual->penjual->id,
            'nama' => 'Es Teh Manis',
            'slug' => 'es-teh-manis',
            'status' => 'pending',
            'stok' => 'ready', // Terkonversi di backend
        ]);

        $produk = Produk::where('nama', 'Es Teh Manis')->first();
        Storage::disk('public')->assertExists($produk->foto_utama);
    }

    public function test_penjual_cannot_edit_other_penjuals_produk(): void
    {
        $penjual1 = $this->makePenjual('p1@test.com');
        $penjual2 = $this->makePenjual('p2@test.com');
        $kategori = $this->makeKategori();

        $produkP1 = Produk::create([
            'penjual_id' => $penjual1->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk P1',
            'slug' => 'produk-p1',
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
        ]);

        $this->actingAs($penjual2)->get("/penjual/produk/{$produkP1->id}/edit")->assertForbidden();
        $this->actingAs($penjual2)->put("/penjual/produk/{$produkP1->id}", [
            'nama' => 'Hack', 'kategori_id' => $kategori->id, 'deskripsi' => 'x', 'harga' => 10, 'stok' => 'tersedia'
        ])->assertForbidden();
        $this->actingAs($penjual2)->delete("/penjual/produk/{$produkP1->id}")->assertForbidden();
    }

    public function test_updating_aktif_produk_changes_status_to_pending(): void
    {
        $penjual = $this->makePenjual();
        $kategori = $this->makeKategori();

        $produk = Produk::create([
            'penjual_id' => $penjual->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Produk Lama',
            'slug' => 'produk-lama',
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
            'status' => 'aktif',
        ]);

        $this->actingAs($penjual)->put("/penjual/produk/{$produk->id}", [
            'nama' => 'Produk Baru',
            'kategori_id' => $kategori->id,
            'deskripsi' => 'y',
            'harga' => 2000,
            'stok' => 'tersedia', // Mapping ui->db: tersedia->ready
        ])->assertRedirect(route('penjual.produk.index'));

        $this->assertDatabaseHas('produk', [
            'id' => $produk->id,
            'nama' => 'Produk Baru',
            'slug' => 'produk-baru',
            'status' => 'pending', // Berubah dari aktif jadi pending
        ]);
    }

    public function test_slug_is_unique_when_creating_same_name(): void
    {
        $penjual = $this->makePenjual();
        $kategori = $this->makeKategori();

        // Buat langsung lewat model
        Produk::create([
            'penjual_id' => $penjual->penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Nasi Goreng',
            'slug' => 'nasi-goreng',
            'deskripsi' => 'x',
            'harga' => 1000,
            'stok' => 'ready',
        ]);

        // Buat lewat web dengan nama sama
        $this->actingAs($penjual)->post('/penjual/produk', [
            'nama' => 'Nasi Goreng',
            'kategori_id' => $kategori->id,
            'deskripsi' => 'Enak',
            'harga' => 5000,
            'stok' => 'tersedia',
        ]);

        $this->assertDatabaseHas('produk', [
            'slug' => 'nasi-goreng-1',
            'deskripsi' => 'Enak',
        ]);
    }
}
