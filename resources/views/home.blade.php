@extends('layouts.app')

@section('title', 'মুক্তাদার বইঘর | Muktada\'s Boighor — জ্ঞানের আলোয় নতুন পথচলা')

@section('styles')
<style>
    /* Hero Section */
    .real-hero {
        position: relative;
        min-height: 380px;
        background: linear-gradient(90deg, rgba(8, 27, 35, 0.75), rgba(8, 27, 35, 0.35)), url('{{ asset('library-hero.png') }}') center/cover no-repeat !important;
        color: #fff !important;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 40px 30px;
        overflow: hidden;
        border-bottom: 3px solid var(--gold);
    }

    .real-hero::after {
        content: "";
        position: absolute;
        z-index: 2;
        left: 2%;
        bottom: 0;
        width: 320px;
        height: 100%;
        background-image: url('{{ asset('author-portrait-cutout.png') }}');
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: contain;
        pointer-events: none;
    }

    .real-hero-content {
        position: relative;
        z-index: 3;
        max-width: 580px;
        text-align: right;
        padding-left: 20px;
    }

    .real-hero h1 {
        font-size: 36px;
        font-weight: 800;
        color: #fff !important;
        line-height: 1.25;
        margin-bottom: 14px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.8) !important;
    }

    .real-hero p {
        font-size: 17px;
        color: #f1f5f9 !important;
        line-height: 1.6;
        margin-bottom: 24px;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.7) !important;
    }

    .real-hero-btns {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .hero-btn-primary {
        background: linear-gradient(135deg, #f4cf68, #d6a12e);
        color: #092d45 !important;
        padding: 12px 24px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(214, 161, 46, 0.4);
        transition: all 0.2s ease;
        border: 1px solid #c48e1a;
    }

    .hero-btn-primary:hover {
        background: linear-gradient(135deg, #e4b840, #bd881a);
        transform: translateY(-2px);
    }

    .hero-btn-secondary {
        background: rgba(255, 255, 255, 0.15);
        color: #fff !important;
        backdrop-filter: blur(8px);
        padding: 12px 22px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        border: 1.5px solid rgba(255, 255, 255, 0.6);
        transition: all 0.2s ease;
    }

    .hero-btn-secondary:hover {
        background: #fff;
        color: var(--navy) !important;
        transform: translateY(-2px);
    }

    /* Container */
    .real-container {
        padding: 30px 24px 50px;
    }

    .real-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        border-bottom: 2px solid var(--line);
        padding-bottom: 10px;
    }

    .real-section-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .real-section-header a {
        font-size: 14px;
        font-weight: 700;
        color: var(--gold-dark);
        text-decoration: none;
    }

    .real-section-header a:hover {
        color: var(--navy);
        text-decoration: underline;
    }

    /* ============================================================== */
    /* MARQUEE ANIMATION ENGINE (Matching PlayMathEarn infinite ticker) */
    /* ============================================================== */
    .real-marquee-wrapper {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding: 8px 0 16px;
        margin-bottom: 35px;
        mask-image: linear-gradient(to right, transparent 0%, black 2.5%, black 97.5%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 2.5%, black 97.5%, transparent 100%);
    }

    /* Categories Marquee */
    .category-marquee-track {
        display: flex !important;
        gap: 12px !important;
        width: max-content !important;
        animation: category-scroll 32s linear infinite !important;
        will-change: transform;
    }

    .category-marquee-track:hover {
        animation-play-state: paused !important;
    }

    @keyframes category-scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .real-category-badge {
        flex: 0 0 135px !important;
        width: 135px !important;
        min-width: 135px !important;
        background: linear-gradient(135deg, #fbf7ed, #f5ebd5);
        border: 1.5px solid #e0d4bd;
        border-radius: 12px;
        padding: 12px 10px;
        text-align: center;
        text-decoration: none;
        color: var(--navy);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(9, 45, 69, 0.04);
        cursor: pointer;
    }

    .real-category-badge:hover {
        background: linear-gradient(135deg, #f4cf68, #d6a12e);
        border-color: #bd8b19;
        color: var(--navy);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(214, 161, 46, 0.25);
    }

    .category-badge-icon {
        font-size: 22px;
    }

    .category-badge-name {
        font-size: 13.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Books Marquee */
    .books-marquee-track {
        display: flex !important;
        gap: 16px !important;
        width: max-content !important;
        animation: books-scroll 30s linear infinite !important;
        will-change: transform;
    }

    .books-marquee-track:hover {
        animation-play-state: paused !important;
    }

    .books-marquee-track.track-slow {
        animation-duration: 36s !important;
    }

    @keyframes books-scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    /* Book Cards inside Marquee */
    .real-book-card {
        flex: 0 0 185px !important;
        width: 185px !important;
        min-width: 185px !important;
        max-width: 185px !important;
        background: #fffdf8 !important;
        border: 1px solid var(--line) !important;
        border-radius: 12px !important;
        padding: 10px !important;
        display: flex !important;
        flex-direction: column !important;
        box-shadow: 0 4px 14px rgba(9, 45, 69, 0.05) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
        position: relative;
    }

    .real-book-card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 25px rgba(9, 45, 69, 0.12) !important;
        border-color: var(--gold) !important;
    }

    .real-book-link {
        text-decoration: none;
        color: inherit;
        display: block;
        flex: 1;
    }

    .real-cover {
        position: relative;
        aspect-ratio: 3/4;
        border-radius: 8px;
        overflow: hidden;
        background: #f1ebd9;
        margin-bottom: 8px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .real-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .real-book-card:hover .real-cover img {
        transform: scale(1.04);
    }

    .discount-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        background: #e11d48;
        color: #fff;
        font-size: 10.5px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.25);
    }

    .publisher-tag {
        position: absolute;
        bottom: 6px;
        left: 6px;
        background: rgba(9, 45, 69, 0.88);
        color: #f4cf68;
        font-size: 9.5px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }

    .real-book-card h3 {
        font-size: 14px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.3;
        margin-bottom: 3px;
        min-height: 38px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .real-book-card p.cat-label {
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .real-price {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 10px;
    }

    .real-price strong {
        font-size: 15px;
        color: var(--navy);
        font-weight: 800;
    }

    .real-price del {
        font-size: 11.5px;
        color: #94a3b8;
    }

    .real-card-bottom {
        border-top: 1px solid #f1ebd9;
        padding-top: 8px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .product-types {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
    }

    .btn-ebook {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 4px;
        border-radius: 5px;
        background: #fdf2d0;
        color: #925c07 !important;
        border: 1px solid #e9cd89;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
    }

    .btn-ebook:hover {
        background: #f4cf68;
        color: var(--navy) !important;
    }

    .btn-hardcopy {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 4px;
        border-radius: 5px;
        background: var(--navy);
        color: #fff !important;
        border: 1px solid var(--navy);
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-hardcopy:hover {
        background: #174261;
    }

    /* Membership Banner matching PlayMathEarn */
    .real-membership {
        background: linear-gradient(135deg, #092d45 0%, #154566 100%) !important;
        border: 2px solid var(--gold) !important;
        border-radius: 16px !important;
        padding: 35px 40px !important;
        color: #fff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin: 35px 0 45px !important;
        box-shadow: 0 12px 30px rgba(9, 45, 69, 0.15) !important;
    }

    .real-membership h2 {
        font-size: 28px !important;
        font-weight: 800 !important;
        color: var(--gold-light) !important;
        margin-bottom: 8px !important;
    }

    .real-membership p {
        font-size: 15px !important;
        color: #e2e8f0 !important;
        max-width: 600px !important;
        margin-bottom: 18px !important;
    }

    .real-membership a {
        display: inline-block !important;
        background: linear-gradient(135deg, #f4cf68, #d6a12e) !important;
        color: #092d45 !important;
        padding: 10px 22px !important;
        border-radius: 999px !important;
        font-weight: 800 !important;
        text-decoration: none !important;
        border: 1px solid #c48e1a !important;
        box-shadow: 0 4px 12px rgba(214, 161, 46, 0.35) !important;
    }

    .membership-crown {
        font-size: 72px;
        color: var(--gold-light);
        line-height: 1;
        opacity: 0.9;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    /* Publisher Section Banner */
    .publisher-banner {
        background: #fff;
        border: 2px dashed #93c5fd;
        border-radius: 16px;
        padding: 26px 30px;
        margin-bottom: 45px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 4px 15px rgba(29, 78, 216, 0.05);
    }

    .publisher-banner h3 {
        color: #1e40af;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .publisher-banner p {
        color: #475569;
        font-size: 14px;
        max-width: 650px;
        margin: 0;
    }

    .publisher-banner-btn {
        background: #2563eb;
        color: #fff !important;
        padding: 11px 22px;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        border: 1px solid #1d4ed8;
        transition: all 0.2s;
    }

    .publisher-banner-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    /* Author Spotlight */
    .author-spotlight-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 26px;
        margin-bottom: 45px;
        display: flex;
        align-items: center;
        gap: 25px;
        box-shadow: 0 4px 15px rgba(9, 45, 69, 0.05);
    }

    .author-spotlight-img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--gold-light);
        box-shadow: 0 4px 12px rgba(9, 45, 69, 0.12);
        flex-shrink: 0;
    }

    .author-spotlight-text h4 {
        font-size: 18px;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .author-quote-text {
        font-size: 14.5px;
        font-style: italic;
        color: #334155;
        border-left: 3px solid var(--gold);
        padding-left: 14px;
        margin: 8px 0;
        line-height: 1.6;
    }

    /* Real Features matching PlayMathEarn */
    .real-features-box {
        margin-bottom: 45px;
    }

    .real-features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .feature-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 20px 16px;
        text-align: center;
        box-shadow: 0 3px 10px rgba(9, 45, 69, 0.04);
    }

    .feature-card-icon {
        font-size: 30px;
        margin-bottom: 6px;
        display: block;
    }

    .feature-card-title {
        font-weight: 800;
        font-size: 14px;
        color: var(--navy);
        margin-bottom: 4px;
    }

    .feature-card-sub {
        font-size: 11.5px;
        color: var(--muted);
    }

    /* Reviews Section */
    .reviews-box {
        margin-bottom: 20px;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }

    .reader-review-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(9, 45, 69, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 15px;
        margin-bottom: 8px;
    }

    .review-quote {
        font-size: 13.5px;
        color: #334155;
        font-style: italic;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .review-author {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--navy);
        border-top: 1px solid #f1ebd9;
        padding-top: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .verified-pill {
        background: #dcfce7;
        color: #166534;
        font-size: 10.5px;
        padding: 2px 7px;
        border-radius: 999px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .real-hero {
            min-height: 290px;
            padding: 25px 16px;
            justify-content: center;
        }

        .real-hero::after {
            display: none;
        }

        .real-hero-content {
            max-width: 100%;
            text-align: center;
            padding: 0;
        }

        .real-hero h1 {
            font-size: 25px;
        }

        .real-hero p {
            font-size: 13.5px;
        }

        .real-hero-btns {
            justify-content: center;
        }

        .real-book-card {
            flex: 0 0 150px !important;
            width: 150px !important;
            min-width: 150px !important;
            max-width: 150px !important;
        }

        .real-membership {
            flex-direction: column;
            text-align: center;
            padding: 26px 18px !important;
            gap: 12px;
        }

        .publisher-banner {
            flex-direction: column;
            text-align: center;
        }

        .publisher-banner-btn {
            width: 100%;
            text-align: center;
        }

        .author-spotlight-card {
            flex-direction: column;
            text-align: center;
        }

        .real-features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

    <!-- Hero Section with Library Background & Author Cutout -->
    <section class="real-hero">
        <div class="real-hero-content">
            <h1>{{ $settings['site_tagline'] ?? 'মুক্তাদার বইঘর — জ্ঞানের আলোয় নতুন পথচলা' }}</h1>
            <p>ভালো বই পড়ুন, মনন গড়ুন, সুন্দর জীবনকে আরও সমৃদ্ধ করুন। চিন্তাশীল সাহিত্য, উপন্যাস ও গবেষণাধর্মী রচনার একমাত্র প্রামাণ্য ডিজিটাল ঠিকানা।</p>
            <div class="real-hero-btns">
                <a href="{{ route('books.index') }}" class="hero-btn-primary">📖 সকল বই দেখুন →</a>
                <a href="{{ route('memberships.index') }}" class="hero-btn-secondary">👑 মেম্বারশিপ নিন</a>
            </div>
        </div>
    </section>

    <div class="real-container">

        <!-- Category Sliding Marquee Section (Matching PlayMathEarn continuous scroll) -->
        <section id="categories" class="real-categories">
            <div class="real-section-header">
                <h2>📚 বিষয়ভিত্তিক ক্যাটাগরি</h2>
                <a href="{{ route('books.index') }}">সকল বই ক্যাটালগ →</a>
            </div>
            
            <div class="real-marquee-wrapper">
                <div class="category-marquee-track">
                    @php
                        $categoryIcons = [
                            'islamic' => '🕌',
                            'novels' => '📖',
                            'stories' => '✍️',
                            'biography' => '👤',
                            'self-development' => '🌱',
                            'history' => '🏛️',
                            'liberation-war' => '🇧🇩',
                            'career' => '💼',
                            'children' => '🧒',
                            'other' => '📚',
                        ];
                    @endphp

                    {{-- Loop 1 for infinite scroll --}}
                    @foreach($categories as $cat)
                        <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="real-category-badge">
                            <span class="category-badge-icon">{{ $categoryIcons[$cat->slug] ?? '📖' }}</span>
                            <span class="category-badge-name">{{ $cat->name }}</span>
                        </a>
                    @endforeach

                    {{-- Loop 2 for continuous seamless looping --}}
                    @foreach($categories as $cat)
                        <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="real-category-badge" aria-hidden="true">
                            <span class="category-badge-icon">{{ $categoryIcons[$cat->slug] ?? '📖' }}</span>
                            <span class="category-badge-name">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Featured Books Sliding Animation Section (Matching PlayMathEarn infinite ticker) -->
        @if($featuredBooks->isNotEmpty())
            <section class="real-section" id="featured">
                <div class="real-section-header">
                    <h2>⭐ নির্বাচিত বইসমূহ</h2>
                    <a href="{{ route('books.index', ['filter' => 'featured']) }}">সবগুলো দেখুন →</a>
                </div>

                <div class="real-marquee-wrapper">
                    <div class="books-marquee-track">
                        {{-- Loop 1: Original Set --}}
                        @foreach($featuredBooks as $book)
                            <article class="real-book-card">
                                <a href="{{ route('books.show', $book->slug) }}" class="real-book-link">
                                    <div class="real-cover">
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" loading="lazy">
                                        @if($book->discount_percent > 0)
                                            <span class="discount-badge">-{{ round($book->discount_percent) }}%</span>
                                        @endif
                                        @if($book->publisher_name)
                                            <span class="publisher-tag">{{ $book->publisher_name }}</span>
                                        @endif
                                    </div>
                                    <h3>{{ $book->title }}</h3>
                                    <p class="cat-label">{{ $book->categories->first()?->name ?? 'বই' }}</p>
                                    <div class="real-price">
                                        <strong>৳ {{ number_format($book->hardcopyEffectivePrice()) }}</strong>
                                        @if($book->discount_percent > 0)
                                            <del>৳ {{ number_format($book->price_hardcopy) }}</del>
                                        @endif
                                    </div>
                                </a>
                                <div class="real-card-bottom">
                                    <div class="product-types">
                                        <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="btn-ebook">ই-বুক</a>
                                        <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="format" value="hardcopy">
                                            <button type="submit" class="btn-hardcopy">হার্ডকপি</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        {{-- Loop 2: Duplicate Set for Seamless Continuous Sliding --}}
                        @foreach($featuredBooks as $book)
                            <article class="real-book-card" aria-hidden="true">
                                <a href="{{ route('books.show', $book->slug) }}" class="real-book-link">
                                    <div class="real-cover">
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" loading="lazy">
                                        @if($book->discount_percent > 0)
                                            <span class="discount-badge">-{{ round($book->discount_percent) }}%</span>
                                        @endif
                                        @if($book->publisher_name)
                                            <span class="publisher-tag">{{ $book->publisher_name }}</span>
                                        @endif
                                    </div>
                                    <h3>{{ $book->title }}</h3>
                                    <p class="cat-label">{{ $book->categories->first()?->name ?? 'বই' }}</p>
                                    <div class="real-price">
                                        <strong>৳ {{ number_format($book->hardcopyEffectivePrice()) }}</strong>
                                        @if($book->discount_percent > 0)
                                            <del>৳ {{ number_format($book->price_hardcopy) }}</del>
                                        @endif
                                    </div>
                                </a>
                                <div class="real-card-bottom">
                                    <div class="product-types">
                                        <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="btn-ebook">ই-বুক</a>
                                        <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="format" value="hardcopy">
                                            <button type="submit" class="btn-hardcopy">হার্ডকপি</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Popular Books Sliding Animation Section -->
        @if($popularBooks->isNotEmpty())
            <section class="real-section" id="popular">
                <div class="real-section-header">
                    <h2>🔥 জনপ্রিয় বেস্টসেলার বই</h2>
                    <a href="{{ route('books.index', ['sort' => 'popular']) }}">সবগুলো দেখুন →</a>
                </div>

                <div class="real-marquee-wrapper">
                    <div class="books-marquee-track track-slow">
                        {{-- Loop 1: Original Set --}}
                        @foreach($popularBooks as $book)
                            <article class="real-book-card">
                                <a href="{{ route('books.show', $book->slug) }}" class="real-book-link">
                                    <div class="real-cover">
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" loading="lazy">
                                        @if($book->discount_percent > 0)
                                            <span class="discount-badge">-{{ round($book->discount_percent) }}%</span>
                                        @endif
                                        @if($book->publisher_name)
                                            <span class="publisher-tag">{{ $book->publisher_name }}</span>
                                        @endif
                                    </div>
                                    <h3>{{ $book->title }}</h3>
                                    <p class="cat-label">{{ $book->categories->first()?->name ?? 'বই' }}</p>
                                    <div class="real-price">
                                        <strong>৳ {{ number_format($book->hardcopyEffectivePrice()) }}</strong>
                                        @if($book->discount_percent > 0)
                                            <del>৳ {{ number_format($book->price_hardcopy) }}</del>
                                        @endif
                                    </div>
                                </a>
                                <div class="real-card-bottom">
                                    <div class="product-types">
                                        <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="btn-ebook">ই-বুক</a>
                                        <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="format" value="hardcopy">
                                            <button type="submit" class="btn-hardcopy">হার্ডকপি</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        {{-- Loop 2: Duplicate Set for Seamless Continuous Sliding --}}
                        @foreach($popularBooks as $book)
                            <article class="real-book-card" aria-hidden="true">
                                <a href="{{ route('books.show', $book->slug) }}" class="real-book-link">
                                    <div class="real-cover">
                                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" loading="lazy">
                                        @if($book->discount_percent > 0)
                                            <span class="discount-badge">-{{ round($book->discount_percent) }}%</span>
                                        @endif
                                        @if($book->publisher_name)
                                            <span class="publisher-tag">{{ $book->publisher_name }}</span>
                                        @endif
                                    </div>
                                    <h3>{{ $book->title }}</h3>
                                    <p class="cat-label">{{ $book->categories->first()?->name ?? 'বই' }}</p>
                                    <div class="real-price">
                                        <strong>৳ {{ number_format($book->hardcopyEffectivePrice()) }}</strong>
                                        @if($book->discount_percent > 0)
                                            <del>৳ {{ number_format($book->price_hardcopy) }}</del>
                                        @endif
                                    </div>
                                </a>
                                <div class="real-card-bottom">
                                    <div class="product-types">
                                        <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="btn-ebook">ই-বুক</a>
                                        <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="format" value="hardcopy">
                                            <button type="submit" class="btn-hardcopy">হার্ডকপি</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Membership Banner -->
        <section id="membership" class="real-membership">
            <div>
                <h2>মেম্বারশিপ নিন!</h2>
                <p>বিশেষ ডিসকাউন্টে বই কিনুন ও বিনামূল্যে আনলিমিটেড প্রিমিয়াম ডিজিটাল ই-বুক উপভোগ করুন।</p>
                <a href="{{ route('memberships.index') }}">মেম্বারশিপ প্ল্যান দেখুন →</a>
            </div>
            <span class="membership-crown">♛</span>
        </section>

        <!-- Multi-Vendor Publisher Promotion Banner -->
        <div class="publisher-banner">
            <div>
                <h3>🏢 আপনি কি একজন লেখক বা প্রকাশনা সংস্থা?</h3>
                <p>মুক্তাদার বইঘরের অনুমোদিত প্রকাশক হয়ে আপনার প্রকাশিত বইগুলো যুক্ত করুন। লক্ষ লক্ষ পাঠকের কাছে পৌঁছে দিন আপনার সৃজনশীল সাহিত্যকর্ম।</p>
            </div>
            <a href="{{ route('publisher.register') }}" class="publisher-banner-btn">
                প্রকাশক হিসেবে নিবন্ধন করুন →
            </a>
        </div>

        <!-- Author Spotlight -->
        <div class="author-spotlight-card">
            <img src="{{ asset('author-portrait.jpg') }}" alt="লেখক মুক্তাদা" class="author-spotlight-img">
            <div class="author-spotlight-text">
                <h4>লেখক ও চিন্তক মুক্তাদা</h4>
                <div class="author-quote-text">
                    “বই হলো মনের জানালা, যা মানুষকে সত্য ও সুন্দরের পথ দেখায়। সুন্দর জীবন গড়তে ভালো বইয়ের কোনো বিকল্প নেই।”
                </div>
                <p style="font-size:13.5px; color:#64748b; margin-top:6px;">
                    জীবন, সমাজ ও আত্মউন্নয়নমূলক সাহিত্যের মাধ্যমে মানুষের মনন ও চিন্তা পরিশুদ্ধ করাই তাঁর লেখার মূল উদ্দেশ্য।
                    <a href="{{ route('author') }}" style="color:var(--gold-dark); font-weight:700; margin-left:8px;">লেখকের পূর্ণ পরিচিতি পড়ুন →</a>
                </p>
            </div>
        </div>

        <!-- Real Features matching PlayMathEarn -->
        <section class="real-features-box">
            <div class="real-section-header">
                <h2>✨ মুক্তাদার বইঘরের বিশেষ সুবিধা</h2>
            </div>
            <div class="real-features-grid">
                <div class="feature-card">
                    <span class="feature-card-icon">🚚</span>
                    <div class="feature-card-title">নির্ভরযোগ্য ডেলিভারি</div>
                    <div class="feature-card-sub">সারাদেশে দ্রুততম হোম ডেলিভারি</div>
                </div>
                <div class="feature-card">
                    <span class="feature-card-icon">🔒</span>
                    <div class="feature-card-title">নিরাপদ পেমেন্ট</div>
                    <div class="feature-card-sub">বিকাশ, নগদ ও ক্যাশ অন ডেলিভারি</div>
                </div>
                <div class="feature-card">
                    <span class="feature-card-icon">📱</span>
                    <div class="feature-card-title">অনলাইন রিডিং</div>
                    <div class="feature-card-sub">ব্রাউজারেই ডিজিটাল ই-বুক রিডার</div>
                </div>
                <div class="feature-card">
                    <span class="feature-card-icon">🎧</span>
                    <div class="feature-card-title">২৪/৭ সাপোর্ট</div>
                    <div class="feature-card-sub">সরাসরি ডেডিকেটেড কাস্টমার কেয়ার</div>
                </div>
            </div>
        </section>

        <!-- Reader Testimonials -->
        @if($reviews->isNotEmpty())
            <section class="reviews-box">
                <div class="real-section-header">
                    <h2>💬 পাঠকদের মূল্যবান মতামত</h2>
                </div>
                <div class="reviews-grid">
                    @foreach($reviews as $rev)
                        <div class="reader-review-card">
                            <div>
                                <div class="review-stars">
                                    @for($i = 0; $i < $rev->rating; $i++) ★ @endfor
                                </div>
                                <p class="review-quote">“{{ $rev->comment }}”</p>
                            </div>
                            <div class="review-author">
                                <span>{{ $rev->customer_name }}</span>
                                @if($rev->is_verified_purchase)
                                    <span class="verified-pill">✓ ভেরিফাইড পাঠক</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </div>

@endsection
