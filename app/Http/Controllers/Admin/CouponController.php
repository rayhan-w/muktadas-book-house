<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric|min:1',
            'min_spend' => 'nullable|numeric|min:0',
            'valid_until' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($validated['code'])),
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_spend' => $validated['min_spend'] ?? 0,
            'valid_until' => $validated['valid_until'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'is_active' => true,
        ]);

        return back()->with('success', 'নতুন ডিসকাউন্ট কুপন তৈরি হয়েছে।');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();
        return back()->with('success', 'কুপন স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'কুপন মুছে ফেলা হয়েছে।');
    }
}
