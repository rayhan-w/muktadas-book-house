@extends('layouts.publisher')

@section('title', 'পাবলিশার ড্যাশবোর্ড | মুক্তাদার বইঘর')
@section('page_title', 'ড্যাশবোর্ড ওভারভিউ')

@section('content')

    <!-- Account Status Alert -->
    @if($user->isApprovedPublisher())
        <div class="alert alert-success" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 14px;">
            <div>
                <span style="font-size: 18px; margin-right: 6px;">🎉</span>
                <strong>অভিনন্দন!</strong> আপনার প্রকাশনী অ্যাকাউন্টটি সক্রিয় ও অনুমোদিত। আপনি এখন বই তালিকাভুক্ত করতে পারেন।
            </div>
            <a href="{{ route('publisher.books.create') }}" class="btn btn-sm btn-primary" style="white-space: nowrap;">+ নতুন বই জমা দিন</a>
        </div>
    @elseif($user->isPendingPublisher())
        <div class="alert alert-warning" style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="font-size: 22px;">⏳</div>
            <div>
                <strong style="font-size: 15px;">আপনার প্রকাশনী অ্যাকাউন্টটি পর্যালোচনার জন্য অপেক্ষমাণ রয়েছে</strong>
                <p style="margin: 4px 0 0; font-size: 13.5px; opacity: 0.95;">
                    আমাদের অ্যাডমিন টিম আপনার তথ্য যাচাই করছে। অনুমোদন সম্পন্ন হলে আপনার ড্যাশবোর্ডে নতুন বই যুক্ত করার অপশনটি স্বয়ংক্রিয়ভাবে চালু হয়ে যাবে। সাধারণত ২৪ ঘণ্টার মধ্যে অ্যাকাউন্ট যাচাই সম্পন্ন হয়।
                </p>
            </div>
        </div>
    @elseif($user->isRejectedPublisher())
        <div class="alert alert-error" style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="font-size: 22px;">✕</div>
            <div>
                <strong style="font-size: 15px;">আপনার প্রকাশনী অ্যাকাউন্টটি অনুমোদন করা সম্ভব হয়নি</strong>
                @if($user->publisher_rejection_reason)
                    <p style="margin: 4px 0 0; font-size: 13.5px;">
                        <strong>কারণ:</strong> {{ $user->publisher_rejection_reason }}
                    </p>
                @endif
                <p style="margin: 4px 0 0; font-size: 13px;">
                    প্রয়োজনে অ্যাডমিন টিমের সাথে যোগাযোগ করুন: <a href="mailto:contact@muktadasbookhouse.com" style="color: inherit; text-decoration: underline;">contact@muktadasbookhouse.com</a>
                </p>
            </div>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="grid-4" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div>
                <div class="stat-val">{{ $totalBooks }}</div>
                <div class="stat-label">মোট জমাকৃত বই</div>
            </div>
            <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">📚</div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #16a34a;">{{ $approvedBooks }}</div>
                <div class="stat-label">অনুমোদিত ও লাইভ বই</div>
            </div>
            <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">✓</div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #d97706;">{{ $pendingBooks }}</div>
                <div class="stat-label">অপেক্ষমাণ (পর্যালোচনাধীন)</div>
            </div>
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">⏳</div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #dc2626;">{{ $rejectedBooks }}</div>
                <div class="stat-label">বাতিলকৃত বই</div>
            </div>
            <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">✕</div>
        </div>
    </div>

    <!-- Security & Policy Warning Box -->
    <div class="pub-card" style="background: #f8fafc; border-left: 4px solid #0284c7;">
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
            <span>🛡️</span> বই জমা ও সম্পাদনার নিরাপত্তা নীতিমালা
        </h3>
        <ul style="font-size: 13.5px; color: #475569; line-height: 1.7; padding-left: 20px; margin: 0;">
            <li><strong>নতুন বই জমা:</strong> আপনি নতুন কোনো বই জমা দিলে তা সরাসরি ওয়েবসাইটে দেখা যাবে না। আমাদের অ্যাডমিন টিম যাচাই ও অনুমোদন দেওয়ার পরেই তা লাইভ হবে।</li>
            <li><strong>অনুমোদিত বই সম্পাদনা (Strict Re-approval Policy):</strong> ইতিমধ্যে অনুমোদিত এবং ওয়েবসাইটে লাইভ থাকা কোনো বই আপনি সম্পাদনা (Edit) করলে কন্টেন্টের সুরক্ষা রক্ষায় <em>বইটি তাৎক্ষণিকভাবে সাময়িকভাবে অফলাইনে চলে যাবে</em> এবং অ্যাডমিনের পুনঃঅনুমোদনের জন্য পেন্ডিং থাকবে। অ্যাডমিন রি-অ্যাপ্রুভ করলেই তা আবার লাইভ হবে।</li>
            <li><strong>সঠিক তথ্য:</strong> বইয়ের মূল্য, পৃষ্ঠা সংখ্যা, সারসংক্ষেপ ও কাভার ছবির সঠিক তথ্য প্রদান করুন।</li>
        </ul>
    </div>

    <!-- Recent Books Table -->
    <div class="pub-card">
        <div class="card-header">
            <h2>সাম্প্রতিক জমাকৃত বইসমূহ</h2>
            @if($user->isApprovedPublisher())
                <a href="{{ route('publisher.books.create') }}" class="btn btn-sm btn-primary">+ নতুন বই জমা দিন</a>
            @endif
        </div>

        @if($recentBooks->count() > 0)
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">কভার</th>
                            <th>বইয়ের নাম</th>
                            <th>লেখক</th>
                            <th>মূল্য</th>
                            <th>স্ট্যাটাস</th>
                            <th>জমার তারিখ</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBooks as $book)
                            <tr>
                                <td>
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 44px; height: 60px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                </td>
                                <td>
                                    <strong style="color: #0f172a; display: block; font-size: 14.5px;">{{ $book->title }}</strong>
                                    <small style="color: #64748b;">
                                        @foreach($book->categories as $c)
                                            <span style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-size: 11px;">{{ $c->name }}</span>
                                        @endforeach
                                    </small>
                                </td>
                                <td>{{ $book->author_name }}</td>
                                <td>
                                    <div>হার্ডকপি: ৳{{ number_format($book->price_hardcopy, 0) }}</div>
                                    <small style="color: #64748b;">ই-বুক: ৳{{ number_format($book->price_ebook, 0) }}</small>
                                </td>
                                <td>
                                    @if($book->approval_status === 'approved')
                                        <span class="status-badge status-approved">✓ অনুমোদিত ও লাইভ</span>
                                    @elseif($book->approval_status === 'pending')
                                        <span class="status-badge status-pending">⏳ পর্যালোচনায় আছে</span>
                                    @else
                                        <span class="status-badge status-rejected">✕ বাতিল</span>
                                        @if($book->rejection_reason)
                                            <div style="font-size: 11px; color: #dc2626; margin-top: 3px;">
                                                কারণ: {{ Str::limit($book->rejection_reason, 40) }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $book->created_at->format('d M, Y') }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        @if($book->approval_status === 'approved')
                                            <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn btn-sm btn-gray" title="ওয়েবসাইটে দেখুন">👁️</a>
                                        @endif
                                        <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn btn-sm btn-gray" title="সম্পাদনা">✏️</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="text-align: center; margin-top: 18px;">
                <a href="{{ route('publisher.books.index') }}" style="color: #0284c7; font-weight: 700; text-decoration: none; font-size: 14px;">সকল বই দেখুন ({{ $totalBooks }}টি) →</a>
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px; color: #64748b;">
                <div style="font-size: 40px; margin-bottom: 10px;">📖</div>
                <h3 style="font-size: 16px; font-weight: 700; color: #334155;">এখনও কোনো বই জমা দেননি</h3>
                <p style="font-size: 13.5px; margin: 6px 0 16px;">আপনার প্রকাশনীর নতুন বই জমা দিতে নিচের বাটনে ক্লিক করুন।</p>
                @if($user->isApprovedPublisher())
                    <a href="{{ route('publisher.books.create') }}" class="btn btn-primary">+ নতুন বই জমা দিন</a>
                @else
                    <span style="font-size: 13px; color: #d97706; font-weight: 600;">(অ্যাকাউন্ট অনুমোদনের পর বই যোগ করতে পারবেন)</span>
                @endif
            </div>
        @endif
    </div>

@endsection
