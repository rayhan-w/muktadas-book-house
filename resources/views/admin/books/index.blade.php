@extends('layouts.admin')

@section('title', 'বই ব্যবস্থাপনা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'বই ব্যবস্থাপনা')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>ক্যাটালগের সকল বই ({{ $books->total() }})</h2>
            <small style="color: var(--admin-muted);">বইয়ের দাম, প্রচ্ছদ, ই-বুক ফাইল, স্টক ও প্রিভিউ পাতা পরিবর্তন করুন।</small>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn-sm btn-blue">+ নতুন বই যুক্ত করুন</a>
    </div>

    <!-- Filter form -->
    <form method="GET" action="{{ route('admin.books.index') }}" style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="বইয়ের নাম দিয়ে খুঁজুন..." class="form-control" style="max-width: 300px;">
        <select name="category" class="form-control" style="max-width: 200px;">
            <option value="">সব ক্যাটাগরি</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-sm btn-gray">ফিল্টার</button>
        @if(request('q') || request('category'))
            <a href="{{ route('admin.books.index') }}" class="btn-sm btn-red">রিসেট</a>
        @endif
    </form>

    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>প্রচ্ছদ</th>
                    <th>বইয়ের নাম ও লেখক</th>
                    <th>ক্যাটাগরি</th>
                    <th>হার্ডকপি মূল্য</th>
                    <th>ই-বুক মূল্য</th>
                    <th>স্টক স্ট্যাটাস</th>
                    <th>প্রিভিউ</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 40px; height: 55px; object-fit: contain; border-radius: 4px; border: 1px solid var(--admin-border);">
                        </td>
                        <td>
                            <strong>{{ $book->title }}</strong>
                            <small style="display: block; color: var(--admin-muted);">লেখক: {{ $book->author_name }}</small>
                            @if($book->publisher_name)
                                <div style="font-size: 11.5px; color: #2563eb; margin-top: 2px;">
                                    🏢 প্রকাশনী: {{ $book->publisher_name }}
                                    @if($book->approval_status === 'pending')
                                        <span style="background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 4px; font-weight: 700;">পেন্ডিং</span>
                                    @elseif($book->approval_status === 'approved')
                                        <span style="background: #dcfce7; color: #166534; padding: 1px 5px; border-radius: 4px; font-weight: 700;">অনুমোদিত</span>
                                    @else
                                        <span style="background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 4px; font-weight: 700;">বাতিল</span>
                                    @endif
                                </div>
                            @endif
                            @if($book->is_featured) <span style="font-size: 10px; background: #fef3c7; color: #92400e; padding: 1px 5px; border-radius: 4px;">Featured</span> @endif
                            @if($book->is_upcoming) <span style="font-size: 10px; background: #e0e7ff; color: #3730a3; padding: 1px 5px; border-radius: 4px;">Upcoming</span> @endif
                        </td>
                        <td>
                            {{ $book->categories->pluck('name')->join(', ') ?: '—' }}
                        </td>
                        <td>৳ {{ number_format($book->price_hardcopy) }}</td>
                        <td>৳ {{ number_format($book->price_ebook) }}</td>
                        <td>
                            @if($book->stock_status === 'in_stock')
                                <span class="badge badge-delivered">ইন স্টক ({{ $book->stock_quantity }})</span>
                            @elseif($book->stock_status === 'low_stock')
                                <span class="badge badge-pending">স্বল্প স্টক ({{ $book->stock_quantity }})</span>
                            @else
                                <span class="badge badge-cancelled">স্টক নেই</span>
                            @endif
                        </td>
                        <td>{{ $book->preview_pages }} পৃষ্ঠা</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="btn-sm btn-gray" title="ওয়েবসাইটে দেখুন">👁️</a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn-sm btn-blue">এডিট</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই বইটি মুছে ফেলতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-red">মুছুন</button>
                                </form>
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
</div>
@endsection
