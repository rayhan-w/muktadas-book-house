@extends('layouts.app')

@section('title', 'যোগাযোগ ও মতামত | মুক্তাদার বইঘর')

@section('content')
<div style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 35px 0; margin-bottom: 40px;">
    <div class="container">
        <h1 style="font-size: 28px; color: var(--primary); margin-bottom: 6px;">✉️ লেখকের সাথে যোগাযোগ করুন</h1>
        <p style="color: var(--text-muted); font-size: 15px;">আপনার যেকোনো জিজ্ঞাসা, বইয়ের প্রতিক্রিয়া বা পরামর্শ জানাতে ফর্মটি পূরণ করুন।</p>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 40px; align-items: flex-start;">
        <!-- Form -->
        <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 35px; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 20px; color: var(--primary); margin-bottom: 20px;">বার্তা পাঠান</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">আপনার নাম *</label>
                        <input type="text" name="name" required placeholder="নাম লিখুন" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">ইমেইল অ্যাড্রেস *</label>
                        <input type="email" name="email" required placeholder="example@mail.com" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">মোবাইল নম্বর (ঐচ্ছিক)</label>
                        <input type="text" name="phone" placeholder="০১XXXXXXXXX" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">বিষয়</label>
                        <input type="text" name="subject" value="{{ request('subject') }}" placeholder="বার্তা বা জিজ্ঞাসার বিষয়" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 8px;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">আপনার বার্তা বা প্রশ্ন *</label>
                    <textarea name="message" rows="5" required placeholder="এখানে বিস্তারিত লিখুন..." style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border-color); border-radius: 8px; font-family: inherit; font-size: 15px;"></textarea>
                </div>

                <button type="submit" class="btn btn-gold" style="padding: 12px 25px; font-size: 15px;">বার্তা পাঠান →</button>
            </form>
        </div>

        <!-- Info Sidebar -->
        <div style="background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 30px; box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 18px; color: var(--primary); margin-bottom: 16px;">যোগাযোগের ঠিকানা</h3>
            <div style="font-size: 14px; line-height: 2; color: var(--text-dark);">
                <p>📍 <strong>ঠিকানা:</strong> {{ $settings['contact_address'] }}</p>
                <p>📞 <strong>ফোন:</strong> {{ $settings['contact_phone'] }}</p>
                <p>✉️ <strong>ইমেইল:</strong> {{ $settings['contact_email'] }}</p>
                @if($settings['whatsapp_number'])
                    <p>💬 <strong>WhatsApp:</strong> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number']) }}" target="_blank" style="color: #16a34a; font-weight: 700;">মেসেজ দিন</a></p>
                @endif
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 13px; color: var(--text-muted);">
                অর্ডার সংক্রান্ত যেকোনো জরুরি জিজ্ঞাসায় সকাল ৯টা থেকে রাত ৯টা পর্যন্ত হেল্পলাইনে কল করতে পারেন।
            </div>
        </div>
    </div>
</div>
@endsection
