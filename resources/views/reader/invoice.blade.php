@extends('layouts.app')

@section('title', 'ডিজিটাল ইনভয়েস #' . $order->order_number . ' | মুক্তাদার বইঘর')

@section('styles')
<style>
    .invoice-container {
        max-width: 800px;
        margin: 40px auto 70px;
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        padding: 40px;
    }

    /* Print styles */
    @media print {
        header, footer, .sub-nav, .no-print { display: none !important; }
        .invoice-container { border: none; box-shadow: none; margin: 0; padding: 20px; }
    }

    .invoice-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid var(--cream-bg);
        padding-bottom: 25px;
        margin-bottom: 25px;
    }

    /* Tracking Stepper */
    .status-stepper {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 30px 0 35px;
    }

    .status-stepper::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 20px;
        right: 20px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }

    .step-node {
        position: relative;
        z-index: 2;
        background: #fff;
        text-align: center;
        width: 90px;
    }

    .step-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: grid;
        place-items: center;
        margin: 0 auto 6px;
        font-weight: 700;
        font-size: 13px;
    }

    .step-node.completed .step-dot {
        background: #16a34a;
        color: #fff;
    }

    .step-node.active .step-dot {
        background: var(--gold);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(212, 155, 20, 0.2);
    }

    .step-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .step-node.active .step-label {
        color: var(--primary);
        font-weight: 700;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
    }

    .invoice-table th, .invoice-table td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .invoice-table th {
        background: #f8fafc;
        color: var(--text-muted);
        font-size: 13px;
    }
</style>
@endsection

@section('content')
<div class="container">
    @if(session('order_placed'))
        <div class="alert alert-success no-print" style="margin-top: 20px;">
            🎉 {{ session('order_placed') }}
        </div>
    @endif

    <div class="invoice-container">
        <!-- Top header -->
        <div class="invoice-top">
            <div>
                <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর" style="width: 50px; height: 50px; border-radius: 8px; margin-bottom: 8px;">
                <h2 style="color: var(--primary); font-size: 24px; font-weight: 800;">মুক্তাদার বইঘর</h2>
                <small style="color: var(--text-muted);">MUKTADA'S BOIGHOR | Digital Receipt</small>
            </div>
            <div style="text-align: right;">
                <h1 style="font-size: 22px; color: var(--gold-hover); margin-bottom: 4px;">অর্ডার #{{ $order->order_number }}</h1>
                <div style="font-size: 13px; color: var(--text-muted);">তারিখ: {{ $order->created_at->format('d M, Y — h:i A') }}</div>
                <div style="margin-top: 6px;">
                    <span class="badge badge-{{ $order->order_status }}">
                        {{ $order->statusInBengali() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Real-time Status Progression -->
        @php
            $statuses = ['pending', 'payment_verified', 'processing', 'shipped', 'delivered'];
            $currentIndex = array_search($order->order_status, $statuses);
            if ($currentIndex === false) $currentIndex = 0;
        @endphp

        <div class="status-stepper no-print">
            <div class="step-node {{ $currentIndex >= 0 ? 'completed' : '' }} {{ $currentIndex === 0 ? 'active' : '' }}">
                <div class="step-dot">১</div>
                <div class="step-label">অর্ডার গৃহীত</div>
            </div>
            <div class="step-node {{ $currentIndex >= 1 ? 'completed' : '' }} {{ $currentIndex === 1 ? 'active' : '' }}">
                <div class="step-dot">২</div>
                <div class="step-label">পেমেন্ট যাচাই</div>
            </div>
            <div class="step-node {{ $currentIndex >= 2 ? 'completed' : '' }} {{ $currentIndex === 2 ? 'active' : '' }}">
                <div class="step-dot">৩</div>
                <div class="step-label">প্রসেসিং</div>
            </div>
            <div class="step-node {{ $currentIndex >= 3 ? 'completed' : '' }} {{ $currentIndex === 3 ? 'active' : '' }}">
                <div class="step-dot">৪</div>
                <div class="step-label">শিপড</div>
            </div>
            <div class="step-node {{ $currentIndex >= 4 ? 'completed' : '' }} {{ $currentIndex === 4 ? 'active' : '' }}">
                <div class="step-dot">৫</div>
                <div class="step-label">ডেলিভারড</div>
            </div>
        </div>

        @if($order->courier_tracking_id)
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px 18px; border-radius: 8px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                <span>🚚 কুরিয়ার ট্র্যাকিং নম্বর (Steadfast/Pathao): <strong>{{ $order->courier_tracking_id }}</strong></span>
                <span style="font-size: 13px; color: #166534; font-weight: 700;">কুরিয়ারে হস্তান্তর হয়েছে</span>
            </div>
        @endif

        <!-- Customer & Delivery info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px; font-size: 14px;">
            <div>
                <strong style="color: var(--primary); display: block; margin-bottom: 6px; font-size: 15px;">গ্রাহকের তথ্য:</strong>
                <div>নাম: <strong>{{ $order->customer_name }}</strong></div>
                <div>মোবাইল: {{ $order->customer_phone }}</div>
                <div>ইমেইল: {{ $order->customer_email }}</div>
            </div>
            <div>
                <strong style="color: var(--primary); display: block; margin-bottom: 6px; font-size: 15px;">ডেলিভারি ও পেমেন্ট বিবরণ:</strong>
                @if($order->delivery_address)
                    <div>ঠিকানা: {{ $order->delivery_address }}</div>
                    <div>এলাকা: {{ $order->delivery_zone === 'dhaka' ? 'ঢাকা সিটির ভেতরে' : 'ঢাকা সিটির বাইরে' }}</div>
                @else
                    <div>ডেলিভারির ধরন: ডিজিটাল ই-বুক (অনলাইন রিডার)</div>
                @endif
                <div>পেমেন্ট মেথড: <strong style="text-transform: uppercase;">{{ $order->payment_method }}</strong></div>
                @if($order->payment_trx_id)
                    <div>TrxID: <code>{{ $order->payment_trx_id }}</code></div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>বইয়ের নাম</th>
                    <th>ধরন</th>
                    <th>দর</th>
                    <th>সংখ্যা</th>
                    <th style="text-align: right;">মোট</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->book->title }}</strong>
                            <small style="display: block; color: var(--text-muted);">{{ $item->book->author_name }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $item->format === 'ebook' ? 'badge-verified' : 'badge-processing' }}">
                                {{ $item->format === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}
                            </span>
                        </td>
                        <td>৳ {{ number_format($item->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right;"><strong>৳ {{ number_format($item->total) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; color: var(--text-muted);">উপমোট:</td>
                    <td style="text-align: right;">৳ {{ number_format($order->subtotal) }}</td>
                </tr>
                @if($order->discount > 0)
                    <tr>
                        <td colspan="4" style="text-align: right; color: #16a34a;">কুপন ছাড়:</td>
                        <td style="text-align: right; color: #16a34a;">- ৳ {{ number_format($order->discount) }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4" style="text-align: right; color: var(--text-muted);">ডেলিভারি চার্জ:</td>
                    <td style="text-align: right;">৳ {{ number_format($order->delivery_charge) }}</td>
                </tr>
                <tr style="font-size: 18px; font-weight: 800; color: var(--primary);">
                    <td colspan="4" style="text-align: right;">সর্বমোট:</td>
                    <td style="text-align: right;">৳ {{ number_format($order->total) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Actions -->
        <div class="no-print" style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('home') }}" class="btn btn-outline">← হোমপেজে ফিরুন</a>
            <div style="display: flex; gap: 10px;">
                @if($order->items->where('format', 'ebook')->isNotEmpty())
                    <a href="{{ route('reader.library') }}" class="btn btn-gold">📚 My Library-তে যান</a>
                @endif
                <button type="button" class="btn btn-primary" onclick="window.print()">🖨️ ইনভয়েস প্রিন্ট করুন</button>
            </div>
        </div>
    </div>
</div>
@endsection
