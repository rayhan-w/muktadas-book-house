@extends('layouts.app')

@section('title', 'প্রকাশক নিবন্ধন | মুক্তাদার বইঘর')

@section('content')
<div style="background: #f8fafc; padding: 60px 0; min-height: 80vh;">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 20px;">
        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; overflow: hidden;">
            
            <!-- Banner / Header -->
            <div style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%); padding: 36px 30px; text-align: center; color: #ffffff;">
                <div style="font-size: 40px; margin-bottom: 10px;">🏢</div>
                <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 8px;">প্রকাশক হিসেবে যুক্ত হোন</h1>
                <p style="font-size: 14.5px; color: #cbd5e1; max-width: 500px; margin: 0 auto; line-height: 1.5;">
                    মুক্তাদার বইঘরে আপনার প্রকাশনীর বইগুলো লক্ষাধিক পাঠকের কাছে পৌঁছে দিন। নিবন্ধন সম্পন্ন হলে অ্যাডমিন অনুমোদনের পর আপনি বই তালিকাভুক্ত করতে পারবেন।
                </p>
            </div>

            <div style="padding: 36px 30px;">
                @if ($errors->any())
                    <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('publisher.register.submit') }}" method="POST">
                    @csrf

                    <!-- Organization Info -->
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                            <span>🏢</span> প্রকাশনীর তথ্য
                        </h3>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                প্রকাশনীর নাম <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" name="publisher_company" value="{{ old('publisher_company') }}" required placeholder="যেমন: ঐতিহ্য প্রকাশনী, সমর্পণ প্রকাশন"
                                style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                প্রকাশনী সম্পর্কে সংক্ষিপ্ত পরিচিতি (ঐচ্ছিক)
                            </label>
                            <textarea name="publisher_bio" rows="3" placeholder="আপনার প্রকাশনীর বিশেষত্ব, প্রকাশের ধরন ইত্যাদি..."
                                style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">{{ old('publisher_bio') }}</textarea>
                        </div>
                    </div>

                    <!-- Contact Person Info -->
                    <div style="margin-bottom: 24px;">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                            <span>👤</span> দায়িত্বপ্রাপ্ত ব্যক্তির তথ্য
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                    দায়িত্বপ্রাপ্ত ব্যক্তির নাম <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="আপনার পুরো নাম"
                                    style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                    মোবাইল নম্বর <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="০১XXXXXXXXX"
                                    style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                অফিসিয়াল ইমেইল অ্যাড্রেস <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="contact@yourpublisher.com"
                                style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                প্রকাশনী / অফিসের ঠিকানা
                            </label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="বাংলাবাজার / কাঁটাবন, ঢাকা..."
                                style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Security / Password -->
                    <div style="margin-bottom: 28px;">
                        <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                            <span>🔒</span> অ্যাকাউন্টের নিরাপত্তা
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                    পাসওয়ার্ড (কমপক্ষে ৬ অক্ষর) <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="password" name="password" required placeholder="••••••••"
                                    style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                                    পাসওয়ার্ড নিশ্চিত করুন <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; font-family: inherit; box-sizing: border-box;">
                            </div>
                        </div>
                    </div>

                    <!-- Notice Banner -->
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px 18px; margin-bottom: 24px; font-size: 13.5px; color: #1e40af; line-height: 1.6;">
                        <div style="font-weight: 700; font-size: 14.5px; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                            <span>ℹ️</span> কোনো অগ্রিম অনলাইন ফি প্রয়োজন নেই:
                        </div>
                        প্রকাশক হিসেবে নিবন্ধনের জন্য কোনো অনলাইন অগ্রিম ফি দিতে হবে না। নিবন্ধন সম্পন্ন হওয়ার পর আপনার প্রকাশনীর প্রোফাইল তৈরি হবে। এরপর সরাসরি অ্যাডমিনের সাথে হোয়াটসঅ্যাপে আলোচনা সাপেক্ষে মেয়াদের চুক্তি (১ মাস, ৩ মাস, ৬ মাস, ১ বছর বা আজীবন) চূড়ান্ত ও অ্যাকাউন্ট অনুমোদন করিয়ে নিতে পারবেন।
                    </div>

                    <button type="submit" style="width: 100%; background: #0284c7; color: #ffffff; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; transition: 0.2s;">
                        বিনামূল্যে প্রকাশক হিসেবে আবেদন করুন →
                    </button>
                </form>

                @php
                    $rawPhone = \App\Models\SiteSetting::get('contact_whatsapp') ?: \App\Models\SiteSetting::get('contact_phone', '01700112233');
                    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                    if (str_starts_with($cleanPhone, '01')) {
                        $cleanPhone = '88' . $cleanPhone;
                    }
                @endphp
                <div style="margin-top: 24px; padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #0f172a;">নিবন্ধন বা চুক্তি সংক্রান্ত প্রশ্ন আছে?</div>
                        <div style="font-size: 12.5px; color: #64748b;">সরাসরি অ্যাডমিনের সাথে হোয়াটসঅ্যাপে কথা বলতে পারেন</div>
                    </div>
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('আসসালামু আলাইকুম। আমি মুক্তাদার বইঘরে প্রকাশক হিসেবে যুক্ত হতে আগ্রহী। নিয়ম ও শর্তাবলি জানতে চাই।') }}" target="_blank" style="background: #25d366; color: #fff; font-size: 13px; font-weight: 700; padding: 8px 14px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>💬</span> হোয়াটসঅ্যাপ চ্যাট
                    </a>
                </div>

                <div style="text-align: center; margin-top: 24px; font-size: 14px; color: #64748b;">
                    ইতিমধ্যে প্রকাশক অ্যাকাউন্ট আছে? 
                    <a href="{{ route('login') }}" style="color: #0284c7; font-weight: 700; text-decoration: none;">লগইন করুন</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
