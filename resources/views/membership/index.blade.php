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
        border-radius: var(--radius);
        border: 2px solid var(--border-color);
        padding: 35px 25px;
        text-align: center;
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        transition: 0.2s;
    }

    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .plan-card.featured {
        border-color: var(--gold);
        background: #fffdf7;
        box-shadow: 0 10px 30px rgba(212, 155, 20, 0.18);
    }

    .plan-badge {
        display: inline-block;
        background: var(--gold);
        color: #fff;
        padding: 4px 14px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .plan-price {
        font-size: 38px;
        font-weight: 800;
        color: var(--primary);
        margin: 15px 0 20px;
    }

    .plan-benefits {
        list-style: none;
        text-align: left;
        margin: 20px 0 30px;
        flex: 1;
        font-size: 15px;
        line-height: 2;
    }

    .plan-benefits li {
        padding-left: 24px;
        position: relative;
        color: var(--text-dark);
    }

    .plan-benefits li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #16a34a;
        font-weight: 700;
    }

    @media (max-width: 860px) {
        .membership-grid { grid-template-columns: 1fr; margin-top: 20px; }
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

                <a href="{{ route('contact') }}?subject={{ urlencode($plan->title . ' মেম্বারশিপ আবেদন') }}" class="btn {{ $plan->slug === 'two-years' ? 'btn-gold' : 'btn-primary' }}" style="width: 100%; font-size: 16px;">
                    মেম্বারশিপ নিন →
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
