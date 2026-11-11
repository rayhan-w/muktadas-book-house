@extends('layouts.app')

@section('title', 'সকল বইয়ের ক্যাটালগ | মুক্তাদার বইঘর — সহজপাঠ থিম')

@section('styles')
<style>
    .catalog-shell {
        padding: 30px 24px 60px;
        max-width: 1440px;
        margin: 0 auto;
        width: 100%;
    }

    .catalog-header-box {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 24px 28px;
        margin-bottom: 22px;
        box-shadow: var(--sp-shadow-sm);
    }

    .catalog-header-box h1 {
        font-size: 24px;
        color: var(--sp-heading);
        font-weight: 800;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .catalog-header-box p {
        font-size: 14px;
        color: var(--sp-muted);
        margin: 0;
    }

    /* Toolbar: Categories and Sorting */
    .category-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 14px 20px;
        margin-bottom: 26px;
        box-shadow: var(--sp-shadow-sm);
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
        gap: 6px;
        padding: 7px 14px;
        border-radius: var(--sp-radius-pill);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        color: var(--sp-body);
        background: #f8fafc;
        border: 1px solid var(--sp-border);
        transition: all 0.2s ease;
    }

    .cat-pill:hover {
        background: var(--sp-paste-light);
        border-color: var(--sp-paste-border);
        color: var(--sp-burgundy);
    }

    .cat-pill.active {
        background: var(--sp-burgundy);
        border-color: var(--sp-burgundy);
        color: #ffffff !important;
        font-weight: 700;
    }

    .cat-pill-count {
        background: rgba(0, 0, 0, 0.06);
        color: inherit;
        padding: 1px 7px;
        border-radius: var(--sp-radius-pill);
        font-size: 11px;
        font-weight: 800;
    }

    .cat-pill.active .cat-pill-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .sort-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sort-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--sp-heading);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .sort-select {
        padding: 8px 14px;
        border-radius: var(--sp-radius-sm);
        border: 1.5px solid var(--sp-border);
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        background: #ffffff;
        color: var(--sp-heading);
        outline: none;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: var(--sp-burgundy);
    }

    /* SahojPath Compact Product Cards Grid */
    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 35px;
    }

    @media (max-width: 1024px) {
        .catalog-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
        }
        .catalog-header-box {
            padding: 16px;
        }
        .catalog-header-box h1 {
            font-size: 19px;
        }
    }

    @media (max-width: 480px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 8px !important;
        }
        .catalog-shell {
            padding: 15px 10px 40px;
        }
    }

    /* Single Book Card - SahojPath Premium Compact Card */
    .catalog-card {
        background: #ffffff;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius);
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--sp-shadow-sm);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
    }

    .catalog-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sp-shadow-hover);
        border-color: #cbd5e1;
    }

    /* Cover Area */
    .card-cover-container {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1.35;
        border-radius: 10px;
        overflow: hidden;
        background: #f8fafc;
        margin-bottom: 12px;
        border: 1px solid #f1f5f9;
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
        transform: scale(1.04);
    }

    .cover-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: #ffffff;
        padding: 16px;
        text-align: center;
        font-weight: 700;
        font-size: 13.5px;
        line-height: 1.4;
    }

    /* SahojPath Badges */
    .badge-discount-tag {
        position: absolute;
        top: 8px;
        left: 8px;
        background: var(--sp-green-bg) !important;
        color: var(--sp-green) !important;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: var(--sp-radius-pill);
        border: 1px solid rgba(25, 135, 84, 0.25);
        z-index: 3;
        line-height: 1.2;
    }

    .badge-upcoming-tag {
        position: absolute;
        top: 8px;
        right: 8px;
        background: var(--sp-amber-bg) !important;
        color: var(--sp-amber) !important;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: var(--sp-radius-pill);
        border: 1px solid rgba(234, 88, 12, 0.25);
        z-index: 3;
        line-height: 1.2;
    }

    .badge-publisher-tag {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        backdrop-filter: blur(4px);
        z-index: 2;
    }

    /* Card Details */
    .card-details {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-title-link {
        text-decoration: none;
    }

    .card-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--sp-heading);
        line-height: 1.35;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 38px;
        transition: color 0.2s ease;
    }

    .card-title:hover {
        color: var(--sp-burgundy);
    }

    .card-author-name {
        font-size: 12px;
        color: var(--sp-muted);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-rating-strip {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: #f59e0b;
        margin-bottom: 8px;
    }

    .card-rating-count {
        color: var(--sp-muted);
        font-size: 11px;
        font-weight: 600;
    }

    /* SahojPath Price Group */
    .price-group {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .price-group .product-price {
        font-size: 16px;
        font-weight: 800;
        color: var(--sp-crimson);
    }

    .price-group .old-price {
        font-size: 12px;
        color: var(--sp-light);
        text-decoration: line-through;
        font-weight: 600;
    }

    .card-price-pills-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-bottom: 12px;
    }

    .pale-gold-pill {
        background: #f8fafc;
        border: 1px solid var(--sp-border);
        border-radius: var(--sp-radius-sm);
        padding: 4px 6px;
        text-align: center;
        font-size: 11px;
        color: var(--sp-body);
        line-height: 1.25;
    }

    .pale-gold-pill .pill-kind {
        display: block;
        font-size: 9.5px;
        color: var(--sp-muted);
    }

    .pale-gold-pill .pill-val {
        display: block;
        color: var(--sp-heading);
        font-weight: 800;
        font-size: 12px;
    }

    /* SahojPath .btn-cart Action Button */
    .btn-cart {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        background: var(--sp-crimson);
        color: #ffffff !important;
        border: 0;
        border-radius: var(--sp-radius-pill);
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(229, 70, 70, 0.2);
    }

    .btn-cart:hover {
        background: var(--sp-burgundy);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(139, 38, 59, 0.25);
        transform: translateY(-1px);
    }

    .btn-upcoming {
        background: #f1f5f9 !important;
        color: var(--sp-amber) !important;
        border: 1px dashed var(--sp-amber) !important;
        box-shadow: none !important;
    }

    /* Empty state */
    .empty-state-box {
        background: #ffffff;
        padding: 60px 20px;
        border-radius: var(--sp-radius);
        text-align: center;
        border: 2px dashed var(--sp-border);
        margin: 30px 0;
    }

    .empty-state-box h3 {
        color: var(--sp-heading);
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .empty-state-box p {
        color: var(--sp-muted);
        font-size: 14px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="catalog-shell" style="padding-top: 15px;">

    <!-- Toolbar: Categories and Sorting -->
    <div class="category-toolbar">
        <div class="category-pills">
            <a href="{{ route('books.index') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">
                <i class="fa-solid fa-books"></i> সব বই
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
            
            <label for="sort-select-input" class="sort-label">
                <i class="bi bi-sort-down"></i> সর্ট করুন:
            </label>
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
            <div style="font-size: 42px; margin-bottom: 14px; color: var(--sp-muted);">
                <i class="bi bi-journal-x"></i>
            </div>
            <h3>কোনো বই খুঁজে পাওয়া যায়নি</h3>
            <p>এই ক্যাটাগরিতে বর্তমানে কোনো প্রকাশিত বই নেই। দয়া করে অন্য কোনো ক্যাটাগরি নির্বাচন করে চেষ্টা করুন।</p>
            <a href="{{ route('books.index') }}" class="cat-pill active" style="font-size: 14px; padding: 10px 22px; display: inline-flex;">
                সকল বই দেখুন
            </a>
        </div>
    @else
        <div class="catalog-grid">
            @foreach($books as $book)
                <article class="catalog-card">
                    <div>
                        <!-- Cover with Safe Fallback -->
                        <div class="card-cover-container">
                            <a href="{{ route('books.show', $book->slug) }}">
                                <img src="{{ $book->cover_url }}" 
                                     alt="{{ $book->title }} বইয়ের প্রচ্ছদ" 
                                     loading="lazy" 
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'cover-fallback\'><span>{{ addslashes($book->title) }}</span><small style=\'display:block;margin-top:6px;opacity:0.8;\'>{{ addslashes($book->author_name) }}</small></div>';">
                            </a>

                            @if($book->is_upcoming)
                                <span class="badge-upcoming-tag">আসন্ন বই</span>
                            @elseif($book->discount_percent > 0)
                                <span class="badge-discount-tag">({{ round($book->discount_percent) }}% ছাড়)</span>
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
                            <div class="card-author-name">
                                <i class="bi bi-pen"></i> {{ $book->author_name }}
                            </div>

                            <!-- Rating & Real DB Review Count -->
                            <div class="card-rating-strip">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="card-rating-count">{{ number_format($book->averageRating(), 1) }} ({{ $book->approvedReviews()->count() }})</span>
                            </div>

                            <!-- SahojPath Price Group -->
                            <div class="price-group">
                                @if($book->discount_percent > 0)
                                    <del class="old-price">৳{{ number_format($book->price_hardcopy) }}</del>
                                @endif
                                <span class="product-price">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                            </div>

                            <!-- Dual Pricing Pills (E-book + Hardcopy) -->
                            <div class="card-price-pills-row">
                                @if($book->price_ebook > 0)
                                    <div class="pale-gold-pill" title="ডিজিタル ই-বুক মূল্য">
                                        <span class="pill-kind">ই-বুক</span>
                                        <span class="pill-val">৳{{ number_format($book->ebookEffectivePrice()) }}</span>
                                    </div>
                                @endif
                                <div class="pale-gold-pill" title="মুদ্রিত হার্ডকপি মূল্য">
                                    <span class="pill-kind">হার্ডকপি</span>
                                    <span class="pill-val">৳{{ number_format($book->hardcopyEffectivePrice()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button: SahojPath .btn-cart -->
                    <div style="margin-top: 10px;">
                        @if($book->is_upcoming)
                            <a href="{{ route('books.show', $book->slug) }}" class="btn-cart btn-upcoming">
                                <i class="bi bi-clock-history"></i> প্রকাশের অপেক্ষায়
                            </a>
                        @else
                            <a href="{{ route('books.show', $book->slug) }}" class="btn-cart">
                                <i class="bi bi-bag-plus"></i> বিস্তারিত দেখুন
                            </a>
                        @endif
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
