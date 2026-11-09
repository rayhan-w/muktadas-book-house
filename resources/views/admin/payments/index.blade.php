@extends('layouts.admin')

@section('title', 'পেমেন্ট সেটিংস | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'পেমেন্ট মেথড ও নম্বর পরিচালনা')

@section('content')
<div class="grid-2">
    <!-- Payment numbers form -->
    <div class="admin-card">
        <div class="card-header">
            <div>
                <h2>ম্যানুয়াল পেমেন্ট নম্বর ও নির্দেশনাবলী</h2>
                <small style="color: var(--admin-muted);">এখানে পরিবর্তিত নম্বরগুলো সরাসরি ওয়েবসাইটের চেকআউট পেজে প্রদর্শিত হবে।</small>
            </div>
        </div>

        <form action="{{ route('admin.payments.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">bKash (বিকাশ) নম্বর ও অ্যাকাউন্ট টাইপ *</label>
                <input type="text" name="bkash_number" value="{{ old('bkash_number', $numbers['bkash']) }}" required class="form-control" placeholder="যেমন: 01700-112233 (Merchant / Send Money)">
            </div>

            <div class="form-group">
                <label class="form-label">Nagad (নগদ) নম্বর ও অ্যাকাউন্ট টাইপ *</label>
                <input type="text" name="nagad_number" value="{{ old('nagad_number', $numbers['nagad']) }}" required class="form-control" placeholder="যেমন: 01800-445566 (Merchant)">
            </div>

            <div class="form-group">
                <label class="form-label">Upay (উপায়) নম্বর *</label>
                <input type="text" name="upay_number" value="{{ old('upay_number', $numbers['upay']) }}" required class="form-control" placeholder="যেমন: 01900-778899 (Personal)">
            </div>

            <div class="form-group">
                <label class="form-label">পাঠকদের জন্য পেমেন্ট নির্দেশনাবলী</label>
                <textarea name="payment_instruction" rows="4" class="form-control">{{ old('payment_instruction', $numbers['instruction']) }}</textarea>
                <small style="color: var(--admin-muted); font-size: 12px;">টাকা পাঠানোর নিয়ম ও ট্রানজেকশন আইডি দেওয়ার নিয়মাবলি এখানে লিখুন।</small>
            </div>

            <button type="submit" class="btn-sm btn-blue" style="padding: 12px 24px; font-size: 15px;">
                ✓ পেমেন্ট সেটিংস সংরক্ষণ করুন
            </button>
        </form>
    </div>

    <!-- Pending payments needing approval -->
    <div class="admin-card">
        <div class="card-header">
            <div>
                <h2>অনুমোদনের অপেক্ষায় থাকা পেমেন্ট ({{ $pendingPayments->count() }})</h2>
                <small style="color: var(--admin-muted);">TrxID মিলিয়ে দ্রুত পেমেন্ট ভেরিফাই করুন।</small>
            </div>
        </div>

        @if($pendingPayments->isEmpty())
            <p style="color: var(--admin-muted); text-align: center; padding: 40px;">কোনো অপেক্ষমাণ পেমেন্ট নেই।</p>
        @else
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>অর্ডার</th>
                            <th>গ্রাহক</th>
                            <th>মাধ্যম ও TrxID</th>
                            <th>টাকা</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPayments as $p)
                            <tr>
                                <td><strong>#{{ $p->order_number }}</strong></td>
                                <td>
                                    <div>{{ $p->customer_name }}</div>
                                    <small>{{ $p->customer_phone }}</small>
                                </td>
                                <td>
                                    <strong style="text-transform: uppercase;">{{ $p->payment_method }}</strong><br>
                                    <code>{{ $p->payment_trx_id }}</code>
                                </td>
                                <td><strong>৳ {{ number_format($p->total) }}</strong></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $p->id) }}" class="btn-sm btn-green" style="font-size: 12px;">যাচাই ও অনুমোদন</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
