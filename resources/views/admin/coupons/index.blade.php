@extends('layouts.admin')

@section('title', 'কুপন ও ছাড় | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'কুপন ও ডিসকাউন্ট পরিচালনা')

@section('content')
<div class="grid-2">
    <!-- List of coupons -->
    <div class="admin-card">
        <div class="card-header">
            <h2>সকল কুপন কোড ({{ $coupons->count() }})</h2>
        </div>

        @if($coupons->isEmpty())
            <p style="color: var(--admin-muted); text-align: center; padding: 30px;">কোনো কুপন তৈরি করা হয়নি।</p>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>কোড</th>
                        <th>ছাড়ের ধরন</th>
                        <th>ন্যূনতম অর্ডার</th>
                        <th>ব্যবহার</th>
                        <th>স্ট্যাটাস</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $c)
                        <tr>
                            <td><code>{{ $c->code }}</code></td>
                            <td>
                                {{ $c->discount_type === 'percent' ? $c->discount_value . '%' : '৳ ' . number_format($c->discount_value) }}
                            </td>
                            <td>৳ {{ number_format($c->min_spend) }}</td>
                            <td>{{ $c->times_used }} বার</td>
                            <td>
                                <span class="badge {{ $c->is_active ? 'badge-delivered' : 'badge-cancelled' }}">
                                    {{ $c->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <form action="{{ route('admin.coupons.toggle', $c->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-sm btn-gray" style="padding: 4px 8px;">
                                            {{ $c->is_active ? 'বন্ধ করুন' : 'চালু করুন' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.coupons.destroy', $c->id) }}" method="POST" onsubmit="return confirm('কুপনটি মুছে ফেলতে চান?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-red" style="padding: 4px 8px;">মুছুন</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Create Coupon Form -->
    <div class="admin-card">
        <div class="card-header">
            <h2>+ নতুন কুপন তৈরি করুন</h2>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">কুপন কোড (ইংরেজি বড় অক্ষরে) *</label>
                <input type="text" name="code" required class="form-control" placeholder="যেমন: EID20 বা BOIGHOR50" style="text-transform: uppercase;">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ছাড়ের ধরন *</label>
                    <select name="discount_type" class="form-control">
                        <option value="percent">শতাংশ (%)</option>
                        <option value="fixed">নির্দিষ্ট টাকা (৳)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">ছাড়ের পরিমাণ *</label>
                    <input type="number" step="0.01" name="discount_value" required class="form-control" placeholder="যেমন: 10 বা 50">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ন্যূনতম অর্ডারের পরিমাণ (টাকা)</label>
                    <input type="number" step="0.01" name="min_spend" value="300" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">মেয়াদ উত্তীর্ণের তারিখ</label>
                    <input type="date" name="valid_until" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">সর্বোচ্চ ব্যবহার সীমা (খালি রাখলে আনলিমিটেড)</label>
                <input type="number" name="usage_limit" class="form-control" placeholder="যেমন: 100">
            </div>

            <button type="submit" class="btn-sm btn-blue" style="padding: 10px 20px;">
                কুপন তৈরি করুন
            </button>
        </form>
    </div>
</div>
@endsection
