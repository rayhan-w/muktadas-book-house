<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use App\Models\SiteSetting;
use App\Models\EbookLibrary;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);

        // If direct checkout from book page (e.g. ?direct_book=alor-poth&format=ebook)
        $bookParam = $request->get('book', $request->get('bookSlug'));
        $formatParam = $request->get('format', $request->get('type'));

        if ($bookParam && $formatParam) {
            $directBook = Book::approved()->where('slug', $bookParam)->first();
            if ($directBook) {
                $format = $formatParam === 'ebook' ? 'ebook' : 'hardcopy';
                $price = $format === 'ebook' ? $directBook->ebookEffectivePrice() : $directBook->hardcopyEffectivePrice();
                $cartKey = "{$directBook->id}_{$format}";
                $cart = [
                    $cartKey => [
                        'book_id' => $directBook->id,
                        'title' => $directBook->title,
                        'slug' => $directBook->slug,
                        'cover_image' => $directBook->cover_url,
                        'format' => $format,
                        'price' => $price,
                        'quantity' => 1,
                    ]
                ];
                session()->put('cart', $cart);
            }
        }

        if (empty($cart)) {
            return redirect()->route('books.index')->with('error', 'আপনার কার্টে কোনো বই নেই। প্রথমে বই নির্বাচন করুন।');
        }

        $subtotal = 0;
        $hasHardcopy = false;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            if ($item['format'] === 'hardcopy') {
                $hasHardcopy = true;
            }
        }

        $discount = session()->get('coupon_discount', 0);
        $deliveryDhaka = (float) SiteSetting::get('delivery_charge_dhaka', '60');
        $deliveryOutside = (float) SiteSetting::get('delivery_charge_outside', '120');

        $paymentSettings = [
            'bkash' => SiteSetting::get('bkash_number', '01700-112233'),
            'bkash_type' => SiteSetting::get('bkash_type', 'merchant'),
            'nagad' => SiteSetting::get('nagad_number', '01800-445566'),
            'nagad_type' => SiteSetting::get('nagad_type', 'personal'),
            'upay' => SiteSetting::get('upay_number', '01900-778899'),
            'upay_type' => SiteSetting::get('upay_type', 'personal'),
            'instruction' => SiteSetting::get('payment_instruction', 'নির্ধারিত নম্বরে টাকা পাঠিয়ে Transaction ID দিন।'),
        ];

        $user = Auth::user();

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'hasHardcopy', 'deliveryDhaka', 'deliveryOutside', 'paymentSettings', 'user'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('books.index')->with('error', 'আপনার কার্টে কোনো বই নেই।');
        }

        $hasHardcopy = false;
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            if ($item['format'] === 'hardcopy') {
                $hasHardcopy = true;
            }
        }

        $rules = [
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:100',
            'payment_method' => 'required|in:bkash,nagad,upay,cod',
            'delivery_zone' => 'required|in:dhaka,outside_dhaka',
        ];

        if ($hasHardcopy) {
            $rules['delivery_address'] = 'required|string|max:500';
        }

        if ($request->payment_method !== 'cod') {
            $rules['payment_trx_id'] = 'required|string|max:100';
            $rules['payment_number'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules);

        // Calculate delivery charge
        $deliveryCharge = 0;
        if ($hasHardcopy) {
            $deliveryCharge = $validated['delivery_zone'] === 'outside_dhaka'
                ? (float) SiteSetting::get('delivery_charge_outside', '120')
                : (float) SiteSetting::get('delivery_charge_dhaka', '60');
        }

        $discount = (float) session()->get('coupon_discount', 0);
        $total = max(0, ($subtotal - $discount) + $deliveryCharge);

        // Generate unique readable order number e.g. MB-10025
        $nextNumber = (Order::max('id') ?? 1000) + 1;
        $orderNumber = 'MB-' . $nextNumber;

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'delivery_address' => $validated['delivery_address'] ?? null,
            'delivery_zone' => $validated['delivery_zone'],
            'delivery_charge' => $deliveryCharge,
            'delivery_instruction' => $request->delivery_instruction,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_number' => $validated['payment_number'] ?? null,
            'payment_trx_id' => $validated['payment_trx_id'] ?? null,
            'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
            'order_status' => 'pending',
        ]);

        // Add order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item['book_id'],
                'format' => $item['format'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);
        }

        // Increment coupon usage if used
        if ($couponCode = session()->get('coupon_code')) {
            Coupon::where('code', $couponCode)->increment('times_used');
        }

        // Clear cart
        session()->forget(['cart', 'coupon_code', 'coupon_discount']);

        return redirect()->route('orders.invoice', $order->order_number)->with('order_placed', 'আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে! অর্ডার নম্বর: ' . $order->order_number);
    }
}
