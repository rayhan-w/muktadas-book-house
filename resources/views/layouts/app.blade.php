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

    <!-- Google Fonts: Noto Sans Bengali & Manrope & Libre Baskerville -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Manrope:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons 1.11.3 & FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SahojPath Reference Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/sahojpath.css') }}?v={{ time() }}">

    @yield('styles')
</head>
<body class="real-site">

    <!-- Header matching SahojPath -->
    <header class="real-header">
        <div class="real-head-top {{ request()->routeIs('checkout*') ? 'checkout-header-mode' : '' }}">
            <!-- Brand (লোগোর পাশে শুধু বাংলা নাম, ইংরেজি Muktada..house বাদ) -->
            <a href="{{ route('home') }}" class="real-brand">
                <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর">
                <span>
                    <b>মুক্তাদার বইঘর</b>
                </span>
            </a>

            @if(!request()->routeIs('checkout*'))
                <!-- Search Form -->
                <form action="{{ route('books.index') }}" method="GET" class="real-search-form">
                    <input type="search" name="search" class="real-search" placeholder="বইয়ের নাম, লেখক বা বিষয় খুঁজুন..." value="{{ request('search') }}" aria-label="বই খুঁজুন">
                    <button type="submit" aria-label="সার্চ">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Right Nav / User Actions -->
                <nav class="real-head-nav">
                    <!-- Auth / Profile (একক লগইন বাটন - ক্লিক করলে ভেতরে রেজিস্ট্রেশনের অপশন রয়েছে) -->
                    @guest
                        <a href="{{ route('login') }}" class="nav-pill-auth auth-link" title="লগইন করুন">
                            <i class="bi bi-box-arrow-in-right"></i> লগইন
                        </a>
                    @else
                        <div class="nav-pill-auth nav-pill-logged">
                            <a href="{{ route('reader.dashboard') }}" class="auth-link" title="আমার প্রোফাইল">
                                <i class="bi bi-person-circle"></i> {{ Str::limit(auth()->user()->name, 8) }}
                            </a>
                            @if(auth()->user()->isAdmin())
                                <span class="auth-sep">|</span>
                                <a href="{{ route('admin.dashboard') }}" class="auth-link" style="color:var(--sp-burgundy);" title="অ্যাডমিন">
                                    <i class="bi bi-gear-fill"></i>
                                </a>
                            @endif
                            <span class="auth-sep">|</span>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin:0;">
                                @csrf
                                <button type="submit" class="auth-link" style="background:transparent; border:none; cursor:pointer; padding:0; display:inline-flex; align-items:center;" title="লগআউট">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    @endguest

                    <!-- Shopping Cart (মোবাইলে সবসময় উপরে ডানে থাকবে) -->
                    <a href="{{ route('cart.index') }}" class="nav-pill pill-cart" title="শপিং কার্ট">
                        <i class="bi bi-bag-heart-fill"></i>
                        <span class="cart-badge">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                    </a>
                </nav>
            @else
                <!-- Checkout Header Actions (মোবাইলে ক্লিন ব্যাক বাটন) -->
                <div class="checkout-head-actions">
                    <a href="{{ route('cart.index') }}" class="checkout-back-btn">
                        <i class="bi bi-arrow-left"></i> কার্টে ফিরে যান
                    </a>
                </div>
            @endif
        </div>

        @if(!request()->routeIs('checkout*'))
        <!-- Navigation Bar (প্রকাশক অপশন নিচে ফুটারে থাকবে) -->
        <nav class="real-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> হোম
            </a>
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') && !request('category') ? 'active' : '' }}">
                <i class="bi bi-book"></i> সকল বই
            </a>
            <a href="{{ route('home') }}#popular">
                <i class="bi bi-fire text-danger"></i> বেস্টসেলার
            </a>
        </nav>
        @endif
    </header>

    <!-- Main Content Container -->
    <main class="real-main-wrap">
        @if(session('success') || session('error'))
            <div style="max-width: 1200px; margin: 15px auto 0; padding: 0 20px;">
                @if(session('success'))
                    <div style="padding: 12px 18px; border-radius: 10px; font-weight: 600; font-size: 14px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                        <i class="bi bi-check-circle-fill text-success"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="padding: 12px 18px; border-radius: 10px; font-weight: 600; font-size: 14px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;">
                        <i class="bi bi-exclamation-triangle-fill text-danger"></i> {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    @if(!request()->routeIs('checkout*'))
    <!-- Footer matching SahojPath -->
    <footer class="site-footer" id="contact">
        <!-- Newsletter Strip -->
        <div style="background: rgba(255, 255, 255, 0.04); border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 22px 20px;">
            <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(251, 191, 36, 0.15); color: #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                        <i class="bi bi-envelope-paper-heart-fill"></i>
                    </div>
                    <div>
                        <b style="color: #ffffff; font-size: 16px; display: block; line-height: 1.3;">নতুন বই ও বিশেষ ছাড়ের আপডেট পেতে চান?</b>
                        <small style="color: #94a3b8; font-size: 13px;">আমাদের নিউজলেটারে সাবস্ক্রাইব করুন, সরাসরি আপনার ইমেইলে পেয়ে যাবেন আকর্ষণীয় অফার।</small>
                    </div>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" style="display: flex; gap: 8px; flex: 1; max-width: 440px; min-width: 260px;">
                    @csrf
                    <input type="email" name="email" required placeholder="আপনার ইমেইল অ্যাড্রেস লিখুন..." style="flex: 1; padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #ffffff; font-size: 13.5px; outline: none;">
                    <button type="submit" style="background: #16a34a; color: #ffffff; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; white-space: nowrap; transition: 0.2s; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="bi bi-send-fill"></i> সাবস্ক্রাইব
                    </button>
                </form>
            </div>
            @if(session('newsletter_success'))
                <div style="max-width: 1200px; margin: 12px auto 0; background: #dcfce7; color: #166534; padding: 10px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 600;">
                    ✓ {{ session('newsletter_success') }}
                </div>
            @endif
        </div>

        <div class="footer-inner">
            <div class="footer-brand">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <img src="{{ asset('muktadar-logo.jpg') }}" alt="মুক্তাদার বইঘর" style="width:48px; height:48px; border-radius:10px; object-fit:cover; border:1.5px solid rgba(255,255,255,0.2);">
                    <div>
                        <b style="font-size:20px; color:#ffffff; font-weight:800; display:block; line-height:1.2;">মুক্তাদার বইঘর</b>
                        <small style="color:#94a3b8; font-size:11.5px; font-weight:600; display:block; margin-top:2px;">শব্দের মায়ায়, গল্পের ছায়ায়</small>
                    </div>
                </div>
                <p>লেখক মুক্তাদার চিন্তাশীল সাহিত্য, উপন্যাস, জীবনমুখী গবেষণা ও ইসলামী বইয়ের একমাত্র প্রামাণ্য রিডিং প্ল্যাটফর্ম। ঘরে বসে হার্ডকপি সংগ্রহ করুন কিংবা সরাসরি ডিজিটাল রিডারে ই-বুক উপভোগ করুন।</p>
                
                <!-- অন্যান্য প্রাপ্তি স্থান (Page 1) -->
                <div style="margin:14px 0; padding:12px 14px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.12); border-radius:10px; font-size:12.5px; color:#cbd5e1; line-height:1.6;">
                    <strong style="color:#fef08a; display:block; margin-bottom:4px; font-size:13px;">
                        <i class="bi bi-geo-alt-fill text-warning me-1"></i> অন্যান্য প্রাপ্তি স্থান:
                    </strong>
                    <div>(১) সি এস ডি, ঢাকা সেনানিবাস, ঢাকা</div>
                    <div>(২) রাওয়া পাবলিকেশন, রাওয়া কমপ্লেক্স, মহাখালী, ঢাকা।</div>
                </div>

                @if(\App\Models\SiteSetting::get('whatsapp_number'))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp_number')) }}" target="_blank" class="footer-whatsapp">
                        <i class="bi bi-whatsapp"></i> WhatsApp এ যোগাযোগ
                    </a>
                @endif
            </div>

            <div class="footer-col">
                <b>দ্রুত লিংক</b>
                <a href="{{ route('home') }}"><i class="bi bi-chevron-right small"></i> হোম</a>
                <a href="{{ route('books.index') }}"><i class="bi bi-chevron-right small"></i> সকল বই</a>
                <a href="{{ route('home') }}#categories"><i class="bi bi-chevron-right small"></i> ক্যাটাগরি</a>
                <a href="{{ route('home') }}#popular"><i class="bi bi-chevron-right small"></i> বেস্টসেলার বই</a>
                <a href="{{ route('memberships.index') }}"><i class="bi bi-chevron-right small"></i> মেম্বারশিপ প্ল্যান</a>
                <a href="{{ route('publisher.register') }}" style="color:var(--sp-gold); font-weight:700;"><i class="bi bi-chevron-right small"></i> প্রকাশক নিবন্ধন</a>
            </div>

            <div class="footer-col">
                <b>সাহায্য ও নীতি</b>
                <a href="{{ route('about') }}"><i class="bi bi-chevron-right small"></i> আমাদের কথা</a>
                <a href="{{ route('author') }}"><i class="bi bi-chevron-right small"></i> লেখক পরিচিতি</a>
                <a href="{{ route('terms') }}"><i class="bi bi-chevron-right small"></i> ব্যবহারের শর্তাবলী</a>
                <a href="{{ route('privacy') }}"><i class="bi bi-chevron-right small"></i> গোপনীয়তা নীতি</a>
                <a href="{{ route('refund-policy') }}"><i class="bi bi-chevron-right small"></i> রিফান্ড ও রিটার্ন নীতি</a>
                <a href="{{ route('contact') }}"><i class="bi bi-chevron-right small"></i> যোগাযোগ ও অভিযোগ</a>
            </div>

            <div class="footer-col">
                <b>যোগাযোগ</b>
                <span><i class="bi bi-envelope-fill text-danger me-2"></i> {{ \App\Models\SiteSetting::get('contact_email', 'contact@muktadasbookhouse.com') }}</span>
                <span><i class="bi bi-telephone-fill text-danger me-2"></i> {{ \App\Models\SiteSetting::get('contact_phone', '+880 1700-112233') }}</span>
                <span><i class="bi bi-geo-alt-fill text-danger me-2"></i> {{ \App\Models\SiteSetting::get('contact_address', 'কনকর্ড টাওয়ার, শান্তিনগর, ঢাকা-১২১৭') }}</span>
                <span style="color:#94a3b8; font-size:12px; margin-top:8px;"><i class="bi bi-truck text-success me-1"></i> সারাদেশে ক্যাশ অন ডেলিভারি সুবিধা প্রযোজ্য।</span>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-inner">
                <div>স্বত্ব © ২০২৪-{{ date('Y') }} মুক্তাদার বইঘর (Muktada's Boighor)। সর্বস্বত্ব সংরক্ষিত।</div>
                <div>ডিজিটাল পাঠ ও প্রকাশনা সহযোগী: <strong>Muktada Book House</strong></div>
            </div>
        </div>
    </footer>
    @else
    <!-- Minimal Checkout Footer -->
    <footer class="checkout-minimal-footer">
        <div><i class="bi bi-shield-lock-fill text-success me-1"></i> স্বত্ব © ২০২৪-{{ date('Y') }} মুক্তাদার বইঘর। নিরাপদ পেমেন্ট ও এনক্রিপ্টেড চেকআউট।</div>
    </footer>
    @endif

    @yield('scripts')
</body>
</html>
