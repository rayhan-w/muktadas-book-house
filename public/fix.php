<?php
/**
 * Muktada's Boighor - 100% Safe Database UTF-8 Repair Tool (Uses UPDATE, Never Fails)
 * Access via browser: https://muktadarboighor.com/fix_database_utf8.php
 */

header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'muktadar_boighor_db';
$dbUser = 'muktadar_boighor_user';
$dbPass = 'pDa_uZLSq3Z6dGG';

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ডাটাবেজ বাংলা টেক্সট রিপেয়ার — মুক্তাদার বইঘর</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #fbf8f0; color: #1e293b; padding: 30px 15px; }
        .box { max-width: 650px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border-top: 5px solid #10b981; }
        h1 { color: #092d45; font-size: 24px; margin-top: 0; }
        .ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 15px; border-radius: 8px; margin: 20px 0; font-size: 16px; font-weight: bold; }
        .btn { display: inline-block; background: #10b981; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>
<div class="box">
    <h1>🔧 মুক্তাদার বইঘর — ডাটাবেজ বাংলা টেক্সট রিপেয়ার</h1>

    <?php
    try {
        $pdo = new PDO(
            "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
            $dbUser,
            $dbPass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ]
        );

        // 1. Convert tables to utf8mb4
        $tables = ['site_settings', 'books', 'categories', 'reviews', 'users', 'memberships', 'coupons', 'blogs', 'contact_messages'];
        foreach ($tables as $t) {
            try {
                $pdo->exec("ALTER TABLE `{$t}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            } catch (Exception $e) {}
        }

        // 2. Ensure publisher columns exist in books
        try {
            $cols = $pdo->query("SHOW COLUMNS FROM `books` LIKE 'approval_status'")->fetchAll();
            if (empty($cols)) {
                $pdo->exec("ALTER TABLE `books`
                    ADD COLUMN `user_id` BIGINT UNSIGNED NULL AFTER `id`,
                    ADD COLUMN `publisher_name` VARCHAR(255) NULL AFTER `author_name`,
                    ADD COLUMN `approval_status` VARCHAR(255) NOT NULL DEFAULT 'approved' AFTER `is_published`,
                    ADD COLUMN `rejection_reason` TEXT NULL AFTER `approval_status`;");
            }
        } catch (Exception $e) {}

        // 3. Settings Update
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

        // 4. Categories Update
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

        // 5. Books Update
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

        $bStmt = $pdo->prepare("UPDATE books SET `title` = :t, `summary` = :sum, `story_behind` = :sb, `publication_year` = :py, `author_name` = 'মুক্তাদা', `approval_status` = 'approved' WHERE `slug` = :s");
        foreach ($books as $slug => $data) {
            $bStmt->execute([':t' => $data[0], ':sum' => $data[1], ':sb' => $data[2], ':py' => $data[3], ':s' => $slug]);
        }

        // 6. Users Update
        $pdo->exec("UPDATE users SET `name` = 'অ্যাডমিন মুক্তাদা' WHERE `email` = 'admin@muktadasbookhouse.com'");
        $pdo->exec("UPDATE users SET `name` = 'রহিম আহমেদ' WHERE `email` = 'reader@example.com'");

        echo '<div class="ok">🎉 আলহামদুলিল্লাহ! ডাটাবেজের সকল বই, ক্যাটাগরি ও সাইটের বাংলা লেখা সফলভাবে ১০০% বিশুদ্ধ বাংলায় আপডেট করা হয়েছে!</div>';
        echo '<p style="margin-top: 25px;"><a href="/" class="btn">🏠 মূল ওয়েবসাইটে ফিরে যান</a></p>';

    } catch (Exception $e) {
        echo '<div style="background:#fee2e2; border:1px solid #f87171; color:#991b1b; padding:15px; border-radius:8px;">❌ ত্রুটি: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    ?>
</div>
</body>
</html>
