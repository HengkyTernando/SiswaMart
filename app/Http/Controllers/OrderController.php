<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /** GET – daftar pesanan customer */
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with(['items.product', 'messages'])
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }

    /** POST – customer menyelesaikan pesanan (shipped → delivered) */
    public function complete(Order $order)
    {
        // Hanya pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Hanya jika status shipped
        if ($order->status !== 'shipped') {
            return back()->with('order_error', 'Pesanan hanya bisa diselesaikan jika sudah berstatus "Dikirim".');
        }

        $order->update(['status' => 'delivered']);

        return back()->with('order_success', 'Pesanan berhasil diselesaikan! Terima kasih sudah berbelanja di SiswaMart. 🎉');
    }
}
