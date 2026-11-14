@extends('layouts.app')

@section('title', 'লেখক পরিচিতি — ' . $settings['author_name'] . ' | মুক্তাদার বইঘর')

@section('content')
<div style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 50px 0 40px; margin-bottom: 40px;">
    <div class="container" style="display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
        <img src="{{ asset($settings['author_photo'] ?: 'author-portrait.jpg') }}" alt="{{ $settings['author_name'] }}" style="width: 170px; height: 170px; border-radius: 50%; object-fit: cover; object-position: top center; border: 5px solid var(--gold-light); box-shadow: var(--shadow-md);">
        <div>
            <h1 style="font-size: 34px; color: var(--primary); font-weight: 800; margin-bottom: 8px;">{{ $settings['author_name'] }}</h1>
            <p style="font-size: 18px; color: var(--gold-hover); font-weight: 600; margin-bottom: 12px;">লেখক, গবেষক ও সাহিত্যিক</p>
            <p style="color: var(--text-muted); max-width: 700px; font-size: 15px; line-height: 1.7;">
                {{ $settings['author_bio'] }}
            </p>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 35px; margin-bottom: 40px; box-shadow: var(--shadow-sm);">
        <h2 style="font-size: 22px; color: var(--primary); margin-bottom: 14px;">লেখকের বাণী ও দর্শন</h2>
        <blockquote style="font-size: 17px; font-style: italic; color: var(--primary); border-left: 4px solid var(--gold); padding-left: 20px; line-height: 1.8;">
            “{{ $settings['author_quote'] }}”
        </blockquote>
    </div>

    <div class="section-head">
        <h2>📚 লেখকের প্রকাশিত বইসমূহ</h2>
    </div>

    <div class="books-grid">
        @foreach($authorBooks as $book)
            <div class="book-card">
                <a href="{{ route('books.show', $book->slug) }}" class="card-cover">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}">
                </a>
                <div class="card-content">
                    <h3 class="card-title">{{ $book->title }}</h3>
                    <div class="card-prices">
                        <span class="price-hardcopy">৳ {{ number_format($book->hardcopyEffectivePrice()) }}</span>
                        <span class="price-ebook">ই-বুক: ৳ {{ number_format($book->ebookEffectivePrice()) }}</span>
                    </div>
                    <a href="{{ route('books.show', $book->slug) }}" class="btn btn-primary" style="font-size: 13px; padding: 8px;">বিস্তারিত দেখুন</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
