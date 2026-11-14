@extends('layouts.publisher')

@section('title', 'পাবলিশার ড্যাশবোর্ড | মুক্তাদার বইঘর')
@section('page_title', 'ড্যাশবোর্ড ওভারভিউ')

@section('content')

@php
    $rawPhone = \App\Models\SiteSetting::get('contact_whatsapp') ?: \App\Models\SiteSetting::get('contact_phone', '01700112233');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (str_starts_with($cleanPhone, '01')) {
        $cleanPhone = '88' . $cleanPhone;
    }
    $companyName = $user->publisher_company ?: $user->name;
    $waTextPending = urlencode("আসসালামু আলাইকুম। আমি '{$companyName}' প্রকাশনী থেকে বলছি। আমরা মুক্তাদার বইঘরে প্রকাশক হিসেবে আবেদন করেছি। আমাদের অনুমোদন ও মেয়াদের চুক্তি সম্পর্কে কথা বলতে চাই।");
    $waTextExpired = urlencode("আসসালামু আলাইকুম। আমি '{$companyName}' প্রকাশনী থেকে বলছি। মুক্তাদার বইঘরে আমাদের প্রকাশনীর সাবস্ক্রিপশন মেয়াদ শেষ হয়েছে। মেয়াদ নবায়ন করার জন্য কথা বলতে চাই।");
@endphp

    <!-- Account Status Alert -->
    @if($user->isExpiredPublisher())
        <div class="alert alert-error" style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 14px; background: #fff1f2; border: 1px solid #fecdd3; border-left: 5px solid #e11d48; border-radius: 12px; padding: 18px 22px;">
            <div style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="font-size: 26px; color: #e11d48;"><i class="bi bi-clock-history"></i></div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #9f1239; margin-bottom: 4px;">
                        আপনার প্রকাশনীর সাবস্ক্রিপশন মেয়াদের সমাপ্তি ঘটেছে
                    </h3>
                    <p style="font-size: 13.5px; color: #881337; margin: 0; line-height: 1.6;">
                        আপনার নির্ধারিত মেয়াদ ছিল: <strong>{{ $user->publisher_plan }}</strong> (মেয়াদ শেষ: {{ $user->publisher_expires_at ? $user->publisher_expires_at->format('d M, Y') : 'নির্দিষ্ট নয়' }})।<br>
                        <strong>নিরাপত্তা ও পলিসি নোটিশ:</strong> মেয়াদ উত্তীর্ণ হওয়ায় আপনার প্রকাশনীর সকল বই ওয়েবসাইট থেকে <em>সাময়িকভাবে লুকানো (Unpublished)</em> রাখা হয়েছে। আপনার সকল বই ও তথ্য ডাটাবেজে সম্পূর্ণ নিরাপদ রয়েছে। পুনরায় সাবস্ক্রিপশন নবায়ন করলে সকল বই স্বয়ংক্রিয়ভাবে আবার লাইভ হয়ে যাবে।
                    </p>
                </div>
            </div>
            <div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waTextExpired }}" target="_blank" class="btn btn-sm" style="background: #25d366; color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37,211,102,0.3); padding: 9px 16px; border-radius: 8px; white-space: nowrap;">
                    <i class="bi bi-whatsapp" style="font-size: 17px;"></i> হোয়াটসঅ্যাপে মেয়াদ নবায়ন করুন
                </a>
            </div>
        </div>
    @elseif($user->isApprovedPublisher())
        <div class="alert alert-success" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 5px solid #16a34a; border-radius: 12px; padding: 18px 22px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="font-size: 24px; color: #16a34a;"><i class="bi bi-patch-check-fill"></i></div>
                <div>
                    <h3 style="font-size: 15.5px; font-weight: 700; color: #166534; margin-bottom: 3px;">
                        আপনার প্রকাশনী অ্যাকাউন্টটি সক্রিয় ও অনুমোদিত
                    </h3>
                    <p style="font-size: 13.5px; color: #14532d; margin: 0;">
                        প্যাকেজ: <strong>{{ $user->publisher_plan ?: '১ বছর' }}</strong>
                        @if($user->publisher_expires_at)
                            | মেয়াদ শেষ হবে: <strong>{{ $user->publisher_expires_at->format('d M, Y') }}</strong>
                            @php
                                $daysLeft = (int) now()->diffInDays($user->publisher_expires_at, false);
                            @endphp
                            <span class="badge" style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 999px; font-size: 11.5px; margin-left: 6px; font-weight: 700;">
                                আর {{ max(0, $daysLeft) }} দিন বাকি
                            </span>
                        @else
                            <span class="badge" style="background: #e0e7ff; color: #3730a3; padding: 2px 8px; border-radius: 999px; font-size: 11.5px; margin-left: 6px; font-weight: 700;">
                                আজীবন লাইফটাইম
                            </span>
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('publisher.books.create') }}" class="btn btn-sm btn-primary" style="white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
                <i class="bi bi-plus-circle"></i> নতুন বই জমা দিন
            </a>
        </div>
    @elseif($user->isPendingPublisher())
        <div class="alert alert-warning" style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 16px; background: #fffbeb; border: 1px solid #fde68a; border-left: 5px solid #d97706; border-radius: 12px; padding: 18px 22px;">
            <div style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="font-size: 24px; color: #d97706;"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <h3 style="font-size: 15.5px; font-weight: 700; color: #92400e; margin-bottom: 4px;">
                        আপনার প্রকাশনী অ্যাকাউন্টটি পর্যালোচনার জন্য অপেক্ষমাণ রয়েছে
                    </h3>
                    <p style="margin: 0; font-size: 13.5px; color: #78350f; line-height: 1.6;">
                        আমাদের অ্যাডমিন টিম আপনার তথ্য পর্যালোচনা করছে। প্রকাশকদের জন্য অনলাইনে কোনো অগ্রিম ফি দিতে হয় না। অ্যাডমিনের সাথে আলোচনা করে মেয়াদের মেয়াদ (১ মাস, ৬ মাস, ১ বছর বা আজীবন) ও চুক্তি চূড়ান্ত করতে পারেন।
                    </p>
                </div>
            </div>
            <div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waTextPending }}" target="_blank" class="btn btn-sm" style="background: #25d366; color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37,211,102,0.3); padding: 9px 16px; border-radius: 8px; white-space: nowrap;">
                    <i class="bi bi-whatsapp" style="font-size: 17px;"></i> অ্যাডমিনের সাথে হোয়াটসঅ্যাপে আলাপ করুন
                </a>
            </div>
        </div>
    @elseif($user->isRejectedPublisher())
        <div class="alert alert-error" style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 16px; background: #fef2f2; border: 1px solid #fecaca; border-left: 5px solid #dc2626; border-radius: 12px; padding: 18px 22px;">
            <div style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="font-size: 24px; color: #dc2626;"><i class="bi bi-x-circle-fill"></i></div>
                <div>
                    <h3 style="font-size: 15.5px; font-weight: 700; color: #991b1b; margin-bottom: 4px;">
                        আপনার প্রকাশনী অ্যাকাউন্টটি অনুমোদন করা সম্ভব হয়নি
                    </h3>
                    @if($user->publisher_rejection_reason)
                        <p style="margin: 4px 0 0; font-size: 13.5px; color: #7f1d1d;">
                            <strong>বাতিলকরণের কারণ:</strong> {{ $user->publisher_rejection_reason }}
                        </p>
                    @endif
                </div>
            </div>
            <div>
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('আসসালামু আলাইকুম। আমার প্রকাশনী আবেদনটি বাতিল হয়েছে। এ বিষয়ে সহযোগিতা চাই।') }}" target="_blank" class="btn btn-sm" style="background: #25d366; color: #fff; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border-radius: 8px; white-space: nowrap;">
                    <i class="bi bi-whatsapp"></i> অ্যাডমিন সহায়তা নিন
                </a>
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
            <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">
                <i class="bi bi-book"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #16a34a;">{{ $approvedBooks }}</div>
                <div class="stat-label">অনুমোদিত বই</div>
            </div>
            <div class="stat-icon" style="background: #dcfce7; color: #16a34a;">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #d97706;">{{ $pendingBooks }}</div>
                <div class="stat-label">অপেক্ষমাণ (পর্যালোচনাধীন)</div>
            </div>
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>

        <div class="stat-card">
            <div>
                <div class="stat-val" style="color: #dc2626;">{{ $rejectedBooks }}</div>
                <div class="stat-label">বাতিলকৃত বই</div>
            </div>
            <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">
                <i class="bi bi-x-octagon"></i>
            </div>
        </div>
    </div>

    <!-- Security & Policy Warning Box -->
    <div class="pub-card" style="background: #f8fafc; border-left: 4px solid #0284c7; margin-bottom: 24px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-shield-lock-fill" style="color: #0284c7;"></i> বই জমা ও সম্পাদনার নিরাপত্তা নীতিমালা
        </h3>
        <ul style="font-size: 13.5px; color: #475569; line-height: 1.7; padding-left: 20px; margin: 0;">
            <li><strong>নতুন বই জমা:</strong> আপনি নতুন কোনো বই জমা দিলে তা সরাসরি ওয়েবসাইটে দেখা যাবে না। আমাদের অ্যাডমিন টিম যাচাই ও অনুমোদন দেওয়ার পরেই তা লাইভ হবে।</li>
            <li><strong>অনুমোদিত বই সম্পাদনা (Strict Re-moderation Policy):</strong> ইতিমধ্যে অনুমোদিত এবং ওয়েবসাইটে লাইভ থাকা কোনো বই আপনি সম্পাদনা (Edit) করলে কন্টেন্টের সুরক্ষা রক্ষায় <em>বইটি তাৎক্ষণিকভাবে সাময়িকভাবে অফলাইনে চলে যাবে</em> এবং অ্যাডমিনের পুনঃঅনুমোদনের জন্য পেন্ডিং থাকবে। অ্যাডমিন রি-অ্যাপ্রুভ করলেই তা আবার লাইভ হবে।</li>
            <li><strong>সাবস্ক্রিপশন মেয়াদ:</strong> আপনার প্রকাশনীর সাবস্ক্রিপশন মেয়াদ সক্রিয় থাকা পর্যন্তই বইগুলো পাঠকদের কাছে প্রদর্শিত হবে। মেয়াদ শেষ হলে বইগুলো স্বয়ংক্রিয়ভাবে আনপাবলিশ হয়ে যাবে এবং নবায়ন করলে পুনরায় লাইভ হবে।</li>
        </ul>
    </div>

    <!-- Recent Books Table -->
    <div class="pub-card">
        <div class="card-header">
            <h2 style="display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-collection-fill" style="color: #0284c7;"></i> সাম্প্রতিক জমাকৃত বইসমূহ
            </h2>
            @if($user->isApprovedPublisher())
                <a href="{{ route('publisher.books.create') }}" class="btn btn-sm btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-plus-circle"></i> নতুন বই জমা দিন
                </a>
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
                                    @if($user->isExpiredPublisher())
                                        <span class="status-badge" style="background:#fee2e2; color:#991b1b; padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 700;">
                                            <i class="bi bi-eye-slash-fill"></i> মেয়াদের কারণে অফলাইন
                                        </span>
                                    @elseif($book->approval_status === 'approved')
                                        <span class="status-badge status-approved" style="display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-check-circle-fill"></i> অনুমোদিত ও লাইভ
                                        </span>
                                    @elseif($book->approval_status === 'pending')
                                        <span class="status-badge status-pending" style="display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-hourglass-split"></i> পর্যালোচনায় আছে
                                        </span>
                                    @else
                                        <span class="status-badge status-rejected" style="display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-x-circle-fill"></i> বাতিল
                                        </span>
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
                                        @if($book->approval_status === 'approved' && $user->isApprovedPublisher())
                                            <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn btn-sm btn-gray" title="ওয়েবসাইটে দেখুন">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn btn-sm btn-gray" title="সম্পাদনা">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="text-align: center; margin-top: 18px;">
                <a href="{{ route('publisher.books.index') }}" style="color: #0284c7; font-weight: 700; text-decoration: none; font-size: 14px;">
                    সকল বই দেখুন ({{ $totalBooks }}টি) →
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px; color: #64748b;">
                <div style="font-size: 40px; margin-bottom: 10px; color: #94a3b8;"><i class="bi bi-book"></i></div>
                <h3 style="font-size: 16px; font-weight: 700; color: #334155;">এখনও কোনো বই জমা দেননি</h3>
                <p style="font-size: 13.5px; margin: 6px 0 16px;">আপনার প্রকাশনীর নতুন বই জমা দিতে নিচের বাটনে ক্লিক করুন।</p>
                @if($user->isApprovedPublisher())
                    <a href="{{ route('publisher.books.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                        <i class="bi bi-plus-circle"></i> নতুন বই জমা দিন
                    </a>
                @elseif($user->isExpiredPublisher())
                    <span style="font-size: 13px; color: #dc2626; font-weight: 600;">(মেয়াদ নবায়নের পর নতুন বই যোগ করতে পারবেন)</span>
                @else
                    <span style="font-size: 13px; color: #d97706; font-weight: 600;">(অ্যাকাউন্ট অনুমোদনের পর বই যোগ করতে পারবেন)</span>
                @endif
            </div>
        @endif
    </div>

@endsection
