@extends('layouts.app')

@section('title', 'নমুনা পৃষ্ঠা পড়ুন — ' . $book->title . ' | মুক্তাদার বইঘর')

@section('styles')
<style>
    .preview-container {
        max-width: 850px;
        margin: 40px auto 60px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .preview-header {
        background: var(--primary);
        color: #fff;
        padding: 18px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .preview-header h1 {
        font-size: 20px;
        font-weight: 700;
    }

    .preview-controls {
        background: #f1f5f9;
        padding: 12px 25px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .preview-content {
        padding: 40px;
        min-height: 500px;
        font-size: 17px;
        line-height: 2;
        color: #1e293b;
        background: #fffefb;
    }

    .preview-footer {
        background: var(--cream-bg);
        border-top: 1px solid var(--border-color);
        padding: 25px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="preview-container">
        <div class="preview-header">
            <div>
                <h1>{{ $book->title }} — নমুনা পাঠ</h1>
                <small style="color: var(--gold-light);">লেখক: {{ $book->author_name }} | অনুমোদিত প্রিভিউ</small>
            </div>
            <a href="{{ route('books.show', $book->slug) }}" class="btn btn-outline" style="border-color: #fff; color: #fff; padding: 6px 14px; font-size: 13px;">← বইয়ের পেজ</a>
        </div>

        <div class="preview-controls">
            <span style="font-weight: 700; color: var(--primary);">
                পৃষ্ঠা <span id="currPage">১</span> / {{ $book->preview_pages }}
            </span>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn btn-primary" id="prevBtn" onclick="prevPage()" disabled style="padding: 6px 14px; font-size: 13px;">আগের পৃষ্ঠা</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPage()" style="padding: 6px 14px; font-size: 13px;">পরের পৃষ্ঠা</button>
            </div>
        </div>

        <div class="preview-content" id="previewArea">
            <!-- Simulated Sample Pages for Preview -->
            <div id="page1" class="page-view">
                <div style="text-align: center; margin-bottom: 30px;">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="max-height: 250px; border-radius: 6px; box-shadow: var(--shadow-sm); margin-bottom: 15px;">
                    <h2 style="font-size: 24px; color: var(--primary);">{{ $book->title }}</h2>
                    <p style="color: var(--text-muted);">{{ $book->author_name }}</p>
                </div>
                <p><strong>সূচনা:</strong></p>
                <p>{{ $book->summary }}</p>
            </div>

            <div id="page2" class="page-view" style="display: none;">
                <h3 style="color: var(--primary); margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">প্রথম অধ্যায়: ভাবনার নতুন দিগন্ত</h3>
                <p>জীবনের প্রতিটি বাঁকে মানুষ এক একটি সত্যের মুখোমুখি হয়। কখনো সেই সত্য তাকে থামিয়ে দেয়, কখনো বা নতুন উদ্যমে পথচলার প্রেরণা জোগায়। যে ব্যক্তি নিজের চিন্তাকে আলোকিত করতে পারে, তার জন্য কোনো অন্ধকারই স্থায়ী হতে পারে না।</p>
                <p>বই হলো সেই আলোকবর্তিকা, যা আমাদের মনের চোখকে খুলে দেয় এবং পৃথিবীর ক্ষণস্থায়ী কোলাহল পেরিয়ে অনন্ত সৌন্দর্যের দিকে আহ্বান জানায়।</p>
            </div>

            <div id="page3" class="page-view" style="display: none;">
                <h3 style="color: var(--primary); margin-bottom: 15px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">আত্মশুদ্ধি ও প্রশান্তির সন্ধান</h3>
                <p>আমরা প্রতিনিয়ত বাইরের জগতের সংস্কারে ব্যস্ত, কিন্তু আমাদের অন্তর্জগত যে অবহেলায় খাঁ খাঁ করছে—সে খবর কি আমরা রাখি? একটি সুন্দর জীবনের গোড়াপত্তন হয় মনের গভীর থেকে। লোভ, অহংকার আর সংকীর্ণতা দূর না হলে আত্মিক প্রশান্তি কোনোদিন মিলবে না।</p>
                <p>এই বইটি আপনাকে সেই হারিয়ে যাওয়া প্রশান্তির পথ দেখাবে, যেখানে প্রতিটি নিঃশ্বাস হয়ে উঠবে অর্থবহ ও নির্মল।</p>
            </div>
        </div>

        <div class="preview-footer">
            <h3 style="font-size: 18px; color: var(--primary); margin-bottom: 6px;">নমুনা পড়া শেষ হয়েছে!</h3>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 18px;">বাকি অধ্যায়গুলো পড়তে এখনই সংগ্রহ করুন হার্ডকপি কিংবা সরাসরি উপভোগ করুন ডিজিটাল ই-বুক।</p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="format" value="hardcopy">
                    <button type="submit" class="btn btn-gold">🛒 হার্ডকপি অর্ডার করুন (৳ {{ number_format($book->hardcopyEffectivePrice()) }})</button>
                </form>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="format" value="ebook">
                    <input type="hidden" name="buy_now" value="1">
                    <button type="submit" class="btn btn-primary">⚡ ই-বুক কিনুন (৳ {{ number_format($book->ebookEffectivePrice()) }})</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentPage = 1;
    const totalPages = Math.min({{ $book->preview_pages }}, 3);

    function updatePage() {
        for (let i = 1; i <= 3; i++) {
            const el = document.getElementById('page' + i);
            if (el) el.style.display = i === currentPage ? 'block' : 'none';
        }
        document.getElementById('currPage').innerText = currentPage;
        document.getElementById('prevBtn').disabled = currentPage === 1;
        document.getElementById('nextBtn').disabled = currentPage >= totalPages;
    }

    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updatePage();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePage();
        }
    }
</script>
@endsection
