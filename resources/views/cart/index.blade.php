@extends('layouts.app')

@section('title', 'শপিং কার্ট | মুক্তাদার বইঘর')

@section('styles')
<style>
    .cart-page-header {
        background: #ffffff;
        border-bottom: 1px solid var(--sp-border);
        padding: 24px 0;
        margin-bottom: 30px;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 370px;
        gap: 28px;
        margin-bottom: 60px;
        align-items: flex-start;
    }

    .cart-table-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        overflow: hidden;
        box-shadow: var(--sp-shadow-sm);
    }

    /* Desktop Cart Table */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        background: #f8fafc;
        padding: 14px 18px;
        text-align: left;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--sp-muted);
        border-bottom: 1px solid var(--sp-border);
    }

    .cart-table td {
        padding: 16px 18px;
        border-bottom: 1px solid var(--sp-border);
        font-size: 14.5px;
        vertical-align: middle;
    }

    .cart-item-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .cart-item-img {
        width: 55px;
        height: 75px;
        object-fit: cover;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid var(--sp-border);
        flex-shrink: 0;
    }

    .cart-item-title {
        font-weight: 700;
        color: var(--sp-heading);
        text-decoration: none;
        display: block;
        line-height: 1.4;
        transition: color 0.2s;
    }

    .cart-item-title:hover {
        color: var(--sp-burgundy);
    }

    .format-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: var(--sp-radius-pill);
        font-size: 11.5px;
        font-weight: 700;
    }

    .format-hardcopy { background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; }
    .format-ebook { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

    .qty-input {
        width: 65px;
        padding: 7px 10px;
        border: 1.5px solid var(--sp-border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        text-align: center;
        font-weight: 700;
        outline: none;
        transition: border-color 0.2s;
    }

    .qty-input:focus {
        border-color: var(--sp-burgundy);
    }

    .btn-delete-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fef2f2;
        color: #dc2626 !important;
        border: 1px solid #fecaca;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-delete-item:hover {
        background: #dc2626;
        color: #ffffff !important;
        transform: scale(1.08);
    }

    /* Mobile Cart Cards (Hidden on Desktop) */
    .cart-mobile-list {
        display: none;
    }

    .cart-mobile-card {
        padding: 16px;
        border-bottom: 1px solid var(--sp-border);
        display: flex;
        gap: 12px;
        position: relative;
    }

    .cart-mobile-card:last-child {
        border-bottom: none;
    }

    .cart-mobile-card-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    /* Summary Card */
    .cart-summary {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 26px;
        box-shadow: var(--sp-shadow-md);
        position: sticky;
        top: 90px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14.5px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        border-top: 2px dashed var(--sp-border);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 20px;
        font-weight: 800;
        color: var(--sp-burgundy);
    }

    .coupon-box {
        display: flex;
        gap: 8px;
        margin: 20px 0;
    }

    .coupon-input {
        flex: 1;
        padding: 10px 14px;
        border: 1.5px solid var(--sp-border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        text-transform: uppercase;
        outline: none;
    }

    .coupon-input:focus {
        border-color: var(--sp-burgundy);
    }

    .btn-apply-coupon {
        padding: 10px 18px;
        background: var(--sp-burgundy);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-apply-coupon:hover {
        background: var(--sp-crimson);
    }

    .btn-checkout-proceed {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        font-size: 16px;
        font-weight: 800;
        padding: 14px;
        margin-top: 16px;
        background: var(--sp-burgundy);
        color: #ffffff !important;
        border: none;
        border-radius: var(--sp-radius-pill);
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(15, 118, 110, 0.3);
        transition: all 0.25s ease;
    }

    .btn-checkout-proceed:hover {
        background: var(--sp-crimson);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.4);
    }

    /* Cart Header & Action Buttons */
    .btn-cart-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #f8fafc;
        color: var(--sp-burgundy) !important;
        border: 1.5px solid var(--sp-border);
        border-radius: var(--sp-radius-pill);
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        white-space: nowrap;
    }

    .btn-cart-back:hover {
        background: #ffffff;
        border-color: var(--sp-burgundy);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15);
    }

    .btn-catalog-explore {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 28px;
        background: var(--sp-crimson);
        color: #ffffff !important;
        border: 1.5px solid var(--sp-crimson);
        border-radius: var(--sp-radius-pill);
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.25);
    }

    .btn-catalog-explore:hover {
        background: var(--sp-burgundy);
        border-color: var(--sp-burgundy);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.35);
    }

    @media (max-width: 860px) {
        .cart-grid { grid-template-columns: 1fr; }
        .cart-table-desktop { display: none; }
        .cart-mobile-list { display: block; }
        .cart-header-row {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 14px !important;
        }
        .btn-cart-back {
            align-self: flex-start;
            margin-left: 4px;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-page-header">
    <div class="container cart-header-row" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
        <div>
            <h1 style="font-size: 24px; color: var(--sp-burgundy); margin-bottom: 4px; font-weight:800;">
                <i class="bi bi-bag-check-fill text-success"></i> আপনার শপিং কার্ট
            </h1>
            <p style="color: var(--sp-muted); font-size: 14px; margin:0;">কার্টের বইয়ের সংখ্যা পরিবর্তন করতে পারেন অথবা সরাসরি চেকআউটে যেতে পারেন।</p>
        </div>
        <a href="{{ route('books.index') }}" class="btn-cart-back">
            <i class="bi bi-book"></i> আরও বই দেখুন
        </a>
    </div>
</div>

<div class="container">
    @if(empty($cart))
        <div style="background: #ffffff; border: 2px dashed var(--sp-border); border-radius: var(--sp-radius); padding: 70px 20px; text-align: center; margin-bottom: 60px;">
            <div style="font-size: 56px; margin-bottom: 12px;">🛍️</div>
            <h2 style="color: var(--sp-burgundy); margin-bottom: 8px; font-size: 22px; font-weight: 800;">আপনার কার্ট বর্তমানে খালি!</h2>
            <p style="color: var(--sp-muted); font-size: 14.5px; margin-bottom: 24px; max-width: 460px; margin-left:auto; margin-right:auto;">
                আপনি এখনো কোনো বই কার্টে যোগ করেননি। আমাদের নতুন ও বেস্টসেলার বইগুলোর সম্ভার থেকে আপনার পছন্দের বইটি বেছে নিন।
            </p>
            <a href="{{ route('books.index') }}" class="btn-catalog-explore">
                <i class="bi bi-grid-fill"></i> বইয়ের ক্যাটালগ ঘুরে দেখুন
            </a>
        </div>
    @else
        <div class="cart-grid">
            <!-- Items Form -->
            <form action="{{ route('cart.update') }}" method="POST" class="cart-table-card">
                @csrf

                <!-- Desktop Table View -->
                <div class="cart-table-desktop">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>বইয়ের নাম ও বিবরণ</th>
                                <th>ফরম্যাট</th>
                                <th>মূল্য</th>
                                <th>পরিমাণ</th>
                                <th>মোট</th>
                                <th style="text-align:center;">মুছে ফেলুন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $key => $item)
                                <tr>
                                    <td>
                                        <div class="cart-item-info">
                                            <img src="{{ $item['cover_image'] }}" alt="{{ $item['title'] }}" class="cart-item-img">
                                            <div>
                                                <a href="{{ route('books.show', $item['slug']) }}" class="cart-item-title">
                                                    {{ $item['title'] }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="format-badge {{ $item['format'] === 'ebook' ? 'format-ebook' : 'format-hardcopy' }}">
                                            {{ $item['format'] === 'ebook' ? 'ডিজিটাল ই-বুক' : 'মুদ্রিত হার্ডকপি' }}
                                        </span>
                                    </td>
                                    <td>৳ {{ number_format($item['price']) }}</td>
                                    <td>
                                        @if($item['format'] === 'ebook')
                                            <span style="font-weight:700; color:var(--sp-muted);">১টি</span>
                                        @else
                                            <input type="number" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}" min="1" max="50" class="qty-input">
                                        @endif
                                    </td>
                                    <td><strong style="color:var(--sp-burgundy);">৳ {{ number_format($item['price'] * $item['quantity']) }}</strong></td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('cart.remove', $key) }}" class="btn-delete-item" title="কার্ট থেকে মুছে ফেলুন" onclick="return confirm('আপনি কি বইটি কার্ট থেকে মুছে ফেলতে চান?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View (Page 7) -->
                <div class="cart-mobile-list">
                    @foreach($cart as $key => $item)
                        <div class="cart-mobile-card">
                            <img src="{{ $item['cover_image'] }}" alt="{{ $item['title'] }}" class="cart-item-img">
                            <div class="cart-mobile-card-details">
                                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                                    <a href="{{ route('books.show', $item['slug']) }}" class="cart-item-title" style="font-size:14.5px;">
                                        {{ $item['title'] }}
                                    </a>
                                    <a href="{{ route('cart.remove', $key) }}" class="btn-delete-item" style="width:30px; height:30px; font-size:13px;" title="মুছে ফেলুন" onclick="return confirm('আপনি কি বইটি কার্ট থেকে মুছে ফেলতে চান?')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>

                                <div style="display:flex; align-items:center; gap:8px; margin:2px 0;">
                                    <span class="format-badge {{ $item['format'] === 'ebook' ? 'format-ebook' : 'format-hardcopy' }}">
                                        {{ $item['format'] === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}
                                    </span>
                                    <span style="font-size:13px; color:var(--sp-muted);">৳ {{ number_format($item['price']) }}</span>
                                </div>

                                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:6px;">
                                    <div>
                                        @if($item['format'] === 'ebook')
                                            <span style="font-size:12.5px; font-weight:700; color:var(--sp-muted);">পরিমাণ: ১টি</span>
                                        @else
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <span style="font-size:12px; color:var(--sp-muted);">সংখ্যা:</span>
                                                <input type="number" name="quantities[{{ $key }}]" value="{{ $item['quantity'] }}" min="1" max="50" class="qty-input" style="width:55px; padding:4px 6px; font-size:13px;">
                                            </div>
                                        @endif
                                    </div>
                                    <strong style="font-size:15px; color:var(--sp-burgundy);">
                                        ৳ {{ number_format($item['price'] * $item['quantity']) }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="padding: 14px 18px; background: #f8fafc; border-top: 1px solid var(--sp-border); display: flex; justify-content: space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <a href="{{ route('books.index') }}" style="font-size: 13.5px; font-weight:700; color:var(--sp-burgundy); text-decoration:none;">
                        <i class="bi bi-arrow-left"></i> আরও বই যোগ করুন
                    </a>
                    <button type="submit" class="btn-apply-coupon" style="padding:8px 16px; font-size:13px;">
                        <i class="bi bi-arrow-repeat"></i> কার্ট আপডেট করুন
                    </button>
                </div>
            </form>

            <!-- Summary -->
            <div class="cart-summary">
                <h3 style="font-size: 18px; color: var(--sp-burgundy); margin-bottom: 16px; font-weight:800;">
                    <i class="bi bi-receipt me-1"></i> অর্ডার সারাংশ
                </h3>

                <div class="summary-line">
                    <span style="color: var(--sp-muted);">বইয়ের সাবটোটাল:</span>
                    <strong>৳ {{ number_format($subtotal) }}</strong>
                </div>

                @if($discount > 0)
                    <div class="summary-line" style="color: #16a34a;">
                        <span>কুপন ছাড় ({{ session('coupon_code') }}):</span>
                        <strong>- ৳ {{ number_format($discount) }}</strong>
                    </div>
                    <div style="font-size: 12px; margin-bottom: 10px;">
                        <a href="{{ route('cart.coupon.remove') }}" style="color: #dc2626; text-decoration:none; font-weight:600;">
                            <i class="bi bi-x-circle"></i> কুপন বাতিল করুন
                        </a>
                    </div>
                @endif

                <div class="summary-line">
                    <span style="color: var(--sp-muted);">ডেলিভারি চার্জ:</span>
                    <small style="color: var(--sp-muted);">পরবর্তী ধাপে নির্ধারিত হবে</small>
                </div>

                <div class="summary-total">
                    <span>সর্বমোট দেয়:</span>
                    <span>৳ {{ number_format($total) }}</span>
                </div>

                <!-- Coupon Box -->
                <form action="{{ route('cart.coupon') }}" method="POST" class="coupon-box">
                    @csrf
                    <input type="text" name="code" placeholder="কুপন কোড দিন" class="coupon-input" required>
                    <button type="submit" class="btn-apply-coupon">প্রয়োগ</button>
                </form>

                <a href="{{ route('checkout') }}" class="btn-checkout-proceed">
                    চেকআউটে এগিয়ে যান <i class="bi bi-arrow-right"></i>
                </a>
                
                <small style="display:block; text-align:center; color:var(--sp-muted); font-size:12px; margin-top:12px;">
                    <i class="bi bi-shield-check text-success"></i> শতভাগ নিরাপদ ও এনক্রিপ্টেড চেকআউট
                </small>
            </div>
        </div>
    @endif
</div>
@endsection
