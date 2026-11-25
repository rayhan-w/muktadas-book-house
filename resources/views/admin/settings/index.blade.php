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

        <!-- 1. General Info & Logo -->
        <h3 style="font-size: 16px; margin-bottom: 12px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-palette-fill"></i> ১. সাধারণ সাইট ব্র্যান্ডিং ও লোগো
        </h3>
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

        <!-- Logo Upload & Live Preview Card -->
        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 18px; margin-top: 15px;">
            <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 8px; display: block;">
                <i class="bi bi-image-fill" style="color: var(--admin-primary);"></i> ওয়েবসাইটের লোগো পরিবর্তন করুন (Site Logo)
            </label>
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="width: 84px; height: 84px; background: #fff; border: 1.5px solid var(--admin-border); border-radius: 12px; padding: 6px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 6px;">
                        <img id="logoPreviewImg" src="{{ $settings['site_logo'] }}" alt="Current Logo" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">
                    </div>
                    <small style="color: var(--admin-muted); font-size: 11px; font-weight: 600;">বর্তমান লোগো</small>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <input type="file" name="site_logo" id="siteLogoInput" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" class="form-control" onchange="previewSiteLogo(this)">
                    <small style="color: var(--admin-muted); display: block; margin-top: 6px; font-size: 12.5px; line-height: 1.5;">
                        <i class="bi bi-info-circle-fill text-primary me-1"></i> পিএনজি (PNG), জেপিজি (JPG), ওয়েবপি (WEBP) বা এসভিজি (SVG) ফরম্যাট গ্রহণযোগ্য (সর্বোচ্চ ৪ এমবি)। লোগো পরিবর্তন করলে সাইটের হেডার, ফুটার এবং অ্যাডমিন প্যানেলে স্বয়ংক্রিয়ভাবে আপডেট হবে।
                    </small>
                </div>
            </div>
        </div>

        <!-- Hero Top Banner Upload Card -->
        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 18px; margin-top: 15px;">
            <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 8px; display: block;">
                <i class="bi bi-aspect-ratio-fill" style="color: #059669;"></i> হোমপেজের মূল ব্যানার পরিবর্তন করুন (Hero Banner)
            </label>
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <div style="text-align: center;">
                    <div style="width: 160px; height: 75px; background: #fff; border: 1.5px solid var(--admin-border); border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 6px;">
                        <img id="bannerPreviewImg" src="{{ $settings['hero_banner'] }}" alt="Current Banner" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <small style="color: var(--admin-muted); font-size: 11px; font-weight: 600;">বর্তমান ব্যানার</small>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <input type="file" name="hero_banner" id="heroBannerInput" accept="image/png, image/jpeg, image/jpg, image/webp" class="form-control" onchange="previewHeroBanner(this)">
                    <small style="color: var(--admin-muted); display: block; margin-top: 6px; font-size: 12.5px; line-height: 1.5;">
                        <i class="bi bi-info-circle-fill text-success me-1"></i> আপনার পছন্দমতো নতুন ব্যানার বা লেখকের ছবি ডিজাইন করে এখানে আপলোড করুন। প্রস্তাবিত সাইজ: ১২০০ × ৪৫০ পিক্সেল (সর্বোচ্চ ৮ এমবি)।
                    </small>
                </div>
            </div>
        </div>

        <!-- Ambient Background Music Card (Optional) -->
        <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 18px; margin-top: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 10px;">
                <label class="form-label" style="font-weight: 700; color: #166534; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-music-note-beamed" style="font-size: 18px;"></i> ওয়েবসাইটে মৃদু সুর / ব্যাকগ্রাউন্ড মিউজিক (Ambient Audio)
                </label>
                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #166534;">
                    <input type="hidden" name="bg_music_enabled" value="0">
                    <input type="checkbox" name="bg_music_enabled" value="1" {{ ($settings['bg_music_enabled'] ?? '0') === '1' ? 'checked' : '' }} style="width: 16px; height: 16px;">
                    মিউজিক প্লেয়ার চালু রাখুন
                </label>
            </div>
            <p style="font-size: 12.5px; color: #15803d; margin-bottom: 12px; line-height: 1.5;">
                পাঠক যখন ওয়েবসাইটে প্রবেশ করবেন, নিচে একটি সুন্দর ফ্লোটিং মিউজিক কন্ট্রোলার থাকবে যার মাধ্যমে মৃদু ও স্নিগ্ধ সুর উপভোগ করতে পারবেন (পাঠক চাইলে যেকোনো সময় অন/অফ করতে পারবেন)।
            </p>
            <div class="grid-2" style="align-items: center;">
                <div>
                    <input type="file" name="bg_music" accept="audio/mp3, audio/wav, audio/ogg, audio/mpeg" class="form-control" style="background: #fff;">
                    <small style="color: #166534; display: block; margin-top: 4px; font-size: 11.5px;">কপিরাইট-ফ্রি এমপি৩ (MP3/WAV) ফাইল আপলোড করুন (সর্বোচ্চ ১৫ এমবি)।</small>
                </div>
                @if(!empty($settings['bg_music']))
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <audio controls style="height: 38px; max-width: 100%;">
                            <source src="{{ asset($settings['bg_music']) }}">
                        </audio>
                    </div>
                @endif
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

        <!-- 5. Mail & SMTP Settings -->
        <h3 style="font-size: 16px; margin-bottom: 6px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-envelope-at-fill"></i> ৫. ইমেইল (SMTP / Sendmail) কনফিগারেশন
        </h3>
        <p style="font-size: 13px; color: var(--admin-muted); margin-bottom: 14px;">
            পাসওয়ার্ড রিসেট, অর্ডার কনফার্মেশন ও পেমেন্ট অ্যাপ্রুভাল ইমেইল পাঠানোর জন্য কনফিগারেশন। cPanel সার্ভারে <code>Sendmail</code> স্বয়ংক্রিয়ভাবে কাজ করে, অথবা আপনার নিজস্ব ওয়েবমেইল / জিমেইল SMTP ব্যবহার করতে পারেন।
        </p>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">মেইল ড্রাইভার (Mail Driver) *</label>
                <select name="mail_mailer" class="form-control" style="cursor: pointer;">
                    <option value="phpmail" {{ old('mail_mailer', $settings['mail_mailer']) === 'phpmail' ? 'selected' : '' }}>PHP Native mail() (cPanel এর জন্য ডিফল্ট ও শতভাগ নিরাপদ)</option>
                    <option value="sendmail" {{ old('mail_mailer', $settings['mail_mailer']) === 'sendmail' ? 'selected' : '' }}>cPanel Sendmail (proc_open সক্রিয় থাকলে)</option>
                    <option value="smtp" {{ old('mail_mailer', $settings['mail_mailer']) === 'smtp' ? 'selected' : '' }}>কাস্টম SMTP (Webmail / Gmail / Brevo)</option>
                    <option value="log" {{ old('mail_mailer', $settings['mail_mailer']) === 'log' ? 'selected' : '' }}>লগ ড্রাইভার (মেইল পাঠাবে না, শুধু টেস্ট লগ রাখবে)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">প্রেরকের ইমেইল (From Address) *</label>
                <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address']) }}" class="form-control" placeholder="noreply@muktadarboighor.com">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">প্রেরকের নাম (From Name)</label>
                <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name']) }}" class="form-control" placeholder="মুক্তাদার বইঘর">
            </div>
            <div class="form-group">
                <label class="form-label">SMTP হোস্ট (SMTP Host - কাস্টম SMTP সিলেক্ট করলে)</label>
                <input type="text" name="mail_host" value="{{ old('mail_host', $settings['mail_host']) }}" class="form-control" placeholder="mail.muktadarboighor.com">
            </div>
        </div>

        <div class="grid-2" style="margin-bottom: 15px;">
            <div class="form-group">
                <label class="form-label">SMTP পোর্ট (Port)</label>
                <input type="text" name="mail_port" value="{{ old('mail_port', $settings['mail_port']) }}" class="form-control" placeholder="465 বা 587">
            </div>
            <div class="form-group">
                <label class="form-label">SMTP এনক্রিপশন (Encryption)</label>
                <input type="text" name="mail_encryption" value="{{ old('mail_encryption', $settings['mail_encryption']) }}" class="form-control" placeholder="ssl বা tls">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">SMTP ইউজারনেম (Username)</label>
                <input type="text" name="mail_username" value="{{ old('mail_username', $settings['mail_username']) }}" class="form-control" placeholder="info@muktadarboighor.com">
            </div>
            <div class="form-group">
                <label class="form-label">SMTP পাসওয়ার্ড (Password)</label>
                <input type="password" name="mail_password" value="{{ old('mail_password', $settings['mail_password']) }}" class="form-control" autocomplete="new-password" placeholder="••••••••">
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 6. Policies & Legal Pages Content -->
        <h3 style="font-size: 16px; margin-bottom: 6px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-file-earmark-text-fill"></i> ৬. গোপনীয়তা নীতি, শর্তাবলী ও রিফান্ড নীতি
        </h3>
        <p style="font-size: 13px; color: var(--admin-muted); margin-bottom: 14px;">
            আপনার সুবিধামতো যখন সময় পাবেন এখান থেকে সাইটের গোপনীয়তা নীতি, ব্যবহারের শর্তাবলী ও রিটার্ন পলিসির লেখা পরিবর্তন করতে পারবেন। ফাঁকা রাখলে ডিফল্ট লেখা প্রদর্শিত হবে।
        </p>

        <div class="form-group">
            <label class="form-label">গোপনীয়তা নীতি (Privacy Policy)</label>
            <textarea name="privacy_policy" rows="5" class="form-control" placeholder="আপনার নিজস্ব গোপনীয়তা নীতি লিখুন...">{{ old('privacy_policy', $settings['privacy_policy']) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">ব্যবহারের শর্তাবলী (Terms & Conditions)</label>
            <textarea name="terms_conditions" rows="5" class="form-control" placeholder="আপনার ওয়েবসাইটের ব্যবহারের নিয়ম ও শর্তাবলী লিখুন...">{{ old('terms_conditions', $settings['terms_conditions']) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">রিটার্ন ও রিফান্ড পলিসি (Return & Refund Policy)</label>
            <textarea name="refund_policy" rows="5" class="form-control" placeholder="বই রিটার্ন ও মূল্য ফেরত সংক্রান্ত নিয়মাবলী লিখুন...">{{ old('refund_policy', $settings['refund_policy']) }}</textarea>
        </div>

        <hr style="border: none; border-top: 1px solid var(--admin-border); margin: 25px 0;">

        <!-- 7. Admin Security & Password Change -->
        <h3 style="font-size: 16px; margin-bottom: 6px; color: var(--admin-primary); display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-shield-lock-fill"></i> ৭. অ্যাডমিন প্রোফাইল ও পাসওয়ার্ড পরিবর্তন
        </h3>
        <p style="font-size: 13px; color: var(--admin-muted); margin-bottom: 14px;">
            আপনার অ্যাডমিন প্যানেলের নাম, লগইন ইমেইল অথবা পাসওয়ার্ড পরিবর্তন করতে পারেন। পাসওয়ার্ড পরিবর্তন না করতে চাইলে পাসওয়ার্ডের ঘর দুটি ফাঁকা রাখুন।
        </p>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">অ্যাডমিনের নাম</label>
                <input type="text" name="admin_name" value="{{ old('admin_name', $admin?->name ?? 'মুক্তাদার অ্যাডমিন') }}" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">অ্যাডমিন লগইন ইমেইল</label>
                <input type="email" name="admin_email" value="{{ old('admin_email', $admin?->email ?? 'info@muktadarboighor.com') }}" class="form-control">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড (ঐচ্ছিক — পরিবর্তন করতে চাইলে লিখুন)</label>
                <input type="password" name="admin_password" class="form-control" autocomplete="new-password" placeholder="কমপক্ষে ৬ অক্ষরের নতুন পাসওয়ার্ড">
            </div>
            <div class="form-group">
                <label class="form-label">নতুন পাসওয়ার্ড নিশ্চিতকরণ (Confirm Password)</label>
                <input type="password" name="admin_password_confirmation" class="form-control" autocomplete="new-password" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন">
            </div>
        </div>

        <button type="submit" class="btn-sm btn-blue" style="padding: 14px 28px; font-size: 16px; margin-top: 10px;">
            <i class="bi bi-check-circle-fill"></i> সেটিংস ও প্রোফাইল আপডেট করুন
        </button>
    </form>
</div>

<!-- Test Email Card -->
<div class="admin-card" style="margin-top: 24px; border: 1.5px solid #bfdbfe; background: #f0f9ff;">
    <div class="card-header" style="border-bottom: 1px solid #bae6fd; padding-bottom: 12px; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 16px; color: #0369a1; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-send-check-fill"></i> লাইভ টেস্ট ইমেইল পাঠান (Email Delivery Test)
            </h3>
            <small style="color: #0c4a6e;">আপনার মেইল সার্ভার বা SMTP ঠিকমতো কাজ করছে কিনা তা এই বাটন দিয়ে সরাসরি এখনই পরীক্ষা করুন।</small>
        </div>
    </div>
    <form action="{{ route('admin.settings.test-email') }}" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
        @csrf
        <div style="flex: 1; min-width: 260px;">
            <label class="form-label" style="color: #0369a1; font-weight: 700;">যে ইমেইলে টেস্ট মেইল পাঠাবেন:</label>
            <input type="email" name="test_email" value="{{ Auth::user()->email ?? 'admin@muktadarboighor.com' }}" required class="form-control" placeholder="আপনার ব্যক্তিগত ইমেইল লিখুন" style="background: #fff;">
        </div>
        <button type="submit" class="btn-sm" style="background: #0284c7; color: #fff; padding: 11px 22px; font-weight: 700; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px;">
            <i class="bi bi-send-fill"></i> টেস্ট ইমেইল পাঠান
        </button>
    </form>
</div>

<script>
function previewSiteLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logoPreviewImg');
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewHeroBanner(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('bannerPreviewImg');
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
