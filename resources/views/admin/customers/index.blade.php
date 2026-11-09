@extends('layouts.admin')

@section('title', 'নিবন্ধিত পাঠক তালিকা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'নিবন্ধিত পাঠক ও গ্রাহকবৃন্দ')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>নিবন্ধিত পাঠকবৃন্দ ({{ $customers->total() }})</h2>
        </div>
    </div>

    <!-- Search form -->
    <form method="GET" action="{{ route('admin.customers.index') }}" style="display: flex; gap: 10px; margin-bottom: 20px; max-width: 400px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="নাম, ইমেইল বা ফোন দিয়ে খুঁজুন..." class="form-control">
        <button type="submit" class="btn-sm btn-gray">খুঁজুন</button>
    </form>

    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>পাঠকের নাম</th>
                    <th>ইমেইল</th>
                    <th>মোবাইল নম্বর</th>
                    <th>মোট অর্ডার</th>
                    <th>ই-বুক সংগ্রহ</th>
                    <th>মেম্বারশিপ</th>
                    <th>রেজিস্ট্রেশনের তারিখ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong></td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone ?? '—' }}</td>
                        <td>{{ $c->orders_count }}টি অর্ডার</td>
                        <td>{{ $c->library_count }}টি ই-বুক</td>
                        <td>
                            @if($c->membership_plan)
                                <span class="badge badge-delivered">{{ $c->membership_plan }}</span>
                            @else
                                <span class="badge badge-processing">সাধারণ</span>
                            @endif
                        </td>
                        <td>{{ $c->created_at->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $customers->links() }}
    </div>
</div>
@endsection
