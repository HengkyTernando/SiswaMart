<?php

namespace Tests\Feature\Public;

use App\Models\Kategori;
use App\Models\Penjual;
use App\Models\Produk;
use App\Models\User;
use App\Models\Ulasan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UlasanTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduk(): Produk
    {
        $user = User::factory()->create(['role' => 'penjual', 'is_active' => true]);
        $penjual = Penjual::create([
            'user_id'          => $user->id,
            'nama_toko'        => 'Toko Public Test',
            'nomor_whatsapp'   => '08123456789',
        ]);
        
        $kategori = Kategori::create(['nama' => 'Makanan', 'slug' => 'makanan']);

        return Produk::create([
            'penjual_id' => $penjual->id,
            'kategori_id' => $kategori->id,
            'nama' => 'Seblak Enak',
            'slug' => 'seblak-enak',
            'harga' => 10000,
            'status' => 'aktif'
        ]);
    }

    public function test_guest_can_submit_review(): void
    {
        $produk = $this->makeProduk();

        $response = $this->post("/produk/{$produk->slug}/ulasan", [
            'guest_username' => 'Budi',
            'rating' => 5,
            'komentar' => 'Sangat enak!',
        ]);

        $response->assertRedirect("/produk/{$produk->slug}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ulasan', [
            'produk_id' => $produk->id,
            'guest_username' => 'Budi',
            'rating' => 5,
            'komentar' => 'Sangat enak!',
            'status' => 'pending'
        ]);
    }

    public function test_validation_rules_for_review(): void
    {
        $produk = $this->makeProduk();

        // Missing username and rating
        $response = $this->post("/produk/{$produk->slug}/ulasan", []);
        $response->assertSessionHasErrors(['guest_username', 'rating']);

        // Invalid rating (out of bounds)
        $response = $this->post("/produk/{$produk->slug}/ulasan", [
            'guest_username' => 'Budi',
            'rating' => 6,
        ]);
        $response->assertSessionHasErrors('rating');
    }

    public function test_pending_reviews_are_not_displayed_in_public(): void
    {
        $produk = $this->makeProduk();

        Ulasan::create([
            'produk_id' => $produk->id,
            'guest_username' => 'Siswa',
            'rating' => 4,
            'komentar' => 'Review rahasia',
            'status' => 'pending'
        ]);

        $response = $this->get("/produk/{$produk->slug}");
        $response->assertOk();
        $response->assertDontSee('Review rahasia');
    }

    public function test_approved_reviews_are_displayed_and_calculated(): void
    {
        $produk = $this->makeProduk();

        Ulasan::create([
            'produk_id' => $produk->id,
            'guest_username' => 'Siswa',
            'rating' => 4,
            'komentar' => 'Review bagus',
            'status' => 'disetujui'
        ]);

        $response = $this->get("/produk/{$produk->slug}");
        $response->assertOk();
        $response->assertSee('Review bagus');
        $response->assertSee('Siswa');
        $response->assertSee('4.0');
    }
}
