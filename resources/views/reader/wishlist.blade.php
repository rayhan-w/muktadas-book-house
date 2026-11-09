@extends('layouts.app')

@section('title', 'আমার পছন্দের তালিকা (উইশলিস্ট) | মুক্তাদার বইঘর')

@section('content')
<div style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 30px 0; margin-bottom: 35px;">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 4px;">❤️ আমার পছন্দের তালিকা (উইশলিস্ট)</h1>
        <p style="color: var(--text-muted); font-size: 15px;">পরে কেনার জন্য আপনার পছন্দ করে রাখা বইসমূহ।</p>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    @if($wishlists->isEmpty())
        <div style="background: #fff; border: 1px dashed var(--border-color); border-radius: var(--radius); padding: 70px 20px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">🤍</div>
            <h2 style="color: var(--primary); margin-bottom: 8px;">আপনার পছন্দের তালিকায় কোনো বই নেই</h2>
            <p style="color: var(--text-muted); margin-bottom: 25px;">যেকোনো বইয়ের পেজ থেকে ‘উইশলিস্ট’ বাটনে চাপ দিয়ে এখানে সংরক্ষণ করতে পারেন।</p>
            <a href="{{ route('books.index') }}" class="btn btn-gold">বই দেখুন</a>
        </div>
    @else
        <div class="books-grid">
            @foreach($wishlists as $wish)
                @php $b = $wish->book; @endphp
                <div class="book-card">
                    <a href="{{ route('books.show', $b->slug) }}" class="card-cover">
                        <img src="{{ $b->cover_url }}" alt="{{ $b->title }}">
                    </a>
                    <div class="card-content">
                        <h3 class="card-title">{{ $b->title }}</h3>
                        <div class="card-prices">
                            <span class="price-hardcopy">৳ {{ number_format($b->hardcopyEffectivePrice()) }}</span>
                        </div>
                        <div style="display: grid; gap: 8px; margin-top: auto;">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $b->id }}">
                                <input type="hidden" name="format" value="hardcopy">
                                <button type="submit" class="btn btn-gold" style="width: 100%; font-size: 13px; padding: 8px;">🛒 কার্টে যোগ করুন</button>
                            </form>
                            <form action="{{ route('reader.wishlist.toggle', $b->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="width: 100%; font-size: 12px; padding: 6px; color: #dc2626; border-color: #fca5a5;">তালিকা থেকে সরান</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
