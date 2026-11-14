@extends('layouts.publisher')

@section('title', 'নতুন বই জমা দিন | পাবলিশার ড্যাশবোর্ড')
@section('page_title', 'নতুন বই তালিকাভুক্ত করুন')

@section('content')

    <div style="max-width: 900px; margin: 0 auto;">
        <!-- Information Box -->
        <div class="alert alert-info" style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 24px; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #0284c7; border-radius: 10px; padding: 16px;">
            <div style="font-size: 20px; color: #0284c7;"><i class="bi bi-info-circle-fill"></i></div>
            <div>
                <strong>বই তালিকাভুক্তি নির্দেশিকা:</strong>
                <p style="margin: 4px 0 0; font-size: 13.5px; color: #1e3a5f;">
                    বইয়ের সকল তথ্য সতর্কতার সাথে পূরণ করুন। আপনার জমার পর বইটি সরাসরি সাইটে লাইভ হবে না—আমাদের অ্যাডমিন টিম বইটি যাচাই করে অনুমোদন (Approve) করলেই তা সর্বসাধারণের কাছে দৃশ্যমান হবে।
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
            <form action="{{ route('publisher.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Info -->
                <div style="margin-bottom: 28px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-book-half" style="color: #0284c7;"></i> বইয়ের প্রাথমিক তথ্য
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">বইয়ের শিরোনাম <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required placeholder="বইয়ের নাম লিখুন" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">লেখক / লেখিকার নাম <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="author_name" value="{{ old('author_name') }}" required placeholder="লেখকের পুরো নাম" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ক্যাটাগরি নির্বাচন করুন <span style="color: #ef4444;">*</span></label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; background: #f8fafc; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            @foreach($categories as $category)
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; color: #334155;">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
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
                            <input type="number" step="0.01" name="price_hardcopy" value="{{ old('price_hardcopy', 0) }}" required class="form-control" placeholder="যেমন: 350">
                        </div>

                        <div class="form-group">
                            <label class="form-label">ই-বুক মূল্য (টাকা) <span style="color: #ef4444;">*</span></label>
                            <input type="number" step="0.01" name="price_ebook" value="{{ old('price_ebook', 0) }}" required class="form-control" placeholder="যেমন: 120">
                        </div>

                        <div class="form-group">
                            <label class="form-label">ডিসকাউন্ট (%) (ঐচ্ছিক)</label>
                            <input type="number" step="0.01" name="discount_percent" value="{{ old('discount_percent', 0) }}" min="0" max="100" class="form-control" placeholder="যেমন: 10">
                        </div>
                    </div>

                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">স্টক পরিমাণ (হার্ডকপি)</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 50) }}" min="0" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">স্টক স্ট্যাটাস <span style="color: #ef4444;">*</span></label>
                            <select name="stock_status" class="form-control">
                                <option value="in_stock" {{ old('stock_status') === 'in_stock' ? 'selected' : '' }}>স্টকে আছে (In Stock)</option>
                                <option value="low_stock" {{ old('stock_status') === 'low_stock' ? 'selected' : '' }}>সীমিত স্টক (Low Stock)</option>
                                <option value="out_of_stock" {{ old('stock_status') === 'out_of_stock' ? 'selected' : '' }}>স্টক শেষ (Out of Stock)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">অনলাইন প্রিভিউ পৃষ্ঠা সংখ্যা</label>
                            <input type="number" name="preview_pages" value="{{ old('preview_pages', 3) }}" min="1" max="50" class="form-control">
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
                            <input type="text" name="publication_year" value="{{ old('publication_year', date('Y')) }}" placeholder="যেমন: 2026" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">মোট পৃষ্ঠা সংখ্যা</label>
                            <input type="number" name="page_count" value="{{ old('page_count') }}" placeholder="যেমন: 224" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বইয়ের সারসংক্ষেপ (Summary)</label>
                        <textarea name="summary" rows="4" class="form-control" placeholder="বইটির মূল বিষয়বস্তু সম্পর্কে লিখুন...">{{ old('summary') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">বইটি লেখার পেছনের গল্প (Story Behind the Book)</label>
                        <textarea name="story_behind" rows="3" class="form-control" placeholder="বইটি প্রকাশের পটভূমি বা বিশেষ কোনো প্রেক্ষাপট...">{{ old('story_behind') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">লেখকের বিশেষ বক্তব্য বা পরিচিতি (Pen Picture)</label>
                        <textarea name="pen_picture" rows="2" class="form-control" placeholder="লেখক পরিচিতি বা বার্তা...">{{ old('pen_picture') }}</textarea>
                    </div>
                </div>

                <!-- Files Upload -->
                <div style="margin-bottom: 32px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 16px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-cloud-arrow-up-fill" style="color: #0284c7;"></i> ফাইল ও কভার ছবি
                    </h3>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">বইয়ের কভার ছবি <span style="color: #ef4444;">*</span> (JPG, PNG)</label>
                            <input type="file" name="cover_image" accept="image/*" required class="form-control">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">সর্বোচ্চ সাইজ: 4 MB। স্পষ্ট ও আকর্ষণীয় কভার ছবি দিন।</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">ই-বুক পিডিএফ ফাইল (PDF) (ঐচ্ছিক)</label>
                            <input type="file" name="ebook_file" accept=".pdf" class="form-control">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">ই-বুক পড়ার জন্য মূল PDF ফাইল আপলোড করুন (সর্বোচ্চ 50 MB)।</small>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">ইউটিউব ভিডিও / রিভিউ লিঙ্ক (ঐচ্ছিক)</label>
                            <input type="url" name="video_url" value="{{ old('video_url') }}" class="form-control" placeholder="https://www.youtube.com/watch?v=... বা https://youtu.be/...">
                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">বইটির ইউটিউব ভিডিও রিভিউ থাকলে লিঙ্ক দিন। বিস্তারিত পেজে ১৬:৯ ফরম্যাটে ভিডিও প্রদর্শিত হবে।</small>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <a href="{{ route('publisher.books.index') }}" class="btn btn-gray">বাতিল করুন</a>
                    <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-size: 15px; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="bi bi-send-check"></i> বইটি অ্যাডমিন পর্যালোচনার জন্য জমা দিন
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
