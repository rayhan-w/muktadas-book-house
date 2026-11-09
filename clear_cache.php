<?php
/**
 * Muktada's Boighor - Cache Cleaner Helper
 * Access via browser: https://muktadarboighor.com/clear_cache.php
 */

header('Content-Type: text/html; charset=UTF-8');

$baseDir = __DIR__;
if (!file_exists($baseDir . '/vendor/autoload.php')) {
    $baseDir = dirname(__DIR__);
}

$viewsDir = $baseDir . '/storage/framework/views';
$deleted = 0;
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir . '/*.php') as $file) {
        if (unlink($file)) {
            $deleted++;
        }
    }
}

// Try running artisan if possible
$artisanOutput = '';
try {
    if (file_exists($baseDir . '/bootstrap/app.php')) {
        require_once $baseDir . '/vendor/autoload.php';
        $app = require_once $baseDir . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $artisanOutput = 'Artisan commands (view:clear, cache:clear, config:clear) ran successfully!';
    }
} catch (Exception $e) {
    $artisanOutput = 'Notice: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ক্যাশ ক্লিয়ার সফল — মুক্তাদার বইঘর</title>
</head>
<body style="font-family:sans-serif; background:#fbf8f0; padding:40px; color:#092d45;">
    <div style="max-width:550px; margin:auto; background:#fff; padding:30px; border-radius:12px; border:2px solid #10b981; box-shadow:0 8px 25px rgba(0,0,0,0.06);">
        <h2 style="color:#065f46; margin-top:0;">✅ ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে!</h2>
        <p><strong>মুছে ফেলা ভিউ ক্যাশ ফাইল:</strong> <?= $deleted ?> টি</p>
        <?php if ($artisanOutput): ?>
            <p style="color:#166534; font-size:13px;"><?= htmlspecialchars($artisanOutput) ?></p>
        <?php endif; ?>
        <p style="margin-top:25px;">
            <a href="/" style="background:#092d45; color:#fff; padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">🏠 মূল ওয়েবসাইটে ফিরে যান</a>
        </p>
    </div>
</body>
</html>
