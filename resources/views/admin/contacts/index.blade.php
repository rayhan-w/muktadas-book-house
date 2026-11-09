@extends('layouts.admin')

@section('title', 'বার্তা ও সাবস্ক্রাইবার | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'পাঠকের বার্তা ও নিউজলেটার সাবস্ক্রাইবার')

@section('content')
<div class="grid-2">
    <!-- Messages -->
    <div class="admin-card">
        <div class="card-header">
            <h2>যোগাযোগের বার্তা ({{ $messages->total() }})</h2>
        </div>

        @if($messages->isEmpty())
            <p style="color: var(--admin-muted); text-align: center; padding: 30px;">কোনো নতুন বার্তা নেই।</p>
        @else
            <div style="display: grid; gap: 14px;">
                @foreach($messages as $msg)
                    <div style="background: {{ $msg->is_read ? '#fff' : '#fffdf5' }}; border: 1px solid {{ $msg->is_read ? 'var(--admin-border)' : '#fde68a' }}; border-radius: 8px; padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                            <div>
                                <strong style="color: var(--admin-dark);">{{ $msg->name }}</strong>
                                <small style="color: var(--admin-muted); display: block;">{{ $msg->email }} {{ $msg->phone ? '· ' . $msg->phone : '' }}</small>
                            </div>
                            <small style="color: var(--admin-muted);">{{ $msg->created_at->diffForHumans() }}</small>
                        </div>
                        @if($msg->subject)
                            <div style="font-weight: 700; font-size: 14px; color: var(--admin-primary); margin-bottom: 6px;">বিষয়: {{ $msg->subject }}</div>
                        @endif
                        <p style="font-size: 14px; line-height: 1.6; color: var(--admin-dark);">{{ $msg->message }}</p>

                        <div style="margin-top: 10px; display: flex; justify-content: flex-end; gap: 8px;">
                            @if(!$msg->is_read)
                                <form action="{{ route('admin.contacts.read', $msg->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-sm btn-green" style="padding: 4px 8px; font-size: 11px;">পঠিত চিহ্নিত করুন</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('বার্তাটি মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-red" style="padding: 4px 8px; font-size: 11px;">মুছুন</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 20px;">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Newsletter Subscribers -->
    <div class="admin-card">
        <div class="card-header">
            <h2>নিউজলেটার সাবস্ক্রাইবার তালিকা ({{ $subscribers->count() }})</h2>
        </div>

        @if($subscribers->isEmpty())
            <p style="color: var(--admin-muted); text-align: center; padding: 30px;">কোনো সাবস্ক্রাইবার নেই।</p>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ইমেইল অ্যাড্রেস</th>
                        <th>তারিখ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $idx => $sub)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><code>{{ $sub->email }}</code></td>
                            <td>{{ $sub->created_at->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
