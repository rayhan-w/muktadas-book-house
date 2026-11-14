@extends('layouts.publisher')

@section('title', 'আমার বইসমূহ | পাবলিশার ড্যাশবোর্ড')
@section('page_title', 'আমার জমাকৃত বইসমূহ')

@section('content')

    <div class="pub-card">
        <div class="card-header">
            <div>
                <h2>প্রকাশিত ও জমাকৃত বই</h2>
                <p style="font-size: 13px; color: #64748b; margin-top: 2px;">আপনার জমা দেওয়া সকল বইয়ের স্ট্যাটাস এবং বিবরণ এখানে দেখতে পারবেন।</p>
            </div>
            @if($user->isApprovedPublisher())
                <a href="{{ route('publisher.books.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <i class="bi bi-plus-circle"></i> নতুন বই জমা দিন
                </a>
            @endif
        </div>

        <!-- Filter Tabs & Search -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('publisher.books.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-gray' }}">
                    সকল বই ({{ $counts['all'] }})
                </a>
                <a href="{{ route('publisher.books.index', ['status' => 'approved']) }}" class="btn btn-sm {{ request('status') === 'approved' ? 'btn-success' : 'btn-gray' }}">
                    <i class="bi bi-check-circle-fill"></i> অনুমোদিত ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('publisher.books.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-gray' }}">
                    <i class="bi bi-hourglass-split"></i> পর্যালোচনায় ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('publisher.books.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-gray' }}">
                    <i class="bi bi-x-circle-fill"></i> বাতিল ({{ $counts['rejected'] }})
                </a>
            </div>

            <form action="{{ route('publisher.books.index') }}" method="GET" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="বই বা লেখক খুঁজুন..." class="form-control" style="width: 220px; padding: 6px 12px; font-size: 13px;">
                <button type="submit" class="btn btn-sm btn-gray">খুঁজুন</button>
            </form>
        </div>

        @if($books->count() > 0)
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">কভার</th>
                            <th>বইয়ের নাম ও ক্যাটাগরি</th>
                            <th>লেখক</th>
                            <th>মূল্য ও স্টক</th>
                            <th>অনুমোদন স্ট্যাটাস</th>
                            <th>জমার তারিখ</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td>
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 44px; height: 60px; object-fit: cover; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                </td>
                                <td>
                                    <strong style="color: #0f172a; display: block; font-size: 14.5px;">{{ $book->title }}</strong>
                                    <div style="margin-top: 3px;">
                                        @foreach($book->categories as $c)
                                            <span style="background: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-size: 11px; margin-right: 3px;">{{ $c->name }}</span>
                                        @endforeach
                                    </div>
                                    @if($book->publication_year)
                                        <small style="color: #64748b; font-size: 11.5px;">প্রকাশ: {{ $book->publication_year }}</small>
                                    @endif
                                </td>
                                <td>{{ $book->author_name }}</td>
                                <td>
                                    <div><strong>হার্ডকপি:</strong> ৳{{ number_format($book->price_hardcopy, 0) }}</div>
                                    <div style="font-size: 12px; color: #64748b;"><strong>ই-বুক:</strong> ৳{{ number_format($book->price_ebook, 0) }}</div>
                                    <div style="font-size: 11.5px; color: {{ $book->stock_quantity > 0 ? '#16a34a' : '#dc2626' }};">
                                        স্টক: {{ $book->stock_quantity }} কপি
                                    </div>
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
                                            <i class="bi bi-hourglass-split"></i> অপেক্ষমাণ (পর্যালোচনাধীন)
                                        </span>
                                    @else
                                        <span class="status-badge status-rejected" style="display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-x-circle-fill"></i> বাতিল
                                        </span>
                                        @if($book->rejection_reason)
                                            <div style="font-size: 12px; color: #dc2626; margin-top: 4px; background: #fee2e2; padding: 4px 8px; border-radius: 6px; max-width: 250px;">
                                                <strong>কারণ:</strong> {{ $book->rejection_reason }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 13px;">{{ $book->created_at->format('d M, Y') }}</div>
                                    <small style="color: #64748b; font-size: 11px;">{{ $book->created_at->format('h:i A') }}</small>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        @if($book->approval_status === 'approved' && $user->isApprovedPublisher())
                                            <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn btn-sm btn-gray" title="ওয়েবসাইটে দেখুন" style="display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="bi bi-eye"></i> দেখুন
                                            </a>
                                        @endif

                                        <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn btn-sm btn-gray" title="সম্পাদনা করুন" style="display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-pencil-square"></i> এডিট
                                        </a>

                                        @if($book->approval_status !== 'approved')
                                            <form action="{{ route('publisher.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই বইটি মুছে ফেলতে চান?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-gray" style="color: #dc2626;" title="মুছে ফেলুন">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
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
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <div style="font-size: 44px; margin-bottom: 12px; color: #94a3b8;"><i class="bi bi-book"></i></div>
                <h3 style="font-size: 16px; font-weight: 700; color: #334155;">কোনো বই পাওয়া যায়নি</h3>
                <p style="font-size: 13.5px; margin: 6px 0 16px;">আপনি এখনও এই বিভাগে কোনো বই জমা দেননি অথবা সার্চে কোনো ফলাফল মেলেনি।</p>
                @if($user->isApprovedPublisher())
                    <a href="{{ route('publisher.books.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                        <i class="bi bi-plus-circle"></i> নতুন বই জমা দিন
                    </a>
                @endif
            </div>
        @endif
    </div>

@endsection
