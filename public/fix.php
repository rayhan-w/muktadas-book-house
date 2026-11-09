<?php
header('Content-Type: text/html; charset=utf-8');

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=muktadar_boighor_db;charset=utf8mb4',
        'muktadar_boighor_user',
        'pDa_uZLSq3Z6dGG',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    );

    // 1. Convert all tables to utf8mb4
    $tables = ['site_settings', 'books', 'categories', 'reviews', 'users', 'memberships', 'coupons', 'blogs', 'contact_messages'];
    foreach ($tables as $t) {
        $pdo->exec("ALTER TABLE `{$t}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    // 2. Settings
    $settings = [
        'site_name' => "মুক্তাদার বইঘর | Muktada's Boighor",
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

    $stmt = $pdo->prepare("UPDATE site_settings SET `value` = :val WHERE `key` = :k");
    foreach ($settings as $k => $v) {
        $stmt->execute([':val' => $v, ':k' => $k]);
    }

    // 3. Categories
    $categories = [
        'islamic' => ['ইসলামিক', 'দ্বীন, জীবন ও আখেরাতের সঠিক পাথেয় সম্পর্কিত বই।'],
        'novels' => ['উপন্যাস', 'সমাজ, প্রেম ও মানবিক অনুভূতির অনন্য আখ্যান।'],
        'stories' => ['গল্প', 'জীবনের ছোট ছোট অনুপ্রেরণামূলক গল্পের সমাহার।'],
        'biography' => ['আত্মজীবনী', 'বরেণ্য মনীষী ও মহৎ জীবনের শিক্ষা।'],
        'self-development' => ['আত্মউন্নয়ন', 'ব্যক্তিত্ব বিকাশ ও সফল ক্যারিয়ার গঠনের বই।'],
        'history' => ['ইতিহাস', 'বিশ্ব ও বাংলার ঐতিহ্যের প্রামাণ্য ইতিহাস।'],
        'liberation-war' => ['মুক্তিযুদ্ধ', 'একাত্তরের বীরত্বগাথা ও গৌরবোজ্জ্বল অধ্যায়।'],
        'career' => ['পেশাগত/ক্যারিয়ার', 'কর্মক্ষেত্রে দক্ষতা ও নেতৃত্ব অর্জনের নির্দেশিকা।'],
        'children' => ['শিশু ও কিশোর', 'শিশুদের মেধা ও নৈতিকতা বিকাশের বই।'],
        'other' => ['অন্যান্য', 'বিবিধ চিন্তাশীল সাহিত্য ও গবেষণামূলক বই।'],
    ];

    $catStmt = $pdo->prepare("UPDATE categories SET `name` = :n, `description` = :d WHERE `slug` = :s");
    foreach ($categories as $slug => $data) {
        $catStmt->execute([':n' => $data[0], ':d' => $data[1], ':s' => $slug]);
    }

    // 4. Books
    $books = [
        'alor-poth' => ['আলোর পথ', 'সত্য, সুন্দর ও আত্মশুদ্ধির আলোকিত জীবন গড়ার এক অনন্য জীবনমুখী গ্রন্থ।', 'জীবনের কঠিন সময়ে আত্মিক প্রশান্তির সন্ধান করতে গিয়ে হৃদয়ের গভীর উপলব্ধি থেকেই এই বইটি রচিত হয়।', '২০২৪'],
        'islamer-jibon' => ['ইসলামের জীবন ও আদর্শ', 'দৈনন্দিন জীবনে ইসলামের শ্বাশত আদর্শ ও নৈতিকতার বাস্তব প্রয়োগ।', 'আধুনিক যুবসমাজের নৈতিক সংকট মোকাবিলায় সহজ ভাষায় দ্বীনি মূল্যবোধ তুলে ধরার তাগিদ থেকে এ গ্রন্থের জন্ম।', '২০২৩'],
        'sundor-jibon' => ['সুন্দর জীবনের পথে', 'হতাশা কাটিয়ে জীবনে ইতিবাচক দৃষ্টিভঙ্গি ও আশাবাদ জাগিয়ে তোলার শক্তিশালী উপন্যাস।', 'বাস্তব জীবনের তিনটি সত্য ঘটনা অবলম্বনে চরিত্রগুলো গড়ে তোলা হয়েছে।', '২০২৪'],
        'duniyar-jibon' => ['দুনিয়ার জীবন ও আখিরাত', 'ক্ষণস্থায়ী পৃথিবীর মায়া আর চিরস্থায়ী আখিরাতের প্রস্তুতি নিয়ে গভীর আত্মবিশ্লেষণ।', 'মৃত্যুচিন্তা ও আখিরাতের জবাবদিহিতা কীভাবে মানুষের দুনিয়ার জীবনকে সুন্দর করে, তা দেখাতেই বইটি লেখা।', '২০২৩'],
        'jibone-rupantor' => ['জীবনের রূপান্তর', 'খারাপ অভ্যাস পরিত্যাগ ও নিজের ভেতরের সম্ভাবনাকে জাগিয়ে তোলার রূপরেখা।', 'পাঠকদের শত শত চিঠি ও মানসিক হতাশার প্রশ্নের জবাব হিসেবে এই বইটি সুবিন্যস্ত করা হয়েছে।', '২০২৪'],
        'sahabider-jibon' => ['সাহাবীদের জীবনকথা', 'রাসূলুল্লাহ (সা.)-এর সাহাবাদের ত্যাগ, সততা ও আত্মত্যাগের অমর গাথা।', 'তরুণ প্রজন্মের জন্য নির্ভরযোগ্য সূত্রে সাহাবিদের বীরত্ব ও চরিত্র রূপায়ণ করার প্রয়াস।', '২০২২'],
        'khushir-pothe' => ['খুশির পথে', 'হৃদয়ের সত্যিকারের প্রশান্তি ও সুখের ঠিকানা পাওয়ার আধ্যাত্মিক যাত্রা।', 'পার্থিব প্রাচুর্যের মাঝেও কেন মানুষ অশান্তিতে থাকে—সেই মূল কারণ অনুসন্ধান করতে গিয়ে বইটি রচিত হয়।', '২০২৪'],
        'nobijir-jibon' => ['নবীজির জীবন ও কর্ম', 'বিশ্বনবীর জীবনের প্রতিটি অধ্যায় থেকে আধুনিক মানুষের জন্য শিক্ষা ও দিকনির্দেশনা।', 'প্রেম ও ভক্তির সাথে সমকালীন জীবনের প্রতিটি সমস্যার নববী সমাধানের এক অপূর্ব সমন্বয়।', '২০২৩'],
        'projnar-alo' => ['প্রজ্ঞার আলো (আসন্ন বই)', 'জীবন, সমাজ ও মহাকালের গভীর দার্শনিক চিন্তা ও প্রজ্ঞার সমাহার।', 'লেখক বর্তমানে এ বইটি চূড়ান্ত সম্পাদনায় ব্যস্ত আছেন।', '২০২৫'],
    ];

    $bStmt = $pdo->prepare("UPDATE books SET `title` = :t, `summary` = :sum, `story_behind` = :sb, `publication_year` = :py, `author_name` = 'মুক্তাদা' WHERE `slug` = :s");
    foreach ($books as $slug => $data) {
        $bStmt->execute([':t' => $data[0], ':sum' => $data[1], ':sb' => $data[2], ':py' => $data[3], ':s' => $slug]);
    }

    // 5. Reviews
    $reviews = [
        'অসাধারণ একটি বই! প্রতিটি পাতায় মনের খোরাক পেয়েছি। লেখকের লেখার ধরণ খুবই সাবলীল ও হৃদয়স্পর্শী।',
        'বইটির প্রতিটি গল্প মন ছুঁয়ে যায়। নিজের জীবনকে নতুন করে উপলব্ধি করতে শিখিয়েছে। অত্যন্ত সুপারিশকৃত!',
        'একটানা পড়ে শেষ করলাম। লেখকের চিন্তার গভীরতা সত্যিই প্রশংসনীয়। সকলের পড়া উচিত।',
        'আমার জীবনের অন্যতম সেরা বই। উপহার দেওয়ার জন্য চমৎকার একটি সংকলন।'
    ];

    $revStmt = $pdo->prepare("UPDATE reviews SET `comment` = :c, `customer_name` = 'মোজাম্মেল হক' WHERE `id` = :id");
    $i = 1;
    foreach ($reviews as $rev) {
        $revStmt->execute([':c' => $rev, ':id' => $i]);
        $i++;
    }

    // 6. Users
    $pdo->exec("UPDATE users SET `name` = 'অ্যাডমিন মুক্তাদা' WHERE `email` = 'admin@muktadasbookhouse.com'");
    $pdo->exec("UPDATE users SET `name` = 'রহিম আহমেদ' WHERE `email` = 'reader@example.com'");

    echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h1 style='color: #10b981;'>🎉 আলহামদুলিল্লাহ! ডাটাবেজের সকল বাংলা লেখা সফলভাবে ঠিক হয়ে গেছে!</h1>";
    echo "<p style='font-size: 18px; color: #374151;'>এখন হোমপেজ রিলোড দিলে সব ঝকঝকে বাংলা দেখতে পাবেন।</p>";
    echo "<p><a href='/' style='display: inline-block; padding: 12px 24px; background: #1e3a8a; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold;'>🏠 হোমপেজে যান</a></p>";
    echo "</div>";
} catch (Exception $e) {
    echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>";
    echo "<h2 style='color: #ef4444;'>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "</div>";
}
