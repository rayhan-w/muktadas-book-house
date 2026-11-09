<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Extend Users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('password'); // admin, customer, staff
            $table->string('phone')->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->string('membership_plan')->nullable()->after('address');
            $table->timestamp('membership_expires_at')->nullable()->after('membership_plan');
        });

        // 2. Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Books Table
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author_name')->default('মুক্তাদার বইঘর');
            $table->text('summary')->nullable();
            $table->text('story_behind')->nullable(); // বইটি লেখার পেছনের গল্প
            $table->string('publication_year')->nullable();
            $table->integer('page_count')->nullable();
            $table->decimal('price_hardcopy', 10, 2)->default(0);
            $table->decimal('price_ebook', 10, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->integer('stock_quantity')->default(50);
            $table->string('stock_status')->default('in_stock'); // in_stock, low_stock, out_of_stock
            $table->string('cover_image')->nullable();
            $table->string('ebook_file')->nullable(); // PDF or preview file path
            $table->integer('preview_pages')->default(3); // 2, 3, 5, 10
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_latest')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_upcoming')->default(false); // Upcoming books / Coming soon
            $table->string('expected_date')->nullable();
            $table->text('pen_picture')->nullable(); // বিশেষ পরিচিতি
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        // 4. Book Category Pivot Table (One book in multiple categories)
        Schema::create('book_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        });

        // 5. Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // e.g. MB-1001
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('delivery_address')->nullable();
            $table->string('delivery_zone')->default('dhaka'); // dhaka, outside_dhaka
            $table->decimal('delivery_charge', 10, 2)->default(60);
            $table->text('delivery_instruction')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('payment_method')->default('bkash'); // bkash, nagad, upay, cod
            $table->string('payment_number')->nullable();
            $table->string('payment_trx_id')->nullable();
            $table->string('payment_status')->default('pending'); // pending, verified, rejected
            $table->string('order_status')->default('pending'); // pending, payment_verified, processing, shipped, delivered, cancelled
            $table->string('courier_tracking_id')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 6. Order Items Table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->string('format')->default('hardcopy'); // hardcopy, ebook
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // 7. Ebook Library Table (My Library)
        Schema::create('ebook_libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('last_read_page')->default(1);
            $table->timestamp('access_granted_at')->useCurrent();
            $table->timestamps();
            $table->unique(['user_id', 'book_id']);
        });

        // 8. Reviews Table (Ratings & Reviews with moderation)
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->text('comment');
            $table->boolean('is_verified_purchase')->default(false);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });

        // 9. Wishlist Table
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'book_id']);
        });

        // 10. Memberships Plans Table
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // ১ বছর, ২ বছর, লাইফটাইম
            $table->string('slug')->unique();
            $table->integer('duration_months')->default(12);
            $table->decimal('price', 10, 2);
            $table->decimal('discount_percent', 5, 2)->default(10);
            $table->integer('free_ebooks_count')->default(1);
            $table->text('benefits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 11. User Memberships Subscriptions
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('membership_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // null for lifetime
            $table->string('status')->default('active'); // active, expired, suspended
            $table->timestamps();
        });

        // 12. Coupons Table
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount_type')->default('percent'); // fixed, percent
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_spend', 10, 2)->default(0);
            $table->date('valid_until')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('times_used')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 13. Site Settings (Key-Value)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 14. Contact Messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // 15. Newsletter Subscribers
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 16. Blogs Table
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('user_memberships');
        Schema::dropIfExists('memberships');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('ebook_libraries');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'membership_plan', 'membership_expires_at']);
        });
    }
};
