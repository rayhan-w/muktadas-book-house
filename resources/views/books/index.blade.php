@extends('layouts.app')

@section('title', 'সকল বইয়ের ক্যাটালগ | মুক্তাদার বইঘর')

@section('styles')
<style>
    .catalog-shell {
        padding: 30px 24px 60px;
    }

    .catalog-header-box {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(9, 45, 69, 0.04);
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

    .category-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        background: #f8f4ec;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 25px;
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
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        color: var(--navy);
        background: #fff;
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

    .sort-select {
        padding: 8px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--line);
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        background: #fff;
        color: var(--navy);
        outline: none;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: var(--navy);
    }

    /* Books Grid matching PlayMathEarn */
    .real-books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }

    .real-book-card {
        background: #fffdf8 !important;
        border: 1px solid var(--line) !important;
        border-radius: 12px !important;
        padding: 12px !important;
        display: flex !important;
        flex-direction: column !important;
        box-shadow: 0 4px 14px rgba(9, 45, 69, 0.05) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        position: relative;
    }

    .real-book-card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 25px rgba(9, 45, 69, 0.1) !important;
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
        margin-bottom: 10px;
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
        transform: scale(1.03);
    }

    .discount-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #e11d48;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 7px;
        border-radius: 6px;
    }

    .publisher-tag {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(9, 45, 69, 0.85);
        color: #f4cf68;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }

    .real-book-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.35;
        margin-bottom: 4px;
        min-height: 42px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .real-book-card p.cat-label {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .real-price {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 12px;
    }

    .real-price strong {
        font-size: 16px;
        color: var(--navy);
        font-weight: 800;
    }

    .real-price del {
        font-size: 12px;
        color: #94a3b8;
    }

    .real-card-bottom {
        border-top: 1px solid #f1ebd9;
        padding-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .product-types {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }

    .btn-ebook {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 6px;
        border-radius: 6px;
        background: #fdf2d0;
        color: #925c07 !important;
        border: 1px solid #e9cd89;
        font-size: 12px;
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
        padding: 7px 6px;
        border-radius: 6px;
        background: var(--navy);
        color: #fff !important;
        border: 1px solid var(--navy);
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-hardcopy:hover {
        background: #174261;
    }
</style>
@endsection

@section('content')
<div class="catalog-shell">

    <div class="catalog-header-box">
        <h1>
            @if(isset($selectedCategory) && $selectedCategory)
                {{ $selectedCategory->name }} ক্যাটাগরির বইসমূহ
            @elseif(request('search'))
                “{{ request('search') }}”-এর অনুসন্ধান ফলাফল
            @else
                সকল প্রকাশিত বইয়ের সম্ভার
            @endif
        </h1>
        <p>মোট {{ $books->total() }}টি বই পাওয়া গেছে। পছন্দের বই নির্বাচন করে সরাসরি হার্ডকপি কিংবা ডিজিটাল ই-বুক হিসেবে সংগ্রহ করুন।</p>
    </div>

    <!-- Toolbar: Categories and Sorting -->
    <div class="category-toolbar">
        <div class="category-pills">
            <a href="{{ route('books.index') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">সব ক্যাটাগরি</a>
            @foreach($categories as $cat)
                <a href="{{ route('books.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" class="cat-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('books.index') }}">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            <select name="sort" class="sort-select" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>সর্বশেষ প্রকাশিত</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>জনপ্রিয় / বেস্টসেলার</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>মূল্য: কম থেকে বেশি</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>মূল্য: বেশি থেকে কম</option>
            </select>
        </form>
    </div>

    @if($books->isEmpty())
        <div style="background: #fff; padding: 60px 20px; border-radius: 14px; text-align: center; border: 1px dashed var(--line); margin: 30px 0;">
            <div style="font-size: 44px; margin-bottom: 12px;">🔍</div>
            <h3 style="color: var(--navy); margin-bottom: 8px;">কোনো বই খুঁজে পাওয়া যায়নি</h3>
            <p style="color: var(--muted); margin-bottom: 20px;">দয়া করে অন্য কোনো নাম বা ক্যাটাগরি নির্বাচন করে চেষ্টা করুন।</p>
            <a href="{{ route('books.index') }}" class="cat-pill active" style="font-size: 15px; padding: 8px 18px;">সকল বই দেখুন</a>
        </div>
    @else
        <div class="real-books-grid">
            @foreach($books as $book)
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
        </div>

        <div style="margin: 30px 0;">
            {{ $books->links() }}
        </div>
    @endif

</div>
@endsection
