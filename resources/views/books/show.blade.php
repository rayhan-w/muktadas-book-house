@extends('layouts.app')

@section('title', $book->meta_title ?: $book->title . ' — ' . $book->author_name . ' | মুক্তাদার বইঘর')
@section('meta_description', $book->meta_description ?: Str::limit(strip_tags($book->summary), 150))
@section('meta_keywords', $book->meta_keywords ?: $book->title . ', ' . $book->author_name . ', মুক্তাদার বইঘর')
@section('og_image', $book->cover_url)

@section('styles')
<style>
    .book-page-wrap {
        padding: 0 0 50px;
    }

    .book-breadcrumb {
        padding: 16px 24px;
        color: #718096;
        font-size: 14px;
        border-bottom: 1px solid var(--line);
        background: #fff;
    }

    .book-breadcrumb a {
        color: var(--navy);
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
        max-width: 1200px;
    }

    .reference-cover {
        width: 250px;
        aspect-ratio: 3/4;
        background: #fff;
        border-radius: 12px;
        padding: 14px;
        box-shadow: 0 10px 25px rgba(9, 45, 69, 0.12);
        flex-shrink: 0;
        position: relative;
        border: 1px solid #e2d9cc;
    }

    .reference-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
        display: block;
    }

    .reference-discount {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--sp-green);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .reference-copy {
        flex: 1;
    }

    .reference-copy h1 {
        font-size: 38px;
        margin: 0 0 8px;
        color: var(--sp-heading);
        font-weight: 800;
        line-height: 1.25;
    }

    .reference-author {
        font-size: 16px;
        color: var(--muted);
        margin-bottom: 12px;
    }

    .reference-author strong {
        color: var(--navy);
    }

    .reference-rating {
        color: #d97706;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .reference-prices {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 22px;
        background: #fffdf7;
        padding: 14px 20px;
        border-radius: 10px;
        border: 1px solid var(--line);
        max-width: fit-content;
    }

    .price-hardcopy-val {
        color: var(--sp-crimson);
        font-size: 26px;
        font-weight: 800;
    }

    .price-orig-del {
        color: #94a3b8;
        font-size: 16px;
    }

    .price-ebook-val {
        color: #b8850e;
        font-size: 15px;
        font-weight: 700;
        margin-left: 10px;
        border-left: 1px solid #cbd5e1;
        padding-left: 14px;
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
        padding: 13px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 800;
        background: var(--sp-burgundy);
        color: #fff !important;
        border: 1px solid #063b56;
        transition: all 0.2s ease;
    }

    .ebook-action:hover {
        background: #0d4a6b;
        transform: translateY(-2px);
    }

    .hardcopy-action {
        flex: 1;
        min-width: 140px;
        text-align: center;
        padding: 13px 18px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 800;
        background: var(--sp-crimson);
        color: var(--sp-heading) !important;
        border: 1px solid #c48e1a;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .hardcopy-action:hover {
        background: linear-gradient(135deg, #e4b840, #bd881a);
        transform: translateY(-2px);
    }

    .preview-action {
        width: 100%;
        text-align: center;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        background: #fff;
        color: var(--navy);
        border: 1.5px solid var(--navy);
        transition: all 0.2s ease;
    }

    .preview-action:hover {
        background: #f1f5f9;
    }

    /* Content Tabs & Panels */
    .book-tabs {
        display: flex;
        gap: 15px;
        background: #fff;
        padding: 16px 30px;
        border-bottom: 1px solid var(--line);
        overflow-x: auto;
    }

    .book-tab-btn {
        background: transparent;
        border: none;
        padding: 10px 18px;
        font-size: 16px;
        font-weight: 700;
        color: var(--muted);
        cursor: pointer;
        font-family: inherit;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .book-tab-btn.active,
    .book-tab-btn:hover {
        color: var(--navy);
        background: #fdf6e2;
        border-bottom: 3px solid var(--gold);
    }

    .book-panels-wrap {
        padding: 30px;
    }

    .book-detail-card {
        background: #fffdf8;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 28px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(9, 45, 69, 0.04);
        line-height: 1.8;
    }

    .book-detail-card h2 {
        font-size: 22px;
        color: var(--navy);
        font-weight: 800;
        margin-bottom: 16px;
        border-bottom: 1.5px solid var(--line);
        padding-bottom: 8px;
    }

    .meta-specs {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 14px;
        margin-top: 20px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 16px;
    }

    .meta-spec-item b {
        display: block;
        font-size: 12px;
        color: var(--muted);
    }

    .meta-spec-item span {
        font-size: 15px;
        color: var(--navy);
        font-weight: 700;
    }

    /* Related Books */
    .related-books-section {
        padding: 0 30px;
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .book-hero-reference {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 24px 16px;
        }

        .reference-cover {
            width: 170px;
        }

        .reference-copy h1 {
            font-size: 26px;
        }

        .reference-prices {
            justify-content: center;
            margin: 0 auto 20px;
        }

        .reference-actions {
            margin: 0 auto;
        }

        .book-tabs {
            padding: 10px 16px;
        }

        .book-tab-btn {
            font-size: 14px;
            padding: 8px 12px;
        }

        .book-panels-wrap {
            padding: 20px 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="book-page-wrap">

    <!-- Breadcrumb Navigation -->
    <div class="book-breadcrumb">
        <a href="{{ route('home') }}">হোম</a> &gt;
        <a href="{{ route('books.index') }}">সকল বই</a> &gt;
        @if($book->categories->isNotEmpty())
            <a href="{{ route('books.index', ['category' => $book->categories->first()->slug]) }}">{{ $book->categories->first()->name }}</a> &gt;
        @endif
        <span>{{ $book->title }}</span>
    </div>

    <!-- Hero Reference matching PlayMathEarn -->
    <div class="book-hero-reference">
        <div class="reference-cover">
            <img src="{{ $book->cover_url }}" alt="{{ $book->title }} বইয়ের প্রচ্ছদ" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#092d45;color:#fff;font-weight:bold;padding:20px;text-align:center;\'>{{ addslashes($book->title) }}</div>';">
            @if($book->is_upcoming)
                <span class="reference-discount" style="background:#0284c7;">আসন্ন বই</span>
            @elseif($book->discount_percent > 0)
                <span class="reference-discount">-{{ round($book->discount_percent) }}% ছাড়</span>
            @endif
        </div>

        <div class="reference-copy">
            <h1>{{ $book->title }}</h1>
            <div class="reference-author">
                লেখক: <strong>{{ $book->author_name }}</strong>
                @if($book->publisher_name)
                    | প্রকাশনী: <strong style="color:#0284c7;">{{ $book->publisher_name }}</strong>
                @endif
                | ক্যাটাগরি: <strong>{{ $book->categories->first()?->name ?? 'বই' }}</strong>
            </div>

            <div class="reference-rating">
                <span style="color:#f59e0b;">★★★★★</span>
                <span>{{ number_format($book->averageRating(), 1) }} ({{ $book->approvedReviews()->count() }}টি পাঠকদের রিভিউ)</span>
            </div>

            <div class="reference-prices">
                <div>
                    <span style="font-size:12px;color:var(--muted);display:block;">হার্ডকপি মূল্য</span>
                    <span class="price-hardcopy-val">৳ {{ number_format($book->hardcopyEffectivePrice()) }}</span>
                    @if($book->discount_percent > 0)
                        <del class="price-orig-del">৳ {{ number_format($book->price_hardcopy) }}</del>
                    @endif
                </div>

                @if($book->price_ebook > 0)
                    <div class="price-ebook-val">
                        <span style="font-size:12px;color:var(--muted);display:block;">ডিজিটাল ই-বুক</span>
                        ৳ {{ number_format($book->ebookEffectivePrice()) }}
                    </div>
                @endif
            </div>

            <div class="reference-actions">
                @if($book->is_upcoming)
                    <div style="background:#e0f2fe; border:1px solid #7dd3fc; border-radius:10px; padding:15px; color:#0369a1; text-align:center; font-weight:700; width:100%; margin-bottom:10px; font-size:15px;">
                        ⏳ বইটি বর্তমানে প্রকাশের অপেক্ষায় রয়েছে (আসন্ন বই)। প্রকাশিত হওয়া মাত্রই সংগ্রহের জন্য উন্মুক্ত করা হবে।
                    </div>
                    @if($book->preview_pages > 0)
                        <a href="{{ route('books.preview', $book->slug) }}" class="preview-action" style="flex:1; text-align:center; width:100%;">
                            📖 {{ $book->preview_pages }} পৃষ্ঠার ফ্রি প্রিভিউ পড়ুন
                        </a>
                    @endif
                @else
                    @if($book->price_ebook > 0)
                        <a href="{{ route('checkout', ['type' => 'ebook', 'bookSlug' => $book->slug]) }}" class="ebook-action">
                            📱 ই-বুক কিনুন (৳{{ number_format($book->ebookEffectivePrice()) }})
                        </a>
                    @endif

                    <form action="{{ route('cart.add') }}" method="POST" style="flex:1; margin:0;">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="format" value="hardcopy">
                        <button type="submit" class="hardcopy-action" style="width:100%;">
                            🛒 হার্ডকপি কার্টে যোগ করুন
                        </button>
                    </form>

                    @if($book->preview_pages > 0)
                        <a href="{{ route('books.preview', $book->slug) }}" class="preview-action">
                            📖 {{ $book->preview_pages }} পৃষ্ঠার ফ্রি প্রিভিউ পড়ুন
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="book-tabs">
        <button type="button" class="book-tab-btn active" onclick="showTab('summary', this)">📖 বইয়ের বিবরণ</button>
        @if($book->story_behind)
            <button type="button" class="book-tab-btn" onclick="showTab('story', this)">✍️ লেখার পেছনের গল্প</button>
        @endif
        <button type="button" class="book-tab-btn" onclick="showTab('author', this)">👤 লেখক পরিচিতি</button>
        <button type="button" class="book-tab-btn" onclick="showTab('reviews', this)">⭐ পাঠকদের মতামত ({{ $book->reviews()->count() }})</button>
    </div>

    <div class="book-panels-wrap">

        <!-- Tab 1: Summary & Details -->
        <div id="tab-summary" class="tab-panel">
            <div class="book-detail-card">
                <h2>বইয়ের সারসংক্ষেপ ও পরিচয়</h2>
                <div style="font-size:16px; color:#334155;">
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
                        <span>বাংলা (প্রমিত)</span>
                    </div>
                    <div class="meta-spec-item">
                        <b>স্টক স্ট্যাটাস</b>
                        @if($book->is_upcoming)
                            <span style="color:#0284c7; font-weight:700;">আসন্ন (শীঘ্রই প্রকাশিত হবে)</span>
                        @else
                            <span style="color:#16a34a; font-weight:700;">{{ $book->stock_status === 'in_stock' ? 'মজুদ আছে' : 'সীমিত স্টক' }}</span>
                        @endif
                    </div>
                    <div class="meta-spec-item">
                        <b>ক্যাটাগরি</b>
                        <span>{{ $book->categories->pluck('name')->join(', ') ?: 'সাধারণ সাহিত্য' }}</span>
                    </div>
                    @if($book->publisher_name)
                        <div class="meta-spec-item">
                            <b>অনুমোদিত প্রকাশক</b>
                            <span style="color:#0284c7;">{{ $book->publisher_name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab 2: Story Behind -->
        @if($book->story_behind)
            <div id="tab-story" class="tab-panel" style="display:none;">
                <div class="book-detail-card">
                    <h2>বইটি লেখার পেছনের গল্প</h2>
                    <div style="font-size:16px; color:#334155; font-style:italic;">
                        {!! nl2br(e($book->story_behind)) !!}
                    </div>
                </div>
            </div>
        @endif

        <!-- Tab 3: Author Info -->
        <div id="tab-author" class="tab-panel" style="display:none;">
            <div class="book-detail-card">
                <h2>লেখক পরিচিতি — {{ $book->author_name }}</h2>
                <p style="font-size:16px; color:#334155;">
                    {{ \App\Models\SiteSetting::get('author_bio', 'লেখক, গবেষক ও চিন্তক। জীবন, সমাজ ও নৈতিক মূল্যবোধের ওপর রচিত তাঁর গ্রন্থসমূহ পাঠকদের হৃদয়ে গভীর প্রেরণা জুগিয়েছে।') }}
                </p>
                <div style="margin-top:16px;">
                    <a href="{{ route('author') }}" class="cat-pill active" style="font-size:14px; padding:8px 18px;">লেখকের পূর্ণ পরিচিতি দেখুন →</a>
                </div>
            </div>
        </div>

        <!-- Tab 4: Reviews -->
        <div id="tab-reviews" class="tab-panel" style="display:none;">
            <div class="book-detail-card">
                <h2>পাঠকদের রিভিউ ও রেটিং</h2>
                @php
                    $bookReviews = $book->reviews()->where('status', 'approved')->latest()->get();
                @endphp
                @if($bookReviews->isEmpty())
                    <p style="color:var(--muted);">এই বইটির জন্য এখনও কোনো রিভিউ প্রকাশিত হয়নি। আপনি বই পাঠ করে প্রথম রিভিউটি দিন!</p>
                @else
                    @foreach($bookReviews as $rev)
                        <div style="border-bottom:1px solid #f1ebd9; padding-bottom:14px; margin-bottom:14px;">
                            <div style="color:#f59e0b; font-size:15px; margin-bottom:4px;">
                                @for($i=0; $i<$rev->rating; $i++) ★ @endfor
                            </div>
                            <p style="font-style:italic; margin-bottom:6px;">“{{ $rev->comment }}”</p>
                            <small style="color:var(--navy); font-weight:700;">— {{ $rev->customer_name }}</small>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    <!-- Related Books -->
    @if(isset($relatedBooks) && $relatedBooks->isNotEmpty())
        <div class="related-books-section">
            <div class="real-section-header">
                <h2>📚 একই বিষয়ের আরও কিছু বই</h2>
                <a href="{{ route('books.index') }}">সকল বই দেখুন →</a>
            </div>
            <div class="real-books-grid">
                @foreach($relatedBooks->take(4) as $rel)
                    <article class="real-book-card">
                        <a href="{{ route('books.show', $rel->slug) }}" class="real-book-link">
                            <div class="real-cover">
                                <img src="{{ $rel->cover_url }}" alt="{{ $rel->title }}" loading="lazy">
                            </div>
                            <h3>{{ $rel->title }}</h3>
                            <div class="real-price">
                                <strong>৳ {{ number_format($rel->hardcopyEffectivePrice()) }}</strong>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
function showTab(tabName, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.book-tab-btn').forEach(b => b.classList.remove('active'));
    
    const target = document.getElementById('tab-' + tabName);
    if (target) target.style.display = 'block';
    if (btn) btn.classList.add('active');
}
</script>
@endsection
