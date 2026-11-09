@extends('layouts.admin')

@section('title', 'মেম্বারশিপ পরিচালনা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'মেম্বারশিপ প্যাকেজ ও সদস্য তালিকা')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>মেম্বারশিপ প্ল্যান সেটিংস</h2>
            <small style="color: var(--admin-muted);">মেম্বারশিপের মূল্য, ছাড়ের শতাংশ ও সুবিধা পরিবর্তন করুন।</small>
        </div>
    </div>

    <div class="grid-3">
        @foreach($memberships as $plan)
            <div style="background: #f8fafc; border: 1.5px solid var(--admin-border); border-radius: 8px; padding: 20px;">
                <h3 style="font-size: 18px; color: var(--admin-dark); margin-bottom: 12px;">{{ $plan->title }}</h3>

                <form action="{{ route('admin.memberships.update', $plan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="title" value="{{ $plan->title }}">

                    <div class="form-group">
                        <label class="form-label">ফি / মূল্য (টাকা)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $plan->price) }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">বইয়ে ছাড়ের শতাংশ (%)</label>
                        <input type="number" step="0.01" name="discount_percent" value="{{ old('discount_percent', $plan->discount_percent) }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ফ্রি ই-বুকের সংখ্যা</label>
                        <input type="number" name="free_ebooks_count" value="{{ old('free_ebooks_count', $plan->free_ebooks_count) }}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label">সুবিধাসমূহ (প্রতি লাইনে একটি)</label>
                        <textarea name="benefits" rows="4" class="form-control">{{ old('benefits', $plan->benefits) }}</textarea>
                    </div>

                    <button type="submit" class="btn-sm btn-blue" style="width: 100%; justify-content: center;">
                        আপডেট করুন
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <h2>সক্রিয় মেম্বার ও ভিআইপি পাঠক ({{ $members->count() }})</h2>
    </div>

    @if($members->isEmpty())
        <p style="color: var(--admin-muted); text-align: center; padding: 30px;">এখনো কোনো মেম্বারশিপ গ্রাহক নেই।</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>সদস্যের নাম</th>
                    <th>ইমেইল</th>
                    <th>মোবাইল</th>
                    <th>প্ল্যান</th>
                    <th>মেয়াদ উত্তীর্ণের তারিখ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                    <tr>
                        <td><strong>{{ $m->name }}</strong></td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->phone ?? '—' }}</td>
                        <td><span class="badge badge-delivered">{{ $m->membership_plan }}</span></td>
                        <td>{{ $m->membership_expires_at ? $m->membership_expires_at->format('d M, Y') : 'আজীবন' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
