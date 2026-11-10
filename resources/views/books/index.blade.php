@extends('layouts.app')

@section('title', 'সকল বইয়ের ক্যাটালগ | মুক্তাদার বইঘর')

@section('styles')
<style>
    .catalog-shell {
        padding: 30px 20px 60px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .catalog-header-box {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 18px rgba(9, 45, 69, 0.04);
    }

    .catalog-header-box h1 {
        font-size: 26px;
        color: var(--navy);
        font-weight: 800;
        margin-bottom: 6px;
    }

    .catalog-header-box p {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
    }

    /* Toolbar: Categories and Sorting */
    .category-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        background: #f8f4ec;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 28px;
    }

    .category-pills {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 15px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        color: var(--navy);
        background: #ffffff;
        border: 1px solid var(--line);
        transition: all 0.2s ease;
    }

    .cat-pill:hover,
    .cat-pill.active {
        background: linear-gradient(135deg, #f4cf68, #d6a12e);
        border-color: #bd8b19;
        color: var(--navy);
        box-shadow: 0 2px 8px rgba(214, 161, 46, 0.25);
    }

    .cat-pill-count {
        background: rgba(9, 45, 69, 0.08);
        color: var(--navy);
        padding: 1px 7px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .cat-pill.active .cat-pill-count {
        background: rgba(9, 45, 69, 0.2);
    }

    .sort-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sort-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--navy);
    }

    .sort-select {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--line);
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        background: #ffffff;
        color: var(--navy);
        outline: none;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: var(--navy);
    }

    /* Reference Cards Grid matching PlayMathEarn */
    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    @media (max-width: 1024px) {
        .catalog-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .catalog-header-box {
            padding: 18px;
        }
        .catalog-header-box h1 {
            font-size: 20px;
        }
    }

    @media (max-width: 480px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }

    /* Single Book Card - PlayMathEarn Clone */
    .catalog-card {
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(9, 45, 69, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .catalog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(9, 45, 69, 0.1);
        border-color: var(--gold);
    }

    /* Cover Area */
    .card-cover-container {
        position: relative;
        width: 100%;
        aspect-ratio: 3/4;
        border-radius: 10px;
        overflow: hidden;
        background: #fbf8f0;
        margin-bottom: 12px;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .card-cover-container a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .card-cover-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .catalog-card:hover .card-cover-container img {
        transform: scale(1.03);
    }

    .cover-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #092d45, #193b4d);
        color: #ffffff;
        padding: 16px;
        text-align: center;
        font-weight: 700;
        font-size: 14px;
        line-height: 1.4;
    }

    /* Badges */
    .badge-discount-tag {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #dc2626 !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
        z-index: 3;
        line-height: 1.2;
    }

    .badge-upcoming-tag {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #0284c7 !important;
        color: #ffffff !important;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.4);
        z-index: 3;
        line-height: 1.2;
    }

    .badge-publisher-tag {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(9, 45, 69, 0.88);
        color: #f4cf68;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
        z-index: 3;
    }

    /* Info Area */
    .card-details {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title-link {
        text-decoration: none;
        color: var(--navy);
    }

    .card-title-link:hover h3 {
        color: var(--gold-dark);
    }

    .card-title {
        font-size: 15.5px;
        font-weight: 800;
        color: var(--navy);
        line-height: 1.35;
        margin-bottom: 4px;
        min-height: 42px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-author-name {
        font-size: 12.5px;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 500;
    }

    /* Gold Stars + DB Review Count */
    .card-rating-strip {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .card-gold-stars {
        color: #f59e0b;
        letter-spacing: 1px;
    }

    .card-rating-count {
        color: #64748b;
        font-weight: 600;
    }

    /* Two Pale-Gold Price Pills */
    .card-price-pills-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .pale-gold-pill {
        background: #fdf8eb;
        border: 1px solid #ebd9a8;
        border-radius: 8px;
        padding: 5px 8px;
        display: inline-flex;
        align-items: baseline;
        gap: 4px;
        font-size: 11.5px;
        flex: 1;
        min-width: 90px;
    }

    .pale-gold-pill .pill-kind {
        color: #85590a;
        font-weight: 700;
        font-size: 10.5px;
    }

    .pale-gold-pill .pill-val {
        color: var(--navy);
        font-weight: 800;
        font-size: 13.5px;
    }

    .pale-gold-pill del {
        color: #94a3b8;
        font-size: 10.5px;
    }

    /* Full-Width Dark-Navy Button */
    .btn-detail-full {
        display: block;
        width: 100%;
        text-align: center;
        background: var(--navy);
        color: #ffffff !important;
        padding: 10px 0;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid var(--navy);
    }

    .btn-detail-full:hover {
        background: var(--gold);
        border-color: var(--gold-dark);
        color: var(--navy) !important;
        box-shadow: 0 4px 12px rgba(214, 161, 46, 0.25);
    }

    /* Empty state */
    .empty-state-box {
        background: #ffffff;
        padding: 60px 20px;
        border-radius: 14px;
        text-align: center;
        border: 2px dashed var(--line);
        margin: 30px 0;
    }

    .empty-state-box h3 {
        color: var(--navy);
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .empty-state-box p {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="catalog-shell">

    <div class="catalog-header-box">
        <h1>
            @if(isset($selectedCategory) && $selectedCategory)
                {{ $selectedCategory->name }} ক্যাটাগরির বইসমূহ
            @elseif(!empty($searchTerm))
                “{{ $searchTerm }}”-এর অনুসন্ধান ফলাফল
            @else
                সকল প্রকাশিত বইয়ের সম্ভার
            @endif
        </h1>
        <p>মোট {{ $books->total() }}টি বই পাওয়া গেছে। পছন্দের বই নির্বাচন করে সরাসরি হার্ডকপি কিংবা ডিজিটাল ই-বুক হিসেবে সংগ্রহ করুন।</p>
    </div>

    <!-- Toolbar: Categories and Sorting -->
    <div class="category-toolbar">
        <div class="category-pills">
            <a href="{{ route('books.index') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">
                <span>সব ক্যাটাগরি</span>
                <span class="cat-pill-count">{{ $totalBooksCount }}</span>
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('books.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" class="cat-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                    <span>{{ $cat->name }}</span>
                    <span class="cat-pill-count">{{ $cat->books_count }}</span>
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('books.index') }}" class="sort-box">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            
            <label for="sort-select-input" class="sort-label">সর্ট করুন:</label>
            <select id="sort-select-input" name="sort" class="sort-select" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>সর্বশেষ প্রকাশিত</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>জনপ্রিয় / বেস্টসেলার</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>মূল্য: কম থেকে বেশি</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>মূল্য: বেশি থেকে কম</option>
                <option value="name_asc" {{ in_array(request('sort'), ['name_asc', 'name']) ? 'selected' : '' }}>নাম: A–Z</option>
            </select>
        </form>
    </div>

    @if($books->isEmpty())
        <div class="empty-state-box">
            <div style="font-size: 48px; margin-bottom: 14px;">🔍</div>
            <h3>কোনো বই খুঁজে পাওয়া যায়নি</h3>
            <p>এই ক্যাটাগরিতে বর্তমানে কোনো প্রকাশিত বই নেই। দয়া করে অন্য কোনো ক্যাটাগরি নির্বাচন করে চেষ্টা করুন।</p>
            <a href="{{ route('books.index') }}" class="cat-pill active" style="font-size: 15px; padding: 10px 22px; display: inline-flex;">
                সকল বই দেখুন
            </a>
        </div>
    @else
        <div class="catalog-grid">
            @foreach($books as $book)
                <article class="catalog-card">
                    <div>
                        <!-- Cover with Safe Fallback and No Red Overlays -->
                        <div class="card-cover-container">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_url }}" 
                                     alt="{{ $book->title }} বইয়ের প্রচ্ছদ" 
                                     loading="lazy" 
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span><small style=\'display:block;margin-top:6px;opacity:0.8;\'>{{ addslashes($book->author_name) }}</small></div>';">
                            </a>

                            @if($book->is_upcoming)
                                <span class="badge-upcoming-tag">আসন্ন</span>
                            @elseif($book->discount_percent > 0)
                                <span class="badge-discount-tag">-{{ round($book->discount_percent) }}%</span>
                            @endif

                            @if($book->publisher_name)
                                <span class="badge-publisher-tag">{{ $book->publisher_name }}</span>
                            @endif
                        </div>

                        <!-- Card Details -->
                        <div class="card-details">
                            <a href="{{ route('books.show', $book->slug) }}" class="card-title-link">
                                <h3 class="card-title">{{ $book->title }}</h3>
                            </a>
                            <div class="card-author-name">লেখক: {{ $book->author_name }}</div>

                            <!-- Rating & Real DB Review Count -->
                            <div class="card-rating-strip">
                                <span class="card-gold-stars">★★★★★</span>
                                <span class="card-rating-count">{{ number_format($book->averageRating(), 1) }} ({{ $book->approvedReviews()->count() }})</span>
                            </div>

                            <!-- Two Pale-Gold Price Pills (E-book + Hardcopy) -->
                            <div class="card-price-pills-row">
                                @if($book->price_ebook > 0)
                                    <div class="pale-gold-pill" title="ডিজিটাল ই-বুক মূল্য">
                                        <span class="pill-kind">ই-বুক</span>
                                        <span class="pill-val">৳{{ number_format($book->ebookEffectivePrice()) }}</span>
                                    </div>
                                @endif
                                <div class="pale-gold-pill" title="মুদ্রিত হার্ডকপি মূল্য">
                                    <span class="pill-kind">হার্ডকপি</span>
                                    <span class="pill-val">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                    @if($book->discount_percent > 0)
                                        <del>৳{{ number_format($book->price_hardcopy) }}</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full-Width Dark-Navy Button -->
                    <div style="margin-top: 10px;">
                        <a href="{{ route('books.show', $book->slug) }}" class="btn-detail-full">
                            বিস্তারিত দেখুন →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div style="margin: 35px 0 20px;">
            {{ $books->links() }}
        </div>
    @endif

</div>
@endsection
