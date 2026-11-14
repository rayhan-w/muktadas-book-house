@extends('layouts.app')

@section('title', 'মুক্তাদার বইঘর | Muktada\'s Boighor — জ্ঞানের আলোয় নতুন পথচলা')

@section('styles')
<style>
    /* Paste Color Modern Clean Hero */
    .hero-banner-section {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto 30px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .hero-banner-link {
        display: block;
        width: 100%;
        border-radius: var(--sp-radius, 16px);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.14);
        border: 1.5px solid rgba(13, 148, 136, 0.22);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        background: #0f172a;
        text-decoration: none;
    }

    .hero-banner-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(13, 148, 136, 0.28);
        border-color: var(--sp-crimson);
    }

    .hero-banner-image {
        width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .hero-banner-section {
            margin-bottom: 20px;
        }

        .hero-banner-link {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.10);
        }
    }

    .badge-discount-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #dc2626 !important;
        color: #ffffff !important;
        border: none !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        padding: 3px 8px !important;
        border-radius: var(--sp-radius-pill) !important;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4) !important;
    }

    .real-hero {
        position: relative;
        min-height: 340px;
        background: linear-gradient(135deg, #042f2e 0%, #0f172b 60%, #115e59 100%) !important;
        color: #fff !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 40px 32px;
        border-radius: var(--sp-radius);
        margin-bottom: 30px;
        overflow: hidden;
        border-bottom: 4px solid var(--sp-crimson);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    }

    .real-hero::after {
        content: "";
        position: absolute;
        z-index: 1;
        right: 4%;
        bottom: 0;
        width: 320px;
        height: 100%;
        background-image: url('{{ asset('author-portrait-cutout.png') }}');
        background-repeat: no-repeat;
        background-position: right bottom;
        background-size: contain;
        pointer-events: none;
        opacity: 0.92;
    }

    .real-hero-content {
        position: relative;
        z-index: 2;
        max-width: 620px;
        text-align: left;
    }

    .hero-badge-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(13, 148, 136, 0.22);
        color: #5eead4;
        border: 1px solid rgba(13, 148, 136, 0.45);
        padding: 5px 14px;
        border-radius: var(--sp-radius-pill);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 14px;
        letter-spacing: 0.3px;
    }

    .real-hero h1 {
        font-size: 32px;
        font-weight: 800;
        color: #ffffff !important;
        line-height: 1.3;
        margin-bottom: 12px;
    }

    .real-hero p {
        font-size: 15px;
        color: #cbd5e1 !important;
        line-height: 1.65;
        margin-bottom: 22px;
    }

    .real-hero-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .hero-btn-primary {
        background: var(--sp-crimson);
        color: #ffffff !important;
        padding: 12px 26px;
        border-radius: var(--sp-radius-pill);
        font-size: 14.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .hero-btn-primary:hover {
        background: var(--sp-burgundy);
        transform: translateY(-2px);
    }

    .hero-btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff !important;
        padding: 12px 22px;
        border-radius: var(--sp-radius-pill);
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.25);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .hero-btn-secondary:hover {
        background: #ffffff;
        color: var(--sp-heading) !important;
        transform: translateY(-2px);
    }

    /* Container */
    .real-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 10px 24px 50px;
        width: 100%;
    }

    /* Section Styling */
    .real-section {
        margin-bottom: 40px;
    }

    /* Membership Banner (Royal Golden Style - Item 15) */
    .real-membership {
        background: linear-gradient(135deg, #451a03 0%, #78350f 25%, #b45309 60%, #d97706 85%, #f59e0b 100%) !important;
        border: 2px solid #fde68a !important;
        border-radius: var(--sp-radius) !important;
        padding: 38px 44px !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin: 40px 0 !important;
        box-shadow: 0 12px 35px rgba(180, 83, 9, 0.35) !important;
        position: relative;
        overflow: hidden;
    }

    .real-membership::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(254, 240, 138, 0.3) 0%, transparent 70%);
        pointer-events: none;
    }

    .real-membership h2 {
        font-size: 26px !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        margin-bottom: 8px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
    }

    .real-membership p {
        font-size: 14.5px !important;
        color: #fef3c7 !important;
        max-width: 620px !important;
        margin-bottom: 18px !important;
        line-height: 1.6;
    }

    .real-membership a.btn-gold-card {
        display: inline-flex !important;
        align-items: center;
        gap: 8px;
        background: #ffffff !important;
        color: #78350f !important;
        padding: 12px 26px !important;
        border-radius: var(--sp-radius-pill) !important;
        font-weight: 800 !important;
        text-decoration: none !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
        transition: all 0.25s ease;
    }

    .real-membership a.btn-gold-card:hover {
        background: #fef3c7 !important;
        color: #451a03 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.3) !important;
    }

    .membership-crown {
        font-size: 72px;
        color: rgba(254, 240, 138, 0.35);
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
    }

    /* Publisher Banner */
    .publisher-banner {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-left: 5px solid var(--sp-crimson);
        border-radius: var(--sp-radius);
        padding: 24px 30px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: var(--sp-shadow-sm);
    }

    .publisher-banner h3 {
        font-size: 19px;
        font-weight: 800;
        color: var(--sp-heading);
        margin-bottom: 4px;
    }

    .publisher-banner p {
        font-size: 14px;
        color: var(--sp-muted);
        margin: 0;
    }

    .publisher-banner a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--sp-burgundy);
        color: #ffffff !important;
        padding: 9px 20px;
        border-radius: var(--sp-radius-pill);
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .publisher-banner a:hover {
        background: var(--sp-crimson);
        transform: translateY(-2px);
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }

    .feature-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--sp-shadow-sm);
        transition: transform 0.2s ease;
    }

    .feature-card:hover {
        transform: translateY(-3px);
    }

    .feature-icon {
        font-size: 26px;
        color: var(--sp-burgundy);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff5f6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--sp-heading);
    }

    .feature-sub {
        font-size: 12px;
        color: var(--sp-muted);
    }

    /* Testimonials */
    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
        margin-bottom: 40px;
    }

    .reader-review-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 20px;
        box-shadow: var(--sp-shadow-sm);
        display: flex;
        flex-direction: column;
    }

    .review-user-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .review-user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--sp-burgundy);
        font-weight: 700;
    }

    .review-user-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--sp-heading);
    }

    .review-stars {
        color: #eab308;
        font-size: 12px;
    }

    .review-comment {
        font-size: 13.5px;
        color: var(--sp-body);
        line-height: 1.6;
        margin-top: 6px;
    }

    @media (max-width: 900px) {
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        /* Mobile Hero Banner: Ultra Compact & Slim */
        .hero-banner-section {
            margin: 0 auto 12px auto !important;
            padding: 0 !important;
        }

        .hero-banner-link {
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08) !important;
        }

        .hero-banner-image {
            border-radius: 12px !important;
            max-height: 145px !important;
            object-fit: cover !important;
        }

        /* Mobile Hero Card: Clean, Slim & Proportionate (Item 6 & Image 2) */
        .badge-discount-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #dc2626 !important;
        color: #ffffff !important;
        border: none !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        padding: 3px 8px !important;
        border-radius: var(--sp-radius-pill) !important;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4) !important;
    }

    .real-hero {
            padding: 14px 14px 16px !important;
            min-height: auto !important;
            border-radius: 12px !important;
            margin-bottom: 14px !important;
            background: linear-gradient(145deg, #042f2e 0%, #0f172b 100%) !important;
            border-bottom: 3px solid var(--sp-crimson) !important;
            display: block !important;
        }

        .real-hero::after {
            display: none !important;
        }

        .real-hero-content {
            max-width: 100% !important;
            text-align: center !important;
        }

        .hero-badge-tag {
            font-size: 11px !important;
            padding: 3px 10px !important;
            margin-bottom: 8px !important;
            background: rgba(13, 148, 136, 0.25) !important;
            color: #5eead4 !important;
            border: 1px solid rgba(13, 148, 136, 0.45) !important;
            display: inline-flex !important;
            justify-content: center !important;
        }

        .real-hero h1 {
            font-size: 18px !important;
            line-height: 1.25 !important;
            margin-bottom: 6px !important;
            text-align: center !important;
        }

        .real-hero p {
            font-size: 12px !important;
            line-height: 1.5 !important;
            margin-bottom: 12px !important;
            text-align: center !important;
            color: #cbd5e1 !important;
        }

        .real-hero-btns {
            display: flex !important;
            flex-direction: row !important;
            gap: 8px !important;
            width: 100% !important;
            justify-content: center !important;
        }

        .hero-btn-primary, .hero-btn-secondary {
            flex: 1 !important;
            width: auto !important;
            text-align: center !important;
            justify-content: center !important;
            padding: 8px 12px !important;
            font-size: 12.5px !important;
            border-radius: 20px !important;
        }

        /* Super Slim & Clean Category Header & Cards (Image 1 fix) */
        .category-marquee-container {
            padding: 8px 10px !important;
            margin-bottom: 16px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03) !important;
            background: #ffffff !important;
        }

        .category-marquee-header {
            margin-bottom: 6px !important;
            padding-bottom: 5px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .category-marquee-header h2 {
            font-size: 13.5px !important;
            font-weight: 700 !important;
            gap: 5px !important;
            margin: 0 !important;
            color: var(--sp-heading) !important;
        }

        .category-marquee-header h2 i {
            font-size: 13px !important;
        }

        .cat-nav-btn {
            display: none !important; /* Hide bulky arrows on mobile */
        }

        .category-marquee-header .view-all {
            font-size: 11.5px !important;
            font-weight: 700 !important;
            color: var(--sp-burgundy) !important;
            white-space: nowrap !important;
        }

        .category-scroll-container {
            padding: 3px 2px 5px !important;
            gap: 7px !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        .sp-cat-card {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 5px 10px !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 20px !important;
            flex-shrink: 0 !important;
            white-space: nowrap !important;
            text-decoration: none !important;
            min-width: max-content !important;
        }

        .sp-cat-icon {
            width: 26px !important;
            height: 26px !important;
            font-size: 11px !important;
            flex-shrink: 0 !important;
        }

        .sp-cat-info {
            display: flex !important;
            flex-direction: column !important;
            line-height: 1.15 !important;
        }

        .sp-cat-title {
            font-size: 11.5px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            white-space: nowrap !important;
        }

        .sp-cat-count {
            font-size: 9.5px !important;
            color: #64748b !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
        }

        /* Mobile Section Headers & View All Link (Compact & Refined) */
        .real-section-header {
            margin-bottom: 12px !important;
            padding-bottom: 6px !important;
            border-bottom: 1.5px solid #f1f5f9 !important;
        }

        .real-section-header h2 {
            font-size: 14px !important;
            font-weight: 700 !important;
            gap: 6px !important;
            margin: 0 !important;
            line-height: 1.25 !important;
        }

        .real-section-header h2 i {
            font-size: 13.5px !important;
        }

        .view-all, .real-section-header a {
            font-size: 11.5px !important;
            font-weight: 700 !important;
            white-space: nowrap !important;
        }

        .publisher-banner {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .real-membership {
            flex-direction: column;
            text-align: center;
            padding: 28px 20px !important;
            gap: 16px;
        }

        .membership-crown {
            display: none;
        }
    }

    @media (max-width: 640px) {
        .features-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .real-container {
            padding: 10px 12px 30px;
        }
    }

    /* 2-Row Horizontal Scroll Grid Showcase (Desktop & Mobile) */
    .book-scroll-grid-wrapper {
        position: relative;
        width: 100%;
        margin-bottom: 35px;
    }

    .book-scroll-grid {
        display: grid;
        grid-template-rows: repeat(2, auto);
        grid-auto-flow: column;
        grid-auto-columns: minmax(260px, 280px);
        gap: 18px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 6px 4px 16px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--sp-teal) #f1f5f9;
    }

    .book-scroll-grid::-webkit-scrollbar {
        height: 6px;
    }

    .book-scroll-grid::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .book-scroll-grid::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
        transition: background 0.2s;
    }

    .book-scroll-grid::-webkit-scrollbar-thumb:hover {
        background: var(--sp-teal);
    }

    .book-scroll-grid .catalog-card {
        scroll-snap-align: start;
        margin-bottom: 0;
        height: 100%;
    }

    @media (max-width: 768px) {
        .book-scroll-grid {
            grid-auto-columns: minmax(175px, 195px);
            gap: 10px;
            padding: 4px 2px 12px;
        }

        .book-scroll-grid .catalog-card {
            padding: 10px !important;
        }

        .book-scroll-grid .card-cover-container {
            aspect-ratio: 1 / 1.35;
            margin-bottom: 8px;
        }

        .book-scroll-grid .card-title {
            font-size: 13px !important;
            height: 34px !important;
        }

        .book-scroll-grid .btn-cart {
            height: 35px !important;
            font-size: 12px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="real-container">

    <!-- Official Author Hero Banner (Page 1 Design - Centered & Responsive) -->
    <section class="hero-banner-section">
        <a href="{{ route('books.index') }}" class="hero-banner-link" title="মুক্তাদার বইঘর — এখনই কিনুন">
            <img src="{{ asset('muktadar-hero-banner.jpg') }}" 
                 alt="মুক্তাদার বইঘর — ভালো বই, সুন্দর ভাবনা। শব্দের মায়ায়, গল্পের ছায়ায়— বইয়ের পাতায় খুঁজে নিন জীবন, স্বপ্ন ও নতুন এক পৃথিবী। এখনই কিনুন" 
                 class="hero-banner-image"
                 loading="eager"
                 fetchpriority="high">
        </a>
    </section>

    <!-- Category Section (Touch-Swipeable & Mouse-Draggable Horizontal Slider - Item 7) -->
    <section id="categories" class="category-marquee-container">
        <div class="category-marquee-header">
            <h2>
                <i class="bi bi-bookmark-star-fill text-danger"></i> বইয়ের ক্যাটাগরিসমূহ
            </h2>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="cat-nav-btn" onclick="scrollCategories(-280)" title="বামে সরান" aria-label="বামে যান">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="cat-nav-btn" onclick="scrollCategories(280)" title="ডানে সরান" aria-label="ডানে যান">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <a href="{{ route('books.index') }}" class="view-all ms-2">সবগুলো দেখুন →</a>
            </div>
        </div>

        <div class="category-scroll-wrapper">
            <div class="category-scroll-container" id="categoryScrollTrack">
                @php
                    $catIconMap = [
                        'islamic'          => ['icon' => 'fa-solid fa-mosque', 'class' => 'cat-icon-islamic'],
                        'novels'           => ['icon' => 'fa-solid fa-book-open-reader', 'class' => 'cat-icon-novel'],
                        'stories'          => ['icon' => 'fa-solid fa-feather-pointed', 'class' => 'cat-icon-story'],
                        'biography'        => ['icon' => 'fa-solid fa-user-pen', 'class' => 'cat-icon-bio'],
                        'self-development' => ['icon' => 'fa-solid fa-lightbulb', 'class' => 'cat-icon-self'],
                        'history'          => ['icon' => 'fa-solid fa-landmark-dome', 'class' => 'cat-icon-history'],
                        'liberation-war'   => ['icon' => 'fa-solid fa-flag', 'class' => 'cat-icon-war'],
                        'career'           => ['icon' => 'fa-solid fa-briefcase', 'class' => 'cat-icon-career'],
                        'children'         => ['icon' => 'fa-solid fa-shapes', 'class' => 'cat-icon-kids'],
                        'other'            => ['icon' => 'fa-solid fa-layer-group', 'class' => 'cat-icon-other'],
                    ];
                @endphp

                <!-- First Pass -->
                <a href="{{ route('books.index') }}" class="sp-cat-card" title="সকল ক্যাটাগরির বই">
                    <div class="sp-cat-icon cat-icon-all">
                        <i class="fa-solid fa-books"></i>
                    </div>
                    <div class="sp-cat-info">
                        <span class="sp-cat-title">সকল ক্যাটাগরি</span>
                        <span class="sp-cat-count">সব বই</span>
                    </div>
                </a>

                @foreach($categories as $cat)
                    @php
                        $info = $catIconMap[$cat->slug] ?? ['icon' => 'fa-solid fa-book-bookmark', 'class' => 'cat-icon-all'];
                        $bCount = $cat->books_count ?? ($cat->books ? $cat->books->count() : 0);
                    @endphp
                    <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="sp-cat-card" title="{{ $cat->name }}">
                        <div class="sp-cat-icon {{ $info['class'] }}">
                            <i class="{{ $info['icon'] }}"></i>
                        </div>
                        <div class="sp-cat-info">
                            <span class="sp-cat-title">{{ $cat->name }}</span>
                            <span class="sp-cat-count">{{ $bCount }}টি বই</span>
                        </div>
                    </a>
                @endforeach

                <!-- Duplicate Loop for Continuous Scroll -->
                <a href="{{ route('books.index') }}" class="sp-cat-card" title="সকল ক্যাটাগরির বই">
                    <div class="sp-cat-icon cat-icon-all">
                        <i class="fa-solid fa-books"></i>
                    </div>
                    <div class="sp-cat-info">
                        <span class="sp-cat-title">সকল ক্যাটাগরি</span>
                        <span class="sp-cat-count">সব বই</span>
                    </div>
                </a>

                @foreach($categories as $cat)
                    @php
                        $info = $catIconMap[$cat->slug] ?? ['icon' => 'fa-solid fa-book-bookmark', 'class' => 'cat-icon-all'];
                        $bCount = $cat->books_count ?? ($cat->books ? $cat->books->count() : 0);
                    @endphp
                    <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="sp-cat-card" title="{{ $cat->name }}">
                        <div class="sp-cat-icon {{ $info['class'] }}">
                            <i class="{{ $info['icon'] }}"></i>
                        </div>
                        <div class="sp-cat-info">
                            <span class="sp-cat-title">{{ $cat->name }}</span>
                            <span class="sp-cat-count">{{ $bCount }}টি বই</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Top Selling / Bestsellers -->
    @if($popularBooks->isNotEmpty())
        <section class="real-section" id="popular">
            <div class="real-section-header">
                <h2>
                    <i class="bi bi-fire text-danger"></i> বহুল পঠিত ও বেস্টসেলার বই
                </h2>
                <a href="{{ route('books.index', ['sort' => 'popular']) }}" class="view-all">সবগুলো দেখুন →</a>
            </div>
            <div class="catalog-grid">
                @foreach($popularBooks->take(4) as $book)
                    <article class="catalog-card">
                        <div class="card-cover-container">
                            @if($book->discount_percent > 0)
                                <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                            @endif
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author-row">
                                <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                                <div class="card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span>({{ $book->reviews_count ?? 5 }})</span>
                                </div>
                            </div>
                            <div class="card-price-group">
                                @if($book->price_ebook > 0)
                                    <div class="price-format-pill" title="ডিজিটাল ই-বুক মূল্য">
                                        <span class="pill-kind">ই-বুক</span>
                                        <span class="pill-val">৳{{ $book->price_ebook }}</span>
                                    </div>
                                @endif
                                <div class="price-format-pill" title="মুদ্রিত হার্ডকপি মূল্য">
                                    <span class="pill-kind">হার্ডকপি</span>
                                    <span class="pill-val">
                                        ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                        @if($book->discount_percent > 0)
                                            <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">
                                <i class="bi bi-bag-plus"></i> বিস্তারিত ও অর্ডার
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- New Arrivals -->
    @if($latestBooks->isNotEmpty())
        <section class="real-section" id="latest">
            <div class="real-section-header">
                <h2>
                    <i class="bi bi-stars text-warning"></i> সদ্য প্রকাশিত নতুন বই
                </h2>
                <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="view-all">সবগুলো দেখুন →</a>
            </div>
            <div class="catalog-grid">
                @foreach($latestBooks->take(4) as $book)
                    <article class="catalog-card">
                        <div class="card-cover-container">
                            @if($book->discount_percent > 0)
                                <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                            @endif
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author-row">
                                <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                                <div class="card-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <span>({{ $book->reviews_count ?? 4 }})</span>
                                </div>
                            </div>
                            <div class="card-price-group">
                                @if($book->price_ebook > 0)
                                    <div class="price-format-pill" title="ডিজিটাল ই-বুক মূল্য">
                                        <span class="pill-kind">ই-বুক</span>
                                        <span class="pill-val">৳{{ $book->price_ebook }}</span>
                                    </div>
                                @endif
                                <div class="price-format-pill" title="মুদ্রিত হার্ডকপি মূল্য">
                                    <span class="pill-kind">হার্ডকপি</span>
                                    <span class="pill-val">
                                        ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                        @if($book->discount_percent > 0)
                                            <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">
                                <i class="bi bi-bag-plus"></i> বিস্তারিত ও অর্ডার
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- All Books Showcase (2-Row Horizontal Scrollable Grid) -->
    @if($allBooks->isNotEmpty())
        <section class="real-section" id="all-books">
            <div class="real-section-header">
                <h2>
                    <i class="bi bi-collection-fill text-danger"></i> নির্বাচিত গ্রন্থ সম্ভার
                </h2>
                <a href="{{ route('books.index') }}" class="view-all">সবগুলো বই দেখুন →</a>
            </div>
            <div class="book-scroll-grid-wrapper">
                <div class="book-scroll-grid">
                    @foreach($allBooks as $book)
                        <article class="catalog-card">
                            <div class="card-cover-container">
                                @if($book->is_upcoming)
                                    <span class="badge-upcoming-tag">আসন্ন বই</span>
                                @elseif($book->discount_percent > 0)
                                    <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                                @endif
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                </a>
                                <div class="card-author-row">
                                    <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                                    <div class="card-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span>(৫.০)</span>
                                    </div>
                                </div>
                                <div class="card-price-group">
                                    @if($book->price_ebook > 0)
                                        <div class="price-format-pill" title="ডিজিটাল ই-বুক মূল্য">
                                            <span class="pill-kind">ই-বুক</span>
                                            <span class="pill-val">৳{{ $book->price_ebook }}</span>
                                        </div>
                                    @endif
                                    <div class="price-format-pill" title="মুদ্রিত হার্ডকপি মূল্য">
                                        <span class="pill-kind">হার্ডকপি</span>
                                        <span class="pill-val">
                                            ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                            @if($book->discount_percent > 0)
                                                <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @if($book->is_upcoming)
                                    <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">
                                        <i class="bi bi-clock-history"></i> আসন্ন বই — প্রি-অর্ডার
                                    </a>
                                @else
                                    <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">
                                        <i class="bi bi-bag-plus"></i> বিস্তারিত ও অর্ডার
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Publisher Partnership Callout -->
    <div class="publisher-banner">
        <div>
            <h3>
                <i class="fa-solid fa-store text-danger me-2"></i> আপনি কি প্রকাশক বা লেখক?
            </h3>
            <p>আপনার বই মুক্তাদার বইঘরে সরাসরি তালিকাভুক্ত করুন এবং সারাদেশে হাজার হাজার পাঠকের কাছে পৌঁছে দিন।</p>
        </div>
        <a href="{{ route('publisher.register') }}">
            <i class="bi bi-arrow-right-circle"></i> প্রকাশক নিবন্ধন করুন
        </a>
    </div>

    <!-- Membership Banner (Royal Golden Style - Item 15) -->
    <section class="real-membership">
        <div style="position:relative; z-index:1;">
            <div style="display:inline-flex; align-items:center; gap:6px; background:rgba(0,0,0,0.28); border:1px solid rgba(254,240,138,0.5); padding:4px 14px; border-radius:999px; font-size:12px; font-weight:700; color:#fef08a; margin-bottom:12px;">
                <i class="bi bi-stars text-warning"></i> ✨ প্রিমিয়াম মেম্বারশিপ বেনিফিট
            </div>
            <h2>
                <i class="fa-solid fa-crown text-warning me-2"></i> মুক্তাদার বইঘর প্রিমিয়াম মেম্বারশিপ
            </h2>
            <p>আমাদের যেকোনো মেম্বারশিপে যুক্ত হয়ে পান প্রতিটি বইয়ে সর্বোচ্চ ২৫% পর্যন্ত আজীবন ছাড়, ফ্রি প্রিমিয়াম ই-বুক ও লেখকের সাথে সরাসরি আড্ডার সুযোগ।</p>
            <a href="{{ route('memberships.index') }}" class="btn-gold-card">
                <i class="bi bi-gem text-warning"></i> মেম্বারশিপ প্ল্যানসমূহ দেখুন
            </a>
        </div>
        <div class="membership-crown" style="position:relative; z-index:1;">
            <i class="fa-solid fa-crown"></i>
        </div>
    </section>

    <!-- Store Features Grid -->
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="bi bi-truck"></i></div>
            <div>
                <div class="feature-title">দ্রুত হোম ডেলিভারি</div>
                <div class="feature-sub">ঢাকা সিটিতে ২-৩ দিন, সারাদেশে ৩-৫ দিন</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <div class="feature-title">ক্যাশ অন ডেলিভারি</div>
                <div class="feature-sub">বই হাতে পেয়ে মূল্য পরিশোধের সুবিধা</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="bi bi-tablet"></i></div>
            <div>
                <div class="feature-title">ইনস্ট্যান্ট ই-বুক</div>
                <div class="feature-sub">ডিজিটাল রিডারে যেকোনো ডিভাইসে পাঠ</div>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="bi bi-patch-check"></i></div>
            <div>
                <div class="feature-title">১০০% আসল বই</div>
                <div class="feature-sub">লেখক ও প্রকাশকের নিজস্ব মুদ্রণ</div>
            </div>
        </div>
    </div>

    <!-- অন্যান্য প্রাপ্তি স্থান (Physical Bookstore Availability - Page 1) -->
    <div style="background:#ffffff; border:1.5px solid var(--sp-paste-border); border-radius:var(--sp-radius); padding:20px 24px; margin-bottom:40px; box-shadow:var(--sp-shadow-sm); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div style="display:flex; align-items:center; gap:14px;">
            <div style="width:46px; height:46px; border-radius:50%; background:var(--sp-paste-light); color:var(--sp-burgundy); display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <h4 style="margin:0 0 4px; font-size:15.5px; font-weight:800; color:var(--sp-heading);">
                    অফলাইনে সরাসরি বই সংগ্রহের ঠিকানা (অন্যান্য প্রাপ্তি স্থান)
                </h4>
                <p style="margin:0; font-size:13.5px; color:var(--sp-muted); line-height:1.5;">
                    (১) <strong>সি এস ডি</strong>, ঢাকা সেনানিবাস, ঢাকা &nbsp;|&nbsp; (২) <strong>রাওয়া পাবলিকেশন</strong>, রাওয়া কমপ্লেক্স, মহাখালী, ঢাকা।
                </p>
            </div>
        </div>
        <a href="{{ route('contact') }}" class="view-all" style="font-weight:700; text-decoration:none;">যোগাযোগ ঠিকানা →</a>
    </div>

    <!-- Reader Testimonials -->
    @if(isset($reviews) && $reviews->isNotEmpty())
        <section class="real-section">
            <div class="real-section-header">
                <h2>
                    <i class="bi bi-chat-heart text-danger"></i> পাঠকদের অনুভূতি ও মতামত
                </h2>
            </div>
            <div class="reviews-grid">
                @foreach($reviews->take(3) as $rev)
                    <div class="reader-review-card">
                        <div class="review-user-row">
                            <div class="review-user-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <div class="review-user-name">{{ $rev->user_name ?? 'সম্মানিত পাঠক' }}</div>
                                <div class="review-stars">
                                    @for($i=0; $i < ($rev->rating ?? 5); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="review-comment">"{{ $rev->comment }}"</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>

<script>
function scrollCategories(distance) {
    const track = document.getElementById('categoryScrollTrack');
    if (track) {
        track.scrollBy({ left: distance, behavior: 'smooth' });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('categoryScrollTrack');
    if (!track) return;

    let isDown = false;
    let startX, scrollLeft;
    let moved = false;
    let autoScrollTimer = null;

    function startAutoScroll() {
        if (autoScrollTimer) return;
        autoScrollTimer = setInterval(() => {
            if (!isDown) {
                track.scrollLeft += 1;
                if (track.scrollLeft >= track.scrollWidth - track.clientWidth - 2) {
                    track.scrollLeft = 0;
                }
            }
        }, 35);
    }

    function stopAutoScroll() {
        clearInterval(autoScrollTimer);
        autoScrollTimer = null;
    }

    startAutoScroll();

    // Pause on hover
    track.addEventListener('mouseenter', stopAutoScroll);
    track.addEventListener('mouseleave', () => {
        if (!isDown) startAutoScroll();
    });

    // Touch & Pointer Drag
    track.addEventListener('pointerdown', (e) => {
        isDown = true;
        moved = false;
        stopAutoScroll();
        track.classList.add('is-dragging');
        startX = e.pageX - track.offsetLeft;
        scrollLeft = track.scrollLeft;
    });

    track.addEventListener('pointermove', (e) => {
        if (!isDown) return;
        const x = e.pageX - track.offsetLeft;
        const walk = (x - startX);
        if (Math.abs(walk) > 5) {
            moved = true;
        }
        track.scrollLeft = scrollLeft - walk;
    });

    const stopDragging = () => {
        if (!isDown) return;
        isDown = false;
        track.classList.remove('is-dragging');
        setTimeout(startAutoScroll, 3500);
    };

    track.addEventListener('pointerup', stopDragging);
    track.addEventListener('pointercancel', stopDragging);
    track.addEventListener('pointerleave', stopDragging);

    // Prevent accidental navigation when user is dragging
    track.querySelectorAll('.sp-cat-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (moved) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
});
</script>
@endsection
