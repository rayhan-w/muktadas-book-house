@extends('layouts.app')

@section('title', 'লগইন করুন | মুক্তাদার বইঘর')

@section('content')
<div class="container" style="max-width: 480px; margin: 60px auto 90px;">
    <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 40px; box-shadow: var(--shadow-md);">
        <div style="text-align: center; margin-bottom: 25px;">
            <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর" style="width: 60px; height: 60px; border-radius: 10px; margin-bottom: 10px;">
            <h1 style="font-size: 24px; color: var(--primary); font-weight: 800;">অ্যাকাউন্টে লগইন করুন</h1>
            <p style="color: var(--text-muted); font-size: 14px;">আপনার কেনা ই-বুক ও অর্ডার পরিচালনা করতে লগইন করুন।</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">ইমেইল অ্যাড্রেস *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="yourname@mail.com" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">পাসওয়ার্ড *</label>
                <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-size: 15px; font-family: inherit;">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 13px;">
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="remember"> আমাকে মনে রাখুন
                </label>
                <a href="{{ route('contact') }}?subject=Password+Reset+Request" style="color: var(--gold-hover); font-weight: 600;">পাসওয়ার্ড ভুলে গেছেন?</a>
            </div>

            <button type="submit" class="btn btn-gold" style="width: 100%; font-size: 16px; padding: 12px;">
                লগইন করুন
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid #f1f5f9; padding-top: 20px; font-size: 14px; color: var(--text-muted);">
            নতুন পাঠক? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700;">নতুন অ্যাকাউন্ট খুলুন →</a>
        </div>

        <div style="text-align: center; margin-top: 15px; font-size: 13.5px; background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px dashed #cbd5e1;">
            🏢 আপনি কি বই প্রকাশক? <a href="{{ route('publisher.register') }}" style="color: #0284c7; font-weight: 700;">প্রকাশক নিবন্ধন করুন →</a>
        </div>
    </div>
</div>
@endsection
