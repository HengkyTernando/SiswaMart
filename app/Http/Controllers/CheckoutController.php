<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /** GET /customer/checkout – tampilkan form checkout */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')
                ->with('cart_success', 'Keranjang kosong, silakan tambahkan produk terlebih dahulu.');
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        return view('customer.checkout', compact('cart', 'total'));
    }

    /** POST /customer/checkout – proses order */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'phone'            => 'required|string|max:20',
            'shipping_address' => 'required|string|min:10',
            'notes'            => 'nullable|string|max:500',
        ], [
            'name.required'             => 'Nama penerima wajib diisi.',
            'phone.required'            => 'Nomor telepon wajib diisi.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min'      => 'Alamat terlalu pendek (min. 10 karakter).',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')
                ->with('cart_success', 'Keranjang kosong!');
        }

        // Validasi stok sebelum menyimpan
        foreach ($cart as $key => $item) {
            $product = Product::find($item['id']);
            if (! $product || $product->stock < $item['qty']) {
                return back()->withErrors([
                    'stock' => "Stok produk \"{$item['name']}\" tidak mencukupi.",
                ]);
            }
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        // Buat order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_code'       => 'SM-' . strtoupper(Str::random(8)),
            'total_price'      => $total,
            'status'           => 'pending',
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        // Simpan order items & kurangi stok
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'],
                'quantity'   => $item['qty'],
                'price'      => $item['price'],
            ]);

            Product::where('id', $item['id'])->decrement('stock', $item['qty']);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('customer.checkout.success', $order->order_code)
            ->with('order_success', 'Pesanan berhasil dibuat!');
    }

    /** GET /customer/checkout/success/{code} */
    public function success(string $code)
    {
        $order = Order::where('order_code', $code)
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->firstOrFail();

        return view('customer.order-success', compact('order'));
    }
}
