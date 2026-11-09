@extends('layouts.admin')

@section('title', 'অর্ডার ব্যবস্থাপনা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'অর্ডার ব্যবস্থাপনা')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>সকল অর্ডার ({{ $counts['all'] }})</h2>
            <small style="color: var(--admin-muted);">পেন্ডিং অর্ডার যাচাই, স্ট্যাটাস পরিবর্তন ও কুরিয়ার ট্র্যাকিং পরিচালনা করুন।</small>
        </div>
    </div>

    <!-- Status Tabs -->
    <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
        <a href="{{ route('admin.orders.index') }}" class="btn-sm {{ !request('status') ? 'btn-blue' : 'btn-gray' }}">
            সবগুলো ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn-sm {{ request('status') === 'pending' ? 'btn-blue' : 'btn-gray' }}" style="background: #fef3c7; color: #92400e;">
            পেন্ডিং ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'payment_verified']) }}" class="btn-sm {{ request('status') === 'payment_verified' ? 'btn-blue' : 'btn-gray' }}">
            পেমেন্ট অনুমোদিত ({{ $counts['payment_verified'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn-sm {{ request('status') === 'processing' ? 'btn-blue' : 'btn-gray' }}">
            প্রসেসিং ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="btn-sm {{ request('status') === 'shipped' ? 'btn-blue' : 'btn-gray' }}">
            শিপড ({{ $counts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn-sm {{ request('status') === 'delivered' ? 'btn-blue' : 'btn-gray' }}">
            ডেলিভারড ({{ $counts['delivered'] }})
        </a>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 10px; margin-bottom: 20px; max-width: 500px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="অর্ডার আইডি, ফোন বা TrxID দিয়ে খুঁজুন..." class="form-control">
        <button type="submit" class="btn-sm btn-gray">খুঁজুন</button>
    </form>

    @if($orders->isEmpty())
        <p style="text-align: center; color: var(--admin-muted); padding: 40px;">কোনো অর্ডার পাওয়া যায়নি।</p>
    @else
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>অর্ডার নম্বর</th>
                        <th>গ্রাহকের নাম ও ফোন</th>
                        <th>বইয়ের সংখ্যা</th>
                        <th>মোট টাকা</th>
                        <th>পেমেন্ট</th>
                        <th>অর্ডার স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $ord)
                        <tr>
                            <td>
                                <strong>#{{ $ord->order_number }}</strong>
                                @if($ord->courier_tracking_id)
                                    <small style="display: block; color: #16a34a;">কুরিয়ার: {{ $ord->courier_tracking_id }}</small>
                                @endif
                            </td>
                            <td>
                                <div>{{ $ord->customer_name }}</div>
                                <small style="color: var(--admin-muted);">{{ $ord->customer_phone }}</small>
                            </td>
                            <td>{{ $ord->items->count() }}টি বই</td>
                            <td><strong>৳ {{ number_format($ord->total) }}</strong></td>
                            <td>
                                <span class="badge {{ $ord->payment_status === 'verified' ? 'badge-delivered' : 'badge-pending' }}">
                                    {{ $ord->payment_method }}: {{ $ord->paymentStatusInBengali() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $ord->order_status }}">
                                    {{ $ord->statusInBengali() }}
                                </span>
                            </td>
                            <td>{{ $ord->created_at->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn-sm btn-blue">বিস্তারিত ও আপডেট</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
