<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $numbers = [
            'bkash' => SiteSetting::get('bkash_number', '01700-112233'),
            'nagad' => SiteSetting::get('nagad_number', '01800-445566'),
            'upay' => SiteSetting::get('upay_number', '01900-778899'),
            'instruction' => SiteSetting::get('payment_instruction', 'নির্ধারিত নম্বরে টাকা পাঠিয়ে Transaction ID দিন।'),
        ];

        $pendingPayments = Order::where('payment_status', 'pending')
            ->whereNotNull('payment_trx_id')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.payments.index', compact('numbers', 'pendingPayments'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bkash_number' => 'required|string|max:50',
            'nagad_number' => 'required|string|max:50',
            'upay_number' => 'required|string|max:50',
            'payment_instruction' => 'nullable|string',
        ]);

        SiteSetting::set('bkash_number', $validated['bkash_number']);
        SiteSetting::set('nagad_number', $validated['nagad_number']);
        SiteSetting::set('upay_number', $validated['upay_number']);
        SiteSetting::set('payment_instruction', $validated['payment_instruction'] ?? '');

        return back()->with('success', 'পেমেন্ট নম্বর এবং নির্দেশনাবলী ডাটাবেজে সফলভাবে সংরক্ষিত হয়েছে।');
    }
}
