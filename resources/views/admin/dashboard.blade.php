@extends('layouts.admin')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড | মুক্তাদার বইঘর')
@section('page_title', 'ড্যাশবোর্ড ওভারভিউ')

@section('content')

@if($pendingPublishers > 0 || $pendingPublisherBooks > 0)
    <div style="background: #fffbeb; border: 2px solid #f59e0b; border-radius: 12px; padding: 16px 20px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.1);">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef3c7; border: 1px solid #fde68a; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #d97706; flex-shrink: 0;">
                <i class="bi bi-bell-fill"></i>
            </div>
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
                <a href="{{ route('admin.publishers.index', ['status' => 'pending']) }}" class="btn-sm btn-yellow" style="text-decoration: none; background: #f59e0b; color: #fff;">
                    <i class="bi bi-buildings"></i> প্রকাশনী দেখুন
                </a>
            @endif
            @if($pendingPublisherBooks > 0)
                <a href="{{ route('admin.publishers.books', ['status' => 'pending']) }}" class="btn-sm btn-blue" style="text-decoration: none;">
                    <i class="bi bi-check-circle"></i> বই অনুমোদন করুন
                </a>
            @endif
        </div>
    </div>
@endif

<!-- KPI Cards -->
<div class="grid-4" style="margin-bottom: 25px;">
    <div class="kpi-card">
        <div>
            <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">মোট বিক্রয় (আয়)</div>
            <div style="font-size: 26px; font-weight: 800; color: #16a34a; margin: 4px 0 6px;">৳ {{ number_format($totalRevenue) }}</div>
            <small style="color: var(--admin-muted); font-size: 12px;">অনুমোদিত অর্ডারসমূহ থেকে</small>
        </div>
        <div class="kpi-icon-box kpi-icon-emerald">
            <i class="bi bi-wallet2"></i>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">পেন্ডিং অর্ডার</div>
            <div style="font-size: 26px; font-weight: 800; color: #d97706; margin: 4px 0 6px;">{{ $pendingOrders }}</div>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" style="font-size: 12px; color: var(--admin-primary); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                নজর দেওয়া প্রয়োজন <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="kpi-icon-box kpi-icon-amber">
            <i class="bi bi-clock-history"></i>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">মোট বই ক্যাটালগে</div>
            <div style="font-size: 26px; font-weight: 800; color: var(--admin-dark); margin: 4px 0 6px;">{{ $totalBooks }}</div>
            <a href="{{ route('admin.books.index') }}" style="font-size: 12px; color: var(--admin-primary); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                বই পরিচালনা <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="kpi-icon-box kpi-icon-blue">
            <i class="bi bi-journal-album"></i>
        </div>
    </div>

    <div class="kpi-card">
        <div>
            <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">নিবন্ধিত পাঠক</div>
            <div style="font-size: 26px; font-weight: 800; color: #7c3aed; margin: 4px 0 6px;">{{ $totalCustomers }}</div>
            <a href="{{ route('admin.customers.index') }}" style="font-size: 12px; color: #7c3aed; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                গ্রাহক তালিকা <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="kpi-icon-box kpi-icon-purple">
            <i class="bi bi-people-fill"></i>
        </div>
    </div>
</div>

<div class="grid-2" style="margin-bottom: 25px;">
    <!-- Sales breakdown by format -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2 style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-pie-chart-fill" style="color: var(--admin-primary);"></i>
                ফরম্যাট অনুযায়ী বিক্রয়
            </h2>
        </div>
        <div style="display: flex; gap: 20px; align-items: center; padding: 10px 0;">
            <div style="flex: 1; background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 12px; padding: 18px; text-align: center;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 8px;">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">হার্ডকপি বিক্রি</div>
                <strong style="font-size: 22px; color: var(--admin-dark); display: block; margin-top: 4px;">৳ {{ number_format($hardcopySales) }}</strong>
            </div>
            <div style="flex: 1; background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 12px; padding: 18px; text-align: center;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #f0fdfa; color: #0d9488; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 8px;">
                    <i class="bi bi-tablet-landscape-fill"></i>
                </div>
                <div style="font-size: 13px; color: var(--admin-muted); font-weight: 600;">ই-বুক বিক্রি</div>
                <strong style="font-size: 22px; color: #0d9488; display: block; margin-top: 4px;">৳ {{ number_format($ebookSales) }}</strong>
            </div>
        </div>
    </div>

    <!-- Quick action links -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2 style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-lightning-charge-fill" style="color: #f59e0b;"></i>
                জরুরি অ্যাকশন
            </h2>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <a href="{{ route('admin.books.create') }}" class="btn-sm btn-blue" style="padding: 12px; justify-content: center;">
                <i class="bi bi-plus-circle-fill"></i> নতুন বই যোগ করুন
            </a>
            <a href="{{ route('admin.payments.index') }}" class="btn-sm btn-green" style="padding: 12px; justify-content: center;">
                <i class="bi bi-credit-card-2-front-fill"></i> পেমেন্ট নম্বর পরিবর্তন
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-gray" style="padding: 12px; justify-content: center;">
                <i class="bi bi-bag-check-fill"></i> সকল অর্ডার দেখুন
            </a>
            <a href="{{ route('admin.settings.index') }}" class="btn-sm btn-gray" style="padding: 12px; justify-content: center;">
                <i class="bi bi-gear-fill"></i> সাইট সেটিংস
            </a>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="admin-card">
    <div class="card-header">
        <h2 style="display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-clock-history" style="color: var(--admin-primary);"></i>
            সাম্প্রতিক অর্ডারসমূহ
        </h2>
        <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-blue">
            সব অর্ডার দেখুন <i class="bi bi-arrow-right"></i>
        </a>
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
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-sm btn-blue">
                                    <i class="bi bi-eye-fill"></i> বিবরণ
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
