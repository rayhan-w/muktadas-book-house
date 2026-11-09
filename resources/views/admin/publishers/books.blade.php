@extends('layouts.admin')

@section('title', 'প্রকাশকদের বই অনুমোদন | অ্যাডমিন প্যানেল')
@section('page_title', 'প্রকাশকদের জমাকৃত বইসমূহ')

@section('content')

    <!-- Policy Banner -->
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; font-size: 13.5px; color: #1e40af; line-height: 1.6;">
        🛡️ <strong>কন্টেন্ট নিরাপত্তা ও অনুমোদন ব্যবস্থা:</strong> কোনো প্রকাশক নতুন বই জমা দিলে অথবা <em>ইতিমধ্যে লাইভ থাকা কোনো বই সম্পাদনা (Edit) করলে</em> তা স্বয়ংক্রিয়ভাবে সাময়িকভাবে অপ্রকাশিত হয়ে এই তালিকায় <strong>"অপেক্ষমাণ (Pending)"</strong> হিসেবে জমা হয়। আপনি যাচাই করে "অনুমোদন করুন" বাটনে ক্লিক করলে তা সরাসরি ওয়েবসাইটে পাঠকদের জন্য প্রকাশিত হবে।
    </div>

    <div class="admin-card">
        <div class="card-header">
            <div>
                <h2>প্রকাশকদের জমাকৃত সকল বই</h2>
                <p style="font-size: 13px; color: var(--admin-muted); margin-top: 3px;">
                    বইয়ের তথ্যাদি, কভার এবং মূল্য যাচাই করে অনুমোদন বা বাতিল করুন।
                </p>
            </div>
        </div>

        <!-- Filter Tabs & Search -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 14px;">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.publishers.books') }}" class="btn-sm {{ !request('status') ? 'btn-primary' : 'btn-gray' }}" style="text-decoration: none;">
                    সকল বই ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.publishers.books', ['status' => 'pending']) }}" class="btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-gray' }}" style="text-decoration: none;">
                    ⏳ অপেক্ষমাণ ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.publishers.books', ['status' => 'approved']) }}" class="btn-sm {{ request('status') === 'approved' ? 'btn-primary' : 'btn-gray' }}" style="text-decoration: none;">
                    ✓ অনুমোদিত ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.publishers.books', ['status' => 'rejected']) }}" class="btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-gray' }}" style="text-decoration: none;">
                    ✕ বাতিলকৃত ({{ $counts['rejected'] }})
                </a>
            </div>

            <form action="{{ route('admin.publishers.books') }}" method="GET" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="বই, লেখক বা প্রকাশনী..." class="form-control" style="width: 240px; padding: 6px 12px; font-size: 13px;">
                <button type="submit" class="btn-sm btn-gray">খুঁজুন</button>
            </form>
        </div>

        @if($books->count() > 0)
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">কভার</th>
                            <th>বইয়ের নাম ও তথ্য</th>
                            <th>প্রকাশক / প্রকাশনী</th>
                            <th>মূল্য ও স্টক</th>
                            <th>অনুমোদন স্ট্যাটাস</th>
                            <th>তারিখ</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td>
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 46px; height: 64px; object-fit: cover; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.15);">
                                </td>
                                <td>
                                    <strong style="color: var(--admin-dark); font-size: 15px; display: block;">
                                        {{ $book->title }}
                                    </strong>
                                    <div style="font-size: 13px; color: var(--admin-muted);">লেখক: {{ $book->author_name }}</div>
                                    <div style="margin-top: 4px;">
                                        @foreach($book->categories as $c)
                                            <span style="background: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-size: 11px;">{{ $c->name }}</span>
                                        @endforeach
                                    </div>
                                    @if($book->summary)
                                        <div style="font-size: 12px; color: #64748b; margin-top: 4px; max-width: 280px;" title="{{ $book->summary }}">
                                            {{ Str::limit($book->summary, 75) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: #0f172a; display: block; font-size: 14px;">
                                        🏢 {{ $book->publisher_name ?: ($book->user?->publisher_company ?: $book->user?->name) }}
                                    </strong>
                                    <small style="color: var(--admin-muted); display: block;">
                                        {{ $book->user?->email }}
                                    </small>
                                    <small style="color: var(--admin-muted); display: block;">
                                        {{ $book->user?->phone }}
                                    </small>
                                </td>
                                <td>
                                    <div>হার্ডকপি: <strong>৳{{ number_format($book->price_hardcopy, 0) }}</strong></div>
                                    <div style="font-size: 12px; color: var(--admin-muted);">ই-বুক: ৳{{ number_format($book->price_ebook, 0) }}</div>
                                    <div style="font-size: 11.5px; color: #16a34a;">স্টক: {{ $book->stock_quantity }} কপি</div>
                                    @if($book->ebook_file)
                                        <div style="font-size: 11px; color: #2563eb; margin-top: 3px;">
                                            <a href="{{ asset($book->ebook_file) }}" target="_blank" style="color: inherit; text-decoration: underline;">📄 PDF প্রিভিউ</a>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($book->approval_status === 'approved')
                                        <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-block;">
                                            ✓ অনুমোদিত (লাইভ)
                                        </span>
                                    @elseif($book->approval_status === 'pending')
                                        <span style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-block;">
                                            ⏳ পর্যালোচনার জন্য অপেক্ষমাণ
                                        </span>
                                    @else
                                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-block;">
                                            ✕ বাতিলকৃত
                                        </span>
                                        @if($book->rejection_reason)
                                            <div style="font-size: 11.5px; color: #dc2626; margin-top: 4px; background: #fee2e2; padding: 4px 8px; border-radius: 6px; max-width: 220px;">
                                                কারণ: {{ $book->rejection_reason }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 13px;">{{ $book->updated_at->format('d M, Y') }}</div>
                                    <small style="color: var(--admin-muted);">{{ $book->updated_at->format('h:i A') }}</small>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn-sm btn-gray" title="প্রিভিউ দেখুন">
                                            👁️
                                        </a>

                                        @if($book->approval_status !== 'approved')
                                            <form action="{{ route('admin.publishers.books.approve', $book->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-sm btn-primary" onclick="return confirm('আপনি কি এই বইটি অনুমোদন করে ওয়েবসাইটে প্রকাশ করতে চান?');">
                                                    ✓ অনুমোদন করুন
                                                </button>
                                            </form>
                                        @endif

                                        @if($book->approval_status !== 'rejected')
                                            <button type="button" class="btn-sm btn-gray" style="color: #dc2626;" onclick="openRejectBookModal({{ $book->id }}, '{{ addslashes($book->title) }}');">
                                                ✕ বাতিল
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $books->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: var(--admin-muted);">
                <div style="font-size: 40px; margin-bottom: 10px;">📖</div>
                <h3>প্রকাশকদের কোনো বই পাওয়া যায়নি</h3>
            </div>
        @endif
    </div>

    <!-- Book Rejection Modal -->
    <div id="rejectBookModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 450px; max-width: 90%; border-radius: 12px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                বইয়ের আবেদন বাতিলকরণ
            </h3>
            <p id="modalBookTitle" style="font-size: 13.5px; color: #64748b; margin-bottom: 16px;"></p>

            <form id="rejectBookForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        বাতিলের কারণ লিখুন (প্রকাশক তার ড্যাশবোর্ডে দেখতে পাবেন) <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="rejection_reason" required rows="3" class="form-control" placeholder="যেমন: কভারের কোয়ালিটি ঠিক নেই বা মূল্য সংক্রান্ত তথ্যে অসঙ্গতি রয়েছে..." style="width: 100%; box-sizing: border-box;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-sm btn-gray" onclick="closeRejectBookModal();">ফিরে যান</button>
                    <button type="submit" class="btn-sm btn-danger">নিশ্চিত বাতিল করুন</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openRejectBookModal(id, title) {
        document.getElementById('modalBookTitle').innerText = 'বইয়ের শিরোনাম: ' + title;
        document.getElementById('rejectBookForm').action = '/admin/publisher-books/' + id + '/reject';
        document.getElementById('rejectBookModal').style.display = 'flex';
    }

    function closeRejectBookModal() {
        document.getElementById('rejectBookModal').style.display = 'none';
    }
</script>
@endsection
