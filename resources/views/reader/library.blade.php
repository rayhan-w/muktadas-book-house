@extends('layouts.app')

@section('title', 'আমার ডিজিটাল পাঠাগার (ই-বুক) | মুক্তাদার বইঘর')

@section('content')
<div style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 30px 0; margin-bottom: 35px;">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 4px;">📚 আমার ডিজিটাল পাঠাগার</h1>
        <p style="color: var(--text-muted); font-size: 15px;">আপনার অনুমোদিত সকল ই-বুক এখানে সংরক্ষিত রয়েছে। মোবাইল বা কম্পিউটার থেকে সরাসরি অনলাইনে পড়ুন।</p>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    @if($ebooks->isEmpty())
        <div style="background: #fff; border: 1px dashed var(--border-color); border-radius: var(--radius); padding: 70px 20px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">📖</div>
            <h2 style="color: var(--primary); margin-bottom: 8px;">আপনার পাঠাগারে এখনো কোনো ই-বুক নেই!</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">আমাদের সংগ্রহ থেকে পছন্দের বইয়ের ডিজিটাল সংস্করণ কিনুন বা প্রিভিউ পড়ুন।</p>
            <a href="{{ route('books.index') }}" class="btn btn-gold">বইয়ের ক্যাটালগ দেখুন</a>
        </div>
    @else
        <div class="books-grid">
            @foreach($ebooks as $item)
                @php $b = $item->book; @endphp
                <div class="book-card" style="border: 2px solid var(--border-color);">
                    <div class="card-cover">
                        <img src="{{ $b->cover_url }}" alt="{{ $b->title }}">
                    </div>
                    <div class="card-content">
                        <span style="font-size: 12px; color: #16a34a; font-weight: 700; margin-bottom: 4px;">✓ সক্রিয় ডিজিটাল কপি</span>
                        <h3 class="card-title">{{ $b->title }}</h3>
                        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">লেখক: {{ $b->author_name }}</p>

                        <div style="background: var(--cream-bg); padding: 8px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; color: var(--primary);">
                            সর্বশেষ পড়েছেন: <strong>পৃষ্ঠা {{ $item->last_read_page }}</strong>
                        </div>

                        <a href="{{ route('books.read', $b->slug) }}" class="btn btn-gold" style="width: 100%; text-align: center;">
                            📖 বই পড়ুন →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
