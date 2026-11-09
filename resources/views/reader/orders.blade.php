@extends('layouts.app')

@section('title', 'আমার সকল অর্ডার | মুক্তাদার বইঘর')

@section('content')
<div style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 30px 0; margin-bottom: 35px;">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 4px;">🛍️ আমার সকল অর্ডার</h1>
        <p style="color: var(--text-muted); font-size: 15px;">আপনার সকল হার্ডকপি ও ই-বুক অর্ডারের বিস্তারিত বিবরণ ও ডেলিভারি ট্র্যাকিং।</p>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    @if($orders->isEmpty())
        <div style="background: #fff; border: 1px dashed var(--border-color); border-radius: var(--radius); padding: 70px 20px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">📦</div>
            <h2 style="color: var(--primary); margin-bottom: 8px;">এখনো কোনো অর্ডার সম্পন্ন করা হয়নি</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">বই কার্টে যোগ করে সহজে অর্ডার নিশ্চিত করুন।</p>
            <a href="{{ route('books.index') }}" class="btn btn-gold">বই দেখুন</a>
        </div>
    @else
        <div style="display: grid; gap: 20px;">
            @foreach($orders as $ord)
                <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 25px; box-shadow: var(--shadow-sm);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 18px; font-weight: 800; color: var(--primary);">অর্ডার #{{ $ord->order_number }}</span>
                            <span style="color: var(--text-muted); font-size: 13px; margin-left: 10px;">{{ $ord->created_at->format('d M, Y — h:i A') }}</span>
                        </div>
                        <div>
                            <span class="badge badge-{{ $ord->order_status }}">{{ $ord->statusInBengali() }}</span>
                        </div>
                    </div>

                    <!-- Items -->
                    <div style="margin-bottom: 16px;">
                        @foreach($ord->items as $item)
                            <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 6px;">
                                <span>{{ $item->book->title }} ({{ $item->format === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}) × {{ $item->quantity }}</span>
                                <strong>৳ {{ number_format($item->total) }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 14px; color: var(--text-muted);">সর্বমোট: <strong>৳ {{ number_format($ord->total) }}</strong></span>
                            @if($ord->courier_tracking_id)
                                <div style="font-size: 12px; color: #166534; margin-top: 4px;">🚚 কুরিয়ার ট্র্যাকিং: <strong>{{ $ord->courier_tracking_id }}</strong></div>
                            @endif
                        </div>
                        <a href="{{ route('orders.invoice', $ord->order_number) }}" class="btn btn-outline" style="font-size: 13px; padding: 7px 15px;">
                            📄 ইনভয়েস ও রসিদ
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 30px;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
