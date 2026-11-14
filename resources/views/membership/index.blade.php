@extends('layouts.app')

@section('title', 'মেম্বারশিপ সুবিধা ও প্যাকেজসমূহ | মুক্তাদার বইঘর')

@section('styles')
<style>
    .membership-hero {
        background: linear-gradient(135deg, #092d45, #154566);
        color: #fff;
        padding: 60px 0 50px;
        text-align: center;
        border-bottom: 4px solid var(--gold);
    }

    .membership-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin: -40px auto 60px;
        position: relative;
        z-index: 10;
    }

    .plan-card {
        background: #fff;
        border-radius: var(--sp-radius, 16px);
        border: 1.5px solid var(--sp-border, #e2e8f0);
        padding: 35px 25px;
        text-align: center;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    }

    .plan-card.featured {
        border-color: #f59e0b;
        background: #fffdf7;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.18);
    }

    .plan-badge {
        display: inline-block;
        background: linear-gradient(135deg, #d97706, #f59e0b);
        color: #fff;
        padding: 5px 16px;
        border-radius: var(--sp-radius-pill, 999px);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.3);
    }

    .plan-price {
        font-size: 38px;
        font-weight: 800;
        color: var(--sp-burgundy, #0f766e);
        margin: 15px 0 20px;
    }

    .plan-benefits {
        list-style: none;
        text-align: left;
        margin: 20px 0 30px;
        flex: 1;
        font-size: 15px;
        line-height: 2;
        padding: 0;
    }

    .plan-benefits li {
        padding-left: 24px;
        position: relative;
        color: #334155;
    }

    .plan-benefits li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: 800;
    }

    /* Modern Attractive Membership Action Buttons */
    .btn-plan-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 20px;
        font-size: 15px;
        font-weight: 800;
        border-radius: var(--sp-radius-pill, 999px);
        text-decoration: none !important;
        border: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: auto;
    }

    .btn-plan-standard {
        background: var(--sp-crimson, #0d9488);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.28);
    }

    .btn-plan-standard:hover {
        background: var(--sp-burgundy, #0f766e);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(15, 118, 110, 0.38);
    }

    .btn-plan-featured {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 16px rgba(217, 119, 6, 0.35);
    }

    .btn-plan-featured:hover {
        background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(180, 83, 9, 0.45);
    }

    @media (max-width: 860px) {
        .membership-grid { grid-template-columns: 1fr; margin-top: 20px; gap: 20px; }
    }
</style>
@endsection

@section('content')
<div class="membership-hero">
    <div class="container" style="max-width: 750px;">
        <span style="font-size: 32px; display: block; margin-bottom: 8px;">👑</span>
        <h1 style="font-size: 36px; margin-bottom: 12px; font-weight: 800;">মুক্তাদার বইঘর মেম্বারশিপ ক্লাব</h1>
        <p style="font-size: 17px; color: #cbd5e1;">নিয়মিত বইপ্রেমী ও পাঠকদের জন্য বিশেষ সুবিধা, সারা বছর সকল বইয়ে আকর্ষণীয় ছাড় এবং ফ্রি ই-বুক উপভোগের সুবর্ণ সুযোগ।</p>
    </div>
</div>

<div class="container">
    <div class="membership-grid">
        @foreach($memberships as $plan)
            <div class="plan-card {{ $plan->slug === 'two-years' ? 'featured' : '' }}">
                @if($plan->slug === 'two-years')
                    <div><span class="plan-badge">সবচেয়ে জনপ্রিয় চয়েস</span></div>
                @endif
                <h3 style="font-size: 22px; color: var(--primary);">{{ $plan->title }}</h3>
                <div class="plan-price">৳ {{ number_format($plan->price) }}</div>
                
                <ul class="plan-benefits">
                    @foreach(explode("\n", $plan->benefits) as $line)
                        @if(trim($line))
                            <li>{{ trim($line) }}</li>
                        @endif
                    @endforeach
                </ul>

                <a href="{{ route('contact') }}?subject={{ urlencode($plan->title . ' মেম্বারশিপ আবেদন') }}" class="btn-plan-action {{ $plan->slug === 'two-years' ? 'btn-plan-featured' : 'btn-plan-standard' }}">
                    <i class="bi bi-star-fill"></i> মেম্বারশিপ নিন →
                </a>
            </div>
        @endforeach
    </div>

    <!-- Instruction Box -->
    <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 35px; margin-bottom: 60px; box-shadow: var(--shadow-sm);">
        <h3 style="font-size: 20px; color: var(--primary); margin-bottom: 12px;">মেম্বারশিপ পেমেন্ট ও অ্যাক্টিভেশন নিয়মাবলী:</h3>
        <p style="color: var(--text-muted); font-size: 15px; line-height: 1.8;">
            ১. আপনার পছন্দের প্ল্যান নির্ধারণ করে বিকাশ (<strong>{{ $bkash }}</strong>) অথবা নগদ (<strong>{{ $nagad }}</strong>)-এ সেন্ড মানি করুন।<br>
            ২. আপনার পেমেন্টের TrxID এবং রেজিস্টার্ড ইমেইল এড্রেস দিয়ে আমাদের সাথে যোগাযোগ করুন অথবা পেমেন্ট রেফারেন্স দিয়ে রিকোয়েস্ট পাঠান।<br>
            ৩. সর্বোচ্চ ২৪ ঘণ্টার মধ্যে অ্যাডমিন যাচাই করে আপনার অ্যাকাউন্টে মেম্বারশিপ সুবিধা সক্রিয় করে দেবে।
        </p>
    </div>
</div>
@endsection
