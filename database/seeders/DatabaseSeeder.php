<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 0. Reset Tables (safe to re-run) ─────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderItem::truncate();
        Order::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. Fixed Users ────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin SiswaMart',
            'email'    => 'admin@siswamart.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '08100000001',
            'address'  => 'Jl. Admin No. 1, Jakarta',
        ]);

        $seller1 = User::create([
            'name'     => 'Toko Perlengkapan Sekolah',
            'email'    => 'seller@siswamart.com',
            'password' => Hash::make('password'),
            'role'     => 'seller',
            'phone'    => '08200000001',
            'address'  => 'Jl. Pedagang No. 5, Bandung',
        ]);

        $seller2 = User::create([
            'name'     => 'Toko Buku Ceria',
            'email'    => 'seller2@siswamart.com',
            'password' => Hash::make('password'),
            'role'     => 'seller',
            'phone'    => '08200000002',
            'address'  => 'Jl. Buku No. 10, Surabaya',
        ]);

        $seller3 = User::create([
            'name'     => 'Kantin Sekolah Jujur',
            'email'    => 'kantin@siswamart.com',
            'password' => Hash::make('password'),
            'role'     => 'seller',
            'phone'    => '08200000003',
            'address'  => 'Kantin Area Sekolah, Depok',
        ]);

        $customer = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'customer@siswamart.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '08300000001',
            'address'  => 'Jl. Pelajar No. 3, Yogyakarta',
        ]);

        // ─── 2. Categories ─────────────────────────────────────────────
        $cats = [
            ['name' => 'Alat Tulis',         'icon' => 'pencil',   'description' => 'Pensil, pulpen, penggaris, dan perlengkapan menulis lainnya'],
            ['name' => 'Buku & Referensi',   'icon' => 'book',     'description' => 'Buku pelajaran, novel, dan buku referensi sekolah'],
            ['name' => 'Tas Sekolah',        'icon' => 'backpack', 'description' => 'Tas ransel, tas selempang, dan tas lainnya untuk sekolah'],
            ['name' => 'Elektronik Belajar', 'icon' => 'laptop',   'description' => 'Kalkulator, flash disk, dan alat elektronik penunjang belajar'],
            ['name' => 'Seragam & Pakaian',  'icon' => 'shirt',    'description' => 'Seragam sekolah, dasi, sabuk, dan atribut sekolah'],
            ['name' => 'Olahraga',           'icon' => 'sports',   'description' => 'Perlengkapan olahraga untuk siswa'],
            ['name' => 'Makanan',            'icon' => 'food',     'description' => 'Camilan, roti, dan makanan berat sehat untuk siswa'],
            ['name' => 'Minuman',            'icon' => 'drink',    'description' => 'Air mineral, jus buah, dan minuman segar bergizi'],
        ];

        $categories = collect($cats)->map(function ($cat) {
            return Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
                'icon'        => $cat['icon'],
            ]);
        });

        // ─── 3. Products ───────────────────────────────────────────────
        $products_data = [
            // Alat Tulis (cat 0)
            ['cat' => 0, 'seller' => $seller1, 'name' => 'Pensil 2B Faber Castell (12 pcs)', 'price' => 25000,  'stock' => 150, 'desc' => 'Pensil gambar berkualitas tinggi untuk sketsa dan tulis.',   'img' => 'products/faber-castell-2b.jpg'],
            ['cat' => 0, 'seller' => $seller1, 'name' => 'Pulpen Pilot G2 Hitam',            'price' => 15000,  'stock' => 200, 'desc' => 'Pulpen gel halus anti bocor, tinta hitam tahan lama.',      'img' => 'products/pilot-g2.jpg'],
            ['cat' => 0, 'seller' => $seller2, 'name' => 'Set Penggaris 30cm + Segitiga',    'price' => 18000,  'stock' => 80,  'desc' => 'Set penggaris lurus dan segitiga untuk geometri.',         'img' => 'products/set-penggaris-30cm.jpg'],
            ['cat' => 0, 'seller' => $seller1, 'name' => 'Stabilo Boss Highlight 6 Warna',   'price' => 32000,  'stock' => 120, 'desc' => 'Stabilo warna-warni untuk menandai catatan penting.',     'img' => 'products/stabilo-boss.jpg'],
            // Buku (cat 1)
            ['cat' => 1, 'seller' => $seller2, 'name' => 'Buku Tulis Sidu 38 Lembar (10 pcs)', 'price' => 30000, 'stock' => 300, 'desc' => 'Buku tulis bergaris halus, cover tebal anti sobek.',   'img' => 'products/buku-tulis-sidu-38-lembar.jpg'],
            ['cat' => 1, 'seller' => $seller1, 'name' => 'Kamus Bahasa Inggris Lengkap',     'price' => 120000, 'stock' => 40,  'desc' => 'Kamus lengkap Inggris-Indonesia lebih dari 50.000 kata.', 'img' => 'products/kamus-inggris.jpg'],
            // Tas (cat 2)
            ['cat' => 2, 'seller' => $seller1, 'name' => 'Tas Ransel Sekolah Besar 35L',     'price' => 180000, 'stock' => 60,  'desc' => 'Tas ransel ergonomis anti air kapasitas besar.',         'img' => 'products/tas-ransel.jpg'],
            ['cat' => 2, 'seller' => $seller2, 'name' => 'Tas Selempang Mini Waterproof',    'price' => 95000,  'stock' => 45,  'desc' => 'Tas kecil praktis untuk bawa dompet dan alat tulis.',     'img' => 'products/tas-selempang-mini-waterproof.jpg'],
            // Elektronik (cat 3)
            ['cat' => 3, 'seller' => $seller1, 'name' => 'Kalkulator Casio FX-991ES',        'price' => 210000, 'stock' => 35,  'desc' => 'Kalkulator scientific 417 fungsi, layar besar.',          'img' => 'products/kalkulator-casio.jpg'],
            ['cat' => 3, 'seller' => $seller2, 'name' => 'Flash Disk SanDisk 32GB',          'price' => 75000,  'stock' => 100, 'desc' => 'Flash disk mini cepat USB 3.0 untuk simpan tugas.',       'img' => 'products/flashdisk-sandisk-32gb.jpg'],
            // Seragam (cat 4)
            ['cat' => 4, 'seller' => $seller1, 'name' => 'Seragam Putih Abu-abu SMP Set',   'price' => 145000, 'stock' => 70,  'desc' => 'Seragam lengkap baju putih dan celana/rok abu-abu.',      'img' => 'products/seragam-smp.jpg'],
            // Olahraga (cat 5)
            ['cat' => 5, 'seller' => $seller2, 'name' => 'Sepatu Olahraga Sekolah Putih',   'price' => 220000, 'stock' => 55,  'desc' => 'Sepatu kets putih ringan untuk olahraga sekolah.',        'img' => 'products/sepatu-olahraga-putih.jpg'],
            // Makanan (cat 6)
            ['cat' => 6, 'seller' => $seller3, 'name' => 'Roti Bakar Coklat Keju',            'price' => 12000,  'stock' => 50,  'desc' => 'Roti bakar dengan isian coklat premium dan parutan keju melimpah.', 'img' => 'products/roti-bakar.jpg'],
            ['cat' => 6, 'seller' => $seller3, 'name' => 'Nasi Goreng Spesial Siswa',         'price' => 15000,  'stock' => 30,  'desc' => 'Nasi goreng dengan telur, sosis, bakso, dan bumbu khas kantin.',    'img' => 'products/nasi-goreng.jpg'],
            // Minuman (cat 7)
            ['cat' => 7, 'seller' => $seller3, 'name' => 'Es Teh Manis Segar',                'price' => 5000,   'stock' => 100, 'desc' => 'Es teh manis segar pelepas dahaga setelah belajar.',           'img' => 'products/es-teh.jpg'],
            ['cat' => 7, 'seller' => $seller3, 'name' => 'Jus Alpukat Sehat',                 'price' => 10000,  'stock' => 40,  'desc' => 'Jus alpukat segar dari buah asli dengan kental manis coklat.',  'img' => 'products/jus-alpukat.jpg'],
        ];

        $createdProducts = collect($products_data)->map(function ($p) use ($categories) {
            $baseSlug = Str::slug($p['name']);
            return Product::create([
                'category_id' => $categories[$p['cat']]->id,
                'user_id'     => $p['seller']->id,
                'name'        => $p['name'],
                'slug'        => $baseSlug . '-' . Str::random(5),
                'description' => $p['desc'],
                'price'       => $p['price'],
                'stock'       => $p['stock'],
                'image'       => $p['img'],
                'is_active'   => true,
            ]);
        });

        // ─── 4. Sample Order ───────────────────────────────────────────
        $order = Order::create([
            'user_id'          => $customer->id,
            'order_code'       => 'SM-' . strtoupper(Str::random(8)),
            'total_price'      => 55000,
            'status'           => 'delivered',
            'shipping_address' => $customer->address,
            'notes'            => 'Tolong bungkus rapi ya.',
        ]);

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $createdProducts[0]->id,
            'quantity'   => 2,
            'price'      => $createdProducts[0]->price,
        ]);
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $createdProducts[1]->id,
            'quantity'   => 1,
            'price'      => $createdProducts[1]->price,
        ]);
    }
}
