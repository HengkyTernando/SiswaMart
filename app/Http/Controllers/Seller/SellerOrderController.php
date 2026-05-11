<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    /** GET – daftar pesanan yang mengandung produk seller */
    public function index()
    {
        $sellerProductIds = auth()->user()->products()->pluck('id');

        // Ambil order_id yang mengandung produk seller
        $orderIds = OrderItem::whereIn('product_id', $sellerProductIds)
            ->pluck('order_id')
            ->unique();

        $orders = Order::whereIn('id', $orderIds)
            ->with(['user', 'items.product', 'messages'])
            ->latest()
            ->paginate(15);

        return view('seller.orders', compact('orders', 'sellerProductIds'));
    }

    /** PATCH – update status order */
    public function updateStatus(Request $request, Order $order)
    {
        // Pastikan seller memiliki produk di order ini
        $sellerProductIds = auth()->user()->products()->pluck('id');
        $hasProduct = $order->items()->whereIn('product_id', $sellerProductIds)->exists();
        if (!$hasProduct) abort(403);

        $request->validate([
            'status' => 'required|in:processing,shipped,cancelled',
        ]);

        // Validasi alur status
        $allowed = [
            'pending'    => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => [],
            'delivered'  => [],
            'cancelled'  => [],
        ];

        if (!in_array($request->status, $allowed[$order->status] ?? [])) {
            return back()->with('order_error', 'Perubahan status tidak diizinkan.');
        }

        $order->update(['status' => $request->status]);

        $label = [
            'processing' => 'sedang diproses',
            'shipped'    => 'dikirim',
            'cancelled'  => 'dibatalkan',
        ][$request->status] ?? $request->status;

        return back()->with('order_success', "Pesanan {$order->order_code} berhasil ditandai sebagai {$label}.");
    }
}
