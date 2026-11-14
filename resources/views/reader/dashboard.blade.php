@extends('layouts.app')

@section('title', 'আমার অ্যাকাউন্ট ও ড্যাশবোর্ড | মুক্তাদার বইঘর')

@section('styles')
<style>
    .dash-header {
        background: #fff;
        border-bottom: 1px solid var(--border-color);
        padding: 26px 0;
        margin-bottom: 28px;
    }

    .dash-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 26px;
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
        background: var(--cream-bg);
        color: var(--primary);
        display: grid;
        place-items: center;
        font-size: 24px;
        font-weight: 700;
        margin: 0 auto 10px;
        border: 2px solid var(--border-color);
    }

    .dash-menu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 14.5px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 4px;
        transition: 0.15s;
        text-decoration: none;
    }

    .dash-menu-link i {
        font-size: 16px;
        width: 20px;
        text-align: center;
        color: var(--gold-hover);
    }

    .dash-menu-link:hover, .dash-menu-link.active {
        background: var(--cream-bg);
        color: var(--gold-hover);
    }

    .dash-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    .dash-stat-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 18px 14px;
        box-shadow: var(--shadow-sm);
        text-align: center;
    }

    .stat-val {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
        margin: 4px 0 6px;
    }

    .dash-panel {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 24px;
        margin-bottom: 25px;
        box-shadow: var(--shadow-sm);
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
            padding: 14px 10px;
        }
        .stat-val {
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')
<div class="dash-header">
    <div class="container">
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
            @if($user->membership_plan)
                <div style="margin-top: 6px;">
                    <span style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 3px 10px; border-radius: 999px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="bi bi-award-fill"></i> {{ $user->membership_plan }} মেম্বার
                    </span>
                </div>
            @endif
        </div>

        <nav>
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
            <h2 style="font-size: 18px; color: var(--primary); margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-person-gear" style="color: var(--gold-hover);"></i> ব্যক্তিগত তথ্য আপডেট
            </h2>
            <form action="{{ route('reader.profile.update') }}" method="POST">
                @csrf
                <div class="grid-form-2" style="margin-bottom: 14px;">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 4px; color: var(--text-dark);">নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 4px; color: var(--text-dark);">মোবাইল নম্বর</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 4px; color: var(--text-dark);">ডেলিভারি ঠিকানা</label>
                    <textarea name="address" rows="2" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box;">{{ old('address', $user->address) }}</textarea>
                </div>

                <hr style="border: none; border-top: 1px solid var(--border-color); margin: 20px 0;">

                <h3 style="font-size: 15px; color: var(--primary); margin-bottom: 12px; font-weight: 700;">পাসওয়ার্ড পরিবর্তন (প্রয়োজন না হলে খালি রাখুন)</h3>
                <div class="grid-form-2" style="margin-bottom: 18px;">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 4px; color: var(--text-dark);">নতুন পাসওয়ার্ড</label>
                        <input type="password" name="new_password" placeholder="••••••••" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 4px; color: var(--text-dark);">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" name="new_password_confirmation" placeholder="••••••••" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box;">
                    </div>
                </div>

                <button type="submit" class="btn btn-gold" style="font-weight: 700; padding: 10px 22px;">তথ্য সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>
</div>
@endsection
