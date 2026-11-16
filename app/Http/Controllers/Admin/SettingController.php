<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        $settings = [
            'site_name' => SiteSetting::get('site_name', 'মুক্তাদার বইঘর | Muktada\'s Boighor'),
            'site_tagline' => SiteSetting::get('site_tagline', 'জ্ঞানের আলোয় নতুন পথচলা — ভালো বই, সুন্দর ভাবনা'),
            'site_logo' => SiteSetting::getLogo(),
            'site_logo_raw' => SiteSetting::get('site_logo'),
            'author_name' => SiteSetting::get('author_name', 'মুক্তাদা'),
            'author_bio' => SiteSetting::get('author_bio', ''),
            'author_quote' => SiteSetting::get('author_quote', ''),
            'author_photo' => SiteSetting::get('author_photo', 'author-portrait.jpg'),
            'delivery_charge_dhaka' => SiteSetting::get('delivery_charge_dhaka', '60'),
            'delivery_charge_outside' => SiteSetting::get('delivery_charge_outside', '120'),
            'contact_email' => SiteSetting::get('contact_email', 'contact@muktadasbookhouse.com'),
            'contact_phone' => SiteSetting::get('contact_phone', '+880 1700-112233'),
            'contact_address' => SiteSetting::get('contact_address', 'ঢাকা, বাংলাদেশ'),
            'facebook_url' => SiteSetting::get('facebook_url', ''),
            'whatsapp_number' => SiteSetting::get('whatsapp_number', ''),
            'youtube_url' => SiteSetting::get('youtube_url', ''),
            'mail_mailer' => SiteSetting::get('mail_mailer', env('MAIL_MAILER', 'sendmail')),
            'mail_host' => SiteSetting::get('mail_host', env('MAIL_HOST', 'mail.muktadarboighor.com')),
            'mail_port' => SiteSetting::get('mail_port', env('MAIL_PORT', '465')),
            'mail_username' => SiteSetting::get('mail_username', env('MAIL_USERNAME', '')),
            'mail_password' => SiteSetting::get('mail_password', env('MAIL_PASSWORD', '')),
            'mail_encryption' => SiteSetting::get('mail_encryption', env('MAIL_ENCRYPTION', 'ssl')),
            'mail_from_address' => SiteSetting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'noreply@muktadarboighor.com')),
            'mail_from_name' => SiteSetting::get('mail_from_name', env('MAIL_FROM_NAME', 'মুক্তাদার বইঘর')),
        ];

        return view('admin.settings.index', compact('settings', 'admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'site_name' => 'required|string|max:200',
            'site_tagline' => 'nullable|string|max:300',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:4096',
            'author_name' => 'required|string|max:100',
            'author_bio' => 'nullable|string',
            'author_quote' => 'nullable|string',
            'delivery_charge_dhaka' => 'required|numeric|min:0',
            'delivery_charge_outside' => 'required|numeric|min:0',
            'contact_email' => 'required|email|max:120',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:300',
            'facebook_url' => 'nullable|string|max:200',
            'whatsapp_number' => 'nullable|string|max:50',
            'youtube_url' => 'nullable|string|max:200',
            'mail_mailer' => 'nullable|string|in:sendmail,smtp,log',
            'mail_host' => 'nullable|string|max:120',
            'mail_port' => 'nullable|string|max:10',
            'mail_username' => 'nullable|string|max:120',
            'mail_password' => 'nullable|string|max:120',
            'mail_encryption' => 'nullable|string|max:10',
            'mail_from_address' => 'nullable|email|max:120',
            'mail_from_name' => 'nullable|string|max:120',
            'author_photo' => 'nullable|image|max:2048',
            'admin_name' => 'nullable|string|max:100',
            'admin_email' => 'nullable|email|max:120|unique:users,email,' . ($admin ? $admin->id : 0),
            'admin_password' => 'nullable|string|min:6|confirmed',
        ], [
            'admin_password.min' => 'অ্যাডমিন নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'admin_password.confirmed' => 'নতুন পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
        ]);

        $settingKeys = [
            'site_name', 'site_tagline', 'author_name', 'author_bio', 'author_quote',
            'delivery_charge_dhaka', 'delivery_charge_outside', 'contact_email',
            'contact_phone', 'contact_address', 'facebook_url', 'whatsapp_number', 'youtube_url',
            'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_encryption', 'mail_from_address', 'mail_from_name'
        ];

        foreach ($settingKeys as $key) {
            if (isset($validated[$key])) {
                SiteSetting::set($key, (string) $validated[$key]);
            }
        }

        if ($request->hasFile('site_logo')) {
            $logoFile = $request->file('site_logo');
            $logoExt = $logoFile->getClientOriginalExtension();
            $logoName = 'logo_' . time() . '.' . $logoExt;
            $destDir = public_path('uploads');
            if (!file_exists($destDir)) {
                @mkdir($destDir, 0775, true);
            }
            $logoFile->move($destDir, $logoName);
            SiteSetting::set('site_logo', 'uploads/' . $logoName);

            // Also copy to public/muktadar-logo.jpg so static references automatically match
            try {
                @copy($destDir . '/' . $logoName, public_path('muktadar-logo.jpg'));
            } catch (\Throwable $e) {}
        }

        if ($request->hasFile('author_photo')) {
            $photoName = 'author_' . time() . '.' . $request->file('author_photo')->getClientOriginalExtension();
            $request->file('author_photo')->move(public_path(), $photoName);
            SiteSetting::set('author_photo', $photoName);
        }

        // Update Admin Credentials if provided
        if ($admin) {
            if (!empty($validated['admin_name'])) {
                $admin->name = $validated['admin_name'];
            }
            if (!empty($validated['admin_email'])) {
                $admin->email = $validated['admin_email'];
            }
            if (!empty($validated['admin_password'])) {
                $admin->password = Hash::make($validated['admin_password']);
            }
            $admin->save();
        }

        return back()->with('success', 'সকল ওয়েবসাইট, বিজনেস সেটিংস ও অ্যাডমিন প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:120',
        ]);

        $recipient = $request->input('test_email');
        $siteName = SiteSetting::get('site_name', 'মুক্তাদার বইঘর');

        try {
            \Illuminate\Support\Facades\Mail::raw("আসসালামু আলাইকুম,\n\nএটি '{$siteName}' ওয়েবসাইট থেকে পাঠানো একটি টেস্ট ইমেইল। আপনার ইমেইল ও মেইল সার্ভার কনফিগারেশন সফলভাবে কাজ করছে!\n\nতারিখ: " . date('Y-m-d H:i:s') . "\nমুক্তাদার বইঘর কারিগরি টিম", function ($message) use ($recipient, $siteName) {
                $message->to($recipient)
                        ->subject("ইমেইল টেস্ট সফল — {$siteName}");
            });

            return back()->with('success', "টেস্ট ইমেইল সফলভাবে '{$recipient}' ঠিকানায় পাঠানো হয়েছে! অনুগ্রহ করে আপনার ইনবক্স অথবা স্প্যাম ফোল্ডার চেক করুন।");
        } catch (\Throwable $e) {
            return back()->with('error', 'ইমেইল পাঠাতে সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }
}
