<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\EbookLibrary;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.book', 'user']);

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhere('customer_name', 'like', "%{$term}%")
                  ->orWhere('customer_phone', 'like', "%{$term}%")
                  ->orWhere('payment_trx_id', 'like', "%{$term}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'payment_verified' => Order::where('order_status', 'payment_verified')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['items.book', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,payment_verified,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,verified,rejected',
            'courier_tracking_id' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string',
        ]);

        $order->order_status = $validated['order_status'];

        if (!empty($validated['payment_status'])) {
            $order->payment_status = $validated['payment_status'];
        }

        if ($validated['order_status'] === 'payment_verified') {
            $order->payment_status = 'verified';

            // Auto-grant E-books to library for customer
            if ($order->user_id) {
                foreach ($order->items as $item) {
                    if ($item->format === 'ebook') {
                        EbookLibrary::firstOrCreate(
                            ['user_id' => $order->user_id, 'book_id' => $item->book_id],
                            ['order_id' => $order->id, 'last_read_page' => 1]
                        );
                    }
                }
            }
        }

        if ($request->filled('courier_tracking_id')) {
            $order->courier_tracking_id = $validated['courier_tracking_id'];
        }

        if ($request->filled('admin_notes')) {
            $order->admin_notes = $validated['admin_notes'];
        }

        $order->save();

        return back()->with('success', 'অর্ডারের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'অর্ডারটি মুছে ফেলা হয়েছে।');
    }
}
