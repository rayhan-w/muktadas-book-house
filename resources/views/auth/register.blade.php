@extends('layouts.app')

@section('title', 'নতুন পাঠক রেজিস্ট্রেশন | মুক্তাদার বইঘর')

@section('content')
<div class="container" style="max-width: 500px; margin: 50px auto 80px;">
    <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 40px; box-shadow: var(--shadow-md);">
        <div style="text-align: center; margin-bottom: 25px;">
            <h1 style="font-size: 24px; color: var(--primary); font-weight: 800;">নতুন অ্যাকাউন্ট তৈরি করুন</h1>
            <p style="color: var(--text-muted); font-size: 14px;">মুক্তাদার বইঘরের একজন পাঠক হিসেবে যুক্ত হোন।</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">আপনার পূর্ণ নাম *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="যেমন: আবদুল্লাহ আল মামুন" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">ইমেইল অ্যাড্রেস *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="yourname@mail.com" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">মোবাইল নম্বর *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="০১XXXXXXXXX" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) *</label>
                <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">পাসওয়ার্ড নিশ্চিত করুন *</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <button type="submit" class="btn btn-gold" style="width: 100%; font-size: 16px; padding: 12px;">
                অ্যাকাউন্ট তৈরি করুন
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 20px; font-size: 14px; color: var(--text-muted);">
            ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">লগইন করুন →</a>
        </div>
    </div>
</div>
@endsection
