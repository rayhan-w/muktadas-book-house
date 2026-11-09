<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $book->title }} — অনলাইন ই-বুক রিডার | মুক্তাদার বইঘর</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* Security: Disable copy and text selection */
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: #1e293b;
            color: #f1f5f9;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Anti-Print Protection */
        @media print {
            body { display: none !important; }
        }

        /* Reader Topbar */
        .reader-topbar {
            background: #0f172a;
            border-bottom: 1px solid #334155;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
        }

        .reader-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .reader-title small {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 400;
        }

        .reader-tools {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tool-btn {
            background: #1e293b;
            border: 1px solid #334155;
            color: #e2e8f0;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .tool-btn:hover { background: #334155; }

        /* Reading Stage */
        .reader-viewport {
            flex: 1;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            padding: 30px 15px;
            position: relative;
            background: #0f172a;
        }

        /* Paper sheet */
        .reader-paper {
            background: #ffffff;
            color: #1e293b;
            width: 100%;
            max-width: 780px;
            min-height: 900px;
            padding: 50px 45px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative;
            line-height: 2;
            font-size: 17px;
            transition: font-size 0.2s, background 0.3s, color 0.3s;
        }

        /* Dark Mode Theme */
        body.dark-mode .reader-paper {
            background: #1e293b;
            color: #e2e8f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.9);
        }

        /* Dynamic Security Watermark */
        .watermark-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            align-content: space-around;
            justify-content: space-around;
            opacity: 0.12;
            z-index: 10;
        }

        .watermark-text {
            transform: rotate(-25deg);
            font-size: 15px;
            font-weight: 700;
            color: #000;
            margin: 40px;
            white-space: nowrap;
        }

        body.dark-mode .watermark-text {
            color: #fff;
        }

        /* Reader Bottom Navigation */
        .reader-footer {
            background: #0f172a;
            border-top: 1px solid #334155;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
        }

        .page-counter {
            font-size: 14px;
            font-weight: 600;
            color: #cbd5e1;
        }

        .save-status {
            font-size: 12px;
            color: #10b981;
            display: none;
        }
    </style>
</head>
<body oncontextmenu="return false;">

    <!-- Topbar -->
    <header class="reader-topbar">
        <div class="reader-title">
            <a href="{{ route('reader.library') }}" style="color: #fbbf24; text-decoration: none; font-size: 18px;">← লাইব্রেরি</a>
            <span>{{ $book->title }}</span>
            <small>লেখক: {{ $book->author_name }}</small>
        </div>

        <div class="reader-tools">
            <button class="tool-btn" onclick="adjustFont(-1)" title="ফন্ট ছোট করুন">A-</button>
            <button class="tool-btn" onclick="adjustFont(1)" title="ফন্ট বড় করুন">A+</button>
            <button class="tool-btn" onclick="toggleDarkMode()" title="নাইট মোড">🌙 মোড</button>
            <button class="tool-btn" onclick="toggleFullScreen()" title="ফুলস্ক্রিন">⛶ ফুলস্ক্রিন</button>
        </div>
    </header>

    <!-- Reader Paper Sheet -->
    <main class="reader-viewport" id="viewport">
        <div class="reader-paper" id="paper">
            <!-- Dynamic Watermark across entire book sheet -->
            <div class="watermark-overlay">
                @for($w = 0; $w < 8; $w++)
                    <div class="watermark-text">
                        মুক্তাদার বইঘর | পাঠক: {{ $user->name }} ({{ $user->phone ?? $user->email }})
                    </div>
                @endfor
            </div>

            <!-- Page Content -->
            <div id="bookContent">
                <div style="text-align: center; margin-bottom: 40px; border-bottom: 2px solid #e2e8f0; padding-bottom: 25px;">
                    <h1 style="font-size: 28px; margin-bottom: 8px;">{{ $book->title }}</h1>
                    <p style="color: #64748b;">{{ $book->author_name }}</p>
                    <small style="color: #10b981; font-weight: 700; display: block; margin-top: 5px;">✓ লাইসেন্সপ্রাপ্ত ডিজিটাল সংস্করণ</small>
                </div>

                <div id="dynamicPageContent">
                    <!-- Text changes according to active page -->
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Page Navigation -->
    <footer class="reader-footer">
        <button class="tool-btn" onclick="navigatePage(-1)" id="btnPrev">← আগের পৃষ্ঠা</button>
        
        <div style="display: flex; align-items: center; gap: 10px;">
            <span class="page-counter">
                পৃষ্ঠা <strong id="lblCurrentPage">{{ $lastReadPage }}</strong> / <span id="lblTotalPages">50</span>
            </span>
            <span class="save-status" id="saveStatus">✓ সেভ হয়েছে</span>
        </div>

        <button class="tool-btn" onclick="navigatePage(1)" id="btnNext">পরের পৃষ্ঠা →</button>
    </footer>

    <script>
        let curPage = {{ $lastReadPage }};
        const totalPages = {{ $book->page_count ?: 50 }};
        let fontSize = 17;

        const pagesData = [
            `<h3>প্রথম অধ্যায়: আত্মিক প্রশান্তির সূচনা</h3>
            <p>মানুষ জন্মগতভাবেই শান্তি ও সুখের কাঙাল। কিন্তু সেই কাঙ্ক্ষিত শান্তির সন্ধানে মানুষ যে পথে পা বাড়ায়, তা অনেক সময়ই তাকে নিয়ে যায় এক অন্তহীন মরুভূমির দিকে। পার্থিব সম্পদ, খ্যাতি আর প্রাচুর্যের চাকচিক্য মানুষকে হয়তো ক্ষণিকের জন্য আনন্দ দিতে পারে, কিন্তু তা হৃদয়ের গভীরে চিরস্থায়ী প্রশান্তির পরশ বুলাতে পারে না।</p>
            <p>প্রকৃত প্রশান্তি নিহিত রয়েছে মনের ভেতরের পবিত্রতা ও সঠিক জীবনবোধের মধ্যে। যখন কোনো মানুষ বুঝতে পারে তার সৃষ্টি ও বেঁচে থাকার আসল উদ্দেশ্য, তখন তার চারপাশের ক্ষুদ্র দুঃখ-কষ্টগুলো অর্থহীন হয়ে পড়ে।</p>`,
            
            `<h3>দ্বিতীয় অধ্যায়: ভাবনার রূপান্তর</h3>
            <p>আমাদের জীবন অনেকটাই আমাদের চিন্তার প্রতিফলন। আমরা যা ভাবি, আমাদের কাজগুলো ঠিক সেভাবেই রূপ নেয়। নেতিবাচক চিন্তা মানুষকে ভেঙে দেয়, অন্যদিকে আশাবাদী ও গভীর চেতনা মানুষকে সবচেয়ে অন্ধকার পথ থেকেও আলোর সন্ধান দেয়।</p>
            <p>জ্ঞানী মানুষেরা কখনোই পরিস্থিতিকে দোষারোপ করে বসে থাকেন না। তারা নিজেদের বদলানোর মাধ্যমে প্রতিকূল পরিস্থিতিকে জয় করার সাহস দেখান। সত্য ও সুন্দরের পথে পথচলা তখনই সহজ হয়, যখন নিজের মনের লাগাম নিজের হাতে থাকে।</p>`,

            `<h3>তৃতীয় অধ্যায়: জীবনের গভীরতম উপলব্ধি</h3>
            <p>এই পৃথিবীতে আমরা সবাই একজন মুসাফিরের মতো। ক্ষণিকের এই যাত্রায় কী পেলাম আর কী হারালাম—সেই হিসেবের চেয়েও বড় বিষয় হলো আমরা অপরের জন্য কী রেখে গেলাম। যে মানুষ মানুষের কল্যাণে নিজেকে বিলিয়ে দেয়, সেই মানুষ কখনো মরে না। তার কর্ম ও চিন্তা প্রজন্মের পর প্রজন্ম বেঁচে থাকে।</p>
            <p>সুন্দর জীবন গড়ার প্রথম শর্ত হলো অহংকার পরিত্যাগ করা। সরলতা ও সততার চেয়ে বড় কোনো ভূষণ মানুষের হতে পারে না।</p>`
        ];

        function renderPage() {
            const container = document.getElementById('dynamicPageContent');
            const contentIndex = (curPage - 1) % pagesData.length;
            container.innerHTML = pagesData[contentIndex] + `
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px dashed #cbd5e1; font-size: 13px; color: #64748b; text-align: center;">
                    — পৃষ্ঠা ${curPage} সমাপ্ত —
                </div>
            `;
            document.getElementById('lblCurrentPage').innerText = curPage;
            document.getElementById('btnPrev').disabled = (curPage <= 1);
            document.getElementById('btnNext').disabled = (curPage >= totalPages);

            // Auto-scroll to top
            document.getElementById('viewport').scrollTop = 0;

            // Save reading progress to database via AJAX
            saveProgress(curPage);
        }

        function navigatePage(direction) {
            const target = curPage + direction;
            if (target >= 1 && target <= totalPages) {
                curPage = target;
                renderPage();
            }
        }

        function saveProgress(page) {
            fetch("{{ route('books.progress', $book->slug) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ page: page })
            }).then(res => res.json()).then(data => {
                const el = document.getElementById('saveStatus');
                el.style.display = 'inline';
                setTimeout(() => el.style.display = 'none', 1500);
            }).catch(() => {});
        }

        function adjustFont(delta) {
            fontSize = Math.min(26, Math.max(14, fontSize + delta));
            document.getElementById('paper').style.fontSize = fontSize + 'px';
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(() => {});
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        // Initialize page
        renderPage();

        // Keyboard arrow navigation
        window.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') navigatePage(1);
            if (e.key === 'ArrowLeft') navigatePage(-1);
        });
    </script>
</body>
</html>
