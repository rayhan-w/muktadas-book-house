@extends('layouts.app')

@section('title', 'মুক্তাদার বইঘর | Muktada\'s Boighor — জ্ঞানের আলোয় নতুন পথচলা')

@section('styles')
<style>
    /* SahojPath Modern Clean Hero */
    .real-hero {
        position: relative;
        min-height: 340px;
        background: linear-gradient(135deg, #0f172b 0%, #1e293b 60%, #334155 100%) !important;
        color: #fff !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 40px 30px;
        border-radius: var(--sp-radius);
        margin-bottom: 30px;
        overflow: hidden;
        border-bottom: 4px solid var(--sp-burgundy);
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
        opacity: 0.9;
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
        background: rgba(229, 70, 70, 0.2);
        color: #fca5a5;
        border: 1px solid rgba(229, 70, 70, 0.4);
        padding: 4px 14px;
        border-radius: var(--sp-radius-pill);
        font-size: 12.5px;
        font-weight: 700;
        margin-bottom: 14px;
        letter-spacing: 0.5px;
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
        box-shadow: 0 4px 14px rgba(229, 70, 70, 0.35);
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

    /* Membership Banner (SahojPath Burgundy Accent) */
    .real-membership {
        background: linear-gradient(135deg, #4f1726 0%, #8b263b 100%) !important;
        border-radius: var(--sp-radius) !important;
        padding: 35px 40px !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        margin: 40px 0 !important;
        box-shadow: 0 10px 30px rgba(139, 38, 59, 0.2) !important;
    }

    .real-membership h2 {
        font-size: 26px !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        margin-bottom: 8px !important;
    }

    .real-membership p {
        font-size: 14.5px !important;
        color: #fecdd3 !important;
        max-width: 600px !important;
        margin-bottom: 18px !important;
    }

    .real-membership a {
        display: inline-flex !important;
        align-items: center;
        gap: 8px;
        background: #ffffff !important;
        color: var(--sp-burgundy) !important;
        padding: 10px 24px !important;
        border-radius: var(--sp-radius-pill) !important;
        font-weight: 800 !important;
        text-decoration: none !important;
        transition: all 0.2s;
    }

    .real-membership a:hover {
        background: #fff1f2 !important;
        transform: translateY(-2px);
    }

    .membership-crown {
        font-size: 64px;
        color: rgba(255, 255, 255, 0.25);
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
        .real-hero {
            padding: 28px 20px;
            min-height: 280px;
        }

        .real-hero::after {
            display: none;
        }

        .real-hero h1 {
            font-size: 24px;
        }

        .real-hero p {
            font-size: 13.5px;
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
</style>
@endsection

@section('content')
<div class="real-container">

    <!-- SahojPath Style Hero Banner -->
    <section class="real-hero">
        <div class="real-hero-content">
            <span class="hero-badge-tag">
                <i class="bi bi-patch-check-fill"></i> লেখক মুক্তাদার অফিসিয়াল প্ল্যাটফর্ম
            </span>
            <h1>জ্ঞানের আলোয় নতুন পথচলা,<br>সুন্দর ও অর্থবহ জীবনের সন্ধান</h1>
            <p>জীবনমুখী সাহিত্য, উপন্যাস, গবেষণা ও ইসলামী বইয়ের একমাত্র বিশ্বস্ত ঠিকানা। ঘরে বসে হার্ডকপি সংগ্রহ করুন কিংবা সরাসরি অ্যাপ ছাড়াই ইনস্ট্যান্ট ই-বুক রিডারে পড়া শুরু করুন।</p>
            <div class="real-hero-btns">
                <a href="{{ route('books.index') }}" class="hero-btn-primary">
                    <i class="bi bi-grid-fill"></i> বইয়ের ক্যাটালগ দেখুন
                </a>
                <a href="#popular" class="hero-btn-secondary">
                    <i class="bi bi-fire text-warning"></i> বেস্টসেলার বই
                </a>
            </div>
        </div>
    </section>

    <!-- Category Marquee Section (Auto-Scrolling Infinite Ticker with Realistic Icons) -->
    <section id="categories" class="category-marquee-container">
        <div class="category-marquee-header">
            <h2>
                <i class="bi bi-bookmark-star-fill text-danger"></i> বইয়ের ক্যাটাগরিসমূহ
            </h2>
            <a href="{{ route('books.index') }}" class="view-all">সবগুলো দেখুন →</a>
        </div>

        <div class="category-marquee-wrapper">
            <div class="category-marquee-track">
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
                <a href="{{ route('books.index') }}" class="sp-cat-card">
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
                    <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="sp-cat-card">
                        <div class="sp-cat-icon {{ $info['class'] }}">
                            <i class="{{ $info['icon'] }}"></i>
                        </div>
                        <div class="sp-cat-info">
                            <span class="sp-cat-title">{{ $cat->name }}</span>
                            <span class="sp-cat-count">{{ $bCount }}টি বই</span>
                        </div>
                    </a>
                @endforeach

                <!-- Duplicate Pass for Seamless Infinite Loop -->
                <a href="{{ route('books.index') }}" class="sp-cat-card" aria-hidden="true">
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
                    <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="sp-cat-card" aria-hidden="true">
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
                                <span class="badge-discount-tag">({{ $book->discount_percent }}% ছাড়)</span>
                            @endif
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                            <div class="card-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span>({{ $book->reviews_count ?? 5 }})</span>
                            </div>
                            <div class="card-price-group">
                                @if($book->price_ebook > 0)
                                    <span class="price-pill-ebook">ই-বুক ৳{{ $book->price_ebook }}</span>
                                @endif
                                <div class="price-pill-hardcopy">
                                    হার্ডকপি ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                    @if($book->discount_percent > 0)
                                        <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                    @endif
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
                                <span class="badge-discount-tag">({{ $book->discount_percent }}% ছাড়)</span>
                            @endif
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                            <div class="card-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span>({{ $book->reviews_count ?? 4 }})</span>
                            </div>
                            <div class="card-price-group">
                                @if($book->price_ebook > 0)
                                    <span class="price-pill-ebook">ই-বুক ৳{{ $book->price_ebook }}</span>
                                @endif
                                <div class="price-pill-hardcopy">
                                    হার্ডকপি ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                    @if($book->discount_percent > 0)
                                        <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                    @endif
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

    <!-- All Books Showcase -->
    @if($allBooks->isNotEmpty())
        <section class="real-section" id="all-books">
            <div class="real-section-header">
                <h2>
                    <i class="bi bi-collection-fill text-danger"></i> নির্বাচিত গ্রন্থ সম্ভার
                </h2>
                <a href="{{ route('books.index') }}" class="view-all">সবগুলো বই দেখুন →</a>
            </div>
            <div class="catalog-grid">
                @foreach($allBooks->take(8) as $book)
                    <article class="catalog-card">
                        <div class="card-cover-container">
                            @if($book->is_upcoming)
                                <span class="badge-upcoming-tag">আসন্ন বই</span>
                            @elseif($book->discount_percent > 0)
                                <span class="badge-discount-tag">({{ $book->discount_percent }}% ছাড়)</span>
                            @endif
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : asset('author-portrait.jpg') }}" alt="{{ $book->title }}" loading="lazy">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author"><i class="bi bi-pen"></i> {{ $book->author_name ?? 'মুক্তাদা' }}</div>
                            <div class="card-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span>(৫.০)</span>
                            </div>
                            <div class="card-price-group">
                                @if($book->price_ebook > 0)
                                    <span class="price-pill-ebook">ই-বুক ৳{{ $book->price_ebook }}</span>
                                @endif
                                <div class="price-pill-hardcopy">
                                    হার্ডকপি ৳{{ $book->discounted_price ?? $book->price_hardcopy }}
                                    @if($book->discount_percent > 0)
                                        <span class="price-original-struck">৳{{ $book->price_hardcopy }}</span>
                                    @endif
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

    <!-- Membership Banner -->
    <section class="real-membership">
        <div>
            <h2>
                <i class="bi bi-award-fill text-warning me-2"></i> মুক্তাদার বইঘর প্রিমিয়াম মেম্বারশিপ
            </h2>
            <p>আমাদের যেকোনো মেম্বারশিপে যুক্ত হয়ে পান প্রতিটি বইয়ে সর্বোচ্চ ২৫% পর্যন্ত আজীবন ছাড়, ফ্রি প্রিমিয়াম ই-বুক ও লেখকের সাথে সরাসরি আড্ডার সুযোগ।</p>
            <a href="{{ route('memberships.index') }}">
                <i class="bi bi-gem text-danger"></i> মেম্বারশিপ প্ল্যানসমূহ দেখুন
            </a>
        </div>
        <div class="membership-crown">
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
@endsection
