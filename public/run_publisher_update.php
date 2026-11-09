<?php
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Database Update</title>";
echo "<style>body{font-family:sans-serif;background:#0f172a;color:#f8fafc;padding:30px;line-height:1.6;} .box{max-width:650px;margin:0 auto;background:#1e293b;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.3);} .ok{color:#4ade80;} .warn{color:#facc15;} .err{color:#f87171;}</style></head><body>";
echo "<div class='box'><h2>📚 মুক্তাদার বইঘর — ডাটাবেজ আপডেট</h2>";

try {
    // Read DB config from .env or fallback to live credentials
    $host = 'localhost';
    $db = 'muktadar_boighor_db';
    $user = 'muktadar_boighor_user';
    $pass = 'pDa_uZLSq3Z6dGG';

    if (file_exists(__DIR__ . '/../.env')) {
        $env = parse_ini_file(__DIR__ . '/../.env');
        if (!empty($env['DB_HOST'])) $host = $env['DB_HOST'];
        if (!empty($env['DB_DATABASE'])) $db = $env['DB_DATABASE'];
        if (!empty($env['DB_USERNAME'])) $user = $env['DB_USERNAME'];
        if (!empty($env['DB_PASSWORD'])) $pass = $env['DB_PASSWORD'];
    }

    $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Check users columns
    $userCols = $pdo->query("SHOW COLUMNS FROM `users`")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('publisher_company', $userCols)) {
        $pdo->exec("ALTER TABLE `users` 
            ADD COLUMN `publisher_company` VARCHAR(255) NULL AFTER `membership_expires_at`,
            ADD COLUMN `publisher_status` VARCHAR(255) NOT NULL DEFAULT 'pending' AFTER `publisher_company`,
            ADD COLUMN `publisher_bio` TEXT NULL AFTER `publisher_status`,
            ADD COLUMN `publisher_rejection_reason` TEXT NULL AFTER `publisher_bio`");
        echo "<p class='ok'>✓ `users` টেবিলে পাবলিশার সংক্রান্ত ৪টি কলাম যুক্ত হয়েছে।</p>";
    } else {
        echo "<p class='warn'>ℹ️ `users` টেবিলে কলামগুলো আগেই বিদ্যমান রয়েছে।</p>";
    }

    // Check books columns
    $bookCols = $pdo->query("SHOW COLUMNS FROM `books`")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('user_id', $bookCols)) {
        $pdo->exec("ALTER TABLE `books`
            ADD COLUMN `user_id` BIGINT UNSIGNED NULL AFTER `id`,
            ADD COLUMN `publisher_name` VARCHAR(255) NULL AFTER `author_name`,
            ADD COLUMN `approval_status` VARCHAR(255) NOT NULL DEFAULT 'approved' AFTER `is_published`,
            ADD COLUMN `rejection_reason` TEXT NULL AFTER `approval_status`");
        echo "<p class='ok'>✓ `books` টেবিলে পাবলিশার ও অনুমোদন সংক্রান্ত ৪টি কলাম যুক্ত হয়েছে।</p>";

        // Try adding foreign key
        try {
            $pdo->exec("ALTER TABLE `books` ADD CONSTRAINT `books_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL");
            echo "<p class='ok'>✓ `books` এবং `users` টেবিলের ফরেন-কি রিলেশন স্থাপন হয়েছে।</p>";
        } catch (\Exception $e) {
            echo "<p class='warn'>ℹ️ ফরেন-কি স্কিপ করা হয়েছে: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p class='warn'>ℹ️ `books` টেবিলে কলামগুলো আগেই বিদ্যমান রয়েছে।</p>";
    }

    // Set existing books to approved
    $pdo->exec("UPDATE `books` SET `approval_status` = 'approved' WHERE `approval_status` IS NULL OR `approval_status` = ''");

    echo "<h3 class='ok'>🎉 ডাটাবেজ আপডেট সফলভাবে সম্পন্ন হয়েছে!</h3>";
    echo "<p><a href='/' style='color:#38bdf8;text-decoration:none;font-weight:bold;'>← মূল ওয়েবসাইটে ফিরে যান</a></p>";

} catch (\Exception $e) {
    echo "<p class='err'><strong>ত্রুটি ঘটেছে:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</div></body></html>";
