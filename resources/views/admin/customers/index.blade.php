@extends('layouts.admin')

@section('title', 'পাঠক ও ব্যবহারকারী তালিকা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'নিবন্ধিত পাঠক ও ব্যবহারকারী ব্যবস্থাপনা')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>নিবন্ধিত সকল পাঠক ও ইউজার ({{ $customers->total() }})</h2>
            <small style="color: var(--admin-muted);">ওয়েবসাইটে রেজিস্টার্ড পাঠকদের মেম্বারশিপ, রোল ও তথ্য পরিচালনা করুন।</small>
        </div>
    </div>

    <!-- Filter Tabs & Search -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 14px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('admin.customers.index', ['role' => 'customer']) }}" class="btn-sm {{ request('role', 'customer') === 'customer' ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                <i class="bi bi-people-fill"></i> পাঠক ({{ $counts['customer'] }})
            </a>
            <a href="{{ route('admin.customers.index', ['role' => 'publisher']) }}" class="btn-sm {{ request('role') === 'publisher' ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                <i class="bi bi-buildings"></i> প্রকাশক ({{ $counts['publisher'] }})
            </a>
            <a href="{{ route('admin.customers.index', ['role' => 'admin']) }}" class="btn-sm {{ request('role') === 'admin' ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                <i class="bi bi-shield-lock-fill"></i> অ্যাডমিন ({{ $counts['admin'] }})
            </a>
            <a href="{{ route('admin.customers.index', ['role' => 'all']) }}" class="btn-sm {{ request('role') === 'all' ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                সকল ইউজার ({{ $counts['all'] }})
            </a>
        </div>

        <form method="GET" action="{{ route('admin.customers.index') }}" style="display: flex; gap: 8px;">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="নাম, ইমেইল বা ফোন..." class="form-control" style="width: 220px; padding: 6px 12px; font-size: 13px;">
            <button type="submit" class="btn-sm btn-gray">খুঁজুন</button>
            @if(request('q'))
                <a href="{{ route('admin.customers.index', ['role' => request('role')]) }}" class="btn-sm btn-red">রিসেট</a>
            @endif
        </form>
    </div>

    @if($customers->isEmpty())
        <div style="text-align: center; padding: 40px; color: var(--admin-muted);">
            <div style="font-size: 38px; color: #cbd5e1; margin-bottom: 10px;"><i class="bi bi-people"></i></div>
            <p>কোনো ব্যবহারকারী পাওয়া যায়নি।</p>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ব্যবহারকারীর নাম ও রোল</th>
                        <th>যোগাযোগের তথ্য</th>
                        <th>মোট অর্ডার</th>
                        <th>ই-বুক সংগ্রহ</th>
                        <th>মেম্বারশিপ প্ল্যান</th>
                        <th>নিবন্ধনের তারিখ</th>
                        <th style="text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $c)
                        <tr>
                            <td>
                                <strong style="font-size: 14.5px; color: var(--admin-dark); display: block;">{{ $c->name }}</strong>
                                <div style="margin-top: 3px;">
                                    @if($c->role === 'admin')
                                        <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px;">
                                            <i class="bi bi-shield-check"></i> সুপার অ্যাডমিন
                                        </span>
                                    @elseif($c->role === 'publisher')
                                        <span class="badge" style="background: #f0fdfa; color: #0f766e; border: 1px solid #99f6e4; font-size: 11px;">
                                            <i class="bi bi-buildings"></i> প্রকাশক
                                        </span>
                                    @else
                                        <span class="badge" style="background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; font-size: 11px;">
                                            <i class="bi bi-person"></i> সাধারণ পাঠক
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div><i class="bi bi-envelope"></i> {{ $c->email }}</div>
                                <div style="font-size: 12.5px; color: var(--admin-muted); margin-top: 2px;">
                                    <i class="bi bi-telephone"></i> {{ $c->phone ?: '—' }}
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #0f172a;">{{ $c->orders_count }}টি</span>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #2563eb;">{{ $c->library_count }}টি</span>
                            </td>
                            <td>
                                @if($c->membership_plan)
                                    <span class="badge" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
                                        <i class="bi bi-award-fill"></i> {{ $c->membership_plan }}
                                    </span>
                                    @if($c->membership_expires_at)
                                        <small style="display: block; font-size: 11px; color: var(--admin-muted); margin-top: 2px;">
                                            মেয়াদ: {{ $c->membership_expires_at->format('d M, Y') }}
                                        </small>
                                    @endif
                                @else
                                    <span class="badge" style="background: #f1f5f9; color: #64748b;">
                                        ফ্রি পাঠক
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 13px;">{{ $c->created_at->format('d M, Y') }}</div>
                                <small style="color: var(--admin-muted);">{{ $c->created_at->format('h:i A') }}</small>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="{{ route('admin.customers.edit', $c->id) }}" class="btn-sm btn-blue" title="তথ্য ও রোল এডিট করুন">
                                        <i class="bi bi-pencil-square"></i> এডিট
                                    </a>
                                    @if($c->id !== auth()->id())
                                        <form action="{{ route('admin.customers.destroy', $c->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ব্যবহারকারীকে মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-red" title="মুছুন">
                                                <i class="bi bi-trash"></i>
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
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
