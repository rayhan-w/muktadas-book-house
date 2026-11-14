<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReaderDashboardController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AuthController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\MembershipController as AdminMembershipController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/author', [HomeController::class, 'author'])->name('author');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy');

// Books
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{slug}/preview', [BookController::class, 'preview'])->name('books.preview');
Route::post('/books/{slug}/reviews', [BookController::class, 'submitReview'])->name('books.review.submit');

// Online E-book Reader (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/books/{slug}/read', [BookController::class, 'read'])->name('books.read');
    Route::post('/books/{slug}/progress', [BookController::class, 'saveReadingProgress'])->name('books.progress');
});

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::match(['get', 'post'], '/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::match(['get', 'post'], '/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Memberships
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
Route::redirect('/membership', '/memberships');

// Digital Invoice / Receipt
Route::get('/orders/invoice/{orderNumber}', [ReaderDashboardController::class, 'invoice'])->name('orders.invoice');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Publisher Registration (Public)
Route::get('/publisher/register', [\App\Http\Controllers\PublisherController::class, 'showRegister'])->name('publisher.register');
Route::post('/publisher/register', [\App\Http\Controllers\PublisherController::class, 'register'])->name('publisher.register.submit');

/*
|--------------------------------------------------------------------------
| Publisher Portal Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'publisher'])->prefix('publisher')->name('publisher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\PublisherController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [\App\Http\Controllers\PublisherController::class, 'books'])->name('books.index');
    Route::get('/books/create', [\App\Http\Controllers\PublisherController::class, 'createBook'])->name('books.create');
    Route::post('/books', [\App\Http\Controllers\PublisherController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{id}/edit', [\App\Http\Controllers\PublisherController::class, 'editBook'])->name('books.edit');
    Route::put('/books/{id}', [\App\Http\Controllers\PublisherController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{id}', [\App\Http\Controllers\PublisherController::class, 'destroyBook'])->name('books.destroy');
});

/*
|--------------------------------------------------------------------------
| Reader Dashboard Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('my-account')->name('reader.')->group(function () {
    Route::get('/', [ReaderDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/library', [ReaderDashboardController::class, 'library'])->name('library');
    Route::get('/orders', [ReaderDashboardController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [ReaderDashboardController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist/toggle/{bookId}', [ReaderDashboardController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::post('/profile/update', [ReaderDashboardController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected with AdminMiddleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Books CRUD
    Route::resource('books', AdminBookController::class);

    // Publisher Management
    Route::get('publishers', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'publishers'])->name('publishers.index');
    Route::put('publishers/{id}/approve', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'approvePublisher'])->name('publishers.approve');
    Route::put('publishers/{id}/reject', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'rejectPublisher'])->name('publishers.reject');

    // Publisher Books Review & Moderation
    Route::get('publisher-books', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'books'])->name('publishers.books');
    Route::put('publisher-books/{id}/approve', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'approveBook'])->name('publishers.books.approve');
    Route::put('publisher-books/{id}/reject', [\App\Http\Controllers\Admin\AdminPublisherController::class, 'rejectBook'])->name('publishers.books.reject');

    // Categories CRUD
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Payment Numbers & Instructions
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('payments', [AdminPaymentController::class, 'update'])->name('payments.update');

    // Reviews Moderation
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::put('reviews/{review}/status', [AdminReviewController::class, 'updateStatus'])->name('reviews.update-status');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Memberships
    Route::get('memberships', [AdminMembershipController::class, 'index'])->name('memberships.index');
    Route::put('memberships/{membership}', [AdminMembershipController::class, 'update'])->name('memberships.update');

    // Coupons
    Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::put('coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
    Route::delete('coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

    // Settings (Site, Author, Delivery)
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Customers & Users Management
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{user}/edit', [AdminCustomerController::class, 'edit'])->name('customers.edit');
    Route::put('customers/{user}', [AdminCustomerController::class, 'update'])->name('customers.update');
    Route::delete('customers/{user}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

    // Contact Inquiries & Newsletter
    Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::put('contacts/{message}/read', [AdminContactController::class, 'markAsRead'])->name('contacts.read');
    Route::delete('contacts/{message}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});

/*
|--------------------------------------------------------------------------
| 1-Click Database UTF-8 Repair Web Route
| Accessible at: /fix-database and /fix-db
|--------------------------------------------------------------------------
*/
Route::get('/fix-database', function () {
    try {
        \Illuminate\Support\Facades\DB::statement('SET foreign_key_checks = 0;');
        
        try {
            $cols = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `users` LIKE 'publisher_company'");
            if (empty($cols)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `users` 
                    ADD COLUMN `publisher_company` VARCHAR(255) NULL AFTER `membership_expires_at`,
                    ADD COLUMN `publisher_status` VARCHAR(255) NOT NULL DEFAULT 'pending' AFTER `publisher_company`,
                    ADD COLUMN `publisher_bio` TEXT NULL AFTER `publisher_status`,
                    ADD COLUMN `publisher_rejection_reason` TEXT NULL AFTER `publisher_bio`;");
            }
        } catch (\Exception $e) {}

        try {
            $cols = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `books` LIKE 'user_id'");
            if (empty($cols)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `books`
                    ADD COLUMN `user_id` BIGINT UNSIGNED NULL AFTER `id`,
                    ADD COLUMN `publisher_name` VARCHAR(255) NULL AFTER `author_name`,
                    ADD COLUMN `approval_status` VARCHAR(255) NOT NULL DEFAULT 'approved' AFTER `is_published`,
                    ADD COLUMN `rejection_reason` TEXT NULL AFTER `approval_status`;");
            }
        } catch (\Exception $e) {}

        $sqlPath = base_path('clean_database_utf8.sql');
        if (!file_exists($sqlPath)) {
            $sqlPath = public_path('clean_database_utf8.sql');
        }

        if (file_exists($sqlPath)) {
            $sql = file_get_contents($sqlPath);
            \Illuminate\Support\Facades\DB::unprepared($sql);
        } else {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        }

        \Illuminate\Support\Facades\DB::statement('SET foreign_key_checks = 1;');

        $siteName = \App\Models\SiteSetting::get('site_name');
        $siteTagline = \App\Models\SiteSetting::get('site_tagline');

        return response('<!DOCTYPE html><html lang="bn"><head><meta charset="utf-8"><title>ডাটাবেজ ফিক্স সফল</title></head><body style="font-family:sans-serif;background:#fbf8f0;padding:40px;color:#092d45;"><div style="max-width:620px;margin:auto;background:#fff;padding:30px;border-radius:12px;border:2px solid #10b981;box-shadow:0 8px 25px rgba(0,0,0,0.08);"><h2 style="color:#065f46;margin-top:0;">✅ আলহামদুলিল্লাহ! ডাটাবেজ সফলভাবে বিশুদ্ধ বাংলায় ফিক্স হয়েছে!</h2><p><strong>সাইটের নাম:</strong> ' . htmlspecialchars($siteName) . '</p><p><strong>ট্যাগলাইন:</strong> ' . htmlspecialchars($siteTagline) . '</p><p style="margin-top:25px;"><a href="/" style="background:#092d45;color:#fff;padding:12px 24px;text-decoration:none;border-radius:6px;font-weight:bold;display:inline-block;">🏠 হোমপেজে যান</a></p></div></body></html>', 200);

    } catch (\Exception $e) {
        return response('Database Fix Error: ' . $e->getMessage(), 500);
    }
});

Route::get('/fix-db', function () {
    return redirect('/fix-database');
});

