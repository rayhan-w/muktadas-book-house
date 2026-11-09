<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => SiteSetting::get('site_name', 'মুক্তাদার বইঘর | Muktada\'s Boighor'),
            'site_tagline' => SiteSetting::get('site_tagline', 'জ্ঞানের আলোয় নতুন পথচলা — ভালো বই, সুন্দর ভাবনা'),
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
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:200',
            'site_tagline' => 'nullable|string|max:300',
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
            'author_photo' => 'nullable|image|max:2048',
        ]);

        foreach ($validated as $key => $val) {
            if ($key !== 'author_photo') {
                SiteSetting::set($key, (string) $val);
            }
        }

        if ($request->hasFile('author_photo')) {
            $photoName = 'author_' . time() . '.' . $request->file('author_photo')->getClientOriginalExtension();
            $request->file('author_photo')->move(public_path(), $photoName);
            SiteSetting::set('author_photo', $photoName);
        }

        return back()->with('success', 'সকল ওয়েবসাইট ও বিজনেস সেটিংস সফলভাবে আপডেট করা হয়েছে।');
    }
}
