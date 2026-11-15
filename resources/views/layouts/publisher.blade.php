<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'পাবলিশার ড্যাশবোর্ড | মুক্তাদার বইঘর')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --pub-dark: #0f172a;
            --pub-sidebar: #0f233a;
            --pub-primary: #0284c7;
            --pub-primary-hover: #0369a1;
            --pub-gold: #d97706;
            --pub-bg: #f1f5f9;
            --pub-card: #ffffff;
            --pub-border: #e2e8f0;
            --pub-text: #0f172a;
            --pub-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Noto Sans Bengali', 'Hind Siliguri', 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            background: var(--pub-bg);
            color: var(--pub-text);
            display: flex;
            min-height: 100vh;
            line-height: 1.6;
        }

        button, input, select, textarea, table, th, td, h1, h2, h3, h4, h5, h6, .badge, .btn, .btn-sm, span, p, a, label, small {
            font-family: 'Noto Sans Bengali', 'Hind Siliguri', 'Manrope', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--pub-sidebar);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            box-shadow: 4px 0 15px rgba(0,0,0,0.06);
        }

        .sidebar-brand {
            padding: 22px 20px;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid #1e3a5f;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand span {
            color: #38bdf8;
        }

        .sidebar-brand small {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 2px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            overflow-y: auto;
            flex: 1;
        }

        .nav-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 12px 12px 6px;
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 14.5px;
            font-weight: 600;
            margin-bottom: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(56, 189, 248, 0.12);
            color: #38bdf8;
        }

        .sidebar-link.active {
            background: var(--pub-primary);
            color: #fff;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #1e3a5f;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .pub-topbar {
            background: #fff;
            border-bottom: 1px solid var(--pub-border);
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
            color: var(--pub-dark);
        }

        .pub-user {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            font-weight: 600;
        }

        .pub-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #0284c7;
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 16px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-approved { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* Cards & Tables */
        .pub-card {
            background: #fff;
            border: 1px solid var(--pub-border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
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
            border-bottom: 1px solid var(--pub-border);
        }

        .data-table th {
            background: #f8fafc;
            color: var(--pub-muted);
            font-weight: 700;
            font-size: 13px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary { background: var(--pub-primary); color: #fff; }
        .btn-primary:hover { background: var(--pub-primary-hover); }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-warning { background: #d97706; color: #fff; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-gray { background: #e2e8f0; color: #334155; }
        .btn-gray:hover { background: #cbd5e1; }
        .btn-sm { padding: 6px 12px; font-size: 12.5px; border-radius: 6px; }

        /* Grid */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        /* Stat Card */
        .stat-card {
            background: #fff;
            border: 1px solid var(--pub-border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-val { font-size: 26px; font-weight: 800; color: var(--pub-dark); }
        .stat-label { font-size: 13px; color: var(--pub-muted); font-weight: 600; margin-top: 4px; }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.5;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
            color: #334155;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            transition: 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--pub-primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        /* Backdrop */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(4px);
            z-index: 990;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .sidebar-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Menu Toggle Button */
        .mobile-menu-toggle {
            display: none;
            background: #f1f5f9;
            border: 1px solid var(--pub-border);
            border-radius: 9px;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--pub-dark);
            cursor: pointer;
            margin-right: 10px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .mobile-menu-toggle:hover {
            background: #e2e8f0;
            color: var(--pub-primary);
        }

        /* Sidebar Close Button */
        .sidebar-close-btn {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #cbd5e1;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            margin-left: auto;
            transition: 0.2s;
        }
        .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        /* Table Responsive */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }

        @media (max-width: 991px) {
            .mobile-menu-toggle {
                display: inline-flex;
            }
            .sidebar-close-btn {
                display: inline-flex;
            }
            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: 280px;
                max-width: 85vw;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: none;
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            }
            .main-wrapper {
                margin-left: 0 !important;
                width: 100%;
            }
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
            .grid-2 {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .pub-topbar {
                padding: 12px 18px;
            }
            .content-area {
                padding: 20px 16px;
            }
        }

        @media (max-width: 600px) {
            .grid-4, .grid-3 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .pub-topbar {
                padding: 10px 14px;
            }
            .topbar-title {
                font-size: 15px;
            }
            .pub-user-meta {
                display: none;
            }
            .pub-user {
                gap: 8px;
            }
            .pub-card {
                padding: 16px 12px;
                border-radius: 12px;
                margin-bottom: 16px;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .data-table {
                min-width: 620px;
            }
            .data-table th, .data-table td {
                padding: 10px 10px;
                font-size: 13px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Mobile Drawer Backdrop -->
    <div class="sidebar-backdrop" id="pubSidebarBackdrop"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="pubSidebar">
        <div class="sidebar-brand">
            <a href="{{ route('publisher.dashboard') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; flex: 1; min-width: 0;">
                <img src="{{ \App\Models\SiteSetting::getLogo() }}" alt="Site Logo" style="width: 38px; height: 38px; border-radius: 9px; object-fit: cover; border: 1.5px solid rgba(255, 255, 255, 0.2); background: #fff; padding: 2px; flex-shrink: 0;">
                <div>
                    <span>{{ \App\Models\SiteSetting::get('site_name', 'মুক্তাদার বইঘর') }}</span>
                    <small>পাবলিশার কর্নার</small>
                </div>
            </a>
            <button type="button" class="sidebar-close-btn" id="pubSidebarCloseBtn" aria-label="মেনু বন্ধ করুন">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">মূল মেনু</div>
            <a href="{{ route('publisher.dashboard') }}" class="sidebar-link {{ request()->routeIs('publisher.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2" style="font-size: 16px;"></i> <span>ড্যাশবোর্ড</span>
            </a>

            <div class="nav-label">বই ব্যবস্থাপনা</div>
            <a href="{{ route('publisher.books.index') }}" class="sidebar-link {{ request()->routeIs('publisher.books.index') ? 'active' : '' }}">
                <i class="bi bi-book-half" style="font-size: 16px;"></i> <span>আমার বইসমূহ</span>
            </a>
            <a href="{{ route('publisher.books.create') }}" class="sidebar-link {{ request()->routeIs('publisher.books.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle" style="font-size: 16px;"></i> <span>নতুন বই জমা দিন</span>
            </a>

            <div class="nav-label">সহায়তা ও ওয়েবসাইট</div>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="bi bi-globe2" style="font-size: 16px;"></i> <span>মূল ওয়েবসাইট</span>
            </a>
            <a href="{{ route('contact') }}" target="_blank" class="sidebar-link">
                <i class="bi bi-headset" style="font-size: 16px;"></i> <span>অ্যাডমিন সহায়তা</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div style="font-size: 12px; color: #94a3b8; margin-bottom: 8px;">
                লগইন আছেন: <strong style="color: #fff;">{{ Auth::user()->name }}</strong>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-gray" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-box-arrow-right"></i> লগআউট করুন
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="pub-topbar">
            <div style="display: flex; align-items: center; min-width: 0;">
                <button type="button" class="mobile-menu-toggle" id="pubSidebarToggleBtn" aria-label="মেনু খুলুন">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">@yield('page_title', 'পাবলিশার ড্যাশবোর্ড')</div>
            </div>

            <div class="pub-user">
                <div class="pub-user-meta">
                    <div style="font-weight: 700; line-height: 1.2;">{{ Auth::user()->publisher_company ?: Auth::user()->name }}</div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                        @if(Auth::user()->isExpiredPublisher())
                            <span class="status-badge" style="background:#fee2e2; color:#991b1b; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-clock-history"></i> মেয়াদ উত্তীর্ণ
                            </span>
                        @elseif(Auth::user()->isApprovedPublisher())
                            <span class="status-badge status-approved" style="display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-patch-check-fill"></i> অনুমোদিত ({{ Auth::user()->publisher_plan ?? 'সক্রিয়' }})
                            </span>
                        @elseif(Auth::user()->isPendingPublisher())
                            <span class="status-badge status-pending" style="display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-hourglass-split"></i> পর্যালোচনাধীন
                            </span>
                        @else
                            <span class="status-badge status-rejected" style="display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-x-circle-fill"></i> বাতিলকৃত
                            </span>
                        @endif
                    </div>
                </div>
                <div class="pub-avatar">{{ mb_substr(Auth::user()->publisher_company ?: Auth::user()->name, 0, 1) }}</div>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        (function() {
            var sidebar = document.getElementById('pubSidebar');
            var backdrop = document.getElementById('pubSidebarBackdrop');
            var toggleBtn = document.getElementById('pubSidebarToggleBtn');
            var closeBtn = document.getElementById('pubSidebarCloseBtn');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('open');
                if (backdrop) backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('open');
                if (backdrop) backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSidebar();
            });

            // Auto close if screen enlarged
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    closeSidebar();
                }
            });
        })();
    </script>

    @yield('scripts')
</body>
</html>
