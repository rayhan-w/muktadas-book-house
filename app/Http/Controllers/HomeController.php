<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\SiteSetting;
use App\Models\Review;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allBooks = Book::with('categories')->approved()->latest()->get();
        
        $featuredBooks = Book::with('categories')->approved()->where('is_featured', true)->latest()->take(12)->get();
        if ($featuredBooks->isEmpty()) {
            $featuredBooks = $allBooks;
        }

        $latestBooks = Book::with('categories')->approved()->where('is_latest', true)->latest()->take(12)->get();
        if ($latestBooks->isEmpty()) {
            $latestBooks = $allBooks;
        }

        $popularBooks = Book::with('categories')->approved()->where('is_popular', true)->latest()->take(12)->get();
        if ($popularBooks->isEmpty()) {
            $popularBooks = $allBooks;
        }

        $upcomingBooks = Book::with('categories')->approved()->where('is_upcoming', true)->latest()->take(8)->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $reviews = Review::where('status', 'approved')->with('book')->latest()->take(6)->get();

        $settings = [
            'site_name' => SiteSetting::get('site_name', 'মুক্তাদার বইঘর | Muktada\'s Boighor'),
            'site_tagline' => SiteSetting::get('site_tagline', 'জ্ঞানের আলোয় নতুন পথচলা — ভালো বই, সুন্দর ভাবনা'),
            'author_name' => SiteSetting::get('author_name', 'মুক্তাদা'),
            'author_bio' => SiteSetting::get('author_bio', 'লেখক ও গবেষক'),
            'author_quote' => SiteSetting::get('author_quote', 'বই হলো মনের জানালা, যা মানুষকে সত্য ও সুন্দরের পথ দেখায়।'),
            'author_photo' => SiteSetting::get('author_photo', 'author-portrait.jpg'),
        ];

        return view('home', compact('allBooks', 'featuredBooks', 'latestBooks', 'popularBooks', 'upcomingBooks', 'categories', 'reviews', 'settings'));
    }

    public function author()
    {
        $authorBooks = Book::approved()->latest()->get();
        $settings = [
            'author_name' => SiteSetting::get('author_name', 'মুক্তাদা'),
            'author_bio' => SiteSetting::get('author_bio', ''),
            'author_quote' => SiteSetting::get('author_quote', ''),
            'author_photo' => SiteSetting::get('author_photo', 'author-portrait.jpg'),
            'facebook_url' => SiteSetting::get('facebook_url', '#'),
            'whatsapp_number' => SiteSetting::get('whatsapp_number', ''),
            'contact_email' => SiteSetting::get('contact_email', ''),
        ];

        return view('pages.author', compact('authorBooks', 'settings'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        $settings = [
            'contact_email' => SiteSetting::get('contact_email', 'contact@muktadasbookhouse.com'),
            'contact_phone' => SiteSetting::get('contact_phone', '+880 1700-112233'),
            'contact_address' => SiteSetting::get('contact_address', 'ঢাকা, বাংলাদেশ'),
            'facebook_url' => SiteSetting::get('facebook_url', '#'),
            'whatsapp_number' => SiteSetting::get('whatsapp_number', ''),
        ];
        return view('pages.contact', compact('settings'));
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। শীঘ্রই লেখক আপনার সাথে যোগাযোগ করবেন।');
    }

    public function subscribeNewsletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:120',
        ]);

        NewsletterSubscriber::updateOrCreate(['email' => $validated['email']], ['is_active' => true]);

        return back()->with('newsletter_success', 'মুক্তাদার বইঘরের নিউজলেটারে সাবস্ক্রাইব করার জন্য ধন্যবাদ!');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function refundPolicy()
    {
        return view('pages.refund-policy');
    }
}
