@extends('layouts.admin')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড | মুক্তাদার বইঘর')
@section('page_title', 'ড্যাশবোর্ড ওভারভিউ')

@section('content')

@if($pendingPublishers > 0 || $pendingPublisherBooks > 0)
    <div style="background: #fffbeb; border: 2px solid #f59e0b; border-radius: 10px; padding: 16px 20px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 26px;">🔔</span>
            <div>
                <strong style="color: #92400e; font-size: 15px;">পাবলিশার পোর্টালে নতুন অ্যাকশন পেন্ডিং আছে:</strong>
                <div style="font-size: 13.5px; color: #78350f; margin-top: 2px;">
                    @if($pendingPublishers > 0)
                        <span>• <strong>{{ $pendingPublishers }}টি</strong> প্রকাশনীর আবেদন পর্যালোচনার অপেক্ষায়</span>
                    @endif
                    @if($pendingPublishers > 0 && $pendingPublisherBooks > 0)
                        <span style="margin: 0 6px;">|</span>
                    @endif
                    @if($pendingPublisherBooks > 0)
                        <span>• <strong>{{ $pendingPublisherBooks }}টি</strong> প্রকাশকদের জমাকৃত বই অনুমোদনের অপেক্ষায়</span>
                    @endif
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 8px;">
            @if($pendingPublishers > 0)
                <a href="{{ route('admin.publishers.index', ['status' => 'pending']) }}" class="btn-sm btn-yellow" style="text-decoration: none;">প্রকাশনী দেখুন</a>
            @endif
            @if($pendingPublisherBooks > 0)
                <a href="{{ route('admin.publishers.books', ['status' => 'pending']) }}" class="btn-sm btn-blue" style="text-decoration: none;">বই অনুমোদন করুন</a>
            @endif
        </div>
    </div>
@endif

<!-- KPI Cards -->
<div class="grid-4" style="margin-bottom: 25px;">
    <div class="admin-card" style="margin-bottom: 0;">
        <div style="font-size: 13px; color: var(--admin-muted);">মোট বিক্রয় (আয়)</div>
        <div style="font-size: 26px; font-weight: 800; color: #16a34a; margin: 6px 0;">৳ {{ number_format($totalRevenue) }}</div>
        <small style="color: var(--admin-muted);">অনুমোদিত অর্ডারসমূহ থেকে</small>
    </div>

    <div class="admin-card" style="margin-bottom: 0;">
        <div style="font-size: 13px; color: var(--admin-muted);">পেন্ডিং অর্ডার</div>
        <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 6px 0;">{{ $pendingOrders }}</div>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" style="font-size: 12px; color: var(--admin-primary); font-weight: 700;">নজর দেওয়া প্রয়োজন →</a>
    </div>

    <div class="admin-card" style="margin-bottom: 0;">
        <div style="font-size: 13px; color: var(--admin-muted);">মোট বই ক্যাটালগে</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--admin-dark); margin: 6px 0;">{{ $totalBooks }}</div>
        <a href="{{ route('admin.books.index') }}" style="font-size: 12px; color: var(--admin-primary); font-weight: 700;">বই পরিচালনা →</a>
    </div>

    <div class="admin-card" style="margin-bottom: 0;">
        <div style="font-size: 13px; color: var(--admin-muted);">নিবন্ধিত পাঠক</div>
        <div style="font-size: 26px; font-weight: 800; color: #2563eb; margin: 6px 0;">{{ $totalCustomers }}</div>
        <a href="{{ route('admin.customers.index') }}" style="font-size: 12px; color: var(--admin-primary); font-weight: 700;">গ্রাহক তালিকা →</a>
    </div>
</div>

<div class="grid-2" style="margin-bottom: 25px;">
    <!-- Sales breakdown by format -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2>ফরম্যাট অনুযায়ী বিক্রয়</h2>
        </div>
        <div style="display: flex; gap: 30px; align-items: center; padding: 15px 0;">
            <div style="flex: 1; background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 18px; text-align: center;">
                <span style="font-size: 24px;">📦</span>
                <div style="font-size: 13px; color: var(--admin-muted); margin-top: 5px;">হার্ডকপি বিক্রি</div>
                <strong style="font-size: 20px; color: var(--admin-dark); display: block; margin-top: 4px;">৳ {{ number_format($hardcopySales) }}</strong>
            </div>
            <div style="flex: 1; background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 18px; text-align: center;">
                <span style="font-size: 24px;">📱</span>
                <div style="font-size: 13px; color: var(--admin-muted); margin-top: 5px;">ই-বুক বিক্রি</div>
                <strong style="font-size: 20px; color: #2563eb; display: block; margin-top: 4px;">৳ {{ number_format($ebookSales) }}</strong>
            </div>
        </div>
    </div>

    <!-- Quick action links -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2>জরুরি অ্যাকশন</h2>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <a href="{{ route('admin.books.create') }}" class="btn-sm btn-blue" style="padding: 12px; justify-content: center;">+ নতুন বই যোগ করুন</a>
            <a href="{{ route('admin.payments.index') }}" class="btn-sm btn-green" style="padding: 12px; justify-content: center;">💳 পেমেন্ট নম্বর পরিবর্তন</a>
            <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-gray" style="padding: 12px; justify-content: center;">🛍️ সকল অর্ডার দেখুন</a>
            <a href="{{ route('admin.settings.index') }}" class="btn-sm btn-gray" style="padding: 12px; justify-content: center;">⚙️ সাইট সেটিংস</a>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="admin-card">
    <div class="card-header">
        <h2>সাম্প্রতিক অর্ডারসমূহ</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-blue">সব অর্ডার দেখুন →</a>
    </div>

    @if($recentOrders->isEmpty())
        <p style="color: var(--admin-muted); text-align: center; padding: 30px;">এখনো কোনো অর্ডার আসেনি।</p>
    @else
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>অর্ডার আইডি</th>
                        <th>গ্রাহকের নাম</th>
                        <th>ফোন নম্বর</th>
                        <th>পেমেন্ট মেথড</th>
                        <th>পরিমাণ</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td><strong style="text-transform: uppercase;">{{ $order->payment_method }}</strong></td>
                            <td>৳ {{ number_format($order->total) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->order_status }}">
                                    {{ $order->statusInBengali() }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-sm btn-blue">বিবরণ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
