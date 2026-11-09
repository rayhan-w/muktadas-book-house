@extends('layouts.admin')

@section('title', 'প্রকাশনী তালিকা | অ্যাডমিন প্যানেল')
@section('page_title', 'প্রকাশনী ও পাবলিশার ব্যবস্থাপনা')

@section('content')

    <div class="admin-card">
        <div class="card-header">
            <div>
                <h2>নিবন্ধিত সকল প্রকাশনী (Publishers)</h2>
                <p style="font-size: 13px; color: var(--admin-muted); margin-top: 3px;">
                    বাহ্যিক প্রকাশকদের আবেদন যাচাই করুন এবং বই জমা দেওয়ার অনুমোদন দিন।
                </p>
            </div>
        </div>

        <!-- Filter Tabs & Search -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 14px;">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.publishers.index') }}" class="btn-sm {{ !request('status') ? 'btn-primary' : 'btn-gray' }}" style="text-decoration: none;">
                    সকল প্রকাশনী ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'pending']) }}" class="btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-gray' }}" style="text-decoration: none;">
                    ⏳ অপেক্ষমাণ ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'approved']) }}" class="btn-sm {{ request('status') === 'approved' ? 'btn-primary' : 'btn-gray' }}" style="text-decoration: none;">
                    ✓ অনুমোদিত ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'rejected']) }}" class="btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-gray' }}" style="text-decoration: none;">
                    ✕ বাতিলকৃত ({{ $counts['rejected'] }})
                </a>
            </div>

            <form action="{{ route('admin.publishers.index') }}" method="GET" style="display: flex; gap: 8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="কোম্পানি, ব্যক্তি বা ইমেইল..." class="form-control" style="width: 240px; padding: 6px 12px; font-size: 13px;">
                <button type="submit" class="btn-sm btn-gray">খুঁজুন</button>
            </form>
        </div>

        @if($publishers->count() > 0)
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>প্রকাশনীর নাম ও ব্যক্তি</th>
                            <th>যোগাযোগের তথ্য</th>
                            <th>পরিচিতি / ঠিকানা</th>
                            <th>মোট জমাকৃত বই</th>
                            <th>স্ট্যাটাস</th>
                            <th>নিবন্ধনের তারিখ</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publishers as $pub)
                            <tr>
                                <td>
                                    <strong style="color: var(--admin-dark); font-size: 15px; display: block;">
                                        🏢 {{ $pub->publisher_company ?: 'নামহীন প্রকাশনী' }}
                                    </strong>
                                    <small style="color: var(--admin-muted);">দায়িত্বপ্রাপ্ত: {{ $pub->name }}</small>
                                </td>
                                <td>
                                    <div>📧 {{ $pub->email }}</div>
                                    <div style="font-size: 12.5px; color: var(--admin-muted);">📱 {{ $pub->phone }}</div>
                                </td>
                                <td>
                                    @if($pub->address)
                                        <div style="font-size: 13px; color: #334155;">📍 {{ $pub->address }}</div>
                                    @endif
                                    @if($pub->publisher_bio)
                                        <small style="color: var(--admin-muted); display: block; max-width: 220px;" title="{{ $pub->publisher_bio }}">
                                            {{ Str::limit($pub->publisher_bio, 60) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.publishers.books', ['q' => $pub->publisher_company]) }}" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                                        {{ $pub->publisher_books_count }}টি বই
                                    </a>
                                </td>
                                <td>
                                    @if($pub->publisher_status === 'approved')
                                        <span class="badge badge-success" style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                            ✓ অনুমোদিত
                                        </span>
                                    @elseif($pub->publisher_status === 'pending')
                                        <span class="badge badge-warning" style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                            ⏳ অপেক্ষমাণ (Pending)
                                        </span>
                                    @else
                                        <span class="badge badge-danger" style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                            ✕ বাতিলকৃত
                                        </span>
                                        @if($pub->publisher_rejection_reason)
                                            <div style="font-size: 11px; color: #dc2626; margin-top: 3px; max-width: 200px;">
                                                কারণ: {{ $pub->publisher_rejection_reason }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 13px;">{{ $pub->created_at->format('d M, Y') }}</div>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                        @if($pub->publisher_status !== 'approved')
                                            <form action="{{ route('admin.publishers.approve', $pub->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-sm btn-primary" onclick="return confirm('আপনি কি এই প্রকাশনীকে অনুমোদন দিতে চান?');">
                                                    ✓ অনুমোদন করুন
                                                </button>
                                            </form>
                                        @endif

                                        @if($pub->publisher_status !== 'rejected')
                                            <button type="button" class="btn-sm btn-gray" style="color: #dc2626;" onclick="openRejectModal({{ $pub->id }}, '{{ addslashes($pub->publisher_company ?: $pub->name) }}');">
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
                {{ $publishers->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px; color: var(--admin-muted);">
                <div style="font-size: 40px; margin-bottom: 10px;">🏢</div>
                <h3>কোনো প্রকাশনীর রেকর্ড পাওয়া যায়নি</h3>
            </div>
        @endif
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 450px; max-width: 90%; border-radius: 12px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">
                প্রকাশনী বাতিলকরণ
            </h3>
            <p id="modalPublisherName" style="font-size: 13.5px; color: #64748b; margin-bottom: 16px;"></p>

            <form id="rejectForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        বাতিলকরণের কারণ লিখুন <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="rejection_reason" required rows="3" class="form-control" placeholder="যেমন: ভুল ট্রেড লাইসেন্স বা অসম্পূর্ণ তথ্য..." style="width: 100%; box-sizing: border-box;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-sm btn-gray" onclick="closeRejectModal();">ফিরে যান</button>
                    <button type="submit" class="btn-sm btn-danger">নিশ্চিত বাতিল করুন</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openRejectModal(id, name) {
        document.getElementById('modalPublisherName').innerText = 'প্রকাশনী: ' + name;
        document.getElementById('rejectForm').action = '/admin/publishers/' + id + '/reject';
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }
</script>
@endsection
