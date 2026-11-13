@extends('layouts.app')

@section('title', 'অ্যাকাউন্টে লগইন করুন | মুক্তাদার বইঘর')

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
    }

    /* Auth Switcher Pills */
    .auth-switcher {
        display: flex;
        background: #f1f5f9;
        border-radius: var(--sp-radius-pill);
        padding: 4px;
        margin-bottom: 24px;
    }

    .auth-switch-btn {
        flex: 1;
        text-align: center;
        padding: 8px 14px;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--sp-muted);
        text-decoration: none;
        border-radius: var(--sp-radius-pill);
        transition: all 0.2s;
    }

    .auth-switch-btn.active {
        background: #ffffff;
        color: var(--sp-burgundy);
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .auth-form-group {
        margin-bottom: 18px;
    }

    .auth-label {
        display: block;
        font-size: 13.5px;
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
        color: #94a3b8;
        font-size: 15px;
        pointer-events: none;
    }

    .auth-input {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border: 1.5px solid var(--sp-border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14.5px;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s ease;
    }

    .auth-input:focus {
        border-color: var(--sp-burgundy);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 16px;
    }

    .auth-extra-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        font-size: 13px;
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
    }

    .auth-submit-btn:hover {
        background: var(--sp-crimson);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 118, 110, 0.35);
    }

    .publisher-notice-box {
        margin-top: 20px;
        padding: 12px 14px;
        background: #f0fdf4;
        border: 1px dashed #86efac;
        border-radius: 10px;
        text-align: center;
        font-size: 13px;
        color: #166534;
    }
</style>
@endsection

@section('content')
<div class="auth-page-wrap">
    <div class="auth-card">
        <!-- Logo & Header -->
        <div class="auth-header">
            <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর" class="auth-logo">
            <h1 class="auth-title">অ্যাকাউন্টে লগইন</h1>
            <p class="auth-sub">আপনার কেনা ই-বুক ও অর্ডার পরিচালনা করতে লগইন করুন।</p>
        </div>

        <!-- Switcher (Login / Register) -->
        <div class="auth-switcher">
            <a href="{{ route('login') }}" class="auth-switch-btn active">
                <i class="bi bi-box-arrow-in-right me-1"></i> লগইন
            </a>
            <a href="{{ route('register') }}" class="auth-switch-btn">
                <i class="bi bi-person-plus me-1"></i> রেজিস্ট্রেশন
            </a>
        </div>

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:10px 14px; border-radius:8px; margin-bottom:18px; font-size:13.5px; font-weight:600;">
                <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="auth-form-group">
                <label class="auth-label">ইমেইল অ্যাড্রেস *</label>
                <div class="auth-input-wrap">
                    <i class="bi bi-envelope auth-input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="yourname@mail.com" class="auth-input">
                </div>
            </div>

            <!-- Password -->
            <div class="auth-form-group">
                <label class="auth-label">পাসওয়ার্ড *</label>
                <div class="auth-input-wrap">
                    <i class="bi bi-lock auth-input-icon"></i>
                    <input type="password" name="password" id="loginPassword" required placeholder="••••••••" class="auth-input">
                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('loginPassword', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="auth-extra-row">
                <label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:var(--sp-body);">
                    <input type="checkbox" name="remember" style="accent-color:var(--sp-burgundy);"> আমাকে মনে রাখুন
                </label>
                <a href="{{ route('contact') }}?subject=Password+Reset+Request" style="color:var(--sp-burgundy); font-weight:600; text-decoration:none;">
                    পাসওয়ার্ড ভুলে গেছেন?
                </a>
            </div>

            <button type="submit" class="auth-submit-btn">
                লগইন করুন <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </form>

        <!-- Publisher Notice -->
        <div class="publisher-notice-box">
            🏢 আপনি কি প্রকাশক বা লেখক? <a href="{{ route('publisher.register') }}" style="color:#15803d; font-weight:800; text-decoration:none;">প্রকাশক নিবন্ধন করুন →</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection
