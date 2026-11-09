@extends('layouts.app')

@section('title', 'শপিং কার্ট | মুক্তাদার বইঘর')

@section('styles')
<style>
    .cart-page-header {
        background: #fff;
        border-bottom: 1px solid var(--border-color);
        padding: 30px 0;
        margin-bottom: 35px;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 30px;
        margin-bottom: 60px;
        align-items: flex-start;
    }

    .cart-table-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        background: #f8fafc;
        padding: 14px 18px;
        text-align: left;
        font-size: 14px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }

    .cart-table td {
        padding: 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 15px;
    }

    .cart-item-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .cart-item-img {
        width: 55px;
        height: 75px;
        object-fit: contain;
        background: #f8fafc;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    .format-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }

    .format-hardcopy { background: #e0f2fe; color: #0369a1; }
    .format-ebook { background: #fef3c7; color: #92400e; }

    .qty-input {
        width: 60px;
        padding: 6px 10px;
        border: 1.5px solid var(--border-color);
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
        text-align: center;
    }

    /* Summary Card */
    .cart-summary {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 25px;
        box-shadow: var(--shadow-sm);
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 15px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        border-top: 2px solid var(--cream-bg);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 20px;
        font-weight: 800;
        color: var(--primary);
    }

    .coupon-box {
        display: flex;
        gap: 8px;
        margin: 20px 0;
    }

    .coupon-input {
        flex: 1;
        padding: 9px 12px;
        border: 1.5px solid var(--border-color);
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
        text-transform: uppercase;
    }

    @media (max-width: 860px) {
        .cart-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="cart-page-header">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 6px;">🛒 আপনার শপিং কার্ট</h1>
        <p style="color: var(--text-muted); font-size: 15px;">একসাথে একাধিক বই নির্বাচন করে এক ঠিকানায় অর্ডার করুন।</p>
    </div>
</div>

<div class="container">
    @if(empty($cart))
        <div style="background: #fff; border: 1px dashed var(--border-color); border-radius: var(--radius); padding: 70px 20px; text-align: center; margin-bottom: 60px;">
            <div style="font-size: 48px; margin-bottom: 15px;">🛍️</div>
            <h2 style="color: var(--primary); margin-bottom: 8px;">আপনার কার্ট বর্তমানে খালি!</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">আপনি এখনো কোনো বই কার্টে যোগ করেননি। বইয়ের ক্যাটালগ ঘুরে দেখুন।</p>
            <a href="{{ route('books.index') }}" class="btn btn-gold">📖 বইয়ের ক্যাটালগ দেখুন</a>
        </div>
    @else
        <div class="cart-grid">
            <!-- Items Form -->
            <form action="{{ route('cart.update') }}" method="POST" class="cart-table-card">
                @csrf
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>বইয়ের বিবরণ</th>
                            <th>ফরম্যাট</th>
                            <th>মূল্য</th>
                            <th>সংখ্যা</th>
                            <th>মোট</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $key => $item)
                            <tr>
                                <td>
                                    <div class="cart-item-info">
                                        <img src="{{ $item['cover_image'] }}" alt="{{ $item['title'] }}" class="cart-item-img">
                                        <div>
                                            <a href="{{ route('books.show', $item['slug']) }}" style="font-weight: 700; color: var(--primary);">
                                                {{ $item['title'] }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="format-badge {{ $item['format'] === 'ebook' ? 'format-ebook' : 'format-hardcopy' }}">
                                        {{ $item['format'] === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}
                                    </span>
                                </td>
                                <td>৳ {{ number_format($item['price']) }}</td>
                                <td>
                                    @if($item['format'] === 'ebook')
                                        <span>১</span>
                                    @else
                                        <input type="number" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}" min="1" max="50" class="qty-input">
                                    @endif
                                </td>
                                <td><strong>৳ {{ number_format($item['price'] * $item['quantity']) }}</strong></td>
                                <td>
                                    <a href="{{ route('cart.remove', $key) }}" style="color: #dc2626; font-size: 16px; font-weight: 700;" title="মুছে ফেলুন">✕</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="padding: 15px 18px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
                    <a href="{{ route('books.index') }}" class="btn btn-outline" style="font-size: 13px; padding: 8px 14px;">+ আরও বই যোগ করুন</a>
                    <button type="submit" class="btn btn-primary" style="font-size: 13px; padding: 8px 14px;">কার্ট আপডেট করুন</button>
                </div>
            </form>

            <!-- Summary -->
            <div class="cart-summary">
                <h3 style="font-size: 18px; color: var(--primary); margin-bottom: 16px;">অর্ডার সারাংশ</h3>

                <div class="summary-line">
                    <span style="color: var(--text-muted);">বইয়ের সাবটোটাল:</span>
                    <strong>৳ {{ number_format($subtotal) }}</strong>
                </div>

                @if($discount > 0)
                    <div class="summary-line" style="color: #16a34a;">
                        <span>কুপন ছাড় ({{ session('coupon_code') }}):</span>
                        <strong>- ৳ {{ number_format($discount) }}</strong>
                    </div>
                    <div style="font-size: 12px; margin-bottom: 10px;">
                        <a href="{{ route('cart.coupon.remove') }}" style="color: #dc2626;">(কুপন বাদ দিন)</a>
                    </div>
                @endif

                <div class="summary-line">
                    <span style="color: var(--text-muted);">ডেলিভারি চার্জ:</span>
                    <small style="color: var(--text-muted);">চেকআউটে নির্ধারিত হবে</small>
                </div>

                <div class="summary-total">
                    <span>সর্বমোট:</span>
                    <span>৳ {{ number_format($total) }}</span>
                </div>

                <!-- Coupon Box -->
                <form action="{{ route('cart.coupon') }}" method="POST" class="coupon-box">
                    @csrf
                    <input type="text" name="code" placeholder="কুপন কোড (যেমন: MUKTADA10)" class="coupon-input" required>
                    <button type="submit" class="btn btn-primary" style="padding: 8px 14px; font-size: 13px;">প্রয়োগ</button>
                </form>

                <a href="{{ route('checkout') }}" class="btn btn-gold" style="width: 100%; font-size: 16px; padding: 14px; margin-top: 10px;">
                    অর্ডার করতে এগিয়ে যান →
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
