<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $couponCode = session()->get('coupon_code');
        $discount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValidForAmount($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget(['coupon_code', 'coupon_discount']);
            }
        }

        $total = max(0, $subtotal - $discount);

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'format' => 'required|in:hardcopy,ebook',
            'quantity' => 'nullable|integer|min:1|max:50',
        ]);

        $book = Book::approved()->findOrFail($validated['book_id']);
        $format = $validated['format'];
        $quantity = $format === 'ebook' ? 1 : max(1, (int) ($validated['quantity'] ?? 1));
        $price = $format === 'ebook' ? $book->ebookEffectivePrice() : $book->hardcopyEffectivePrice();

        $cartKey = "{$book->id}_{$format}";
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            if ($format === 'hardcopy') {
                $cart[$cartKey]['quantity'] += $quantity;
            }
        } else {
            $cart[$cartKey] = [
                'book_id' => $book->id,
                'title' => $book->title,
                'slug' => $book->slug,
                'cover_image' => $book->cover_url,
                'format' => $format,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'বইটি কার্টে যুক্ত হয়েছে।',
                'cartCount' => count($cart),
            ]);
        }

        if ($request->has('buy_now')) {
            return redirect()->route('checkout');
        }

        return redirect()->route('cart.index')->with('success', '“' . $book->title . '” সফলভাবে কার্টে যোগ করা হয়েছে।');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $cartKey => $qty) {
            if (isset($cart[$cartKey])) {
                $qty = (int) $qty;
                if ($qty <= 0) {
                    unset($cart[$cartKey]);
                } else {
                    $cart[$cartKey]['quantity'] = $cart[$cartKey]['format'] === 'ebook' ? 1 : $qty;
                }
            }
        }

        session()->put('cart', $cart);
        return back()->with('success', 'কার্ট সফলভাবে আপডেট করা হয়েছে।');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'বইটি কার্ট থেকে সরানো হয়েছে।');
    }

    public function applyCoupon(Request $request)
    {
        $code = trim(strtoupper($request->input('code', '')));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return back()->with('error', 'অকার্যকর কুপন কোড।');
        }

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if (!$coupon->isValidForAmount($subtotal)) {
            return back()->with('error', "এই কুপনটি ব্যবহার করতে ন্যূনতম ৳ {$coupon->min_spend} টাকার বই অর্ডার করতে হবে।");
        }

        $discount = $coupon->calculateDiscount($subtotal);
        session()->put('coupon_code', $coupon->code);
        session()->put('coupon_discount', $discount);

        return back()->with('success', "কুপন কোড প্রয়োগ করা হয়েছে! আপনি ৳ {$discount} ছাড় পেয়েছেন।");
    }

    public function removeCoupon()
    {
        session()->forget(['coupon_code', 'coupon_discount']);
        return back()->with('success', 'কুপনটি সরানো হয়েছে।');
    }
}
