@extends('layouts.app')

@section('title', 'লেখক পরিচিতি — ' . $settings['author_name'] . ' | মুক্তাদার বইঘর')

@section('content')
<div class="legal-page-header">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
        <img src="{{ asset($settings['author_photo'] ?: 'author-portrait.jpg') }}" alt="{{ $settings['author_name'] }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; object-position: top center; border: 4px solid var(--sp-burgundy); box-shadow: var(--sp-shadow-md);">
        <div style="flex: 1; min-width: 250px;">
            <h1 style="font-size: 30px; color: var(--sp-burgundy); font-weight: 800; margin-bottom: 6px;">{{ $settings['author_name'] }}</h1>
            <p style="font-size: 16px; color: var(--sp-gold-dark, #b45309); font-weight: 700; margin-bottom: 10px;">লেখক, গবেষক ও সাহিত্যিক</p>
            <p style="color: var(--sp-body, #334155); max-width: 750px; font-size: 14.5px; line-height: 1.7; margin:0;">
                {{ $settings['author_bio'] }}
            </p>
        </div>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto 60px; padding: 0 20px;">
    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: var(--sp-radius); padding: 30px; margin-bottom: 35px; box-shadow: var(--sp-shadow-sm);">
        <h2 style="font-size: 20px; color: var(--sp-burgundy); margin-bottom: 12px; font-weight:700;">লেখকের বাণী ও দর্শন</h2>
        <blockquote style="font-size: 16px; font-style: italic; color: #1e293b; border-left: 4px solid var(--sp-burgundy); padding-left: 18px; line-height: 1.8; margin:0;">
            “{{ $settings['author_quote'] }}”
        </blockquote>
    </div>

    <div class="section-head" style="margin-bottom:20px;">
        <h2 style="font-size:22px; color:var(--sp-burgundy); font-weight:800;">📚 লেখকের প্রকাশিত বইসমূহ</h2>
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
