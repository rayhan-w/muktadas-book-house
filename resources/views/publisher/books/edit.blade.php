@extends('layouts.publisher')

@section('title', 'বই সম্পাদনা | পাবলিশার ড্যাশবোর্ড')
@section('page_title', 'বইয়ের তথ্য সম্পাদনা')

@section('content')

    <div style="max-width: 900px; margin: 0 auto;">

        <!-- STRICT VOICE RULE WARNING BANNER -->
        <div class="alert alert-warning" style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 24px; border: 1px solid #fde68a; border-left: 5px solid #d97706; background: #fffbeb; border-radius: 12px; padding: 18px 20px;">
            <div style="font-size: 26px; color: #d97706;"><i class="bi bi-shield-exclamation"></i></div>
            <div>
                <strong style="font-size: 15px; color: #92400e; display: block; margin-bottom: 4px;">
                    বিশেষ নিরাপত্তা সতর্কতা (পুনঃঅনুমোদন নীতি / Re-approval Policy):
                </strong>
                <p style="margin: 0; font-size: 13.5px; color: #78350f; line-height: 1.6;">
                    বইয়ের যেকোনো তথ্য সম্পাদনা করে সংরক্ষণ করলে কন্টেন্টের সত্যতা ও নিরাপত্তা রক্ষার্থে বইটি <strong>তাৎক্ষণিকভাবে সাময়িকভাবে অপ্রকাশিত (Unpublished) হয়ে যাবে</strong>। এরপর সুপার অ্যাডমিন আপনার সংশোধিত তথ্য পর্যালোচনা করে পুনঃঅনুমোদন (Re-approve) দিলে বইটি আবার ওয়েবসাইটে সক্রিয় ও লাইভ হবে।
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pub-card">
            <form action="{{ route('publisher.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-book-half" style="color: #0284c7;"></i> বইয়ের প্রাথমিক তথ্য
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">বইয়ের শিরোনাম <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">লেখক / লেখিকার নাম <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="author_name" value="{{ old('author_name', $book->author_name) }}" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ক্যাটাগরি নির্বাচন করুন <span style="color: #ef4444;">*</span></label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; background: #f8fafc; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @php
                                $selectedCats = old('categories', $book->categories->pluck('id')->toArray());
                            @endphp
                            @foreach($categories as $category)
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; color: #334155;">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCats) ? 'checked' : '' }}>
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-tag-fill" style="color: #0284c7;"></i> মূল্য ও স্টক তথ্য
                    </h3>

                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">হার্ডকপি মূল্য (টাকা) <span style="color: #ef4444;">*</span></label>
                            <input type="number" step="0.01" name="price_hardcopy" value="{{ old('price_hardcopy', $book->price_hardcopy) }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">ই-বুক মূল্য (টাকা) <span style="color: #ef4444;">*</span></label>
                            <input type="number" step="0.01" name="price_ebook" value="{{ old('price_ebook', $book->price_ebook) }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">ডিসকাউন্ট (%) (ঐচ্ছিক)</label>
                            <input type="number" step="0.01" name="discount_percent" value="{{ old('discount_percent', $book->discount_percent) }}" min="0" max="100" class="form-control">
                        </div>
                    </div>

                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">স্টক পরিমাণ (হার্ডকপি)</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $book->stock_quantity) }}" min="0" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">স্টক স্ট্যাটাস <span style="color: #ef4444;">*</span></label>
                            <select name="stock_status" class="form-control">
                                <option value="in_stock" {{ old('stock_status', $book->stock_status) === 'in_stock' ? 'selected' : '' }}>স্টকে আছে (In Stock)</option>
                                <option value="low_stock" {{ old('stock_status', $book->stock_status) === 'low_stock' ? 'selected' : '' }}>সীমিত স্টক (Low Stock)</option>
                                <option value="out_of_stock" {{ old('stock_status', $book->stock_status) === 'out_of_stock' ? 'selected' : '' }}>স্টক শেষ (Out of Stock)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">অনলাইন প্রিভিউ পৃষ্ঠা সংখ্যা</label>
                            <input type="number" name="preview_pages" value="{{ old('preview_pages', $book->preview_pages) }}" min="1" max="50" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Publication Details -->
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-file-text-fill" style="color: #0284c7;"></i> বইয়ের বিস্তারিত ও বিবরণ
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">প্রকাশের সন / সংস্করণ</label>
                            <input type="text" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">মোট পৃষ্ঠা সংখ্যা</label>
                            <input type="number" name="page_count" value="{{ old('page_count', $book->page_count) }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বইয়ের সারসংক্ষেপ (Summary)</label>
                        <textarea name="summary" rows="4" class="form-control">{{ old('summary', $book->summary) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বইটি লেখার পেছনের গল্প (Story Behind the Book)</label>
                        <textarea name="story_behind" rows="3" class="form-control">{{ old('story_behind', $book->story_behind) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">লেখকের বিশেষ পরিচিতি বা বার্তা (Pen Picture)</label>
                        <textarea name="pen_picture" rows="2" class="form-control">{{ old('pen_picture', $book->pen_picture) }}</textarea>
                    </div>
                </div>

                <!-- Files Upload -->
                <div style="margin-bottom: 32px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-cloud-arrow-up-fill" style="color: #0284c7;"></i> ফাইল ও কভার ছবি
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">বইয়ের কভার পরিবর্তন (ঐচ্ছিক)</label>
                            @if($book->cover_image)
                                <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ $book->cover_url }}" alt="Cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                                    <span style="font-size: 13px; color: #64748b;">বর্তমান কভার ছবি</span>
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="form-control">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">পরিবর্তন করতে চাইলে নতুন ছবি আপলোড করুন।</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">ই-বুক পিডিএফ পরিবর্তন (ঐচ্ছিক)</label>
                            @if($book->ebook_file)
                                <div style="margin-bottom: 10px; font-size: 13px; color: #166534; background: #dcfce7; padding: 6px 12px; border-radius: 6px; display: inline-block;">
                                    ✓ পূর্বে একটি পিডিএফ ফাইল আপলোড করা আছে
                                </div>
                            @endif
                            <input type="file" name="ebook_file" accept=".pdf" class="form-control">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">নতুন সংস্করণ দিতে চাইলে নতুন PDF আপলোড করুন।</small>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">🎥 ইউটিউব ভিডিও / রিভিউ লিঙ্ক (ঐচ্ছিক)</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $book->video_url) }}" class="form-control" placeholder="https://www.youtube.com/watch?v=... বা https://youtu.be/...">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">বইটির ইউটিউব ভিডিও রিভিউ থাকলে লিঙ্ক দিন। বিস্তারিত পেজে ১৬:৯ ফরম্যাটে ভিডিও প্রদর্শিত হবে।</small>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <a href="{{ route('publisher.books.index') }}" class="btn btn-gray">ফিরে যান</a>
                    <button type="submit" class="btn btn-warning" style="padding: 12px 24px; font-size: 15px; display: inline-flex; align-items: center; gap: 8px;" onclick="return confirm('⚠️ বইটি আপডেট করলে তা পুনঃঅনুমোদনের জন্য পেন্ডিং হয়ে যাবে এবং সাময়িকভাবে সাইটে বন্ধ থাকবে। আপনি কি এগিয়ে যেতে চান?');">
                        <i class="bi bi-floppy2-fill"></i> তথ্য আপডেট ও পুনঃঅনুমোদনের জন্য পাঠান
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
