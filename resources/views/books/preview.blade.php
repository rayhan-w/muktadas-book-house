@extends('layouts.app')

@section('title', 'নমুনা পৃষ্ঠা পড়ুন — ' . $book->title . ' | মুক্তাদার বইঘর')

@section('styles')
<style>
    .preview-container {
        max-width: 850px;
        margin: 20px auto 50px;
        background: #fff;
        border-radius: var(--sp-radius, 14px);
        border: 1px solid var(--sp-border, #e2e8f0);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .preview-header {
        background: linear-gradient(135deg, #042f2e 0%, #0f172b 100%);
        color: #fff;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .preview-header h1 {
        font-size: 19px;
        font-weight: 800;
        margin: 0;
        color: #ffffff;
    }

    .preview-header small {
        color: #5eead4;
        font-size: 12.5px;
        display: block;
        margin-top: 3px;
    }

    .preview-controls {
        background: #f8fafc;
        padding: 10px 22px;
        border-bottom: 1px solid var(--sp-border, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .preview-content {
        padding: 35px;
        min-height: 480px;
        font-size: 16.5px;
        line-height: 1.95;
        color: #1e293b;
        background: #ffffff;
    }

    .preview-footer {
        background: #f8fafc;
        border-top: 1px solid var(--sp-border, #e2e8f0);
        padding: 24px;
        text-align: center;
    }

    .btn-preview-back {
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        color: #ffffff !important;
        padding: 6px 14px;
        font-size: 12.5px;
        font-weight: 700;
        border-radius: var(--sp-radius-pill, 999px);
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-preview-back:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: #ffffff;
    }

    .btn-preview-nav {
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 700;
        border-radius: var(--sp-radius-pill, 999px);
        border: 1.5px solid var(--sp-crimson, #0d9488);
        background: #ffffff;
        color: var(--sp-crimson, #0d9488);
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-preview-nav:hover:not(:disabled) {
        background: var(--sp-crimson, #0d9488);
        color: #ffffff;
    }

    .btn-preview-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        border-color: #cbd5e1;
        color: #94a3b8;
    }

    .btn-preview-hardcopy {
        background: var(--sp-crimson, #0d9488);
        color: #ffffff !important;
        border: none;
        padding: 10px 18px;
        border-radius: var(--sp-radius-pill, 999px);
        font-weight: 800;
        font-size: 13.5px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        transition: all 0.2s;
    }

    .btn-preview-hardcopy:hover {
        background: var(--sp-burgundy, #0f766e);
        transform: translateY(-1px);
    }

    .btn-preview-ebook {
        background: var(--sp-teal, #0f766e);
        color: #ffffff !important;
        border: none;
        padding: 10px 18px;
        border-radius: var(--sp-radius-pill, 999px);
        font-weight: 800;
        font-size: 13.5px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
        transition: all 0.2s;
    }

    .btn-preview-ebook:hover {
        background: var(--sp-teal-dark, #115e59);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .preview-container {
            margin: 10px auto 30px;
            border-radius: 10px;
        }

        .preview-header {
            padding: 12px 14px;
        }

        .preview-header h1 {
            font-size: 16px;
        }

        .preview-controls {
            padding: 8px 12px;
        }

        .preview-content {
            padding: 18px 14px;
            font-size: 15px;
            min-height: 380px;
        }

        .preview-footer {
            padding: 18px 14px;
        }

        .preview-footer div {
            flex-direction: column;
            gap: 8px !important;
        }

        .preview-footer button {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="preview-container">
        <div class="preview-header">
            <div>
                <h1>{{ $book->title }} — নমুনা পাঠ</h1>
                <small>লেখক: {{ $book->author_name }} | অনুমোদিত প্রিভিউ</small>
            </div>
            <a href="{{ route('books.show', $book->slug) }}" class="btn-preview-back">← বইয়ের পেজ</a>
        </div>

        <div class="preview-controls">
            <span style="font-weight: 800; color: var(--sp-burgundy, #0f766e); font-size: 14.5px;">
                পৃষ্ঠা <span id="currPage">১</span> / {{ $book->preview_pages }}
            </span>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-preview-nav" id="prevBtn" onclick="prevPage()" disabled>আগের পৃষ্ঠা</button>
                <button type="button" class="btn-preview-nav" id="nextBtn" onclick="nextPage()">পরের পৃষ্ঠা</button>
            </div>
        </div>

        <div class="preview-content" id="previewArea">
            <!-- Simulated Sample Pages for Preview -->
            <div id="page1" class="page-view">
                <div style="text-align: center; margin-bottom: 25px;">
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="max-height: 240px; border-radius: 8px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.1); margin-bottom: 14px;">
                    <h2 style="font-size: 22px; color: var(--sp-burgundy, #0f766e); font-weight: 800; margin-bottom: 4px;">{{ $book->title }}</h2>
                    <p style="color: var(--sp-muted, #64748b); font-size: 14px;">{{ $book->author_name }}</p>
                </div>
                <p><strong>সূচনা:</strong></p>
                <p>{{ $book->summary }}</p>
            </div>

            <div id="page2" class="page-view" style="display: none;">
                <h3 style="color: var(--sp-burgundy, #0f766e); margin-bottom: 15px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 8px; font-weight: 800;">প্রথম অধ্যায়: ভাবনার নতুন দিগন্ত</h3>
                <p>জীবনের প্রতিটি বাঁকে মানুষ এক একটি সত্যের মুখোমুখি হয়। কখনো সেই সত্য তাকে থামিয়ে দেয়, কখনো বা নতুন উদ্যমে পথচলার প্রেরণা জোগায়। যে ব্যক্তি নিজের চিন্তাকে আলোকিত করতে পারে, তার জন্য কোনো অন্ধকারই স্থায়ী হতে পারে না।</p>
                <p>বই হলো সেই আলোকবর্তিকা, যা আমাদের মনের চোখকে খুলে দেয় এবং পৃথিবীর ক্ষণস্থায়ী কোলাহল পেরিয়ে অনন্ত সৌন্দর্যের দিকে আহ্বান জানায়।</p>
            </div>

            <div id="page3" class="page-view" style="display: none;">
                <h3 style="color: var(--sp-burgundy, #0f766e); margin-bottom: 15px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 8px; font-weight: 800;">আত্মশুদ্ধি ও প্রশান্তির সন্ধান</h3>
                <p>আমরা প্রতিনিয়ত বাইরের জগতের সংস্কারে ব্যস্ত, কিন্তু আমাদের অন্তর্জগত যে অবহেলায় খাঁ খাঁ করছে—সে খবর কি আমরা রাখি? একটি সুন্দর জীবনের গোড়াপত্তন হয় মনের গভীর থেকে। লোভ, অহংকার আর সংকীর্ণতা দূর না হলে আত্মিক প্রশান্তি কোনোদিন মিলবে না।</p>
                <p>এই বইটি আপনাকে সেই হারিয়ে যাওয়া প্রশান্তির পথ দেখাবে, যেখানে প্রতিটি নিঃশ্বাস হয়ে উঠবে অর্থবহ ও নির্মল।</p>
            </div>
        </div>

        <div class="preview-footer">
            <h3 style="font-size: 18px; color: var(--sp-burgundy, #0f766e); margin-bottom: 6px; font-weight: 800;">নমুনা পড়া শেষ হয়েছে!</h3>
            <p style="color: var(--sp-muted, #64748b); font-size: 14px; margin-bottom: 18px;">বাকি অধ্যায়গুলো পড়তে এখনই সংগ্রহ করুন হার্ডকপি কিংবা সরাসরি উপভোগ করুন ডিজিটাল ই-বুক।</p>
            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="format" value="hardcopy">
                    <button type="submit" class="btn-preview-hardcopy">🛒 হার্ডকপি অর্ডার করুন (৳ {{ number_format($book->hardcopyEffectivePrice()) }})</button>
                </form>
                <form action="{{ route('cart.add') }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="format" value="ebook">
                    <input type="hidden" name="buy_now" value="1">
                    <button type="submit" class="btn-preview-ebook">⚡ ই-বুক কিনুন (৳ {{ number_format($book->ebookEffectivePrice()) }})</button>
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
