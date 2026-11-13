@extends('layouts.app')

@section('title', 'যোগাযোগ ও মতামত | মুক্তাদার বইঘর')

@section('content')
<div style="background: #ffffff; border-bottom: 1px solid var(--sp-border); padding: 30px 0; margin-bottom: 30px;">
    <div style="max-width: 1440px; margin: 0 auto; padding: 0 20px;">
        <span style="display: inline-flex; align-items: center; gap: 6px; background: var(--sp-paste-badge); color: var(--sp-burgundy); padding: 4px 12px; border-radius: var(--sp-radius-pill); font-size: 13px; font-weight: 700; margin-bottom: 8px;">
            <i class="bi bi-chat-heart-fill"></i> সরাসরি যোগাযোগ
        </span>
        <h1 style="font-size: 26px; color: var(--sp-heading); font-weight: 800; margin-bottom: 6px;">✉️ লেখকের সাথে যোগাযোগ করুন</h1>
        <p style="color: var(--sp-muted); font-size: 14.5px; margin: 0;">আপনার যেকোনো জিজ্ঞাসা, বইয়ের প্রতিক্রিয়া বা পরামর্শ জানাতে ফর্মটি পূরণ করুন।</p>
    </div>
</div>

<div style="max-width: 1440px; margin: 0 auto 60px; padding: 0 20px;">
    <div class="contact-grid">
        <!-- Form -->
        <div class="contact-box" style="background: #ffffff; border: 1px solid var(--sp-border); border-radius: var(--sp-radius); padding: 32px; box-shadow: var(--sp-shadow-sm);">
            <h2 style="font-size: 20px; color: var(--sp-heading); font-weight: 800; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-send-fill text-danger"></i> বার্তা পাঠান
            </h2>

            @if(session('success'))
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-check-circle-fill text-success"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="contact-form-row">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--sp-heading); margin-bottom: 6px;">আপনার নাম <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="name" required placeholder="আপনার পূর্ণ নাম লিখুন" value="{{ old('name') }}" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--sp-border); border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--sp-heading); margin-bottom: 6px;">ইমেইল অ্যাড্রেস <span style="color:#ef4444;">*</span></label>
                        <input type="email" name="email" required placeholder="example@mail.com" value="{{ old('email') }}" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--sp-border); border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'">
                    </div>
                </div>

                <div class="contact-form-row">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--sp-heading); margin-bottom: 6px;">মোবাইল নম্বর (ঐচ্ছিক)</label>
                        <input type="text" name="phone" placeholder="০১XXXXXXXXX" value="{{ old('phone') }}" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--sp-border); border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--sp-heading); margin-bottom: 6px;">বিষয়</label>
                        <input type="text" name="subject" value="{{ request('subject') ?: old('subject') }}" placeholder="বার্তা বা জিজ্ঞাসার বিষয়" style="width: 100%; padding: 11px 14px; border: 1.5px solid var(--sp-border); border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'">
                    </div>
                </div>

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--sp-heading); margin-bottom: 6px;">আপনার বার্তা বা প্রশ্ন <span style="color:#ef4444;">*</span></label>
                    <textarea name="message" rows="5" required placeholder="এখানে আপনার বার্তা বা পরামর্শ বিস্তারিত লিখুন..." style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--sp-border); border-radius: 8px; font-family: inherit; font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--sp-crimson)'" onblur="this.style.borderColor='var(--sp-border)'">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn-cart" style="width: auto; padding: 12px 32px; font-size: 15px; cursor: pointer;">
                    <i class="bi bi-send"></i> বার্তা পাঠান →
                </button>
            </form>
        </div>

        <!-- Info Sidebar -->
        <div class="contact-box" style="background: #ffffff; border: 1px solid var(--sp-border); border-radius: var(--sp-radius); padding: 30px; box-shadow: var(--sp-shadow-sm);">
            <h3 style="font-size: 18px; color: var(--sp-heading); font-weight: 800; margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-geo-alt-fill text-danger"></i> যোগাযোগের ঠিকানা
            </h3>
            
            <div style="font-size: 14px; line-height: 1.9; color: var(--sp-body);">
                <div style="margin-bottom: 12px;">
                    <strong style="color: var(--sp-heading); display: block;"><i class="bi bi-pin-map-fill text-danger me-1"></i> ঠিকানা:</strong>
                    <span style="color: var(--sp-muted);">{{ $settings['contact_address'] }}</span>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <strong style="color: var(--sp-heading); display: block;"><i class="bi bi-telephone-fill text-danger me-1"></i> ফোন:</strong>
                    <a href="tel:{{ $settings['contact_phone'] }}" style="color: var(--sp-burgundy); text-decoration: none; font-weight: 700;">{{ $settings['contact_phone'] }}</a>
                </div>

                <div style="margin-bottom: 14px;">
                    <strong style="color: var(--sp-heading); display: block;"><i class="bi bi-envelope-fill text-danger me-1"></i> ইমেইল:</strong>
                    <a href="mailto:{{ $settings['contact_email'] }}" style="color: var(--sp-burgundy); text-decoration: none; font-weight: 600;">{{ $settings['contact_email'] }}</a>
                </div>

                <!-- অন্যান্য প্রাপ্তি স্থান (Page 1) -->
                <div style="margin-top: 16px; padding: 12px 14px; background: var(--sp-paste-light); border: 1px solid var(--sp-paste-border); border-radius: 10px; font-size: 13px;">
                    <strong style="color: var(--sp-burgundy); display: block; margin-bottom: 4px; font-weight: 800;">
                        <i class="bi bi-shop me-1"></i> অন্যান্য সরাসরি প্রাপ্তি স্থান:
                    </strong>
                    <div style="color: var(--sp-body); line-height: 1.6;">
                        (১) <strong>সি এস ডি</strong>, ঢাকা সেনানিবাস, ঢাকা<br>
                        (২) <strong>রাওয়া পাবলিকেশন</strong>, রাওয়া কমপ্লেক্স, মহাখালী, ঢাকা।
                    </div>
                </div>

                @if($settings['whatsapp_number'])
                    <div style="margin-top: 18px;">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) }}" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #16a34a; color: #ffffff; padding: 12px 18px; border-radius: var(--sp-radius-pill); text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
                            <i class="bi bi-whatsapp"></i> WhatsApp এ চ্যাট করুন
                        </a>
                    </div>
                @endif
            </div>

            <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--sp-border); font-size: 13px; color: var(--sp-muted); line-height: 1.6;">
                <i class="bi bi-clock-history me-1"></i> অর্ডার বা জরুরি জিজ্ঞাসায় সকাল ৯টা থেকে রাত ৯টা পর্যন্ত হেল্পলাইনে সরাসরি কল বা WhatsApp করতে পারেন।
            </div>
        </div>
    </div>
</div>
@endsection
