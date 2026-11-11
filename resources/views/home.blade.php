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
        display: inline-block;
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
    }

    .hero-btn-secondary:hover {
        background: #ffffff;
        color: var(--sp-heading) !important;
        transform: translateY(-2px);
    }

    /* Container */
    .real-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 10px 20px 40px;
    }

    /* Category Grid (SahojPath Clean Badges) */
    .real-categories {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 22px 24px;
        margin-bottom: 35px;
        box-shadow: var(--sp-shadow-sm);
    }

    .category-pills-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .home-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: #f8fafc;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-pill);
        font-size: 13.5px;
        font-weight: 600;
        color: var(--sp-heading);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .home-cat-badge:hover {
        background: #fff1f2;
        border-color: #fecdd3;
        color: var(--sp-burgundy);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(139, 38, 59, 0.08);
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
        display: inline-block !important;
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
        font-size: 70px;
        color: rgba(255, 255, 255, 0.25);
    }

    /* Publisher Banner */
    .publisher-banner {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-left: 5px solid var(--sp-crimson);
        border-radius: var(--sp-radius);
        padding: 24px 28px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: var(--sp-shadow-sm);
    }

    .publisher-banner h3 {
        color: var(--sp-heading);
        font-size: 19px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .publisher-banner p {
        color: var(--sp-muted);
        font-size: 14px;
        margin: 0;
    }

    .publisher-banner-btn {
        background: var(--sp-crimson);
        color: #ffffff !important;
        padding: 10px 20px;
        border-radius: var(--sp-radius-sm);
        font-weight: 700;
        font-size: 13.5px;
        white-space: nowrap;
        text-decoration: none;
        transition: background 0.2s;
    }

    .publisher-banner-btn:hover {
        background: var(--sp-burgundy);
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
    }

    .feature-icon {
        font-size: 28px;
        color: var(--sp-crimson);
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
        justify-content: space-between;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 15px;
        margin-bottom: 8px;
    }

    .review-quote {
        font-size: 13.5px;
        color: var(--sp-body);
        font-style: italic;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .review-author {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--sp-heading);
        border-top: 1px solid #f1f5f9;
        padding-top: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .verified-pill {
        background: var(--sp-green-bg);
        color: var(--sp-green);
        font-size: 11px;
        padding: 2px 8px;
        border-radius: var(--sp-radius-pill);
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .real-hero {
            padding: 25px 20px;
            min-height: auto;
        }
        .real-hero::after {
            display: none;
        }
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .publisher-banner {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="real-container">

    <!-- SahojPath Clean Modern Hero -->
    <section class="real-hero">
        <div class="real-hero-content">
            <span class="hero-badge-tag">✨ মুক্তাদার বইঘরে আপনাকে স্বাগতম</span>
            <h1>{{ $settings['site_tagline'] ?? 'জ্ঞানের আলোয় নতুন পথচলা — সুন্দর জীবনের প্রত্যয়' }}</h1>
            <p>লেখক মুক্তাদার চিন্তাশীল গবেষণা, উপন্যাস ও জীবনমুখী সাহিত্যের বিশ্বস্ত ঠিকানা। আপনার পছন্দের বই অর্ডার করুন ঘরে বসেই অথবা সংগ্রহ করুন ডিজিটাল ই-বুক।</p>
            <div class="real-hero-btns">
                <a href="{{ route('books.index') }}" class="hero-btn-primary">সকল বই দেখুন →</a>
                <a href="{{ route('memberships.index') }}" class="hero-btn-secondary">মেম্বারশিপ প্ল্যান</a>
            </div>
        </div>
    </section>

    <!-- Category Pills Section -->
    <section id="categories" class="real-categories">
        <div class="real-section-header">
            <h2>🏷️ জনপ্রিয় ক্যাটাগরিসমূহ</h2>
            <a href="{{ route('books.index') }}" class="view-all">সবগুলো দেখুন →</a>
        </div>
        <div class="category-pills-grid">
            <a href="{{ route('books.index') }}" class="home-cat-badge">
                <span>📚 সকল ক্যাটাগরি</span>
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('books.index', ['category' => $cat->slug]) }}" class="home-cat-badge">
                    <span>{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Top Selling / Bestsellers -->
    @if($popularBooks->isNotEmpty())
        <section class="real-section" id="popular">
            <div class="real-section-header">
                <h2>🔥 সর্বাধিক পঠিত ও বেস্টসেলার বই</h2>
                <a href="{{ route('books.index', ['sort' => 'popular']) }}" class="view-all">সবগুলো দেখুন →</a>
            </div>

            <div class="catalog-grid">
                @foreach($popularBooks as $book)
                    <article class="catalog-card">
                        <div>
                            <div class="card-cover-container">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span></div>';">
                                </a>
                                @if($book->is_upcoming)
                                    <span class="badge-upcoming-tag">আসন্ন বই</span>
                                @elseif($book->discount_percent > 0)
                                    <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                                @endif
                            </div>

                            <div class="card-details">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                </a>
                                <div class="card-author-name">✍️ {{ $book->author_name }}</div>
                                <div class="card-rating-strip">
                                    <span>★★★★★</span>
                                    <span class="card-rating-count">{{ number_format($book->averageRating(), 1) }}</span>
                                </div>
                                <div class="price-group">
                                    @if($book->discount_percent > 0)
                                        <del class="old-price">৳{{ number_format($book->price_hardcopy) }}</del>
                                    @endif
                                    <span class="product-price">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            @if($book->is_upcoming)
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">⏳ প্রকাশের অপেক্ষায়</a>
                            @else
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">বিস্তারিত ও অর্ডার →</a>
                            @endif
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
                <h2>✨ নতুন প্রকাশিত বইসমূহ</h2>
                <a href="{{ route('books.index', ['sort' => 'latest']) }}" class="view-all">সবগুলো দেখুন →</a>
            </div>

            <div class="catalog-grid">
                @foreach($latestBooks as $book)
                    <article class="catalog-card">
                        <div>
                            <div class="card-cover-container">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span></div>';">
                                </a>
                                @if($book->is_upcoming)
                                    <span class="badge-upcoming-tag">আসন্ন বই</span>
                                @elseif($book->discount_percent > 0)
                                    <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                                @endif
                            </div>

                            <div class="card-details">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                </a>
                                <div class="card-author-name">✍️ {{ $book->author_name }}</div>
                                <div class="card-rating-strip">
                                    <span>★★★★★</span>
                                    <span class="card-rating-count">{{ number_format($book->averageRating(), 1) }}</span>
                                </div>
                                <div class="price-group">
                                    @if($book->discount_percent > 0)
                                        <del class="old-price">৳{{ number_format($book->price_hardcopy) }}</del>
                                    @endif
                                    <span class="product-price">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            @if($book->is_upcoming)
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">⏳ প্রকাশের অপেক্ষায়</a>
                            @else
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">বিস্তারিত ও অর্ডার →</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- All Books Showcase -->
    @if(isset($allBooks) && $allBooks->isNotEmpty())
        <section class="real-section" id="all-books">
            <div class="real-section-header">
                <h2>📚 আমাদের ক্যাটালগের সকল বই</h2>
                <a href="{{ route('books.index') }}" class="view-all">ক্যাটালগ দেখুন →</a>
            </div>

            <div class="catalog-grid">
                @foreach($allBooks as $book)
                    <article class="catalog-card">
                        <div>
                            <div class="card-cover-container">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span></div>';">
                                </a>
                                @if($book->is_upcoming)
                                    <span class="badge-upcoming-tag">আসন্ন বই</span>
                                @elseif($book->discount_percent > 0)
                                    <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
                                @endif
                            </div>

                            <div class="card-details">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                </a>
                                <div class="card-author-name">✍️ {{ $book->author_name }}</div>
                                <div class="card-rating-strip">
                                    <span>★★★★★</span>
                                    <span class="card-rating-count">{{ number_format($book->averageRating(), 1) }}</span>
                                </div>
                                <div class="price-group">
                                    @if($book->discount_percent > 0)
                                        <del class="old-price">৳{{ number_format($book->price_hardcopy) }}</del>
                                    @endif
                                    <span class="product-price">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            @if($book->is_upcoming)
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">⏳ প্রকাশের অপেক্ষায়</a>
                            @else
                                <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">বিস্তারিত ও অর্ডার →</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Upcoming Books -->
    @if($upcomingBooks->isNotEmpty())
        <section class="real-section" id="upcoming">
            <div class="real-section-header">
                <h2>⏳ শীঘ্রই আসছে (আসন্ন বইসমূহ)</h2>
            </div>

            <div class="catalog-grid">
                @foreach($upcomingBooks as $book)
                    <article class="catalog-card">
                        <div>
                            <div class="card-cover-container">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span></div>';">
                                </a>
                                <span class="badge-upcoming-tag">আসন্ন বই</span>
                            </div>

                            <div class="card-details">
                                <a href="{{ route('books.show', $book->slug) }}">
                                    <h3 class="card-title">{{ $book->title }}</h3>
                                </a>
                                <div class="card-author-name">✍️ {{ $book->author_name }}</div>
                                <div class="price-group">
                                    <span class="product-price">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">⏳ প্রকাশের অপেক্ষায়</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Membership Banner -->
    <section id="membership" class="real-membership">
        <div>
            <h2>👑 মেম্বারশিপে বিশেষ সুবিধা নিন!</h2>
            <p>প্রিমিয়াম ডিসকাউন্টে হার্ডকপি ক্রয় এবং বিনামূল্যে আনলিমিটেড ডিজিটাল ই-বুক পড়ার সুযোগ।</p>
            <a href="{{ route('memberships.index') }}">মেম্বারশিপ প্ল্যান দেখুন →</a>
        </div>
        <span class="membership-crown">♛</span>
    </section>

    <!-- Publisher Promotion Banner -->
    <div class="publisher-banner">
        <div>
            <h3>🏢 আপনি কি একজন লেখক বা প্রকাশনা সংস্থা?</h3>
            <p>মুক্তাদার বইঘরের অনুমোদিত প্রকাশক হয়ে আপনার প্রকাশিত বইগুলো যুক্ত করুন এবং পৌঁছে দিন পাঠকদের কাছে।</p>
        </div>
        <a href="{{ route('publisher.register') }}" class="publisher-banner-btn">
            প্রকাশক হিসেবে যোগ দিন →
        </a>
    </div>

    <!-- Features -->
    <div class="features-grid">
        <div class="feature-card">
            <span class="feature-icon">🚚</span>
            <div>
                <div class="feature-title">দ্রুততম ডেলিভারি</div>
                <div class="feature-sub">সারাদেশে ক্যাশ অন ডেলিভারি</div>
            </div>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🔒</span>
            <div>
                <div class="feature-title">নিরাপদ পেমেন্ট</div>
                <div class="feature-sub">বিকাশ, নগদ ও সিওডি সুবিধা</div>
            </div>
        </div>
        <div class="feature-card">
            <span class="feature-icon">📱</span>
            <div>
                <div class="feature-title">ডিজিটাল ই-বুক</div>
                <div class="feature-sub">ব্রাউজারেই সাথে সাথে পাঠ</div>
            </div>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🎧</span>
            <div>
                <div class="feature-title">২৪/৭ সেবা</div>
                <div class="feature-sub">সরাসরি ডেডিকেটেড সাপোর্ট</div>
            </div>
        </div>
    </div>

    <!-- Reader Testimonials -->
    @if($reviews->isNotEmpty())
        <section class="real-section" id="testimonials">
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
