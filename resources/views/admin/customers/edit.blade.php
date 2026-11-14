@extends('layouts.admin')

@section('title', 'ব্যবহারকারী এডিট | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'ব্যবহারকারী তথ্য ও রোল পরিবর্তন')

@section('content')
<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <div>
            <h2>ব্যবহারকারী সম্পাদনা: {{ $user->name }}</h2>
            <small style="color: var(--admin-muted);">পাঠকের রোল (Role), মেম্বারশিপ এবং যোগাযোগের তথ্য আপডেট করুন।</small>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn-sm btn-gray">
            <i class="bi bi-arrow-left"></i> তালিকায় ফিরুন
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.customers.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">ব্যবহারকারীর নাম *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">ইমেইল অ্যাড্রেস *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">মোবাইল নম্বর</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="যেমন: 01700112233">
            </div>

            <div class="form-group">
                <label class="form-label">একাউন্ট রোল (User Role) *</label>
                <select name="role" required class="form-control" style="font-weight: 700;">
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>পাঠক (Customer - সাধারণ বই ক্রেতা)</option>
                    <option value="publisher" {{ old('role', $user->role) === 'publisher' ? 'selected' : '' }}>প্রকাশক (Publisher - বই আপলোড পোর্টাল এক্সেস)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>অ্যাডমিন (Admin - পূর্ণ নিয়ন্ত্রণ ক্ষমতা)</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">ঠিকানা</label>
            <textarea name="address" rows="2" class="form-control" placeholder="ব্যবহারকারীর সম্পূর্ণ ঠিকানা...">{{ old('address', $user->address) }}</textarea>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- Membership Settings -->
        <h3 style="font-size: 15px; margin-bottom: 12px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-award-fill text-warning"></i> মেম্বারশিপ প্ল্যান নির্ধারণ
        </h3>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">মেম্বারশিপ প্ল্যান (ফাঁকা রাখলে ফ্রি পাঠক)</label>
                <select name="membership_plan" class="form-control">
                    <option value="" {{ empty(old('membership_plan', $user->membership_plan)) ? 'selected' : '' }}>সাধারণ / ফ্রি পাঠক (কোনো প্ল্যান নেই)</option>
                    <option value="১ মাস" {{ old('membership_plan', $user->membership_plan) === '১ মাস' ? 'selected' : '' }}>১ মাস প্রিমিয়াম</option>
                    <option value="৬ মাস" {{ old('membership_plan', $user->membership_plan) === '৬ মাস' ? 'selected' : '' }}>৬ মাস প্রিমিয়াম</option>
                    <option value="১ বছর" {{ old('membership_plan', $user->membership_plan) === '১ বছর' ? 'selected' : '' }}>১ বছর প্রিমিয়াম</option>
                    <option value="আজীবন" {{ old('membership_plan', $user->membership_plan) === 'আজীবন' ? 'selected' : '' }}>আজীবন (Lifetime)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">মেম্বারশিপের মেয়াদ উত্তীর্ণের তারিখ</label>
                <input type="date" name="membership_expires_at" value="{{ old('membership_expires_at', $user->membership_expires_at ? $user->membership_expires_at->format('Y-m-d') : '') }}" class="form-control">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- Password Reset -->
        <div class="form-group">
            <label class="form-label">নতুন পাসওয়ার্ড নির্ধারণ (ঐচ্ছিক — পরিবর্তন করতে চাইলে লিখুন)</label>
            <input type="password" name="password" class="form-control" placeholder="ব্যবহারকারীর নতুন পাসওয়ার্ড দিন (না বদলাতে চাইলে ফাঁকা রাখুন)">
            <small style="color: var(--admin-muted); display: block; margin-top: 4px;">অ্যাডমিন হিসেবে কোনো পাঠকের পাসওয়ার্ড ভুলে গেলে এখান থেকে সরাসরি নতুন পাসওয়ার্ড সেট করে দিতে পারেন।</small>
        </div>

        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn-sm btn-blue" style="padding: 12px 24px; font-size: 15px;">
                <i class="bi bi-check-circle-fill"></i> তথ্য সংরক্ষণ করুন
            </button>
            <a href="{{ route('admin.customers.index') }}" class="btn-sm btn-gray" style="padding: 12px 20px; font-size: 15px;">
                বাতিল
            </a>
        </div>
    </form>
</div>
@endsection
