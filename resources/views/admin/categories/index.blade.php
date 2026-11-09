@extends('layouts.admin')

@section('title', 'ক্যাটাগরি ব্যবস্থাপনা | মুক্তাদার বইঘর অ্যাডমিন')
@section('page_title', 'বইয়ের ক্যাটাগরি ব্যবস্থাপনা')

@section('content')
<div class="grid-2">
    <!-- List of categories -->
    <div class="admin-card">
        <div class="card-header">
            <h2>সকল ক্যাটাগরি তালিকা ({{ $categories->count() }})</h2>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ক্রম</th>
                    <th>ক্যাটাগরির নাম</th>
                    <th>Slug</th>
                    <th>বই সংখ্যা</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td>{{ $cat->sort_order }}</td>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td>{{ $cat->books_count }}টি বই</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('এই ক্যাটাগরি মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-red" style="padding: 4px 8px;">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create new category form -->
    <div class="admin-card">
        <div class="card-header">
            <h2>+ নতুন ক্যাটাগরি তৈরি করুন</h2>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">ক্যাটাগরির নাম *</label>
                <input type="text" name="name" required class="form-control" placeholder="যেমন: সমকালীন উপন্যাস">
            </div>

            <div class="form-group">
                <label class="form-label">URL Slug (ঐচ্ছিক)</label>
                <input type="text" name="slug" class="form-control" placeholder="যেমন: contemporary-novels">
            </div>

            <div class="form-group">
                <label class="form-label">ক্রম / Sort Order (সংখ্যা)</label>
                <input type="number" name="sort_order" value="{{ $categories->count() + 1 }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">সংক্ষিপ্ত বিবরণ</label>
                <textarea name="description" rows="3" class="form-control" placeholder="এই ক্যাটাগরির বই সম্পর্কে এক-দুই লাইন..."></textarea>
            </div>

            <button type="submit" class="btn-sm btn-blue" style="padding: 10px 20px;">
                ক্যাটাগরি যুক্ত করুন
            </button>
        </form>
    </div>
</div>
@endsection
