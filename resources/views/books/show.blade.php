@extends('layouts.app')

@section('title', $book->meta_title ?: $book->title . ' — ' . $book->author_name . ' | মুক্তাদার বইঘর')
@section('meta_description', $book->meta_description ?: Str::limit(strip_tags($book->summary), 150))
@section('meta_keywords', $book->meta_keywords ?: $book->title . ', ' . $book->author_name . ', মুক্তাদার বইঘর')
@section('og_image', $book->cover_url)

@section('styles')
<style>
    .book-page-wrap {
        padding: 0 0 50px;
        max-width: 1440px;
        margin: 0 auto;
        width: 100%;
    }

    .book-breadcrumb {
        padding: 14px 20px;
        color: var(--sp-muted);
        font-size: 13.5px;
        border-bottom: 1px solid var(--sp-border);
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .book-breadcrumb a {
        color: var(--sp-burgundy);
        text-decoration: none;
        font-weight: 600;
    }

    .book-breadcrumb a:hover {
        text-decoration: underline;
    }

    .book-hero-reference {
        padding: 35px 30px;
        display: flex;
        gap: 36px;
        align-items: flex-start;
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        box-shadow: var(--sp-shadow-sm);
        margin: 20px auto;
        width: 100%;
    }

    .reference-cover {
        width: 250px;
        aspect-ratio: 1 / 1.35;
        background: #ffffff;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        flex-shrink: 0;
        position: relative;
        border: 1px solid var(--sp-border);
    }

    .reference-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }

    .reference-discount {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #dc2626 !important;
        color: #ffffff !important;
        border: none !important;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: var(--sp-radius-pill);
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
    }

    .reference-copy {
        flex: 1;
    }

    .reference-copy h1 {
        font-size: 32px;
        margin: 0 0 8px;
        color: var(--sp-heading);
        font-weight: 800;
        line-height: 1.25;
    }

    .reference-author {
        font-size: 15px;
        color: var(--sp-muted);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .reference-author strong {
        color: var(--sp-burgundy);
    }

    .reference-rating {
        color: #f59e0b;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 20px;
    }

    .reference-rating span {
        color: var(--sp-muted);
        font-weight: 600;
    }

    .reference-prices {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8fafc;
        border: 1px solid var(--sp-border);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 24px;
        max-width: 480px;
        flex-wrap: wrap;
    }

    .price-hardcopy-val {
        font-size: 26px;
        font-weight: 800;
        color: var(--sp-crimson);
        display: inline-block;
    }

    .price-orig-del {
        color: var(--sp-light);
        font-size: 14px;
        margin-left: 8px;
        text-decoration: line-through;
    }

    .price-ebook-val {
        border-left: 2px solid var(--sp-border);
        padding-left: 20px;
        font-size: 18px;
        font-weight: 700;
        color: var(--sp-heading);
    }

    .reference-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        max-width: 520px;
    }

    .ebook-action {
        flex: 1;
        min-width: 140px;
        text-align: center;
        padding: 12px 18px;
        border-radius: var(--sp-radius-pill);
        text-decoration: none;
        font-size: 14.5px;
        font-weight: 700;
        background: var(--sp-burgundy);
        color: #ffffff !important;
        border: 0;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(139, 38, 59, 0.2);
    }

    .ebook-action:hover {
        background: var(--sp-burgundy-dark);
        transform: translateY(-2px);
    }

    .hardcopy-action {
        flex: 1;
        min-width: 140px;
        text-align: center;
        padding: 12px 18px;
        border-radius: var(--sp-radius-pill);
        font-size: 14.5px;
        font-weight: 700;
        background: var(--sp-crimson);
        color: #ffffff !important;
        border: 0;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(229, 70, 70, 0.25);
    }

    .hardcopy-action:hover {
        background: var(--sp-burgundy);
        transform: translateY(-2px);
    }

    .preview-action {
        width: 100%;
        text-align: center;
        padding: 10px 18px;
        border-radius: var(--sp-radius-pill);
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        background: #ffffff;
        color: var(--sp-burgundy) !important;
        border: 1.5px solid var(--sp-burgundy);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .preview-action:hover {
        background: #fff5f6;
    }

    /* Content Tabs & Panels */
    .book-tabs {
        display: flex;
        gap: 10px;
        background: #ffffff;
        padding: 14px 24px;
        border-bottom: 1px solid var(--sp-border);
        overflow-x: auto;
    }

    .book-tab-btn {
        background: transparent;
        border: none;
        padding: 8px 16px;
        font-size: 14.5px;
        font-weight: 700;
        color: var(--sp-muted);
        cursor: pointer;
        font-family: inherit;
        border-radius: var(--sp-radius-pill);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .book-tab-btn.active,
    .book-tab-btn:hover {
        color: var(--sp-burgundy);
        background: #fff5f6;
    }

    .book-panels-wrap {
        padding: 24px;
    }

    .book-detail-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: var(--sp-shadow-sm);
        line-height: 1.8;
    }

    .book-detail-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: var(--sp-heading);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--sp-border);
    }

    .meta-spec-item {
        background: #f8fafc;
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid var(--sp-border);
    }

    .meta-spec-item b {
        display: block;
        font-size: 12px;
        color: var(--sp-muted);
        margin-bottom: 4px;
    }

    .meta-spec-item span {
        font-size: 14px;
        font-weight: 700;
        color: var(--sp-heading);
    }

    /* 16:9 Responsive Video Container */
    .video-responsive-container {
        position: relative;
        width: 100%;
        max-width: 960px;
        margin: 0 auto;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        border-radius: 12px;
        background: #0f172b;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.12);
        border: 1px solid var(--sp-border);
    }

    .video-responsive-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .book-hero-reference {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 24px 16px;
            margin: 10px;
        }

        .reference-cover {
            width: 180px;
        }

        .reference-copy h1 {
            font-size: 24px;
        }

        .reference-author {
            justify-content: center;
        }

        .reference-rating {
            justify-content: center;
        }

        .reference-prices {
            justify-content: center;
            margin: 0 auto 20px;
        }

        .reference-actions {
            margin: 0 auto;
            width: 100%;
        }

        .book-tabs {
            padding: 10px 14px;
        }

        .book-tab-btn {
            font-size: 13px;
            padding: 6px 12px;
        }

        .book-panels-wrap {
            padding: 16px 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="book-page-wrap">

    <!-- Breadcrumb Navigation -->
    <div class="book-breadcrumb">
        <a href="{{ route('home') }}"><i class="bi bi-house"></i> হোম</a>
        <i class="bi bi-chevron-right small"></i>
        <a href="{{ route('books.index') }}">সকল বই</a>
        @if($book->categories->isNotEmpty())
            <i class="bi bi-chevron-right small"></i>
            <a href="{{ route('books.index', ['category' => $book->categories->first()->slug]) }}">{{ $book->categories->first()->name }}</a>
        @endif
        <i class="bi bi-chevron-right small"></i>
        <span>{{ $book->title }}</span>
    </div>

    <!-- Hero Reference matching SahojPath -->
    <div class="book-hero-reference">
        <div class="reference-cover">
            <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#0f172b;color:#fff;font-weight:bold;padding:20px;text-align:center;\'>{{ addslashes($book->title) }}</div>';">
            @if($book->is_upcoming)
                <span class="reference-discount" style="background:var(--sp-amber-bg); color:var(--sp-amber);">আসন্ন বই</span>
            @elseif($book->discount_percent > 0)
                <span class="reference-discount">({{ round($book->discount_percent) }}% ছাড়)</span>
            @endif
        </div>

        <div class="reference-copy">
            <h1>{{ $book->title }}</h1>
            <div class="reference-author">
                <span><i class="bi bi-pen"></i> লেখক: <strong>{{ $book->author_name }}</strong></span>
                @if($book->publisher_name)
                    <span>| <i class="bi bi-building"></i> প্রকাশনী: <strong>{{ $book->publisher_name }}</strong></span>
                @endif
                | <i class="bi bi-bookmark"></i> ক্যাটাগরি: <strong>{{ $book->categories->first()?->name ?? 'বই' }}</strong>
            </div>

            <div class="reference-rating">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
                <span>{{ number_format($book->averageRating(), 1) }} ({{ $book->approvedReviews()->count() }}টি পাঠকদের রিভিউ)</span>
            </div>

            <div class="reference-prices">
                <div>
                    <span style="font-size:12px;color:var(--sp-muted);display:block;">হার্ডকপি মূল্য</span>
                    <span class="price-hardcopy-val">৳ {{ number_format($book->hardcopyEffectivePrice()) }}</span>
                    @if($book->discount_percent > 0)
                        <del class="price-orig-del">৳ {{ number_format($book->price_hardcopy) }}</del>
                    @endif
                </div>

                @if($book->price_ebook > 0)
                    <div class="price-ebook-val">
                        <span style="font-size:12px;color:var(--sp-muted);display:block;">ডিজিটাল ই-বুক</span>
                        ৳ {{ number_format($book->ebookEffectivePrice()) }}
                    </div>
                @endif
            </div>

            <div class="reference-actions">
                @if($book->is_upcoming)
                    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:15px; color:#1e40af; text-align:center; font-weight:700; width:100%; margin-bottom:10px; font-size:14.5px;">
                        <i class="bi bi-clock-history"></i> বইটি বর্তমানে প্রকাশের অপেক্ষায় রয়েছে (আসন্ন বই)। প্রকাশিত হওয়া মাত্রই সংগ্রহের জন্য উন্মুক্ত করা হবে।
                    </div>
                    @if($book->preview_pages > 0)
                        <a href="{{ route('books.preview', $book->slug) }}" class="preview-action">
                            <i class="bi bi-book"></i> {{ $book->preview_pages }} পৃষ্ঠার ফ্রি প্রিভিউ পড়ুন
                        </a>
                    @endif
                @else
                    <!-- হার্ডকপি অর্ডার ও কার্টে যোগ ফরম (Page 7) -->
                    <form action="{{ route('cart.add') }}" method="POST" style="width:100%; margin:0; display:flex; flex-direction:column; gap:10px;">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="format" value="hardcopy">
                        
                        <!-- সরাসরি হার্ডকপি কিনুন / অর্ডার করুন -->
                        <button type="submit" name="buy_now" value="1" class="hardcopy-action" style="width:100%; background:var(--sp-burgundy); color:#ffffff !important; border:none; padding:13px 20px; font-size:15px; font-weight:800; border-radius:var(--sp-radius-pill); cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 14px rgba(15,118,110,0.3); transition:all 0.2s;">
                            <i class="bi bi-truck"></i> হার্ডকপি অর্ডার করুন (৳{{ number_format($book->hardcopyEffectivePrice()) }})
                        </button>

                        <div style="display:flex; gap:10px; width:100%;">
                            <!-- কার্টে যোগ করুন -->
                            <button type="submit" style="flex:1; background:#ffffff; color:var(--sp-burgundy) !important; border:1.5px solid var(--sp-burgundy); padding:11px 16px; font-size:14px; font-weight:700; border-radius:var(--sp-radius-pill); cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;">
                                <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                            </button>

                            @if($book->price_ebook > 0)
                                <!-- ই-বুক কিনুন -->
                                <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="ebook-action" style="flex:1; text-align:center; display:flex; align-items:center; justify-content:center; gap:6px; text-decoration:none;">
                                    <i class="bi bi-tablet"></i> ই-বুক কিনুন (৳{{ number_format($book->ebookEffectivePrice()) }})
                                </a>
                            @endif
                        </div>
                    </form>

                    @if($book->preview_pages > 0)
                        <a href="{{ route('books.preview', $book->slug) }}" class="preview-action" style="margin-top:6px;">
                            <i class="bi bi-book"></i> {{ $book->preview_pages }} পৃষ্ঠার ফ্রি প্রিভিউ পড়ুন
                        </a>
                    @endif
                @endif
            </div>

            <!-- অন্যান্য প্রাপ্তি স্থান (Page 1) -->
            <div style="margin-top:16px; padding:12px 16px; background:#f0fdfa; border:1px solid #99f6e4; border-radius:10px; font-size:13px; color:#0f766e; line-height:1.6;">
                <strong style="display:block; margin-bottom:3px; color:#115e59; font-size:13.5px;">
                    <i class="bi bi-shop me-1"></i> অফলাইনে সরাসরি প্রাপ্তি স্থান:
                </strong>
                <span>(১) সি এস ডি, ঢাকা সেনানিবাস, ঢাকা &bull; (২) রাওয়া পাবলিকেশন, রাওয়া কমপ্লেক্স, মহাখালী, ঢাকা।</span>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation (Page 1: সংক্ষিপ্ত পরিচিতি - লেখার পেছনের গল্প - লেখক নিয়ে কিছু কথা - বুক রিভিউ) -->
    <div class="book-tabs">
        <button type="button" class="book-tab-btn active" onclick="showTab('summary', this)">
            <i class="bi bi-file-text"></i> সংক্ষিপ্ত পরিচিতি
        </button>
        @if($book->story_behind)
            <button type="button" class="book-tab-btn" onclick="showTab('story', this)">
                <i class="bi bi-pen"></i> লেখার পেছনের গল্প
            </button>
        @endif
        <button type="button" class="book-tab-btn" onclick="showTab('author', this)">
            <i class="bi bi-person"></i> লেখক নিয়ে কিছু কথা
        </button>
        <button type="button" class="book-tab-btn" onclick="showTab('reviews', this)">
            <i class="bi bi-chat-heart"></i> বুক রিভিউ ({{ $book->reviews()->count() }})
        </button>
        @if($book->hasVideo())
            <button type="button" class="book-tab-btn" onclick="showTab('video', this)">
                <i class="bi bi-youtube text-danger"></i> ভিডিও রিভিউ
            </button>
        @endif
    </div>

    <div class="book-panels-wrap">

        <!-- Tab 1: Summary & Details (সংক্ষিপ্ত পরিচিতি) -->
        <div id="tab-summary" class="tab-panel">
            <div class="book-detail-card">
                <h2><i class="bi bi-info-circle text-danger"></i> সংক্ষিপ্ত পরিচিতি</h2>
                <div style="font-size:15px; color:#334155;">
                    {!! nl2br(e($book->summary ?: 'এই বইটির বিস্তারিত বিবরণ শীঘ্রই যুক্ত করা হবে।')) !!}
                </div>

                <div class="meta-specs">
                    <div class="meta-spec-item">
                        <b>প্রকাশনা বছর</b>
                        <span>{{ $book->publication_year ?: '২০২৪' }}</span>
                    </div>
                    <div class="meta-spec-item">
                        <b>মোট পৃষ্ঠা সংখ্যা</b>
                        <span>{{ $book->page_count ?: '২৪০' }} পৃষ্ঠা</span>
                    </div>
                    <div class="meta-spec-item">
                        <b>ভাষা</b>
                        <span>বাংলা (Bangla)</span>
                    </div>
                    <div class="meta-spec-item">
                        <b>ক্যাটাগরি</b>
                        <span>{{ $book->categories->pluck('name')->join(', ') ?: 'সাধারণ সাহিত্য' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($book->story_behind)
            <!-- Tab 2: Story Behind -->
            <div id="tab-story" class="tab-panel" style="display:none;">
                <div class="book-detail-card">
                    <h2><i class="bi bi-feather text-danger"></i> লেখার পেছনের গল্প</h2>
                    <div style="font-size:15px; color:#334155; line-height:1.8;">
                        {!! nl2br(e($book->story_behind)) !!}
                    </div>
                </div>
            </div>
        @endif

        <!-- Tab 3: Author Bio (লেখক নিয়ে কিছু কথা) -->
        <div id="tab-author" class="tab-panel" style="display:none;">
            <div class="book-detail-card">
                <h2><i class="bi bi-person-badge text-danger"></i> লেখক নিয়ে কিছু কথা</h2>
                <div style="display:flex; gap:20px; align-items:center; margin-bottom:16px;">
                    <img src="{{ asset('author-portrait.jpg') }}" alt="লেখক মুক্তাদা" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid var(--sp-burgundy);">
                    <div>
                        <h3 style="font-size:18px; margin:0 0 4px; color:var(--sp-heading);">{{ $book->author_name }}</h3>
                        <p style="margin:0; color:var(--sp-muted); font-size:13.5px;">চিন্তাশীল লেখক, চিন্তাবিদ ও গবেষক</p>
                    </div>
                </div>
                <div style="font-size:15px; color:#334155;">
                    {!! nl2br(e($book->pen_picture ?: 'লেখক মুক্তাদা সমকালীন বাংলা সাহিত্যের এক অনন্য চিন্তাশীল কণ্ঠস্বর। তাঁর রচনা মানুষের অন্তর ও মানবজীবনকে ইতিবাচক আলোয় পরিবর্তনের প্রেরণা দেয়।')) !!}
                </div>
            </div>
        </div>

        <!-- Tab 4: Reviews (বুক রিভিউ) -->
        <div id="tab-reviews" class="tab-panel" style="display:none;">
            <div class="book-detail-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px;">
                    <h2 style="margin:0;"><i class="bi bi-stars text-danger"></i> বুক রিভিউ</h2>
                    <span style="font-size:13px; color:var(--sp-muted); background:#f1f5f9; padding:4px 12px; border-radius:var(--sp-radius-pill); font-weight:600;">
                        মোট রিভিউ: {{ $book->approvedReviews->count() }}টি
                    </span>
                </div>

                @if(session('review_success'))
                    <div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; padding:12px 18px; border-radius:10px; margin-bottom:18px; font-weight:600; font-size:14px; display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-check-circle-fill text-success"></i> {{ session('review_success') }}
                    </div>
                @endif

                @if(session('review_error'))
                    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 18px; border-radius:10px; margin-bottom:18px; font-weight:600; font-size:14px; display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-exclamation-triangle-fill text-danger"></i> {{ session('review_error') }}
                    </div>
                @endif

                @if($book->approvedReviews->isEmpty())
                    <p style="color:var(--sp-muted); font-size:14px; margin-bottom:20px;">এই বইটির জন্য এখনও কোনো রিভিউ যোগ করা হয়নি। আপনি বইটি পড়ে থাকলে আপনার সুচিন্তিত মতামত জানান।</p>
                @else
                    <div style="display:flex; flex-direction:column; gap:14px; margin-bottom:25px;">
                        @foreach($book->approvedReviews as $rev)
                            <div style="background:#f8fafc; border:1px solid var(--sp-border); border-radius:10px; padding:16px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; flex-wrap:wrap; gap:6px;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <strong style="color:var(--sp-heading); font-size:14px;"><i class="bi bi-person-circle"></i> {{ $rev->customer_name }}</strong>
                                        @if($rev->is_verified_purchase)
                                            <span style="background:var(--sp-paste-badge); color:var(--sp-burgundy); font-size:11px; font-weight:700; padding:2px 8px; border-radius:var(--sp-radius-pill);">
                                                <i class="bi bi-patch-check-fill text-success"></i> ক্রেতা
                                            </span>
                                        @endif
                                    </div>
                                    <span style="color:#f59e0b; font-size:13px;">
                                        @for($i=0; $i<$rev->rating; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                        @for($i=$rev->rating; $i<5; $i++)
                                            <i class="bi bi-star" style="color:#cbd5e1;"></i>
                                        @endfor
                                    </span>
                                </div>
                                <p style="margin:0; font-size:14px; color:#475569; line-height:1.6;">"{{ $rev->comment }}"</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Review Form / Gate Section (Item 8) -->
                @auth
                    @if($hasPurchased)
                        <div style="margin-top:20px; padding-top:20px; border-top:1.5px dashed var(--sp-border);">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:8px;">
                                <h3 style="font-size:16px; font-weight:800; color:var(--sp-heading); margin:0;">
                                    <i class="bi bi-pencil-square text-danger"></i> আপনার অনুভূতি বা রিভিউ লিখুন
                                </h3>
                                <span style="background:var(--sp-paste-badge); color:var(--sp-burgundy); padding:4px 12px; border-radius:var(--sp-radius-pill); font-size:12px; font-weight:700;">
                                    <i class="bi bi-patch-check-fill text-success"></i> ভেরিফায়েড ক্রেতা হিসেবে লিখছেন
                                </span>
                            </div>

                            <form action="{{ route('books.review.submit', $book->slug) }}" method="POST">
                                @csrf
                                <div style="margin-bottom:14px;">
                                    <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:var(--sp-heading);">
                                        রেটিং দিন (স্টার নির্বাচন করুন):
                                    </label>
                                    <select name="rating" required style="padding:9px 14px; border:1.5px solid var(--sp-border); border-radius:8px; font-size:14px; background:#fff; outline:none; font-weight:700; color:#b45309;">
                                        <option value="5" selected>⭐⭐⭐⭐⭐ (৫ স্টার — অসাধারণ)</option>
                                        <option value="4">⭐⭐⭐⭐ (৪ স্টার — খুব ভালো)</option>
                                        <option value="3">⭐⭐⭐ (৩ স্টার — ভালো)</option>
                                        <option value="2">⭐⭐ (২ স্টার — মোটামুটি)</option>
                                        <option value="1">⭐ (১ স্টার — সন্তোষজনক নয়)</option>
                                    </select>
                                </div>

                                <div style="margin-bottom:16px;">
                                    <label style="display:block; font-size:13px; font-weight:700; margin-bottom:6px; color:var(--sp-heading);">
                                        আপনার বিস্তারিত মন্তব্য বা রিভিউ <span style="color:#ef4444;">*</span>:
                                    </label>
                                    <textarea name="comment" rows="3" required placeholder="বইটি পড়ে আপনার কেমন লেগেছে? আপনার মূল ভাবনা ও অনুভূতি সংক্ষেপে লিখুন..." style="width:100%; padding:11px 14px; border:1.5px solid var(--sp-border); border-radius:8px; font-family:inherit; font-size:14px; outline:none; transition:border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'"></textarea>
                                </div>

                                <button type="submit" class="btn-cart" style="width:auto; padding:10px 26px; font-size:14px; cursor:pointer;">
                                    <i class="bi bi-send"></i> রিভিউ জমা দিন
                                </button>
                            </form>
                        </div>
                    @else
                        <div style="margin-top:20px; padding:18px 20px; border-radius:12px; background:#f8fafc; border:1.5px dashed #cbd5e1; display:flex; align-items:center; gap:14px;">
                            <div style="width:44px; height:44px; border-radius:50%; background:var(--sp-paste-light); display:flex; align-items:center; justify-content:center; color:var(--sp-burgundy); font-size:20px; flex-shrink:0;">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <div>
                                <strong style="color:var(--sp-heading); font-size:14.5px; display:block;">শুধুমাত্র বইটির ক্রেতাদের মতামত</strong>
                                <span style="color:var(--sp-muted); font-size:13.5px;">মুক্তাদার বইঘর থেকে শুধুমাত্র <strong>এই বইটি ক্রয়কারী ভেরিফায়েড পাঠকরাই</strong> রিভিউ ও রেটিং দিতে পারবেন।</span>
                            </div>
                        </div>
                    @endif
                @else
                    <div style="margin-top:20px; padding:18px 20px; border-radius:12px; background:#f8fafc; border:1.5px dashed #cbd5e1; display:flex; align-items:center; gap:14px;">
                        <div style="width:44px; height:44px; border-radius:50%; background:var(--sp-paste-light); display:flex; align-items:center; justify-content:center; color:var(--sp-burgundy); font-size:20px; flex-shrink:0;">
                            <i class="bi bi-person-lock"></i>
                        </div>
                        <div>
                            <strong style="color:var(--sp-heading); font-size:14.5px; display:block;">রিভিউ দেওয়ার নিয়ম</strong>
                            <span style="color:var(--sp-muted); font-size:13.5px;">মতামত বা রিভিউ প্রদান করতে অনুগ্রহ করে <a href="{{ route('login') }}" style="color:var(--sp-crimson); font-weight:700;">লগইন করুন</a>। (শুধুমাত্র বইটি ক্রয়কারী পাঠকরাই রিভিউ দিতে পারবেন)</span>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        @if($book->hasVideo())
            <!-- Tab 5: Video Review -->
            <div id="tab-video" class="tab-panel" style="display:none;">
                <div class="book-detail-card">
                    <h2><i class="bi bi-play-circle-fill text-danger"></i> বই পরিচিতি ও ভিডিও পর্যালোচনা</h2>
                    <p style="color: var(--sp-muted); font-size: 14px; margin-bottom: 20px;">ভিডিওতে দেখে নিন বইটির মূল ভাবনা ও পাঠ প্রতিক্রিয়া:</p>
                    <div class="video-responsive-container">
                        <iframe src="{{ $book->youtube_embed_url }}" 
                                title="{{ $book->title }} - ভিডিও পর্যালোচনা" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>

<script>
function showTab(tabName, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.book-tab-btn').forEach(b => b.classList.remove('active'));
    
    const panel = document.getElementById('tab-' + tabName);
    if (panel) {
        panel.style.display = 'block';
    }
    if (btn) {
        btn.classList.add('active');
    }
}

function scrollToVideoSection(e) {
    if (e) e.preventDefault();
    const sec = document.getElementById('book-video-section');
    if (sec) {
        sec.scrollIntoView({ behavior: 'smooth', block: 'center' });
        sec.classList.add('highlight-pulse');
        setTimeout(() => sec.classList.remove('highlight-pulse'), 2500);
    }
}
</script>
@endsection
