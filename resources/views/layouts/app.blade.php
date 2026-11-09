<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'মুক্তাদার বইঘর | Muktada\'s Boighor — জ্ঞান, মনন ও সুন্দর জীবনের ঠিকানা')</title>
    <meta name="description" content="@yield('meta_description', 'মুক্তাদার বইঘর — লেখক মুক্তাদার চিন্তাশীল বই, উপন্যাস, গবেষণা ও জীবনমুখী সাহিত্যের একমাত্র বিশ্বস্ত প্ল্যাটফর্ম।')">
    <meta name="keywords" content="@yield('meta_keywords', 'মুক্তাদার বইঘর, মুক্তাদা, বাংলা বই, ই-বুক, উপন্যাস, ইসলামিক বই, আত্মউন্নয়ন, বইমেলা')">

    <!-- Open Graph / Social Meta -->
    <meta property="og:title" content="@yield('title', 'মুক্তাদার বইঘর | Muktada\'s Boighor')">
    <meta property="og:description" content="@yield('meta_description', 'লেখক মুক্তাদার চিন্তাশীল বই ও সাহিত্যের অনন্য ডিজিটাল প্ল্যাটফর্ম।')">
    <meta property="og:image" content="@yield('og_image', asset('muktadar-logo.jpg'))">
    <meta property="og:type" content="website">

    <!-- Google Font: Noto Sans Bengali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- PlayMathEarn Reference Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/playmathearn.css') }}?v={{ time() }}">

    <style>
        :root {
            --paper: #fffdf7;
            --cream: #f6f0e4;
            --navy: #092d45;
            --ink: #193b4d;
            --gold: #d6a12e;
            --gold-light: #f4cf68;
            --gold-dark: #b8850e;
            --line: #e4ddcd;
            --muted: #6f756f;
            --font-bengali: 'Noto Sans Bengali', Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-bengali);
            background-color: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .real-site {
            max-width: 1240px;
            margin: 0 auto;
            background: var(--paper);
            min-height: 100vh;
            box-shadow: 0 0 35px rgba(9, 45, 69, 0.08);
            display: flex;
            flex-direction: column;
        }

        /* Header Bar */
        .real-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fffdf9;
            border-bottom: 1px solid var(--line);
            box-shadow: 0 2px 10px rgba(9, 45, 69, 0.04);
        }

        .real-head-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 24px;
            background: #fffdf9;
        }

        .real-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--navy);
            flex-shrink: 0;
        }

        .real-brand img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        .real-brand span {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .real-brand b {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.2px;
        }

        .real-brand small {
            font-size: 8.5px;
            color: var(--gold-dark);
            font-weight: 700;
            letter-spacing: 0.8px;
        }

        /* Search Form */
        .real-search-form {
            display: flex;
            align-items: center;
            flex: 1;
            max-width: 480px;
            height: 42px;
            border: 1.5px solid var(--line);
            border-radius: 999px;
            padding: 2px 6px 2px 16px;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .real-search-form:focus-within {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(9, 45, 69, 0.08);
        }

        .real-search-form input.real-search {
            border: 0;
            outline: 0;
            background: transparent;
            flex: 1;
            width: 100%;
            height: 100%;
            font-family: inherit;
            font-size: 14px;
            color: var(--ink);
        }

        .real-search-form input.real-search::placeholder {
            color: #94a3b8;
        }

        .real-search-form button {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: var(--navy);
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.1s;
        }

        .real-search-form button:hover {
            background: var(--gold);
            color: var(--navy);
        }

        /* Right Header Nav */
        .real-head-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .nav-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            color: var(--navy);
            border: 1px solid var(--line);
            background: #fff;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .nav-pill:hover {
            background: #fdf6e2;
            border-color: var(--gold);
            color: var(--navy);
            transform: translateY(-1px);
        }

        .pill-gold {
            background: linear-gradient(135deg, #f4cf68, #d6a12e);
            color: #092d45;
            border-color: #c48e1a;
        }

        .pill-gold:hover {
            background: linear-gradient(135deg, #e4b840, #bd881a);
            color: #092d45;
        }

        .pill-cart {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
            position: relative;
        }

        .pill-cart:hover {
            background: #154566;
            color: #fff;
        }

        .cart-badge {
            background: var(--gold);
            color: var(--navy);
            border-radius: 999px;
            padding: 1px 7px;
            font-size: 11px;
            font-weight: 800;
            margin-left: 2px;
        }

        .pill-publisher {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .pill-publisher:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Sub Navigation Bar */
        .real-nav {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 8px 18px;
            background: #fff8ed;
            border-top: 1px solid #f0eadb;
            border-bottom: 2px solid var(--gold);
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
        }

        .real-nav::-webkit-scrollbar {
            display: none;
        }

        .real-nav a {
            display: inline-flex;
            align-items: center;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--navy);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .real-nav a:hover,
        .real-nav a.active {
            background: var(--gold-light);
            color: var(--navy);
            box-shadow: 0 2px 8px rgba(214, 161, 46, 0.25);
        }

        /* Main Slot */
        .real-main-wrap {
            flex: 1;
        }

        /* Alert Messages */
        .alert-wrap {
            max-width: 1100px;
            margin: 15px auto 0;
            padding: 0 20px;
        }

        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Footer */
        .site-footer {
            background: #092d45;
            color: #e2e8f0;
            border-top: 3px solid var(--gold);
            padding: 45px 30px 25px;
            margin-top: auto;
        }

        .footer-inner {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
            gap: 30px;
            margin-bottom: 35px;
        }

        .footer-brand b {
            font-size: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .footer-brand small {
            display: block;
            color: var(--gold-light);
            font-size: 12px;
            margin-bottom: 12px;
        }

        .footer-brand p {
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.7;
        }

        .footer-col b {
            display: block;
            font-size: 16px;
            color: var(--gold-light);
            margin-bottom: 14px;
            font-weight: 700;
            border-bottom: 1px solid rgba(214, 161, 46, 0.3);
            padding-bottom: 6px;
        }

        .footer-col a,
        .footer-col span {
            display: block;
            font-size: 13.5px;
            color: #cbd5e1;
            text-decoration: none;
            margin-bottom: 8px;
            transition: color 0.2s, transform 0.2s;
        }

        .footer-col a:hover {
            color: var(--gold-light);
            transform: translateX(3px);
        }

        .footer-whatsapp {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #25d366;
            color: #fff !important;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px !important;
            margin-top: 8px;
        }

        .footer-whatsapp:hover {
            background: #1ebc59;
            transform: translateY(-2px) !important;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .real-head-top {
                flex-wrap: wrap;
                padding: 10px 14px;
                gap: 10px;
            }

            .real-brand img {
                width: 36px;
                height: 36px;
            }

            .real-brand b {
                font-size: 15px;
            }

            .real-search-form {
                order: 3;
                max-width: 100%;
                width: 100%;
                height: 38px;
            }

            .real-head-nav {
                gap: 5px;
            }

            .nav-pill {
                padding: 6px 10px;
                font-size: 11.5px;
            }

            .real-nav {
                justify-content: flex-start;
                padding: 8px 12px;
                gap: 8px;
            }

            .real-nav a {
                font-size: 12px;
                padding: 5px 11px;
            }

            .footer-inner {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="real-site">

    <!-- Header matching PlayMathEarn -->
    <header class="real-header">
        <div class="real-head-top">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="real-brand">
                <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর">
                <span>
                    <b>মুক্তাদার বইঘর</b>
                    <small>MUKTADA'S BOOK HOUSE</small>
                </span>
            </a>

            <!-- Search Form -->
            <form action="{{ route('books.index') }}" method="GET" class="real-search-form">
                <input type="search" name="search" class="real-search" placeholder="বইয়ের নাম বা বিষয় খুঁজুন..." value="{{ request('search') }}" aria-label="বই খুঁজুন">
                <button type="submit" aria-label="সার্চ">⌕</button>
            </form>

            <!-- Right Nav / User Actions -->
            <nav class="real-head-nav">
                <!-- Publisher Section -->
                @auth
                    @if(auth()->user()->isApprovedPublisher())
                        <a href="{{ route('publisher.dashboard') }}" class="nav-pill pill-publisher" title="প্রকাশক ড্যাশবোর্ড">🏢 ড্যাশবোর্ড</a>
                    @elseif(auth()->user()->isPublisher())
                        <a href="{{ route('publisher.dashboard') }}" class="nav-pill pill-publisher" title="প্রকাশক পেন্ডিং">⏳ প্রকাশক</a>
                    @else
                        <a href="{{ route('publisher.register') }}" class="nav-pill pill-publisher" title="প্রকাশক হিসেবে যোগ দিন">🏢 প্রকাশক</a>
                    @endif
                @else
                    <a href="{{ route('publisher.register') }}" class="nav-pill pill-publisher" title="প্রকাশক হিসেবে যোগ দিন">🏢 প্রকাশক</a>
                @endauth

                <!-- Auth / Profile -->
                @guest
                    <a href="{{ route('login') }}" class="nav-pill">লগইন</a>
                    <a href="{{ route('register') }}" class="nav-pill pill-gold">রেজিস্ট্রেশন</a>
                @else
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-pill" style="background:#fee2e2; color:#991b1b; border-color:#fca5a5;">⚙️ অ্যাডমিন</a>
                    @endif
                    <a href="{{ route('reader.dashboard') }}" class="nav-pill">👤 প্রোফাইল</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-pill" style="cursor:pointer; background:transparent;">লগআউট</button>
                    </form>
                @endguest

                <!-- Shopping Cart -->
                <a href="{{ route('cart.index') }}" class="nav-pill pill-cart" title="শপিং কার্ট">
                    🛒 <span class="cart-badge">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                </a>
            </nav>
        </div>

        <!-- Navigation Bar -->
        <nav class="real-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">হোম</a>
            <a href="{{ route('home') }}#categories">ক্যাটাগরি</a>
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') && !request('category') ? 'active' : '' }}">সকল বই</a>
            <a href="{{ route('home') }}#popular">বেস্টসেলার</a>
            <a href="{{ route('memberships.index') }}" class="{{ request()->routeIs('memberships.*') ? 'active' : '' }}">মেম্বারশিপ</a>
            <a href="{{ route('author') }}" class="{{ request()->routeIs('author') ? 'active' : '' }}">লেখক পরিচিতি</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">যোগাযোগ</a>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="real-main-wrap">
        @if(session('success') || session('error'))
            <div class="alert-wrap">
                @if(session('success'))
                    <div class="alert alert-success">✓ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">✕ {{ session('error') }}</div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer matching PlayMathEarn -->
    <footer class="site-footer" id="contact">
        <div class="footer-inner">
            <div class="footer-brand">
                <b>▰ মুক্তাদার বইঘর</b>
                <small>MUKTADA'S BOOK HOUSE — জ্ঞান, পাঠ ও জীবন</small>
                <p>লেখক মুক্তাদার চিন্তাশীল সাহিত্য, উপন্যাস, জীবনমুখী প্রবন্ধ ও ইসলামী বইয়ের একমাত্র প্রামাণ্য রিডিং প্ল্যাটফর্ম। ঘরে বসে হার্ডকপি সংগ্রহ করুন কিংবা সরাসরি ডিজিটাল রিডারে ই-বুক উপভোগ করুন।</p>
                @if(\App\Models\SiteSetting::get('whatsapp_number'))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp_number')) }}" target="_blank" class="footer-whatsapp">
                        💬 WhatsApp এ যোগাযোগ
                    </a>
                @endif
            </div>

            <div class="footer-col">
                <b>দ্রুত লিংক</b>
                <a href="{{ route('home') }}">হোম</a>
                <a href="{{ route('books.index') }}">সকল বই</a>
                <a href="{{ route('home') }}#categories">ক্যাটাগরি</a>
                <a href="{{ route('home') }}#popular">বেস্টসেলার বই</a>
                <a href="{{ route('memberships.index') }}">মেম্বারশিপ প্ল্যান</a>
                <a href="{{ route('publisher.register') }}" style="color:var(--gold-light);font-weight:700;">🏢 প্রকাশক নিবন্ধন</a>
            </div>

            <div class="footer-col">
                <b>সাহায্য ও নীতি</b>
                <a href="{{ route('about') }}">আমাদের কথা</a>
                <a href="{{ route('author') }}">লেখক পরিচিতি</a>
                <a href="{{ route('terms') }}">ব্যবহারের শর্তাবলী</a>
                <a href="{{ route('privacy') }}">গোপনীয়তা নীতি</a>
                <a href="{{ route('refund-policy') }}">রিফান্ড ও রিটার্ন নীতি</a>
                <a href="{{ route('contact') }}">যোগাযোগ ও অভিযোগ</a>
            </div>

            <div class="footer-col">
                <b>যোগাযোগ</b>
                <span>📧 {{ \App\Models\SiteSetting::get('contact_email', 'contact@muktadasbookhouse.com') }}</span>
                <span>📞 {{ \App\Models\SiteSetting::get('contact_phone', '+880 1700-112233') }}</span>
                <span>📍 {{ \App\Models\SiteSetting::get('contact_address', 'কনকর্ড টাওয়ার, শান্তিনগর, ঢাকা-১২১৭') }}</span>
                <span style="color:#94a3b8; font-size:12px; margin-top:8px;">সরাসরি কুরিয়ারে সারাদেশে ক্যাশ অন ডেলিভারি সুবিধা প্রযোজ্য।</span>
            </div>
        </div>

        <div class="footer-bottom">
            <div>স্বত্ব © ২০২৪-{{ date('Y') }} মুক্তাদার বইঘর (Muktada's Boighor)। সর্বস্বত্ব সংরক্ষিত।</div>
            <div>ডিজিটাল পাঠ ও প্রকাশনা সহযোগী: <strong>Muktada Book House</strong></div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
