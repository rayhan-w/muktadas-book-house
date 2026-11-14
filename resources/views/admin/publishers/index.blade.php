@extends('layouts.admin')

@section('title', 'প্রকাশনী তালিকা | অ্যাডমিন প্যানেল')
@section('page_title', 'প্রকাশনী ও পাবলিশার ব্যবস্থাপনা')

@section('content')

    <div class="admin-card">
        <div class="card-header">
            <div>
                <h2>নিবন্ধিত সকল প্রকাশনী (Publishers)</h2>
                <p style="font-size: 13px; color: var(--admin-muted); margin-top: 3px;">
                    বাহ্যিক প্রকাশকদের আবেদন যাচাই করুন, সাবস্ক্রিপশন মেয়াদ নির্ধারণ করুন এবং অনুমোদন দিন।
                </p>
            </div>
        </div>

        <!-- Filter Tabs & Search -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 14px;">
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.publishers.index') }}" class="btn-sm {{ !request('status') ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                    সকল প্রকাশনী ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'pending']) }}" class="btn-sm {{ request('status') === 'pending' ? 'btn-blue' : 'btn-gray' }}" style="text-decoration: none;">
                    <i class="bi bi-hourglass-split"></i> অপেক্ষমাণ ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'approved']) }}" class="btn-sm {{ request('status') === 'approved' ? 'btn-green' : 'btn-gray' }}" style="text-decoration: none;">
                    <i class="bi bi-check-circle-fill"></i> অনুমোদিত ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('admin.publishers.index', ['status' => 'rejected']) }}" class="btn-sm {{ request('status') === 'rejected' ? 'btn-red' : 'btn-gray' }}" style="text-decoration: none;">
                    <i class="bi bi-x-circle-fill"></i> বাতিলকৃত ({{ $counts['rejected'] }})
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
                            <th>জমাকৃত বই</th>
                            <th>স্ট্যাটাস ও মেয়াদ</th>
                            <th>নিবন্ধনের তারিখ</th>
                            <th style="text-align: right;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publishers as $pub)
                            @php
                                $cleanPubPhone = preg_replace('/[^0-9]/', '', $pub->phone);
                                if (str_starts_with($cleanPubPhone, '01')) {
                                    $cleanPubPhone = '88' . $cleanPubPhone;
                                }
                            @endphp
                            <tr>
                                <td>
                                    <strong style="color: var(--admin-dark); font-size: 15px; display: block;">
                                        <i class="bi bi-buildings" style="color: #0284c7;"></i> {{ $pub->publisher_company ?: 'নামহীন প্রকাশনী' }}
                                    </strong>
                                    <small style="color: var(--admin-muted);">দায়িত্বপ্রাপ্ত: {{ $pub->name }}</small>
                                    @if($pub->address)
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;"><i class="bi bi-geo-alt"></i> {{ $pub->address }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div><i class="bi bi-envelope"></i> {{ $pub->email }}</div>
                                    <div style="font-size: 12.5px; color: var(--admin-muted); display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                        <i class="bi bi-telephone"></i> {{ $pub->phone }}
                                        <a href="https://wa.me/{{ $cleanPubPhone }}" target="_blank" style="color: #25d366; font-size: 14px; text-decoration: none;" title="হোয়াটসঅ্যাপে মেসেজ পাঠান">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.publishers.books', ['q' => $pub->publisher_company]) }}" style="color: #2563eb; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="bi bi-book"></i> {{ $pub->publisher_books_count }}টি বই
                                    </a>
                                </td>
                                <td>
                                    @if($pub->publisher_status === 'approved')
                                        @if($pub->isExpiredPublisher())
                                            <span class="badge" style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="bi bi-clock-history"></i> মেয়াদ উত্তীর্ণ
                                            </span>
                                        @else
                                            <span class="badge" style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="bi bi-check-circle-fill"></i> সক্রিয় অনুমোদিত
                                            </span>
                                        @endif
                                        <div style="font-size: 12px; color: #475569; margin-top: 4px;">
                                            প্যাকেজ: <strong>{{ $pub->publisher_plan ?: '১ বছর' }}</strong>
                                            @if($pub->publisher_expires_at)
                                                <br><small style="color: {{ $pub->isExpiredPublisher() ? '#dc2626' : '#64748b' }};">
                                                    মেয়াদ শেষ: {{ $pub->publisher_expires_at->format('d M, Y') }}
                                                </small>
                                            @else
                                                <br><small style="color: #4f46e5; font-weight: 600;">আজীবন (লাইফটাইম)</small>
                                            @endif
                                        </div>
                                    @elseif($pub->publisher_status === 'pending')
                                        <span class="badge" style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-hourglass-split"></i> অপেক্ষমাণ
                                        </span>
                                    @else
                                        <span class="badge" style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-x-circle-fill"></i> বাতিলকৃত
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
                                            <button type="button" class="btn-sm btn-blue" onclick="openApproveModal({{ $pub->id }}, '{{ addslashes($pub->publisher_company ?: $pub->name) }}', '{{ $pub->publisher_plan ?: '১ বছর' }}', '{{ $pub->publisher_expires_at ? $pub->publisher_expires_at->format('Y-m-d') : '' }}');">
                                                <i class="bi bi-check-circle-fill"></i> অনুমোদন করুন
                                            </button>
                                        @else
                                            <button type="button" class="btn-sm btn-gray" style="color: #0284c7;" onclick="openApproveModal({{ $pub->id }}, '{{ addslashes($pub->publisher_company ?: $pub->name) }}', '{{ $pub->publisher_plan ?: '১ বছর' }}', '{{ $pub->publisher_expires_at ? $pub->publisher_expires_at->format('Y-m-d') : '' }}');" title="মেয়াদ পরিবর্তন বা নবায়ন করুন">
                                                <i class="bi bi-arrow-repeat"></i> মেয়াদ নবায়ন
                                            </button>
                                        @endif

                                        <a href="https://wa.me/{{ $cleanPubPhone }}" target="_blank" class="btn-sm btn-gray" style="color: #25d366; text-decoration: none;" title="হোয়াটসঅ্যাপে সরাসরি যোগাযোগ করুন">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>

                                        @if($pub->publisher_status !== 'rejected')
                                            <button type="button" class="btn-sm btn-gray" style="color: #dc2626;" onclick="openRejectModal({{ $pub->id }}, '{{ addslashes($pub->publisher_company ?: $pub->name) }}');" title="বাতিল করুন">
                                                <i class="bi bi-x-circle"></i>
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
                <div style="font-size: 44px; margin-bottom: 10px; color: #94a3b8;"><i class="bi bi-buildings"></i></div>
                <h3>কোনো প্রকাশনীর রেকর্ড পাওয়া যায়নি</h3>
            </div>
        @endif
    </div>

    <!-- Approval / Renewal Modal -->
    <div id="approveModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center;">
        <div style="background: #fff; width: 480px; max-width: 90%; border-radius: 14px; padding: 26px; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-patch-check-fill" style="color: #10b981;"></i> প্রকাশনী অনুমোদন ও মেয়াদ নির্ধারণ
            </h3>
            <p id="approveModalPubName" style="font-size: 13.5px; color: #64748b; margin-bottom: 18px;"></p>

            <form id="approveForm" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        অনুমোদনের মেয়াদ (Validity Duration) <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="publisher_plan" id="publisherPlanSelect" class="form-control" style="width: 100%; box-sizing: border-box;" onchange="toggleCustomDate(this.value)">
                        <option value="১ বছর">১ বছর (Default - ১ Year)</option>
                        <option value="৬ মাস">৬ মাস (6 Months)</option>
                        <option value="৩ মাস">৩ মাস (3 Months)</option>
                        <option value="১ মাস">১ মাস (1 Month)</option>
                        <option value="আজীবন">আজীবন (Lifetime)</option>
                        <option value="custom">কাস্টম নির্দিষ্ট তারিখ (Custom Expiry Date)</option>
                    </select>
                </div>

                <div id="customDateGroup" style="display: none; margin-bottom: 18px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        মেয়াদ উত্তীর্ণের তারিখ নির্ধারণ করুন <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="date" name="publisher_expires_at" id="publisherExpiresAtInput" class="form-control" style="width: 100%; box-sizing: border-box;">
                </div>

                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px 14px; border-radius: 8px; margin-bottom: 20px; font-size: 12.5px; color: #166534; line-height: 1.5;">
                    💡 <strong>স্বয়ংক্রিয় সুরক্ষা:</strong> নির্ধারিত মেয়াদ শেষ হয়ে গেলে এই প্রকাশনীর সকল বই ওয়েবসাইট থেকে নিজে থেকেই আনপাবলিশ (লুকানো) হয়ে যাবে। মেয়াদ পুনরায় বৃদ্ধি বা নবায়ন করলে বইগুলো আবার স্বয়ংক্রিয়ভাবে লাইভ হবে।
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-sm btn-gray" onclick="closeApproveModal();">বাতিল</button>
                    <button type="submit" class="btn-sm btn-green" style="font-weight: 700;">
                        <i class="bi bi-check-lg"></i> অনুমোদন নিশ্চিত করুন
                    </button>
                </div>
            </form>
        </div>
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
    function openApproveModal(id, name, currentPlan, currentExpiry) {
        document.getElementById('approveModalPubName').innerText = 'প্রকাশনী: ' + name;
        document.getElementById('approveForm').action = '/admin/publishers/' + id + '/approve';
        
        var select = document.getElementById('publisherPlanSelect');
        var found = false;
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].value === currentPlan) {
                select.selectedIndex = i;
                found = true;
                break;
            }
        }
        if (!found && currentPlan) {
            select.value = 'custom';
        }
        
        if (currentExpiry) {
            document.getElementById('publisherExpiresAtInput').value = currentExpiry;
        }
        
        toggleCustomDate(select.value);
        document.getElementById('approveModal').style.display = 'flex';
    }

    function toggleCustomDate(val) {
        var group = document.getElementById('customDateGroup');
        var input = document.getElementById('publisherExpiresAtInput');
        if (val === 'custom') {
            group.style.display = 'block';
            input.required = true;
        } else {
            group.style.display = 'none';
            input.required = false;
        }
    }

    function closeApproveModal() {
        document.getElementById('approveModal').style.display = 'none';
    }

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
