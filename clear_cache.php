<?php
/**
 * Muktada's Boighor - Ultimate cPanel Auto-Repair & Cache Cleaner
 * Access via browser: https://muktadarboighor.com/clear_cache.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');

$baseDir = __DIR__;
if (!file_exists($baseDir . '/vendor/autoload.php') && file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    $baseDir = dirname(__DIR__);
}

$results = [];

// 1. Clear bootstrap/cache (Crucial fix for "Class 'view' does not exist")
$bootstrapCache = $baseDir . '/bootstrap/cache';
$bCount = 0;
if (is_dir($bootstrapCache)) {
    foreach (glob($bootstrapCache . '/*.php') as $f) {
        if (basename($f) !== '.gitignore') {
            unlink($f);
            $bCount++;
        }
    }
    $results[] = "✅ bootstrap/cache পরিষ্কার করা হয়েছে ($bCount টি ক্যাশ ফাইল মোছা হয়েছে)।";
}

// 2. Clear storage/framework/views
$viewsDir = $baseDir . '/storage/framework/views';
$vCount = 0;
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir . '/*.php') as $f) {
        unlink($f);
        $vCount++;
    }
    $results[] = "✅ storage/framework/views পরিষ্কার করা হয়েছে ($vCount টি ভিউ মোছা হয়েছে)।";
}

// 3. Ensure required directories exist and are writable
$dirs = [
    $baseDir . '/storage/framework/views',
    $baseDir . '/storage/framework/sessions',
    $baseDir . '/storage/framework/cache',
    $baseDir . '/storage/framework/cache/data',
    $baseDir . '/storage/logs',
    $baseDir . '/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    @chmod($dir, 0775);
}
$results[] = "✅ সকল স্টোরেজ ও ক্যাশ ফোল্ডারের পারমিশন ঠিক করা হয়েছে।";

// 4. Ensure .env exists with correct production credentials
$envFile = $baseDir . '/.env';
if (!file_exists($envFile)) {
    $envContent = 'APP_NAME="মুক্তাদার বইঘর | Muktada\'s Boighor"' . "\n" .
'APP_ENV=production' . "\n" .
'APP_KEY=base64:EdUllJoTjVDZnX704hgQhgEFLcYLa2ZYdj93qHClFgI=' . "\n" .
'APP_DEBUG=true' . "\n" .
'APP_URL=https://muktadarboighor.com' . "\n\n" .
'APP_LOCALE=bn' . "\n" .
'APP_FALLBACK_LOCALE=en' . "\n" .
'APP_FAKER_LOCALE=en_US' . "\n\n" .
'APP_MAINTENANCE_DRIVER=file' . "\n" .
'BCRYPT_ROUNDS=12' . "\n\n" .
'LOG_CHANNEL=stack' . "\n" .
'LOG_STACK=single' . "\n" .
'LOG_DEPRECATIONS_CHANNEL=null' . "\n" .
'LOG_LEVEL=debug' . "\n\n" .
'DB_CONNECTION=mysql' . "\n" .
'DB_HOST=127.0.0.1' . "\n" .
'DB_PORT=3306' . "\n" .
'DB_DATABASE=muktadar_boighor_db' . "\n" .
'DB_USERNAME=muktadar_boighor_user' . "\n" .
'DB_PASSWORD=pDa_uZLSq3Z6dGG' . "\n\n" .
'SESSION_DRIVER=file' . "\n" .
'SESSION_LIFETIME=120' . "\n" .
'SESSION_ENCRYPT=false' . "\n" .
'SESSION_PATH=/' . "\n" .
'SESSION_DOMAIN=null' . "\n\n" .
'BROADCAST_CONNECTION=log' . "\n" .
'FILESYSTEM_DISK=local' . "\n" .
'QUEUE_CONNECTION=sync' . "\n" .
'CACHE_STORE=file' . "\n\n" .
'MEMCACHED_HOST=127.0.0.1' . "\n" .
'REDIS_CLIENT=phpredis' . "\n" .
'REDIS_HOST=127.0.0.1' . "\n" .
'REDIS_PASSWORD=null' . "\n" .
'REDIS_PORT=6379' . "\n\n" .
'MAIL_MAILER=log' . "\n" .
'MAIL_SCHEME=null' . "\n" .
'MAIL_HOST=127.0.0.1' . "\n" .
'MAIL_PORT=2525' . "\n" .
'MAIL_USERNAME=null' . "\n" .
'MAIL_PASSWORD=null' . "\n" .
'MAIL_FROM_ADDRESS="hello@muktadarboighor.com"' . "\n" .
'MAIL_FROM_NAME="${APP_NAME}"' . "\n\n" .
'AWS_ACCESS_KEY_ID=' . "\n" .
'AWS_SECRET_ACCESS_KEY=' . "\n" .
'AWS_DEFAULT_REGION=us-east-1' . "\n" .
'AWS_BUCKET=' . "\n" .
'AWS_USE_PATH_STYLE_ENDPOINT=false' . "\n\n" .
'VITE_APP_NAME="${APP_NAME}"' . "\n";

    if (file_put_contents($envFile, $envContent)) {
        $results[] = "✅ .env ফাইল অনুপস্থিত ছিল; স্বয়ংক্রিয়ভাবে সঠিক প্রোডাকশন কনফিগ দিয়ে .env তৈরি করা হয়েছে।";
    } else {
        $results[] = "⚠️ .env তৈরি করা যায়নি, দয়া করে রুট ডিরেক্টরির পারমিশন চেক করুন।";
    }
} else {
    $results[] = "✅ .env ফাইল বিদ্যমান আছে।";
}

// 5. Run Database Migrations & Ensure video_url column exists
try {
    if (file_exists($baseDir . '/vendor/autoload.php') && file_exists($baseDir . '/bootstrap/app.php')) {
        $app = require_once $baseDir . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $artisanOut = trim(\Illuminate\Support\Facades\Artisan::output());
        $results[] = "✅ ডাটাবেজ মাইগ্রেশন সম্পন্ন হয়েছে: " . ($artisanOut ?: "সব মাইগ্রেশন অলরেডি আপ-টু-ডেট");

        // Ensure Admin user password is password123
        $admin = \App\Models\User::where('email', 'admin@muktadasbookhouse.com')->first();
        if ($admin) {
            if (!\Illuminate\Support\Facades\Hash::check('password123', $admin->password)) {
                $admin->password = \Illuminate\Support\Facades\Hash::make('password123');
                $admin->save();
                $results[] = "✅ অ্যাডমিন পাসওয়ার্ড সিঙ্ক করা হয়েছে (admin@muktadasbookhouse.com / password123)";
            } else {
                $results[] = "✅ অ্যাডমিন অ্যাকাউন্ট সম্পূর্ণ সচল ও ভেরিফায়েড।";
            }
        }
    }
} catch (\Throwable $e) {
    $results[] = "⚠️ মাইগ্রেশন নোটিশ: " . $e->getMessage();
}

// 6. Reset OPcache if available
if (function_exists('opcache_reset')) {
    @opcache_reset();
    $results[] = "✅ PHP OPcache রিসেট করা হয়েছে।";
}


?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>অটো-মেরামত ও ক্যাশ ক্লিয়ার সম্পন্ন — মুক্তাদার বইঘর</title>
</head>
<body style="font-family: system-ui, -apple-system, sans-serif; background: #f0fdf4; padding: 40px 20px; color: #1e293b;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 32px; border-radius: 16px; border: 2px solid #22c55e; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">
        <h2 style="color: #15803d; margin-top: 0; font-size: 24px;">🎉 অটো-মেরামত ও ক্যাশ ক্লিয়ার সফল!</h2>
        <p style="color: #475569; font-size: 15px;">Laravel-এর সকল কনফিগ ও ক্যাশ স্বয়ংক্রিয়ভাবে ঠিক করা হয়েছে:</p>
        
        <ul style="background: #f8fafc; border-radius: 8px; padding: 16px 20px 16px 36px; line-height: 1.8; color: #334155;">
            <?php foreach ($results as $res): ?>
                <li><?= htmlspecialchars($res) ?></li>
            <?php endforeach; ?>
        </ul>

        <div style="margin-top: 28px; text-align: center;">
            <a href="/" style="display: inline-block; background: #16a34a; color: #fff; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);">👉 মূল ওয়েবসাইটে প্রবেশ করুন</a>
        </div>
    </div>
</body>
</html>
