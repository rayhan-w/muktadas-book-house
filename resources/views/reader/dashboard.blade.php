@extends('layouts.app')

@section('title', 'আমার অ্যাকাউন্ট ও ড্যাশবোর্ড | মুক্তাদার বইঘর')

@section('styles')
<style>
    .dash-header {
        background: #ffffff;
        border-bottom: 1.5px solid #e2e8f0;
        padding: 24px 0;
        margin-bottom: 28px;
    }

    .dash-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 26px;
        margin-bottom: 60px;
        align-items: flex-start;
    }

    .dash-sidebar {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 20px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .dash-user-head {
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 20px;
        margin-bottom: 16px;
    }

    .user-avatar-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);
        color: #0f766e;
        display: grid;
        place-items: center;
        font-size: 28px;
        font-weight: 800;
        margin: 0 auto 12px;
        border: 2.5px solid #0d9488;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
    }

    .dash-menu-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        border-radius: 10px;
        font-size: 14.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .dash-menu-link i {
        font-size: 17px;
        width: 22px;
        text-align: center;
        color: #0d9488;
        transition: transform 0.2s ease;
    }

    .dash-menu-link:hover {
        background: #f0fdfa;
        color: #0f766e;
        border-color: #ccfbf1;
        transform: translateX(3px);
    }

    .dash-menu-link.active {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .dash-menu-link.active i {
        color: #ffffff;
    }

    .dash-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    .dash-stat-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 16px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        text-align: center;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .dash-stat-card:hover {
        transform: translateY(-2px);
        border-color: #0d9488;
        box-shadow: 0 6px 18px rgba(13, 148, 136, 0.12);
    }

    .stat-val {
        font-size: 28px;
        font-weight: 800;
        color: #0f766e;
        margin: 6px 0 8px;
        line-height: 1;
    }

    .dash-panel {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 26px;
        margin-bottom: 25px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .dash-form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14.5px;
        background: #ffffff;
        color: #1e293b;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .dash-form-control:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3.5px rgba(13, 148, 136, 0.15);
        background: #ffffff;
    }

    .dash-form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1e293b;
    }

    .dash-btn-submit {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        font-size: 15px;
        font-weight: 700;
        border-radius: 10px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.25);
        transition: all 0.2s ease;
    }

    .dash-btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
    }

    .grid-form-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 900px) {
        .dash-layout { 
            grid-template-columns: 1fr; 
            gap: 20px;
        }
        .dash-stat-grid { 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px;
        }
    }

    @media (max-width: 600px) {
        .dash-header {
            padding: 18px 0;
            margin-bottom: 20px;
        }
        .dash-header h1 {
            font-size: 22px !important;
        }
        .dash-panel {
            padding: 18px 14px;
        }
        .grid-form-2 {
            grid-template-columns: 1fr !important;
            gap: 12px;
        }
        .dash-stat-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .dash-stat-card {
            padding: 16px 12px;
        }
        .stat-val {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="dash-header">
    <div class="container">
        @if(auth()->user()->isAdmin())
            <div style="background: linear-gradient(135deg, #fdf2f8, #fce7f3); border: 1.5px solid #f43f5e; border-radius: 12px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 14px; box-shadow: 0 4px 15px rgba(244,63,94,0.12);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 42px; height: 42px; background: #e11d48; color: #fff; border-radius: 50%; display: grid; place-items: center; font-size: 20px;">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div>
                        <strong style="color: #881337; font-size: 16px; display: block;">👑 আপনি প্রধান অ্যাডমিন হিসেবে লগইন আছেন</strong>
                        <span style="color: #9f1239; font-size: 13.5px;">সাইটের বই, পাবলিশার, অর্ডার ও সেটিংস নিয়ন্ত্রণ করতে মূল অ্যাডমিন প্যানেলে যান।</span>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" style="background: #be123c; color: #fff; padding: 10px 22px; border-radius: 8px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; box-shadow: 0 4px 12px rgba(190,18,60,0.3);">
                    <i class="bi bi-speedometer2"></i> অ্যাডমিন ড্যাশবোর্ড
                </a>
            </div>
        @endif
        <h1 style="font-size: 26px; color: var(--primary); margin-bottom: 4px;">স্বাগতম, {{ $user->name }}!</h1>
        <p style="color: var(--text-muted); font-size: 14.5px; margin: 0;">আপনার কেনা বই, রিডিং প্রগ্রেস এবং অর্ডার পরিচালনা করুন।</p>
    </div>
</div>

<div class="container dash-layout">
    <!-- Sidebar -->
    <aside class="dash-sidebar">
        <div class="dash-user-head">
            <div class="user-avatar-circle">{{ mb_substr($user->name, 0, 1) }}</div>
            <strong style="color: var(--primary); font-size: 17px; display: block;">{{ $user->name }}</strong>
            <small style="color: var(--text-muted);">{{ $user->phone ?? $user->email }}</small>
            @if(auth()->user()->isAdmin())
                <div style="margin-top: 6px;">
                    <span style="background: #fdf2f8; color: #be123c; border: 1px solid #fecdd3; font-size: 11px; padding: 3px 10px; border-radius: 999px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-shield-lock-fill"></i> প্রধান অ্যাডমিন
                    </span>
                </div>
            @elseif($user->membership_plan)
                <div style="margin-top: 6px;">
                    <span style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 3px 10px; border-radius: 999px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-award-fill"></i> {{ $user->membership_plan }} মেম্বার
                    </span>
                </div>
            @endif
        </div>

        <nav>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="dash-menu-link" style="background: #fff1f2; color: #be123c; font-weight: 700; border: 1px solid #fecdd3; margin-bottom: 12px;">
                    <i class="bi bi-speedometer2" style="color: #be123c;"></i> <span>অ্যাডমিন ড্যাশবোর্ড 👑</span>
                </a>
            @endif
            <a href="{{ route('reader.dashboard') }}" class="dash-menu-link active">
                <i class="bi bi-speedometer2"></i> <span>ওভারভিউ</span>
            </a>
            <a href="{{ route('reader.library') }}" class="dash-menu-link">
                <i class="bi bi-journal-bookmark-fill"></i> <span>আমার পাঠাগার (ই-বুক)</span>
            </a>
            <a href="{{ route('reader.orders') }}" class="dash-menu-link">
                <i class="bi bi-bag-check-fill"></i> <span>আমার অর্ডারসমূহ</span>
            </a>
            <a href="{{ route('reader.wishlist') }}" class="dash-menu-link">
                <i class="bi bi-heart-fill"></i> <span>পছন্দের তালিকা (উইশলিস্ট)</span>
            </a>
            <a href="{{ route('memberships.index') }}" class="dash-menu-link">
                <i class="bi bi-award"></i> <span>মেম্বারশিপ প্ল্যান</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                @csrf
                <button type="submit" class="dash-menu-link" style="width: 100%; border: none; background: transparent; cursor: pointer; color: #dc2626; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-box-arrow-right" style="color: #dc2626;"></i> <span>লগআউট</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div>
        <!-- Stats -->
        <div class="dash-stat-grid">
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">মোট অর্ডার</div>
                <div class="stat-val">{{ $totalOrders }}</div>
                <a href="{{ route('reader.orders') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600; text-decoration: none;">অর্ডার দেখুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">কেনা ই-বুক</div>
                <div class="stat-val">{{ $libraryCount }}</div>
                <a href="{{ route('reader.library') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600; text-decoration: none;">বই পড়ুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">উইশলিস্ট</div>
                <div class="stat-val">{{ $wishlistCount }}</div>
                <a href="{{ route('reader.wishlist') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600; text-decoration: none;">তালিকা দেখুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted); font-weight: 600;">মেম্বারশিপ</div>
                <div class="stat-val" style="font-size: 18px; line-height: 1.8;">
                    {{ $user->membership_plan ?: 'সাধারণ' }}
                </div>
                <a href="{{ route('memberships.index') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600; text-decoration: none;">আপগ্রেড করুন →</a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="dash-panel">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h2 style="font-size: 18px; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-clock-history" style="color: var(--gold-hover);"></i> সাম্প্রতিক অর্ডারসমূহ
                </h2>
                <a href="{{ route('reader.orders') }}" style="font-size: 13px; font-weight: 600; color: var(--gold-hover); text-decoration: none;">সবগুলো দেখুন →</a>
            </div>

            @if($recentOrders->isEmpty())
                <p style="color: var(--text-muted); font-size: 14px; font-style: italic; margin: 0;">আপনার এখনো কোনো অর্ডার নেই।</p>
            @else
                <div style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table style="width: 100%; min-width: 500px; border-collapse: collapse; font-size: 13.5px;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color); text-align: left; color: var(--text-muted);">
                                <th style="padding: 10px;">অর্ডার নম্বর</th>
                                <th style="padding: 10px;">তারিখ</th>
                                <th style="padding: 10px;">পরিমাণ</th>
                                <th style="padding: 10px;">স্ট্যাটাস</th>
                                <th style="padding: 10px; text-align: right;">ইনভয়েস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $ord)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 12px 10px; font-weight: 700; color: var(--primary);">#{{ $ord->order_number }}</td>
                                    <td style="padding: 12px 10px;">{{ $ord->created_at->format('d M, Y') }}</td>
                                    <td style="padding: 12px 10px;">৳ {{ number_format($ord->total) }}</td>
                                    <td style="padding: 12px 10px;">
                                        <span class="badge badge-{{ $ord->order_status }}">{{ $ord->statusInBengali() }}</span>
                                    </td>
                                    <td style="padding: 12px 10px; text-align: right;">
                                        <a href="{{ route('orders.invoice', $ord->order_number) }}" class="btn btn-outline" style="padding: 5px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-file-earmark-text"></i> রশিদ
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Profile Update -->
        <div class="dash-panel">
            <h2 style="font-size: 18px; color: var(--sp-burgundy); margin-bottom: 18px; display: flex; align-items: center; gap: 8px; font-weight: 800;">
                <i class="bi bi-person-gear" style="color: var(--sp-crimson);"></i> ব্যক্তিগত তথ্য আপডেট
            </h2>
            <form action="{{ route('reader.profile.update') }}" method="POST">
                @csrf
                <div class="grid-form-2" style="margin-bottom: 16px;">
                    <div>
                        <label class="dash-form-label">নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="dash-form-control">
                    </div>
                    <div>
                        <label class="dash-form-label">মোবাইল নম্বর</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="01XXXXXXXXX" class="dash-form-control">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="dash-form-label">ডেলিভারি ঠিকানা</label>
                    <textarea name="address" rows="3" placeholder="বাসা/হোল্ডিং নম্বর, রোড, এলাকা, জেলা..." class="dash-form-control">{{ old('address', $user->address) }}</textarea>
                </div>

                <hr style="border: none; border-top: 1.5px dashed #e2e8f0; margin: 24px 0;">

                <h3 style="font-size: 15.5px; color: var(--sp-burgundy); margin-bottom: 14px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                    <i class="bi bi-shield-lock" style="color: var(--sp-crimson);"></i> পাসওয়ার্ড পরিবর্তন (প্রয়োজন না হলে খালি রাখুন)
                </h3>
                <div class="grid-form-2" style="margin-bottom: 22px;">
                    <div>
                        <label class="dash-form-label">নতুন পাসওয়ার্ড</label>
                        <input type="password" name="new_password" placeholder="কমপক্ষে ৬ অক্ষরের নতুন পাসওয়ার্ড" class="dash-form-control">
                    </div>
                    <div>
                        <label class="dash-form-label">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" name="new_password_confirmation" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" class="dash-form-control">
                    </div>
                </div>

                <button type="submit" class="dash-btn-submit">
                    <i class="bi bi-check-circle-fill"></i> তথ্য সংরক্ষণ করুন
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
