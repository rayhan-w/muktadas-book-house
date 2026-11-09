@extends('layouts.admin')

@section('title', 'রিভিউ মডারেশন | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'পাঠকদের রিভিউ মডারেশন')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>পাঠকদের রিভিউ ও রেটিং ({{ $reviews->total() }})</h2>
            <small style="color: var(--admin-muted);">রিভিউ সরাসরি ওয়েবসাইটে প্রদর্শিত হবে না। অ্যাডমিন অনুমোদন করার পরেই তা বইয়ের পেজে দেখা যাবে।</small>
        </div>
    </div>

    @if($reviews->isEmpty())
        <p style="text-align: center; color: var(--admin-muted); padding: 40px;">কোনো রিভিউ পাওয়া যায়নি।</p>
    @else
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>বইয়ের নাম</th>
                        <th>পাঠক</th>
                        <th>রেটিং</th>
                        <th>মন্তব্য</th>
                        <th>স্ট্যাটাস</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $rev)
                        <tr>
                            <td>
                                <strong>{{ $rev->book->title }}</strong>
                            </td>
                            <td>
                                <div>{{ $rev->customer_name }}</div>
                                <small style="color: var(--admin-muted);">{{ $rev->customer_email }}</small>
                                @if($rev->is_verified_purchase)
                                    <span style="display: block; font-size: 10px; color: #16a34a; font-weight: 700;">✓ ভেরিফাইড ক্রেতা</span>
                                @endif
                            </td>
                            <td>
                                <span style="color: #f59e0b; font-weight: 700;">
                                    @for($i = 0; $i < $rev->rating; $i++) ★ @endfor
                                </span>
                            </td>
                            <td style="max-width: 300px; font-size: 13px;">
                                “{{ $rev->comment }}”
                            </td>
                            <td>
                                @if($rev->status === 'approved')
                                    <span class="badge badge-delivered">অনুমোদিত (পাবলিক)</span>
                                @elseif($rev->status === 'pending')
                                    <span class="badge badge-pending">অপেক্ষমাণ</span>
                                @else
                                    <span class="badge badge-cancelled">প্রত্যাখ্যাত</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    @if($rev->status !== 'approved')
                                        <form action="{{ route('admin.reviews.update-status', $rev->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn-sm btn-green" style="padding: 4px 8px;">অনুমোদন</button>
                                        </form>
                                    @endif
                                    @if($rev->status !== 'rejected')
                                        <form action="{{ route('admin.reviews.update-status', $rev->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn-sm btn-gray" style="padding: 4px 8px;">রিজেক্ট</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('রিভিউটি মুছে ফেলতে চান?')">
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
        </div>

        <div style="margin-top: 20px;">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
