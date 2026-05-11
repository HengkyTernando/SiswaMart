<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /** Pastikan user boleh akses chat order ini */
    private function authorizeOrder(Order $order): void
    {
        $user = auth()->user();

        if ($user->isCustomer()) {
            // Customer hanya bisa chat order miliknya
            if ($order->user_id !== $user->id) abort(403);
        } elseif ($user->isSeller()) {
            // Seller hanya bisa chat jika ada produknya di order
            $sellerProductIds = $user->products()->pluck('id');
            $hasProduct = $order->items()
                ->whereIn('product_id', $sellerProductIds)
                ->exists();
            if (!$hasProduct) abort(403);
        } elseif ($user->isAdmin()) {
            // Admin boleh akses semua
        } else {
            abort(403);
        }
    }

    /** GET – halaman chat */
    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        $order->load(['items.product', 'user', 'messages.sender']);

        // Tandai pesan yang belum dibaca sebagai sudah dibaca
        $order->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Tentukan partner chat
        $partner = auth()->user()->isCustomer()
            ? $this->resolveSellerFromOrder($order)
            : $order->user;

        return view('customer.chat', compact('order', 'partner'));
    }

    /** POST – kirim pesan (JSON) */
    public function store(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        $request->validate(['body' => 'required|string|max:2000']);

        $msg = Message::create([
            'order_id'  => $order->id,
            'sender_id' => auth()->id(),
            'body'      => $request->body,
        ]);

        $msg->load('sender');

        return response()->json([
            'id'         => $msg->id,
            'body'       => $msg->body,
            'sender_id'  => $msg->sender_id,
            'sender'     => $msg->sender->name,
            'is_me'      => true,
            'created_at' => $msg->created_at->format('H:i'),
        ]);
    }

    /** GET – polling pesan baru (JSON) */
    public function fetch(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        $afterId = (int) $request->get('after', 0);

        $messages = $order->messages()
            ->with('sender')
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'body'       => $m->body,
                'sender_id'  => $m->sender_id,
                'sender'     => $m->sender->name,
                'is_me'      => $m->sender_id === auth()->id(),
                'created_at' => $m->created_at->format('H:i'),
            ]);

        // Tandai pesan masuk sebagai sudah dibaca
        $order->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    /** Ambil seller dari order (seller pertama yang produknya ada di order) */
    private function resolveSellerFromOrder(Order $order)
    {
        return $order->items->first()?->product?->user;
    }
}
