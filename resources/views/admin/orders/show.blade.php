@extends('layouts.admin')

@section('title', 'অর্ডার বিবরণ #' . $order->order_number . ' | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'অর্ডার #' . $order->order_number . ' পরিচালনা')

@section('content')
<div class="grid-2">
    <!-- Left: Order Details & Items -->
    <div>
        <div class="admin-card">
            <div class="card-header">
                <h2>অর্ডারের বিবরণ ও আইটেমসমূহ</h2>
                <a href="{{ route('orders.invoice', $order->order_number) }}" target="_blank" class="btn-sm btn-gray">
                    <i class="bi bi-printer"></i> ইনভয়েস প্রিন্ট
                </a>
            </div>

            <table class="data-table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>বই</th>
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
                                <small style="display: block; color: var(--admin-muted);">লেখক: {{ $item->book->author_name }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $item->format === 'ebook' ? 'badge-verified' : 'badge-processing' }}">
                                    {{ $item->format === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}
                                </span>
                            </td>
                            <td>৳ {{ number_format($item->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align: right;">৳ {{ number_format($item->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; color: var(--admin-muted);">সাবটোটাল:</td>
                        <td style="text-align: right;">৳ {{ number_format($order->subtotal) }}</td>
                    </tr>
                    @if($order->discount > 0)
                        <tr>
                            <td colspan="4" style="text-align: right; color: #16a34a;">কুপন ছাড়:</td>
                            <td style="text-align: right; color: #16a34a;">- ৳ {{ number_format($order->discount) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4" style="text-align: right; color: var(--admin-muted);">ডেলিভারি চার্জ:</td>
                        <td style="text-align: right;">৳ {{ number_format($order->delivery_charge) }}</td>
                    </tr>
                    <tr style="font-weight: 800; font-size: 16px;">
                        <td colspan="4" style="text-align: right;">সর্বমোট:</td>
                        <td style="text-align: right; color: #16a34a;">৳ {{ number_format($order->total) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Customer & Delivery -->
            <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 18px; font-size: 14px;">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: var(--admin-dark);">গ্রাহকের তথ্য ও ঠিকানা</h3>
                <p>নাম: <strong>{{ $order->customer_name }}</strong></p>
                <p>ফোন: <strong>{{ $order->customer_phone }}</strong></p>
                <p>ইমেইল: {{ $order->customer_email }}</p>
                @if($order->delivery_address)
                    <p style="margin-top: 6px;">ঠিকানা: <strong>{{ $order->delivery_address }}</strong> ({{ $order->delivery_zone === 'dhaka' ? 'ঢাকা সিটির ভেতরে' : 'ঢাকা সিটির বাইরে' }})</p>
                @endif
                @if($order->delivery_instruction)
                    <p style="color: #b45309; margin-top: 4px;">নির্দেশনা: {{ $order->delivery_instruction }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Right: Status Update Form -->
    <div>
        <div class="admin-card">
            <div class="card-header">
                <h2>স্ট্যাটাস ও পেমেন্ট আপডেট</h2>
            </div>

            <!-- Payment Details Box -->
            <div style="background: #fffdf5; border: 1px solid #fde68a; border-radius: 8px; padding: 16px; margin-bottom: 20px; font-size: 14px;">
                <h4 style="color: #92400e; margin-bottom: 6px;">পেমেন্ট তথ্য:</h4>
                <p>মাধ্যম: <strong style="text-transform: uppercase;">{{ $order->payment_method }}</strong></p>
                @if($order->payment_trx_id)
                    <p>Transaction ID: <code style="background: #fff; padding: 2px 6px; border-radius: 4px; font-weight: 700;">{{ $order->payment_trx_id }}</code></p>
                @endif
                @if($order->payment_number)
                    <p>প্রেরক নম্বর: {{ $order->payment_number }}</p>
                @endif
                <p style="margin-top: 4px;">বর্তমান পেমেন্ট স্ট্যাটাস: 
                    <span class="badge {{ $order->payment_status === 'verified' ? 'badge-delivered' : 'badge-pending' }}">
                        {{ $order->paymentStatusInBengali() }}
                    </span>
                </p>
            </div>

            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">অর্ডার স্ট্যাটাস *</label>
                    <select name="order_status" class="form-control" style="font-weight: 700;">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>১. পেন্ডিং (Pending)</option>
                        <option value="payment_verified" {{ $order->order_status === 'payment_verified' ? 'selected' : '' }}>২. পেমেন্ট ভেরিফাইড (Payment Verified - সাথে সাথে ই-বুক লাইব্রেরিতে চলে যাবে)</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>৩. প্রসেসিং / প্যাকেজিং (Processing)</option>
                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>৪. শিপড / কুরিয়ারে হস্তান্তর (Shipped)</option>
                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>৫. ডেলিভারড সম্পন্ন (Delivered)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>বাতিল (Cancelled)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">পেমেন্ট ভেরিফিকেশন স্ট্যাটাস</label>
                    <select name="payment_status" class="form-control">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>অপেক্ষমাণ (Pending)</option>
                        <option value="verified" {{ $order->payment_status === 'verified' ? 'selected' : '' }}>যাচাইকৃত (Verified)</option>
                        <option value="rejected" {{ $order->payment_status === 'rejected' ? 'selected' : '' }}>প্রত্যাখ্যাত (Rejected)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">কুরিয়ার ট্র্যাকিং নম্বর (Steadfast / Pathao Tracking Code)</label>
                    <input type="text" name="courier_tracking_id" value="{{ old('courier_tracking_id', $order->courier_tracking_id) }}" class="form-control" placeholder="যেমন: ST-998234">
                    <small style="color: var(--admin-muted); font-size: 12px;">এই নম্বর দিলে পাঠক তার অ্যাকাউন্টে কুরিয়ার ট্র্যাকিং দেখতে পাবেন।</small>
                </div>

                <div class="form-group">
                    <label class="form-label">অ্যাডমিন নোট / বিশেষ মন্তব্য (অভ্যন্তরীণ)</label>
                    <textarea name="admin_notes" rows="2" class="form-control" placeholder="যেমন: কাস্টমারকে ফোন করে ঠিকানা কনফার্ম করা হয়েছে...">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                </div>

                <button type="submit" class="btn-sm btn-blue" style="width: 100%; padding: 12px; font-size: 15px; justify-content: center;">
                    ✓ স্ট্যাটাস সংরক্ষণ করুন
                </button>
            </form>

            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই অর্ডারটি মুছে ফেলতে চান?')" style="margin-top: 15px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-sm btn-red" style="width: 100%; justify-content: center;">
                    অর্ডার ডিলিট করুন
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
