<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাডমিন প্যানেল | মুক্তাদার বইঘর')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --admin-dark: #0f172a;
            --admin-sidebar: #0f172a;
            --admin-sidebar-surface: #1e293b;
            --admin-primary: #2563eb;
            --admin-primary-hover: #1d4ed8;
            --admin-gold: #d97706;
            --admin-bg: #f8fafc;
            --admin-card: #ffffff;
            --admin-border: #e2e8f0;
            --admin-text: #0f172a;
            --admin-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            border-right: 1px solid #1e293b;
        }

        .sidebar-brand {
            padding: 20px;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            background: #0f172a;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2563eb 0%, #0d9488 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 17px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
            flex-shrink: 0;
        }

        .sidebar-nav {
            padding: 14px 10px;
            overflow-y: auto;
            flex: 1;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        .nav-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            padding: 12px 12px 6px;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            border-radius: 9px;
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 3px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-link .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            background: rgba(255, 255, 255, 0.04);
            color: #94a3b8;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #f1f5f9;
        }

        .sidebar-link:hover .nav-icon {
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
            transform: scale(1.05);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.2) 0%, rgba(37, 99, 235, 0.05) 100%);
            color: #fff;
            border-left: 3px solid #3b82f6;
        }

        .sidebar-link.active .nav-icon {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.45);
        }

        .sidebar-footer {
            padding: 14px 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: #0f172a;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid var(--admin-border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--admin-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 15px;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }

        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* Cards & Tables */
        .admin-card {
            background: #fff;
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03), 0 4px 12px rgba(0,0,0,0.02);
        }

        /* KPI Card Styles */
        .kpi-card {
            background: #fff;
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03), 0 4px 10px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }
        .kpi-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .kpi-icon-emerald {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .kpi-icon-amber {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .kpi-icon-blue {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        .kpi-icon-purple {
            background: #faf5ff;
            color: #7c3aed;
            border: 1px solid #e9d5ff;
        }
        .kpi-icon-teal {
            background: #f0fdfa;
            color: #0f766e;
            border: 1px solid #99f6e4;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 700;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table th, .data-table td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid var(--admin-border);
        }

        .data-table th {
            background: #f8fafc;
            color: var(--admin-muted);
            font-weight: 700;
            font-size: 13px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-verified { background: #dbeafe; color: #1e40af; }
        .badge-processing { background: #e0e7ff; color: #3730a3; }
        .badge-shipped { background: #f3e8ff; color: #6b21a8; }
        .badge-delivered { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        .btn-sm {
            padding: 7px 13px;
            font-size: 13px;
            border-radius: 7px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }

        .btn-blue { background: var(--admin-primary); color: #fff; }
        .btn-blue:hover { background: var(--admin-primary-hover); }
        .btn-green { background: #16a34a; color: #fff; }
        .btn-green:hover { background: #15803d; }
        .btn-red { background: #dc2626; color: #fff; }
        .btn-red:hover { background: #b91c1c; }
        .btn-gray { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
        .btn-gray:hover { background: #e2e8f0; }

        /* Form elements */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--admin-dark);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        /* Alert */
        .alert {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        @media (max-width: 900px) {
            .sidebar { width: 70px; }
            .sidebar-brand span, .brand-text, .nav-label, .sidebar-link span, .sidebar-footer span, .sidebar-link .badge-count { display: none; }
            .sidebar-link { justify-content: center; padding: 10px; }
            .sidebar-link .nav-icon { margin: 0; }
            .main-wrapper { margin-left: 70px; }
            .grid-4, .grid-3, .grid-2 { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .content-area { padding: 16px 12px; }
            .admin-topbar { padding: 12px 14px; }
            .topbar-title { font-size: 15px; }
            .admin-card { padding: 16px 14px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-book-half"></i>
            </div>
            <div class="brand-text">
                <div style="font-weight: 700; font-size: 16px; color: #fff; line-height: 1.2;">মুক্তাদার বইঘর</div>
                <small style="font-size: 11px; color: #94a3b8; font-weight: 500; display: block; margin-top: 2px;">অ্যাডমিন কন্ট্রোল</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">মূল মেনু</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
                <span>ড্যাশবোর্ড</span>
            </a>

            <div class="nav-label">বই ও প্রকাশনা</div>
            <a href="{{ route('admin.books.index') }}" class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-journal-album"></i></span>
                <span>সকল বই</span>
            </a>
            <a href="{{ route('admin.publishers.index') }}" class="sidebar-link {{ request()->routeIs('admin.publishers.index') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-buildings"></i></span>
                <span>প্রকাশনী তালিকা</span>
            </a>
            <a href="{{ route('admin.publishers.books') }}" class="sidebar-link {{ request()->routeIs('admin.publishers.books*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-journal-bookmark-fill"></i></span>
                <span>প্রকাশকদের বই</span>
                @php
                    $pendingPubBooks = \App\Models\Book::whereNotNull('user_id')->where('approval_status', 'pending')->count();
                @endphp
                @if($pendingPubBooks > 0)
                    <span class="badge-count" style="margin-left: auto; background: #ef4444; color: #fff; font-size: 11px; padding: 2px 7px; border-radius: 999px; font-weight: 700;">{{ $pendingPubBooks }}</span>
                @endif
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-tags-fill"></i></span>
                <span>ক্যাটাগরি</span>
            </a>

            <div class="nav-label">বিক্রয় ও পেমেন্ট</div>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-bag-check-fill"></i></span>
                <span>অর্ডারসমূহ</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-credit-card-2-front-fill"></i></span>
                <span>পেমেন্ট সেটিংস</span>
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-ticket-perforated-fill"></i></span>
                <span>কুপন ও অফার</span>
            </a>

            <div class="nav-label">গ্রাহক ও মেম্বারশিপ</div>
            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-people-fill"></i></span>
                <span>পাঠক তালিকা</span>
            </a>
            <a href="{{ route('admin.memberships.index') }}" class="sidebar-link {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-award-fill"></i></span>
                <span>মেম্বারশিপ</span>
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-star-fill"></i></span>
                <span>রিভিউ অনুমোদন</span>
            </a>

            <div class="nav-label">যোগাযোগ ও সাইট</div>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-chat-left-dots-fill"></i></span>
                <span>বার্তা ও সাবস্ক্রাইবার</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="bi bi-gear-fill"></i></span>
                <span>সাইট সেটিংস</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link" style="color: #38bdf8;">
                <span class="nav-icon" style="background: rgba(56, 189, 248, 0.12); color: #38bdf8;"><i class="bi bi-box-arrow-up-right"></i></span>
                <span>ওয়েবসাইটে যান</span>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="admin-topbar">
            <div class="topbar-title">
                <i class="bi bi-grid-fill" style="color: var(--admin-primary); font-size: 19px;"></i>
                @yield('page_title', 'অ্যাডমিন ড্যাশবোর্ড')
            </div>

            <div class="admin-user">
                <div class="admin-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <div>{{ Auth::user()?->name ?? 'অ্যাডমিন' }}</div>
                    <small style="color: var(--admin-muted); display: block; line-height: 1;">সুপার অ্যাডমিন</small>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-left: 15px;">
                    @csrf
                    <button type="submit" class="btn-sm btn-gray">
                        <i class="bi bi-box-arrow-right"></i> <span>লগআউট</span>
                    </button>
                </form>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
