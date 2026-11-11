@extends('layouts.app')

@section('title', 'চেকআউট ও অর্ডার কনফার্মেশন | মুক্তাদার বইঘর')

@section('styles')
<style>
    .checkout-header {
        background: #ffffff;
        border-bottom: 1px solid var(--sp-border);
        padding: 24px 0;
        margin-bottom: 30px;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 28px;
        margin-bottom: 60px;
        align-items: flex-start;
    }

    .checkout-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 28px;
        box-shadow: var(--sp-shadow-sm);
        margin-bottom: 24px;
    }

    .checkout-card h2 {
        font-size: 19px;
        font-weight: 800;
        color: var(--sp-burgundy);
        margin-bottom: 18px;
        border-bottom: 1.5px solid var(--sp-paste-light);
        padding-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--sp-heading);
    }

    .form-group input, .form-group textarea, .form-group select {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid var(--sp-border);
        border-radius: 8px;
        font-family: inherit;
        font-size: 14.5px;
        outline: none;
        transition: 0.2s ease;
        background: #f8fafc;
    }

    .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
        border-color: var(--sp-burgundy);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Delivery Zone Radio Cards */
    .zone-selection {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }

    .zone-label {
        border: 1.5px solid var(--sp-border);
        border-radius: 10px;
        padding: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 700;
        background: #f8fafc;
        transition: all 0.2s;
    }

    .zone-label.active {
        border-color: var(--sp-burgundy);
        background: #f0fdfa;
        color: var(--sp-burgundy);
    }

    /* Payment Option Cards */
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 18px;
    }

    .pay-opt {
        border: 1.5px solid var(--sp-border);
        border-radius: 10px;
        padding: 12px 6px;
        text-align: center;
        cursor: pointer;
        font-weight: 800;
        font-size: 13.5px;
        background: #f8fafc;
        transition: all 0.2s;
    }

    .pay-opt.active {
        border-color: var(--sp-burgundy);
        background: #f0fdfa;
        color: var(--sp-burgundy);
        box-shadow: 0 4px 10px rgba(15, 118, 110, 0.12);
    }

    .payment-instruction-box {
        background: #f0fdfa;
        border: 1.5px solid #99f6e4;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 18px;
        font-size: 14px;
        color: #134e4a;
    }

    /* Summary Card */
    .checkout-summary {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 26px;
        box-shadow: var(--sp-shadow-md);
        position: sticky;
        top: 90px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .summary-total-line {
        border-top: 2px dashed var(--sp-border);
        padding-top: 15px;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        font-size: 20px;
        font-weight: 800;
        color: var(--sp-burgundy);
    }

    .btn-submit-order {
        width: 100%;
        font-size: 16px;
        font-weight: 800;
        padding: 14px;
        margin-top: 20px;
        background: var(--sp-burgundy);
        color: #ffffff;
        border: none;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(15, 118, 110, 0.3);
    }

    .btn-submit-order:hover {
        background: var(--sp-crimson);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.4);
    }

    @media (max-width: 860px) {
        .checkout-grid { grid-template-columns: 1fr; }
        .form-row, .payment-methods-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endsection

@section('content')
<div class="checkout-header">
    <div class="container" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size: 24px; color: var(--sp-burgundy); margin-bottom: 4px; font-weight:800;">
                <i class="bi bi-shield-check text-success"></i> চেকআউট ও ডেলিভারি তথ্য
            </h1>
            <p style="color: var(--sp-muted); font-size: 14px; margin:0;">অর্ডার নিশ্চিত করতে নিচের তথ্যগুলো পূরণ করুন।</p>
        </div>
        <div>
            <a href="{{ route('cart.index') }}" class="checkout-back-btn">
                <i class="bi bi-arrow-left"></i> কার্টে ফিরে যান
            </a>
        </div>
    </div>
</div>

<div class="container">
    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="checkout-grid">
            <!-- Form Side -->
            <div>
                <!-- 1. Customer Information -->
                <div class="checkout-card">
                    <h2>১. গ্রাহকের তথ্য</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label>আপনার পূর্ণ নাম *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user?->name) }}" required placeholder="যেমন: মো. রহিম উদ্দিন">
                        </div>
                        <div class="form-group">
                            <label>মোবাইল নম্বর *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone', $user?->phone) }}" required placeholder="০১XXXXXXXXX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>ইমেইল অ্যাড্রেস *</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $user?->email) }}" required placeholder="example@mail.com">
                        <small style="color: var(--text-muted); font-size: 12px;">অর্ডার নিশ্চিতকরণ ও ডিজিটাল ইনভয়েস এই ইমেইলে পাঠানো হবে।</small>
                    </div>
                </div>

                <!-- 2. Delivery Address (for physical books) -->
                @if($hasHardcopy)
                    <div class="checkout-card">
                        <h2>২. ডেলিভারি এলাকা ও ঠিকানা</h2>
                        
                        <label style="font-size: 14px; font-weight: 600; display: block; margin-bottom: 8px;">ডেলিভারি জোন নির্বাচন করুন *</label>
                        <div class="zone-selection">
                            <label class="zone-label active" id="zoneDhakaLabel">
                                <input type="radio" name="delivery_zone" value="dhaka" checked onchange="updateDelivery(this.value)">
                                <div>
                                    <div>ঢাকা সিটির ভেতরে</div>
                                    <small style="color: var(--text-muted);">চার্জ: ৳ {{ number_format($deliveryDhaka) }}</small>
                                </div>
                            </label>
                            <label class="zone-label" id="zoneOutsideLabel">
                                <input type="radio" name="delivery_zone" value="outside_dhaka" onchange="updateDelivery(this.value)">
                                <div>
                                    <div>ঢাকা সিটির বাইরে</div>
                                    <small style="color: var(--text-muted);">চার্জ: ৳ {{ number_format($deliveryOutside) }}</small>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>পূর্ণাঙ্গ ডেলিভারি ঠিকানা (বাসা/রোড/এলাকা/উপজেলা/জেলা) *</label>
                            <textarea name="delivery_address" rows="3" required placeholder="সঠিক ও বিস্তারিত ঠিকানা দিন যাতে কুরিয়ার প্রতিনিধি সহজে খুঁজে পেতে পারেন...">{{ old('delivery_address', $user?->address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>বিশেষ ডেলিভারি নির্দেশনা (ঐচ্ছিক)</label>
                            <input type="text" name="delivery_instruction" placeholder="যেমন: বিকাল ৫টার পর ডেলিভারি দিন বা দারোয়ানের কাছে রাখুন">
                        </div>
                    </div>
                @else
                    <input type="hidden" name="delivery_zone" value="dhaka">
                @endif

                <!-- 3. Payment Method -->
                <div class="checkout-card">
                    <h2>৩. মূল্য পরিশোধ পদ্ধতি (Payment Method)</h2>

                    <div class="payment-methods-grid">
                        <label class="pay-opt active" id="optBkash">
                            <input type="radio" name="payment_method" value="bkash" checked onchange="updatePaymentMethod(this.value)">
                            <div>bKash</div>
                        </label>
                        <label class="pay-opt" id="optNagad">
                            <input type="radio" name="payment_method" value="nagad" onchange="updatePaymentMethod(this.value)">
                            <div>Nagad</div>
                        </label>
                        <label class="pay-opt" id="optUpay">
                            <input type="radio" name="payment_method" value="upay" onchange="updatePaymentMethod(this.value)">
                            <div>Upay</div>
                        </label>
                        @if($hasHardcopy)
                            <label class="pay-opt" id="optCod">
                                <input type="radio" name="payment_method" value="cod" onchange="updatePaymentMethod(this.value)">
                                <div>Cash on Delivery</div>
                            </label>
                        @endif
                    </div>

                    <div class="payment-instruction-box" id="payInstructionBox">
                        <strong style="color: var(--primary); display: block; margin-bottom: 4px;" id="payMethodTitle">বিকাশ পেমেন্ট নম্বর:</strong>
                        <div style="font-size: 18px; font-weight: 800; color: #d97706; margin-bottom: 8px;" id="payNumberDisplay">{{ $paymentSettings['bkash'] }}</div>
                        <p style="color: var(--text-muted); line-height: 1.6;" id="payGuideText">
                            {{ $paymentSettings['instruction'] }}
                        </p>
                    </div>

                    <div id="trxFields">
                        <div class="form-row">
                            <div class="form-group">
                                <label>ট্রানজেকশন আইডি (TrxID) *</label>
                                <input type="text" name="payment_trx_id" id="payment_trx_id" required placeholder="যেমন: 8N7X29A1">
                            </div>
                            <div class="form-group">
                                <label>যে নম্বর থেকে টাকা পাঠিয়েছেন</label>
                                <input type="text" name="payment_number" placeholder="০১XXXXXXXXX">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Side -->
            <div class="checkout-summary">
                <h3 style="font-size: 18px; color: var(--primary); margin-bottom: 16px;">অর্ডার সংক্ষেপ</h3>

                <div style="max-height: 240px; overflow-y: auto; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    @foreach($cart as $item)
                        <div class="summary-item">
                            <span>
                                {{ $item['title'] }} ({{ $item['format'] === 'ebook' ? 'ই-বুক' : 'হার্ডকপি' }}) × {{ $item['quantity'] }}
                            </span>
                            <strong>৳ {{ number_format($item['price'] * $item['quantity']) }}</strong>
                        </div>
                    @endforeach
                </div>

                <div class="summary-item">
                    <span style="color: var(--text-muted);">বইয়ের মূল্য:</span>
                    <strong>৳ {{ number_format($subtotal) }}</strong>
                </div>

                @if($discount > 0)
                    <div class="summary-item" style="color: #16a34a;">
                        <span>কুপন ছাড়:</span>
                        <strong>- ৳ {{ number_format($discount) }}</strong>
                    </div>
                @endif

                <div class="summary-item">
                    <span style="color: var(--text-muted);">ডেলিভারি চার্জ:</span>
                    <strong id="lblDeliveryCharge">৳ {{ number_format($hasHardcopy ? $deliveryDhaka : 0) }}</strong>
                </div>

                <div class="summary-total-line">
                    <span>সর্বমোট দেয়:</span>
                    <span id="lblTotalAmount">৳ {{ number_format(max(0, ($subtotal - $discount) + ($hasHardcopy ? $deliveryDhaka : 0))) }}</span>
                </div>

                <button type="submit" class="btn-submit-order">
                    <i class="bi bi-check2-circle me-1"></i> অর্ডার নিশ্চিত করুন
                </button>
                <small style="display: block; text-align: center; color: var(--text-muted); font-size: 12px; margin-top: 10px;">
                    🔒 আপনার তথ্য শতভাগ সুরক্ষিত
                </small>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const subtotal = {{ $subtotal }};
    const discount = {{ $discount }};
    const hasHardcopy = {{ $hasHardcopy ? 'true' : 'false' }};
    const chargeDhaka = {{ $deliveryDhaka }};
    const chargeOutside = {{ $deliveryOutside }};

    const paymentData = {
        bkash: {
            title: "বিকাশ পেমেন্ট / মার্চেন্ট নম্বর:",
            number: "{{ $paymentSettings['bkash'] }}",
            guide: "বিকাশ অ্যাপ থেকে Send Money বা Payment করুন। এরপর TrxID টি নিচের বক্সে দিন।"
        },
        nagad: {
            title: "নগদ মার্চেন্ট / সেন্ড মানি নম্বর:",
            number: "{{ $paymentSettings['nagad'] }}",
            guide: "নগদ অ্যাপ থেকে টাকা পাঠিয়ে প্রাপ্ত ট্রানজেকশন আইডিটি নিচে পূরণ করুন।"
        },
        upay: {
            title: "উপায় একাউন্ট নম্বর:",
            number: "{{ $paymentSettings['upay'] }}",
            guide: "উপায় অ্যাপ বা ইউএসএসডি কোডের মাধ্যমে টাকা পাঠিয়ে TrxID দিন।"
        },
        cod: {
            title: "ক্যাশ অন ডেলিভারি (Cash on Delivery):",
            number: "বই হাতে পেয়ে মূল্য পরিশোধ করবেন",
            guide: "বই ডেলিভারি পাওয়ার পর কুরিয়ার প্রতিনিধিকে বইয়ের মূল্য বুঝিয়ে দিন। ডেলিভারি কনফার্মেশনের জন্য আমাদের প্রতিনিধি কল করতে পারেন।"
        }
    };

    let currentDelivery = hasHardcopy ? chargeDhaka : 0;

    function updateDelivery(zone) {
        currentDelivery = (zone === 'outside_dhaka') ? chargeOutside : chargeDhaka;
        document.getElementById('lblDeliveryCharge').innerText = '৳ ' + currentDelivery.toLocaleString('en-US');
        const grandTotal = Math.max(0, (subtotal - discount) + currentDelivery);
        document.getElementById('lblTotalAmount').innerText = '৳ ' + grandTotal.toLocaleString('en-US');

        document.getElementById('zoneDhakaLabel').classList.toggle('active', zone === 'dhaka');
        document.getElementById('zoneOutsideLabel').classList.toggle('active', zone === 'outside_dhaka');
    }

    function updatePaymentMethod(method) {
        const info = paymentData[method];
        if (info) {
            document.getElementById('payMethodTitle').innerText = info.title;
            document.getElementById('payNumberDisplay').innerText = info.number;
            document.getElementById('payGuideText').innerText = info.guide;
        }

        const isCod = (method === 'cod');
        const trxFields = document.getElementById('trxFields');
        const trxInput = document.getElementById('payment_trx_id');
        if (isCod) {
            trxFields.style.display = 'none';
            trxInput.removeAttribute('required');
        } else {
            trxFields.style.display = 'block';
            trxInput.setAttribute('required', 'required');
        }

        ['optBkash', 'optNagad', 'optUpay', 'optCod'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.remove('active');
        });
        const activeLabel = document.getElementById('opt' + method.charAt(0).toUpperCase() + method.slice(1));
        if (activeLabel) activeLabel.classList.add('active');
    }
</script>
@endsection
