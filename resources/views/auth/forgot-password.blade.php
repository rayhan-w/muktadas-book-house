@extends('layouts.app')

@section('title', 'পাসওয়ার্ড ভুলে গেছেন? | মুক্তাদার বইঘর')

@section('styles')
<style>
    .auth-page-wrap {
        min-height: calc(100vh - 350px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px 80px;
        background: #f8fafc;
    }

    .auth-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: 18px;
        padding: 38px 34px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .auth-logo {
        width: 58px;
        height: 58px;
        border-radius: 12px;
        object-fit: cover;
        border: 1.5px solid var(--sp-border);
        margin-bottom: 12px;
        box-shadow: var(--sp-shadow-sm);
    }

    .auth-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--sp-heading);
        margin-bottom: 6px;
    }

    .auth-sub {
        font-size: 13.5px;
        color: var(--sp-muted);
        margin: 0;
        line-height: 1.6;
    }

    .auth-form-group {
        margin-bottom: 18px;
    }

    .auth-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--sp-heading);
        margin-bottom: 6px;
    }

    .auth-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .auth-input-icon {
        position: absolute;
        left: 14px;
        color: var(--sp-muted);
        font-size: 16px;
    }

    .auth-input {
        width: 100%;
        padding: 12px 14px 12px 42px;
        background: #ffffff;
        border: 1.5px solid var(--sp-border);
        border-radius: 10px;
        font-size: 14px;
        color: var(--sp-heading);
        transition: all 0.2s;
        outline: none;
    }

    .auth-input:focus {
        border-color: var(--sp-burgundy);
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
    }

    .auth-submit-btn {
        width: 100%;
        padding: 13px 20px;
        background: var(--sp-burgundy);
        color: #ffffff !important;
        border: none;
        border-radius: var(--sp-radius-pill);
        font-size: 15.5px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(15, 118, 110, 0.28);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .auth-submit-btn:hover {
        background: var(--sp-crimson);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 118, 110, 0.35);
    }

    .alert-success-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13.5px;
        line-height: 1.6;
        font-weight: 600;
    }

    .alert-error-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13.5px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="auth-page-wrap">
    <div class="auth-card">
        <!-- Logo & Header -->
        <div class="auth-header">
            <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর" class="auth-logo">
            <h1 class="auth-title">পাসওয়ার্ড রিসেট</h1>
            <p class="auth-sub">আপনার অ্যাকাউন্টের জিমেইল / ইমেইল অ্যাড্রেসটি দিন। আমরা একটি পাসওয়ার্ড রিসেট লিংক পাঠাব।</p>
        </div>

        @if(session('status'))
            <div class="alert-success-box">
                <i class="bi bi-check-circle-fill text-success me-1"></i> {!! session('status') !!}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error-box">
                <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="auth-form-group">
                <label class="auth-label">আপনার জিমেইল / ইমেইল অ্যাড্রেস *</label>
                <div class="auth-input-wrap">
                    <i class="bi bi-envelope auth-input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="yourname@gmail.com" class="auth-input" autofocus>
                </div>
            </div>

            <button type="submit" class="auth-submit-btn">
                <i class="bi bi-send-fill"></i> রিসেট লিংক পাঠান
            </button>
        </form>

        <!-- Back to login -->
        <div style="text-align:center; margin-top:22px; font-size:14px; color:var(--sp-muted);">
            পাসওয়ার্ড মনে পড়েছে? <a href="{{ route('login') }}" style="color:var(--sp-burgundy); font-weight:700; text-decoration:none;">লগইন পেজে ফিরে যান →</a>
        </div>
    </div>
</div>
@endsection
