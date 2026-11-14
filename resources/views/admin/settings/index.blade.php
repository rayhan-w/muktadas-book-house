@extends('layouts.admin')

@section('title', 'সাইট সেটিংস | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'ওয়েবসাইট ও বিজনেস সেটিংস')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <div>
            <h2>ওয়েবসাইট, লেখক পরিচিতি ও ডেলিভারি সেটিংস</h2>
            <small style="color: var(--admin-muted);">কোনো ডেভেলপারের সাহায্য ছাড়াই ওয়েবসাইটের যাবতীয় কনটেন্ট ও বিজনেস তথ্য এখান থেকে পরিবর্তন করুন।</small>
        </div>
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

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. General Info -->
        <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--admin-primary);">১. সাধারণ সাইট ব্র্যান্ডিং</h3>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">ওয়েবসাইটের নাম (Site Title) *</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">সাইটের ট্যাগলাইন (Tagline)</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="form-control">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 2. Author Profile -->
        <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--admin-primary);">২. লেখকের প্রোফাইল ও হোমপেজ বার্তা</h3>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">লেখকের নাম *</label>
                <input type="text" name="author_name" value="{{ old('author_name', $settings['author_name']) }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">লেখকের ছবি পরিবর্তন করুন (Image)</label>
                <input type="file" name="author_photo" accept="image/*" class="form-control">
                @if($settings['author_photo'])
                    <small style="color: var(--admin-muted); display: block; margin-top: 4px;">বর্তমান ছবি: <code>{{ $settings['author_photo'] }}</code></small>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">লেখকের বিশেষ বার্তা বা Quote (হোমপেজে প্রদর্শিত)</label>
            <textarea name="author_quote" rows="2" class="form-control">{{ old('author_quote', $settings['author_quote']) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">লেখকের সংক্ষিপ্ত পরিচিতি (Biography)</label>
            <textarea name="author_bio" rows="3" class="form-control">{{ old('author_bio', $settings['author_bio']) }}</textarea>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 3. Delivery Charges -->
        <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--admin-primary);">৩. কুরিয়ার ডেলিভারি চার্জ নির্ধারণ</h3>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">ঢাকা সিটির ভেতরে ডেলিভারি চার্জ (টাকা) *</label>
                <input type="number" step="0.01" name="delivery_charge_dhaka" value="{{ old('delivery_charge_dhaka', $settings['delivery_charge_dhaka']) }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">ঢাকা সিটির বাইরে ডেলিভারি চার্জ (টাকা) *</label>
                <input type="number" step="0.01" name="delivery_charge_outside" value="{{ old('delivery_charge_outside', $settings['delivery_charge_outside']) }}" required class="form-control">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 4. Contact & Social -->
        <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--admin-primary);">৪. যোগাযোগ ও সোশ্যাল মিডিয়া লিংক</h3>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">যোগাযোগের ইমেইল (Contact Email) *</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">ফোন নম্বর (Phone / Hotline)</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">WhatsApp নম্বর</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}" class="form-control" placeholder="+8801700112233">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">অফিস / ডেলিভারি ঠিকানা</label>
                <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address']) }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Facebook পেজ / প্রোফাইল লিংক</label>
                <input type="text" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}" class="form-control">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 5. Admin Security & Password Change -->
        <h3 style="font-size: 16px; margin-bottom: 6px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-shield-lock-fill"></i> ৫. অ্যাডমিন প্রোফাইল ও পাসওয়ার্ড পরিবর্তন
        </h3>
        <p style="font-size: 13px; color: var(--admin-muted); margin-bottom: 14px;">
            আপনার অ্যাডমিন প্যানেলের নাম, লগইন ইমেইল অথবা পাসওয়ার্ড পরিবর্তন করতে পারেন। পাসওয়ার্ড পরিবর্তন না করতে চাইলে পাসওয়ার্ডের ঘর দুটি ফাঁকা রাখুন।
        </p>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">অ্যাডমিনের নাম</label>
                <input type="text" name="admin_name" value="{{ old('admin_name', $admin?->name ?? 'অ্যাডমিন মুক্তাদা') }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">অ্যাডমিন লগইন ইমেইল</label>
                <input type="email" name="admin_email" value="{{ old('admin_email', $admin?->email ?? 'admin@muktadasbookhouse.com') }}" class="form-control">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড (ঐচ্ছিক — পরিবর্তন করতে চাইলে লিখুন)</label>
                <input type="password" name="admin_password" class="form-control" placeholder="কমপক্ষে ৬ অক্ষরের নতুন পাসওয়ার্ড">
            </div>
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড নিশ্চিতকরণ (Confirm Password)</label>
                <input type="password" name="admin_password_confirmation" class="form-control" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন">
            </div>
        </div>

        <button type="submit" class="btn-sm btn-blue" style="padding: 14px 28px; font-size: 16px; margin-top: 10px;">
            <i class="bi bi-check-circle-fill"></i> সেটিংস ও প্রোফাইল আপডেট করুন
        </button>
    </form>
</div>
@endsection
