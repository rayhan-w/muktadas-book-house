<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'অ্যাডমিন প্যানেল | মুক্তাদার বইঘর')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --admin-dark: #0f172a;
            --admin-sidebar: #1e293b;
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
        }

        .sidebar-brand {
            padding: 20px;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand span {
            color: #fbbf24;
        }

        .sidebar-nav {
            padding: 15px 10px;
            overflow-y: auto;
            flex: 1;
        }

        .nav-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 10px 12px 4px;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 3px;
            text-decoration: none;
            transition: 0.15s;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--admin-primary);
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid #334155;
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
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--admin-dark);
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .admin-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fbbf24;
            color: #1e293b;
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* Cards & Tables */
        .admin-card {
            background: #fff;
            border: 1px solid var(--admin-border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
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
            display: inline-block;
            padding: 3px 8px;
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
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-blue { background: var(--admin-primary); color: #fff; }
        .btn-blue:hover { background: var(--admin-primary-hover); }
        .btn-green { background: #16a34a; color: #fff; }
        .btn-red { background: #dc2626; color: #fff; }
        .btn-gray { background: #e2e8f0; color: #334155; }

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
            .sidebar-brand span, .nav-label, .sidebar-link span, .sidebar-footer { display: none; }
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
            📚 <span>মুক্তাদার বইঘর</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">মূল মেনু</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                📊 <span>ড্যাশবোর্ড</span>
            </a>

            <div class="nav-label">বই ও প্রকাশনা</div>
            <a href="{{ route('admin.books.index') }}" class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                📖 <span>সকল বই</span>
            </a>
            <a href="{{ route('admin.publishers.index') }}" class="sidebar-link {{ request()->routeIs('admin.publishers.index') ? 'active' : '' }}">
                🏢 <span>প্রকাশনী তালিকা</span>
            </a>
            <a href="{{ route('admin.publishers.books') }}" class="sidebar-link {{ request()->routeIs('admin.publishers.books*') ? 'active' : '' }}">
                📚 <span>প্রকাশকদের বই</span>
                @php
                    $pendingPubBooks = \App\Models\Book::whereNotNull('user_id')->where('approval_status', 'pending')->count();
                @endphp
                @if($pendingPubBooks > 0)
                    <span style="margin-left: auto; background: #ef4444; color: #fff; font-size: 11px; padding: 2px 7px; border-radius: 999px; font-weight: 700;">{{ $pendingPubBooks }}</span>
                @endif
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                📑 <span>ক্যাটাগরি</span>
            </a>

            <div class="nav-label">বিক্রয় ও পেমেন্ট</div>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                🛍️ <span>অর্ডারসমূহ</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                💳 <span>পেমেন্ট সেটিংস</span>
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                🏷️ <span>কুপন ও অফার</span>
            </a>

            <div class="nav-label">গ্রাহক ও মেম্বারশিপ</div>
            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                👥 <span>পাঠক তালিকা</span>
            </a>
            <a href="{{ route('admin.memberships.index') }}" class="sidebar-link {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }}">
                👑 <span>মেম্বারশিপ</span>
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                ⭐ <span>রিভিউ অনুমোদন</span>
            </a>

            <div class="nav-label">যোগাযোগ ও সাইট</div>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                ✉️ <span>বার্তা ও সাবস্ক্রাইবার</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                ⚙️ <span>সাইট সেটিংস</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link" style="color: #fbbf24;">
                🌐 <span>ওয়েবসাইটে যান →</span>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="admin-topbar">
            <div class="topbar-title">@yield('page_title', 'অ্যাডমিন ড্যাশবোর্ড')</div>

            <div class="admin-user">
                <div class="admin-avatar">{{ mb_substr(Auth::user()?->name ?? 'A', 0, 1) }}</div>
                <div>
                    <div>{{ Auth::user()?->name ?? 'অ্যাডমিন' }}</div>
                    <small style="color: var(--admin-muted); display: block; line-height: 1;">সুপার অ্যাডমিন</small>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-left: 15px;">
                    @csrf
                    <button type="submit" class="btn-sm btn-gray">লগআউট</button>
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
