<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart  = $this->getCart();
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        return view('customer.cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'integer|min:1',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);
        $qty     = max(1, (int) $request->get('qty', 1));

        $cart = $this->getCart();
        $key  = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min($cart[$key]['qty'] + $qty, $product->stock);
        } else {
            $imgSrc = null;
            if ($product->image) {
                $imgSrc = str_starts_with($product->image, 'http')
                    ? $product->image
                    : asset('storage/' . $product->image);
            }
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'slug'     => $product->slug,
                'price'    => (float) $product->price,
                'stock'    => $product->stock,
                'image'    => $imgSrc,
                'category' => $product->category?->name,
                'qty'      => $qty,
            ];
        }

        $this->saveCart($cart);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Ditambahkan!', 'count' => count($cart)]);
        }

        return back()->with('cart_success', $product->name . ' ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty'        => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();
        $key  = (string) $request->product_id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min((int) $request->qty, $cart[$key]['stock']);
            $this->saveCart($cart);
        }

        return back();
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = $this->getCart();
        unset($cart[(string) $request->product_id]);
        $this->saveCart($cart);
        return back()->with('cart_success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('cart_success', 'Keranjang dikosongkan.');
    }
}
