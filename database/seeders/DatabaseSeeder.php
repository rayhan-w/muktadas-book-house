<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\SiteSetting;
use App\Models\Membership;
use App\Models\Coupon;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin & Customer Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@muktadasbookhouse.com'],
            [
                'name' => 'অ্যাডমিন মুক্তাদা',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '01700112233',
                'address' => 'ঢাকা, বাংলাদেশ',
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'reader@example.com'],
            [
                'name' => 'রহিম আহমেদ',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '01811223344',
                'address' => 'মিরপুর, ঢাকা',
                'membership_plan' => '১ বছর',
                'membership_expires_at' => now()->addYear(),
            ]
        );

        // 2. Categories
        $categoriesData = [
            ['name' => 'ইসলামিক', 'slug' => 'islamic', 'description' => 'দ্বীন, জীবন ও আখেরাতের সঠিক পাথেয় সম্পর্কিত বই।'],
            ['name' => 'উপন্যাস', 'slug' => 'novels', 'description' => 'সমাজ, প্রেম ও মানবিক অনুভূতির অনন্য আখ্যান।'],
            ['name' => 'গল্প', 'slug' => 'stories', 'description' => 'জীবনের ছোট ছোট অনুপ্রেরণামূলক গল্পের সমাহার।'],
            ['name' => 'আত্মজীবনী', 'slug' => 'biography', 'description' => 'বরেণ্য মনীষী ও মহৎ জীবনের শিক্ষা।'],
            ['name' => 'আত্মউন্নয়ন', 'slug' => 'self-development', 'description' => 'ব্যক্তিত্ব বিকাশ ও সফল ক্যারিয়ার গঠনের বই।'],
            ['name' => 'ইতিহাস', 'slug' => 'history', 'description' => 'বিশ্ব ও বাংলার ঐতিহ্যের প্রামাণ্য ইতিহাস।'],
            ['name' => 'মুক্তিযুদ্ধ', 'slug' => 'liberation-war', 'description' => 'একাত্তরের বীরত্বগাথা ও গৌরবোজ্জ্বল অধ্যায়।'],
            ['name' => 'পেশাগত/ক্যারিয়ার', 'slug' => 'career', 'description' => 'কর্মক্ষেত্রে দক্ষতা ও নেতৃত্ব অর্জনের নির্দেশিকা।'],
            ['name' => 'শিশু ও কিশোর', 'slug' => 'children', 'description' => 'শিশুদের মেধা ও নৈতিকতা বিকাশের বই।'],
            ['name' => 'অন্যান্য', 'slug' => 'other', 'description' => 'বিবিধ চিন্তাশীল সাহিত্য ও গবেষণামূলক বই।'],
        ];

        $categories = [];
        foreach ($categoriesData as $index => $cat) {
            $categories[$cat['slug']] = Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // 3. Books
        $booksData = [
            [
                'title' => 'আলোর পথ',
                'slug' => 'alor-poth',
                'author_name' => 'মুক্তাদা',
                'summary' => 'সত্য, সুন্দর ও আত্মশুদ্ধির আলোকিত জীবন গড়ার এক অনন্য জীবনমুখী গ্রন্থ।',
                'story_behind' => 'জীবনের কঠিন সময়ে আত্মিক প্রশান্তির সন্ধান করতে গিয়ে হৃদয়ের গভীর উপলব্ধি থেকেই এই বইটি রচিত হয়।',
                'publication_year' => '২০২৪',
                'page_count' => 240,
                'price_hardcopy' => 350,
                'price_ebook' => 220,
                'discount_percent' => 15,
                'stock_quantity' => 85,
                'cover_image' => 'covers/alor-poth.png',
                'preview_pages' => 3,
                'is_featured' => true,
                'is_popular' => true,
                'is_latest' => true,
                'category_slug' => 'islamic',
            ],
            [
                'title' => 'ইসলামের জীবন ও আদর্শ',
                'slug' => 'islamer-jibon',
                'author_name' => 'মুক্তাদা',
                'summary' => 'দৈনন্দিন জীবনে ইসলামের শ্বাশত আদর্শ ও নৈতিকতার বাস্তব প্রয়োগ।',
                'story_behind' => 'আধুনিক যুবসমাজের নৈতিক সংকট মোকাবিলায় সহজ ভাষায় দ্বীনি মূল্যবোধ তুলে ধরার তাগিদ থেকে এ গ্রন্থের জন্ম।',
                'publication_year' => '২০২৩',
                'page_count' => 280,
                'price_hardcopy' => 400,
                'price_ebook' => 250,
                'discount_percent' => 10,
                'stock_quantity' => 60,
                'cover_image' => 'covers/islamer-pothe.png',
                'preview_pages' => 4,
                'is_featured' => true,
                'is_popular' => true,
                'is_latest' => true,
                'category_slug' => 'islamic',
            ],
            [
                'title' => 'সুন্দর জীবনের পথে',
                'slug' => 'sundor-jibon',
                'author_name' => 'মুক্তাদা',
                'summary' => 'হতাশা কাটিয়ে জীবনে ইতিবাচক দৃষ্টিভঙ্গি ও আশাবাদ জাগিয়ে তোলার শক্তিশালী উপন্যাস।',
                'story_behind' => 'বাস্তব জীবনের তিনটি সত্য ঘটনা অবলম্বনে চরিত্রগুলো গড়ে তোলা হয়েছে।',
                'publication_year' => '২০২৪',
                'page_count' => 310,
                'price_hardcopy' => 450,
                'price_ebook' => 280,
                'discount_percent' => 0,
                'stock_quantity' => 45,
                'cover_image' => 'covers/sundor-jibon.png',
                'preview_pages' => 3,
                'is_featured' => true,
                'is_popular' => true,
                'is_latest' => true,
                'category_slug' => 'novels',
            ],
            [
                'title' => 'দুনিয়ার জীবন ও আখিরাত',
                'slug' => 'duniyar-jibon',
                'author_name' => 'মুক্তাদা',
                'summary' => 'ক্ষণস্থায়ী পৃথিবীর মায়া আর চিরস্থায়ী আখিরাতের প্রস্তুতি নিয়ে গভীর আত্মবিশ্লেষণ।',
                'story_behind' => 'মৃত্যুচিন্তা ও আখিরাতের জবাবদিহিতা কীভাবে মানুষের দুনিয়ার জীবনকে সুন্দর করে, তা দেখাতেই বইটি লেখা।',
                'publication_year' => '২০২৩',
                'page_count' => 190,
                'price_hardcopy' => 300,
                'price_ebook' => 190,
                'discount_percent' => 5,
                'stock_quantity' => 70,
                'cover_image' => 'covers/duniyar-jibon.png',
                'preview_pages' => 3,
                'is_featured' => false,
                'is_popular' => true,
                'is_latest' => true,
                'category_slug' => 'islamic',
            ],
            [
                'title' => 'জীবনের রূপান্তর',
                'slug' => 'jibone-rupantor',
                'author_name' => 'মুক্তাদা',
                'summary' => 'খারাপ অভ্যাস পরিত্যাগ ও নিজের ভেতরের সম্ভাবনাকে জাগিয়ে তোলার রূপরেখা।',
                'story_behind' => 'পাঠকদের শত শত চিঠি ও মানসিক হতাশার প্রশ্নের জবাব হিসেবে এই বইটি সুবিন্যস্ত করা হয়েছে।',
                'publication_year' => '২০২৪',
                'page_count' => 220,
                'price_hardcopy' => 380,
                'price_ebook' => 240,
                'discount_percent' => 10,
                'stock_quantity' => 90,
                'cover_image' => 'covers/jibone-rupantor.png',
                'preview_pages' => 5,
                'is_featured' => true,
                'is_popular' => true,
                'is_latest' => true,
                'category_slug' => 'self-development',
            ],
            [
                'title' => 'সাহাবীদের জীবনকথা',
                'slug' => 'sahabider-jibon',
                'author_name' => 'মুক্তাদা',
                'summary' => 'রাসূলুল্লাহ (সা.)-এর সাহাবাদের ত্যাগ, সততা ও আত্মত্যাগের অমর গাথা।',
                'story_behind' => 'তরুণ প্রজন্মের জন্য নির্ভরযোগ্য সূত্রে সাহাবিদের বীরত্ব ও চরিত্র রূপায়ণ করার প্রয়াস।',
                'publication_year' => '২০২২',
                'page_count' => 350,
                'price_hardcopy' => 500,
                'price_ebook' => 300,
                'discount_percent' => 20,
                'stock_quantity' => 35,
                'cover_image' => 'covers/sahabider-jibon.png',
                'preview_pages' => 3,
                'is_featured' => false,
                'is_popular' => true,
                'is_latest' => false,
                'category_slug' => 'biography',
            ],
            [
                'title' => 'খুশির পথে',
                'slug' => 'khushir-pothe',
                'author_name' => 'মুক্তাদা',
                'summary' => 'হৃদয়ের সত্যিকারের প্রশান্তি ও সুখের ঠিকানা পাওয়ার আধ্যাত্মিক যাত্রা।',
                'story_behind' => 'পার্থিব প্রাচুর্যের মাঝেও কেন মানুষ অশান্তিতে থাকে—সেই মূল কারণ অনুসন্ধান করতে গিয়ে বইটি রচিত হয়।',
                'publication_year' => '২০২৪',
                'page_count' => 200,
                'price_hardcopy' => 320,
                'price_ebook' => 200,
                'discount_percent' => 0,
                'stock_quantity' => 110,
                'cover_image' => 'covers/khushir-pothe.png',
                'preview_pages' => 3,
                'is_featured' => true,
                'is_popular' => false,
                'is_latest' => true,
                'category_slug' => 'stories',
            ],
            [
                'title' => 'নবীজির জীবন ও কর্ম',
                'slug' => 'nobijir-jibon',
                'author_name' => 'মুক্তাদা',
                'summary' => 'বিশ্বনবীর জীবনের প্রতিটি অধ্যায় থেকে আধুনিক মানুষের জন্য শিক্ষা ও দিকনির্দেশনা।',
                'story_behind' => 'প্রেম ও ভক্তির সাথে সমকালীন জীবনের প্রতিটি সমস্যার নববী সমাধানের এক অপূর্ব সমন্বয়।',
                'publication_year' => '২০২৩',
                'page_count' => 420,
                'price_hardcopy' => 600,
                'price_ebook' => 350,
                'discount_percent' => 15,
                'stock_quantity' => 50,
                'cover_image' => 'covers/nobijir-jibon.png',
                'preview_pages' => 5,
                'is_featured' => true,
                'is_popular' => true,
                'is_latest' => false,
                'category_slug' => 'biography',
            ],
            [
                'title' => 'প্রজ্ঞার আলো (আসন্ন বই)',
                'slug' => 'projnar-alo',
                'author_name' => 'মুক্তাদা',
                'summary' => 'জীবন, সমাজ ও মহাকালের গভীর দার্শনিক চিন্তা ও প্রজ্ঞার সমাহার।',
                'story_behind' => 'লেখক বর্তমানে এ বইটি চূড়ান্ত সম্পাদনায় ব্যস্ত আছেন।',
                'publication_year' => '২০২৫',
                'page_count' => 260,
                'price_hardcopy' => 450,
                'price_ebook' => 280,
                'discount_percent' => 0,
                'stock_quantity' => 0,
                'stock_status' => 'in_stock',
                'cover_image' => 'covers/alor-poth.png',
                'preview_pages' => 2,
                'is_featured' => false,
                'is_popular' => false,
                'is_latest' => false,
                'is_upcoming' => true,
                'expected_date' => 'অমর একুশে বইমেলা ২০২৫',
                'category_slug' => 'self-development',
            ],
        ];

        foreach ($booksData as $b) {
            $catSlug = $b['category_slug'];
            unset($b['category_slug']);
            $book = Book::updateOrCreate(['slug' => $b['slug']], $b);
            if (isset($categories[$catSlug])) {
                $book->categories()->syncWithoutDetaching([$categories[$catSlug]->id]);
            }

            // Add verified approved review for each
            Review::updateOrCreate(
                ['book_id' => $book->id, 'customer_name' => 'মোজাম্মেল হক'],
                [
                    'customer_email' => 'reader1@example.com',
                    'rating' => 5,
                    'comment' => 'অসাধারণ একটি বই! প্রতিটি পাতায় মনের খোরাক পেয়েছি। লেখকের লেখার ধরণ খুবই সাবলীল ও হৃদয়স্পর্শী।',
                    'is_verified_purchase' => true,
                    'status' => 'approved',
                ]
            );
        }

        // 4. Site Settings
        $settings = [
            'site_name' => 'মুক্তাদার বইঘর | Muktada\'s Boighor',
            'site_tagline' => 'জ্ঞানের আলোয় নতুন পথচলা — ভালো বই, সুন্দর ভাবনা',
            'author_name' => 'মুক্তাদা',
            'author_bio' => 'লেখক, চিন্তক ও গবেষক। জীবন, সমাজ ও আত্মউন্নয়নমূলক সাহিত্যের মাধ্যমে মানুষের হৃদয় আলোকিত করাই তাঁর লেখার মূল উদ্দেশ্য। তাঁর প্রকাশিত বইগুলো পাঠকসমাজে ব্যাপক সমাদৃত হয়েছে।',
            'author_quote' => 'বই হলো মনের জানালা, যা মানুষকে সত্য ও সুন্দরের পথ দেখায়। সুন্দর জীবন গড়তে ভালো বইয়ের কোনো বিকল্প নেই।',
            'author_photo' => 'author-portrait.jpg',
            'bkash_number' => '01700-112233 (Merchant / Send Money)',
            'nagad_number' => '01800-445566 (Merchant)',
            'upay_number' => '01900-778899 (Personal)',
            'payment_instruction' => 'বিকাশ, নগদ বা উপায়-এ নির্ধারিত টাকা পাঠিয়ে Transaction ID এবং আপনার নম্বরটি দিন। তথ্য সঠিক হলে দ্রুত অর্ডার সম্পন্ন হবে।',
            'delivery_charge_dhaka' => '60',
            'delivery_charge_outside' => '120',
            'contact_email' => 'contact@muktadasbookhouse.com',
            'contact_phone' => '+880 1700-112233',
            'contact_address' => 'কনকর্ড টাওয়ার, শান্তিনগর, ঢাকা-১২১৭',
            'facebook_url' => 'https://facebook.com/muktadasbookhouse',
            'whatsapp_number' => '+8801700112233',
            'youtube_url' => 'https://youtube.com',
        ];

        foreach ($settings as $k => $v) {
            SiteSetting::set($k, $v);
        }

        // 5. Memberships
        Membership::updateOrCreate(
            ['slug' => 'one-year'],
            [
                'title' => '১ বছরের মেম্বারশিপ',
                'duration_months' => 12,
                'price' => 500,
                'discount_percent' => 10,
                'free_ebooks_count' => 1,
                'benefits' => "সকল হার্ডকপিতে ১০% অতিরিক্ত ছাড়\n১টি ফ্রি প্রিমিয়াম ই-বুক\nনতুন বই প্রকাশে অগ্রাধিকার ডেলিভারি\nবিশেষ সদস্য অফার",
                'is_active' => true,
            ]
        );

        Membership::updateOrCreate(
            ['slug' => 'two-years'],
            [
                'title' => '২ বছরের মেম্বারশিপ',
                'duration_months' => 24,
                'price' => 900,
                'discount_percent' => 15,
                'free_ebooks_count' => 3,
                'benefits' => "সকল হার্ডকপিতে ১৫% অতিরিক্ত ছাড়\n৩টি ফ্রি প্রিমিয়াম ই-বুক\nলেখকের স্বাক্ষরিত বিশেষ কপি উপহার\nপ্রি-অর্ডারে বিশেষ সুবিধা",
                'is_active' => true,
            ]
        );

        Membership::updateOrCreate(
            ['slug' => 'lifetime'],
            [
                'title' => 'লাইফটাইম মেম্বারশিপ',
                'duration_months' => 120, // 10 years / lifetime
                'price' => 2000,
                'discount_percent' => 25,
                'free_ebooks_count' => 10,
                'benefits' => "আজীবন সকল বইয়ে ২৫% ভিআইপি ছাড়\nসকল নতুন ই-বুক স্বয়ংক্রিয়ভাবে ফ্রি\nলেখকের সাথে সরাসরি মতবিনিময় সেশনে আমন্ত্রণ\nবিশেষ ক্লাব প্রিভিলেজ",
                'is_active' => true,
            ]
        );

        // 6. Coupons
        Coupon::updateOrCreate(
            ['code' => 'MUKTADA10'],
            [
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_spend' => 300,
                'valid_until' => now()->addMonths(6),
                'usage_limit' => 500,
                'times_used' => 12,
                'is_active' => true,
            ]
        );
        Coupon::updateOrCreate(
            ['code' => 'BOIGHOR50'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 50,
                'min_spend' => 500,
                'valid_until' => now()->addMonths(3),
                'usage_limit' => 200,
                'times_used' => 5,
                'is_active' => true,
            ]
        );
    }
}
