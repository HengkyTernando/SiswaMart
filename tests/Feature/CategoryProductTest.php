<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class CategoryProductTest extends TestCase
{
    /** @test */
    public function home_page_contains_new_categories_and_products(): void
    {
        // 1. Check if categories list is displayed on homepage
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Makanan');
        $response->assertSee('Minuman');

        // 2. Check if new products are rendered under Makanan category
        $makananResponse = $this->get('/?category=makanan');
        $makananResponse->assertStatus(200);
        $makananResponse->assertSee('Roti Bakar Coklat Keju');
        $makananResponse->assertSee('Nasi Goreng Spesial Siswa');

        // 3. Check if new products are rendered under Minuman category
        $minumanResponse = $this->get('/?category=minuman');
        $minumanResponse->assertStatus(200);
        $minumanResponse->assertSee('Es Teh Manis Segar');
        $minumanResponse->assertSee('Jus Alpukat Sehat');
    }

    /** @test */
    public function new_seller_can_login_and_access_dashboard(): void
    {
        // Authenticate as the new seller
        $seller = User::where('email', 'kantin@siswamart.com')->first();

        $this->assertNotNull($seller);

        $response = $this->actingAs($seller)
                         ->get(route('seller.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Kantin Sekolah Jujur');
    }
}
