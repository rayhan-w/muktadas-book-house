@extends('layouts.admin')

@section('title', 'নতুন বই যোগ করুন | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'নতুন বই যুক্ত করুন')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h2>বইয়ের বিবরণ ও কনটেন্ট আপলোড</h2>
        <a href="{{ route('admin.books.index') }}" class="btn-sm btn-gray">← তালিকায় ফিরুন</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. Basic Info -->
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">বইয়ের নাম (Title) *</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="form-control" placeholder="যেমন: আলোর পথ">
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug (ঐচ্ছিক, ফাঁকা রাখলে স্বয়ংক্রিয় তৈরি হবে)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="যেমন: alor-poth">
            </div>
        </div>

        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">লেখকের নাম *</label>
                <input type="text" name="author_name" value="{{ old('author_name', 'মুক্তাদা') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">প্রকাশের সাল</label>
                <input type="text" name="publication_year" value="{{ old('publication_year', '২০২৪') }}" class="form-control" placeholder="যেমন: ২০২৪">
            </div>

            <div class="form-group">
                <label class="form-label">মোট পৃষ্ঠা সংখ্যা</label>
                <input type="number" name="page_count" value="{{ old('page_count', 240) }}" class="form-control" placeholder="যেমন: ২৪০">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="bi bi-buildings"></i> প্রকাশনীর নাম (ঐচ্ছিক — ফাঁকা রাখলে সাইটের নিজস্ব "মুক্তাদার বইঘর" হিসেবে প্রকাশিত হবে)
            </label>
            <input type="text" name="publisher_name" value="{{ old('publisher_name') }}" class="form-control" placeholder="যেমন: অন্যপ্রকাশ, ঐতিহ্য, ইত্যাদি (ফাঁকা রাখলে মুক্তাদার বইঘর)">
        </div>

        <!-- Categories (Multiple selection allowed) -->
        <div class="form-group">
            <label class="form-label">বইয়ের ক্যাটাগরি (একাধিক ক্যাটাগরি সিলেক্ট করা যাবে) *</label>
            <div style="display: flex; gap: 14px; flex-wrap: wrap; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid var(--admin-border);">
                @foreach($categories as $category)
                    <label style="display: flex; align-items: center; gap: 6px; font-size: 14px; cursor: pointer;">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- 2. Pricing & Stock -->
        <div class="grid-4">
            <div class="form-group">
                <label class="form-label">হার্ডকপি মূল্য (টাকা) *</label>
                <input type="number" step="0.01" name="price_hardcopy" value="{{ old('price_hardcopy', 350) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">ই-বুক মূল্য (টাকা) *</label>
                <input type="number" step="0.01" name="price_ebook" value="{{ old('price_ebook', 200) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">বিশেষ ছাড় / ডিসকাউন্ট (%)</label>
                <input type="number" step="0.01" name="discount_percent" value="{{ old('discount_percent', 0) }}" class="form-control" placeholder="যেমন: 10">
            </div>

            <div class="form-group">
                <label class="form-label">প্রিভিউ পৃষ্ঠা সংখ্যা (কয়েক পৃষ্ঠা পাঠ)</label>
                <input type="number" name="preview_pages" value="{{ old('preview_pages', 3) }}" min="1" max="50" class="form-control">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">স্টক পরিমাণ (সংখ্যা)</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 50) }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">স্টক স্ট্যাটাস *</label>
                <select name="stock_status" class="form-control">
                    <option value="in_stock" {{ old('stock_status') === 'in_stock' ? 'selected' : '' }}>ইন স্টক (In Stock)</option>
                    <option value="low_stock" {{ old('stock_status') === 'low_stock' ? 'selected' : '' }}>স্বল্প স্টক (Low Stock)</option>
                    <option value="out_of_stock" {{ old('stock_status') === 'out_of_stock' ? 'selected' : '' }}>স্টক শেষ (Out of Stock)</option>
                </select>
            </div>
        </div>

        <!-- 3. Summary & Story Behind Writing -->
        <div class="form-group">
            <label class="form-label">বইয়ের সারসংক্ষেপ (Summary) *</label>
            <textarea name="summary" rows="4" class="form-control" placeholder="বইটির মূল বিষয়বস্তু ও আকর্ষণীয় সারাংশ লিখুন...">{{ old('summary') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">বইটি লেখার পেছনের গল্প (Story Behind Writing the Book)</label>
            <textarea name="story_behind" rows="3" class="form-control" placeholder="লেখক হিসেবে এই বইটি লেখার পেছনের প্রেক্ষাপট, অনুভূতি বা সত্য ঘটনা...">{{ old('story_behind') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">লেখকের বিশেষ বার্তা / Pen Picture</label>
            <textarea name="pen_picture" rows="2" class="form-control" placeholder="পাঠকের উদ্দেশ্যে এই বই নিয়ে বিশেষ কোনো চিরকুট বা পরিচিতি...">{{ old('pen_picture') }}</textarea>
        </div>

        <!-- 4. File Uploads -->
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">বইয়ের প্রচ্ছদ ছবি (Cover Image - JPG/PNG)</label>
                <input type="file" name="cover_image" accept="image/*" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">ডিজিটাল ই-বুক ফাইল (PDF File - অনলাইন রিডারের জন্য)</label>
                <input type="file" name="ebook_file" accept=".pdf" class="form-control">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">🎥 ইউটিউব ভিডিও / রিভিউ লিঙ্ক (YouTube Video URL)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" class="form-control" placeholder="https://www.youtube.com/watch?v=... বা https://youtu.be/...">
                <small style="color: var(--admin-muted); display: block; margin-top: 4px;">বইটির ইউটিউব রিভিউ বা পরিচিতি লিংক দিলে বিস্তারিত পেজে ১৬:৯ রেসপনসিভ প্লেয়ার প্রদর্শিত হবে। লিংক না দিলে ভিডিও সেকশন লুকায়িত থাকবে।</small>
            </div>
        </div>

        <!-- 5. Flags (Featured, Upcoming, etc.) -->
        <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
            <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                <label style="display: flex; align-items: center; gap: 6px; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> ⭐ Featured Books (হোমপেজে স্পটলাইট)
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }}> 🔥 বেস্টসেলার / Popular
                </label>
                <label style="display: flex; align-items: center; gap: 6px; font-weight: 700; cursor: pointer;">
                    <input type="checkbox" name="is_upcoming" value="1" {{ old('is_upcoming') ? 'checked' : '' }}> ⏳ Upcoming Books (আসন্ন বই)
                </label>
            </div>

            <div style="margin-top: 12px; max-width: 350px;">
                <label class="form-label" style="font-size: 13px;">আসন্ন বইয়ের সম্ভাব্য প্রকাশের তারিখ (যদি Upcoming হয়)</label>
                <input type="text" name="expected_date" value="{{ old('expected_date') }}" class="form-control" placeholder="যেমন: অমর একুশে বইমেলা ২০২৫">
            </div>
        </div>

        <!-- 6. SEO Meta Settings -->
        <h3 style="font-size: 16px; margin: 25px 0 12px; color: var(--admin-dark);">🔍 সার্চ ইঞ্জিন অপটিমাইজেশন (SEO Settings)</h3>
        <div class="grid-3">
            <div class="form-group">
                <label class="form-label">SEO Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="গুগলে প্রদর্শিত টাইটেল">
            </div>
            <div class="form-group">
                <label class="form-label">SEO Keywords</label>
                <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control" placeholder="কমা দিয়ে কীওয়ার্ড লিখুন">
            </div>
            <div class="form-group">
                <label class="form-label">SEO Meta Description</label>
                <input type="text" name="meta_description" value="{{ old('meta_description') }}" class="form-control" placeholder="গুগল সার্চ ফলাফলের সংক্ষিপ্ত বিবরণ">
            </div>
        </div>

        <button type="submit" class="btn-sm btn-blue" style="padding: 12px 24px; font-size: 15px;">
            ✓ বইটি সংরক্ষণ করুন
        </button>
    </form>
</div>
@endsection
