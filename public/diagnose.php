<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Muktadar Boighor - Server Diagnostic</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #1e293b; padding: 20px; line-height: 1.5; }
        .card { max-width: 800px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 24px; }
        h1 { font-size: 20px; margin-top: 0; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; }
        .item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .ok { color: #16a34a; font-weight: bold; }
        .err { color: #dc2626; font-weight: bold; }
        .warn { color: #d97706; font-weight: bold; }
        pre { background: #0f172a; color: #e2e8f0; padding: 12px; border-radius: 6px; overflow-x: auto; font-size: 13px; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="card">
    <h1>🔧 মুক্তাদার বইঘর — সার্ভার ও লারাভেল ডায়াগনস্টিক রিপোর্ট</h1>
    
    <div class="item">
        <span>PHP Version</span>
        <span>
            <?php
            $phpv = phpversion();
            if (version_compare($phpv, '8.2.0', '>=')) {
                echo "<span class='ok'>PHP $phpv (OK - Compatible with Laravel 11)</span>";
            } else {
                echo "<span class='err'>PHP $phpv (Error: Laravel 11 requires PHP 8.2+)</span>";
            }
            ?>
        </span>
    </div>

    <div class="item">
        <span>.env File Status</span>
        <span>
            <?php
            $rootEnv = __DIR__ . '/../.env';
            $currEnv = __DIR__ . '/.env';
            if (file_exists($rootEnv)) {
                echo "<span class='ok'>Found at root (.env)</span>";
            } elseif (file_exists($currEnv)) {
                echo "<span class='ok'>Found in public (.env)</span>";
            } else {
                echo "<span class='err'>MISSING! (This is causing HTTP 500 error)</span>";
            }
            ?>
        </span>
    </div>

    <div class="item">
        <span>Vendor / Autoload</span>
        <span>
            <?php
            if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
                echo "<span class='ok'>Vendor installed</span>";
            } else {
                echo "<span class='err'>vendor/autoload.php missing!</span>";
            }
            ?>
        </span>
    </div>

    <div class="item">
        <span>Storage Writable</span>
        <span>
            <?php
            $storage = __DIR__ . '/../storage';
            if (is_writable($storage)) {
                echo "<span class='ok'>Writable (OK)</span>";
            } else {
                echo "<span class='err'>Not Writable (Permission 755/775 required)</span>";
            }
            ?>
        </span>
    </div>

    <div class="item">
        <span>Bootstrap Cache Writable</span>
        <span>
            <?php
            $bcache = __DIR__ . '/../bootstrap/cache';
            if (is_writable($bcache)) {
                echo "<span class='ok'>Writable (OK)</span>";
            } else {
                echo "<span class='err'>Not Writable</span>";
            }
            ?>
        </span>
    </div>

    <div class="item">
        <span>Database Connection</span>
        <span>
            <?php
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=muktadar_boighor_db;charset=utf8mb4', 'muktadar_boighor_user', 'pDa_uZLSq3Z6dGG', [
                    PDO::ATTR_TIMEOUT => 3,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                $stmt = $pdo->query("SELECT count(*) as cnt FROM books");
                $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;
                echo "<span class='ok'>Connected! ($count books found in database)</span>";
            } catch (Exception $e) {
                echo "<span class='err'>Failed: " . htmlspecialchars($e->getMessage()) . "</span>";
            }
            ?>
        </span>
    </div>

    <?php if (!file_exists($rootEnv) && !file_exists($currEnv)): ?>
    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; margin: 20px 0;">
        <h3 style="color: #991b1b; margin-top: 0;">⚠️ .env ফাইল পাওয়া যায়নি! (HTTP 500 এর মূল কারণ)</h3>
        <p style="color: #7f1d1d;">নিচের বাটনে ক্লিক করলেই স্বয়ংক্রিয়ভাবে সঠিক ডাটাবেস পাসওয়ার্ড ও APP_KEY দিয়ে <code>.env</code> ফাইল তৈরি হয়ে যাবে:</p>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create_env">
            <button type="submit" class="btn" style="background: #16a34a;">⚡ এক ক্লিকে .env তৈরি করুন (Fix 500)</button>
        </form>
    </div>
    <?php endif; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create_env') {
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

        $target = __DIR__ . '/../.env';
        if (file_put_contents($target, $envContent)) {
            echo "<div style='background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 12px; border-radius: 6px; margin: 15px 0;'><strong>✅ সফল!</strong> .env ফাইল তৈরি হয়ে গেছে। এখন <a href='/' style='color: #15803d; font-weight: bold;'>এখানে ক্লিক করে মূল ওয়েবসাইটে যান</a>।</div>";
        } else {
            echo "<div style='background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px; border-radius: 6px; margin: 15px 0;'>❌ .env ফাইল রাইট করতে পারেনি। দয়া করে রুট ডিরেক্টরির পারমিশন চেক করুন।</div>";
        }
    }
    ?>

    <h3>সর্বশেষ Laravel Error Log (যদি থাকে):</h3>
    <pre><?php
    $logFile = __DIR__ . '/../storage/logs/laravel.log';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lastLines = array_slice($lines, -25);
        echo htmlspecialchars(implode("", $lastLines));
    } else {
        echo "কোনো লগ ফাইল পাওয়া যায়নি (storage/logs/laravel.log empty or missing).";
    }
    ?></pre>

    <p style="margin-top: 20px;">
        <a href="/" class="btn">হোমপেজে ফিরে যান</a>
    </p>
</div>
</body>
</html>
