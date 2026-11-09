@extends('layouts.app')

@section('title', 'আমার অ্যাকাউন্ট ও ড্যাশবোর্ড | মুক্তাদার বইঘর')

@section('styles')
<style>
    .dash-header {
        background: #fff;
        border-bottom: 1px solid var(--border-color);
        padding: 30px 0;
        margin-bottom: 35px;
    }

    .dash-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 30px;
        margin-bottom: 60px;
        align-items: flex-start;
    }

    .dash-sidebar {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow-sm);
    }

    .dash-user-head {
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 18px;
        margin-bottom: 15px;
    }

    .user-avatar-circle {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: var(--gold-light);
        color: var(--primary);
        display: grid;
        place-items: center;
        font-size: 24px;
        font-weight: 700;
        margin: 0 auto 10px;
    }

    .dash-menu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
        transition: 0.15s;
    }

    .dash-menu-link:hover, .dash-menu-link.active {
        background: var(--cream-bg);
        color: var(--gold-hover);
    }

    .dash-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }

    .dash-stat-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow-sm);
        text-align: center;
    }

    .stat-val {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
        margin: 5px 0;
    }

    .dash-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 800px) {
        .dash-layout { grid-template-columns: 1fr; }
        .dash-stat-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endsection

@section('content')
<div class="dash-header">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 4px;">স্বাগতম, {{ $user->name }}!</h1>
        <p style="color: var(--text-muted); font-size: 15px;">আপনার কেনা বই, রিডিং প্রগ্রেস এবং অর্ডার পরিচালনা করুন।</p>
    </div>
</div>

<div class="container dash-layout">
    <!-- Sidebar -->
    <aside class="dash-sidebar">
        <div class="dash-user-head">
            <div class="user-avatar-circle">{{ mb_substr($user->name, 0, 1) }}</div>
            <strong style="color: var(--primary); font-size: 17px; display: block;">{{ $user->name }}</strong>
            <small style="color: var(--text-muted);">{{ $user->phone ?? $user->email }}</small>
            @if($user->membership_plan)
                <div style="margin-top: 6px;">
                    <span style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 700;">
                        👑 {{ $user->membership_plan }} মেম্বার
                    </span>
                </div>
            @endif
        </div>

        <nav>
            <a href="{{ route('reader.dashboard') }}" class="dash-menu-link active">📊 ওভারভিউ</a>
            <a href="{{ route('reader.library') }}" class="dash-menu-link">📚 আমার পাঠাগার (ই-বুক)</a>
            <a href="{{ route('reader.orders') }}" class="dash-menu-link">🛍️ আমার অর্ডারসমূহ</a>
            <a href="{{ route('reader.wishlist') }}" class="dash-menu-link">❤️ পছন্দের তালিকা (উইশলিস্ট)</a>
            <a href="{{ route('memberships.index') }}" class="dash-menu-link">👑 মেম্বারশিপ প্ল্যান</a>
            <form action="{{ route('logout') }}" method="POST" style="margin-top: 15px; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                @csrf
                <button type="submit" class="dash-menu-link" style="width: 100%; border: none; background: transparent; cursor: pointer; color: #dc2626;">
                    🚪 লগআউট
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div>
        <!-- Stats -->
        <div class="dash-stat-grid">
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted);">মোট অর্ডার</div>
                <div class="stat-val">{{ $totalOrders }}</div>
                <a href="{{ route('reader.orders') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600;">অর্ডার দেখুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted);">কেনা ই-বুক</div>
                <div class="stat-val">{{ $libraryCount }}</div>
                <a href="{{ route('reader.library') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600;">বই পড়ুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted);">উইশলিস্ট</div>
                <div class="stat-val">{{ $wishlistCount }}</div>
                <a href="{{ route('reader.wishlist') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600;">তালিকা দেখুন →</a>
            </div>
            <div class="dash-stat-card">
                <div style="font-size: 13px; color: var(--text-muted);">মেম্বারশিপ</div>
                <div class="stat-val" style="font-size: 18px; line-height: 1.8;">
                    {{ $user->membership_plan ?: 'সাধারণ' }}
                </div>
                <a href="{{ route('memberships.index') }}" style="font-size: 12px; color: var(--gold-hover); font-weight: 600;">আপগ্রেড করুন →</a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="dash-panel">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h2 style="font-size: 18px; color: var(--primary);">সাম্প্রতিক অর্ডারসমূহ</h2>
                <a href="{{ route('reader.orders') }}" style="font-size: 13px; font-weight: 600; color: var(--gold-hover);">সবগুলো দেখুন →</a>
            </div>

            @if($recentOrders->isEmpty())
                <p style="color: var(--text-muted); font-size: 14px; font-style: italic;">আপনার এখনো কোনো অর্ডার নেই।</p>
            @else
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
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
                                    <a href="{{ route('orders.invoice', $ord->order_number) }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 12px;">রশিদ দেখুন</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Profile Update -->
        <div class="dash-panel">
            <h2 style="font-size: 18px; color: var(--primary); margin-bottom: 18px;">ব্যক্তিগত তথ্য আপডেট</h2>
            <form action="{{ route('reader.profile.update') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 8px 12px; border: 1.5px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">মোবাইল নম্বর</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 8px 12px; border: 1.5px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">ডেলিভারি ঠিকানা</label>
                    <textarea name="address" rows="2" style="width: 100%; padding: 8px 12px; border: 1.5px solid var(--border-color); border-radius: 6px; font-family: inherit;">{{ old('address', $user->address) }}</textarea>
                </div>

                <hr style="border: none; border-top: 1px solid var(--border-color); margin: 20px 0;">

                <h3 style="font-size: 15px; color: var(--primary); margin-bottom: 12px;">পাসওয়ার্ড পরিবর্তন (প্রয়োজন না হলে খালি রাখুন)</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">নতুন পাসওয়ার্ড</label>
                        <input type="password" name="new_password" style="width: 100%; padding: 8px 12px; border: 1.5px solid var(--border-color); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" name="new_password_confirmation" style="width: 100%; padding: 8px 12px; border: 1.5px solid var(--border-color); border-radius: 6px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-gold">তথ্য সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>
</div>
@endsection
