<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('categories');

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books,slug',
            'author_name' => 'required|string|max:255',
            'publisher_name' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'story_behind' => 'nullable|string',
            'publication_year' => 'nullable|string|max:50',
            'page_count' => 'nullable|integer|min:1',
            'price_hardcopy' => 'required|numeric|min:0',
            'price_ebook' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'preview_pages' => 'required|integer|min:1|max:50',
            'is_featured' => 'nullable|boolean',
            'is_latest' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'is_upcoming' => 'nullable|boolean',
            'expected_date' => 'nullable|string|max:100',
            'pen_picture' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'cover_image' => 'nullable|image|max:3072',
            'ebook_file' => 'nullable|mimes:pdf|max:51200',
            'video_url' => 'nullable|string|max:500',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $slug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        if (Book::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(100, 999);
        }

        $bookData = [
            'title' => $validated['title'],
            'slug' => $slug,
            'author_name' => $validated['author_name'],
            'publisher_name' => $request->filled('publisher_name') ? trim($request->publisher_name) : null,
            'summary' => $validated['summary'] ?? null,
            'story_behind' => $validated['story_behind'] ?? null,
            'publication_year' => $validated['publication_year'] ?? null,
            'page_count' => $validated['page_count'] ?? null,
            'price_hardcopy' => $validated['price_hardcopy'],
            'price_ebook' => $validated['price_ebook'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'stock_status' => $validated['stock_status'],
            'preview_pages' => $validated['preview_pages'],
            'is_featured' => $request->has('is_featured'),
            'is_latest' => $request->has('is_latest'),
            'is_popular' => $request->has('is_popular'),
            'is_upcoming' => $request->has('is_upcoming'),
            'expected_date' => $validated['expected_date'] ?? null,
            'pen_picture' => $validated['pen_picture'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'is_published' => true,
            'approval_status' => 'approved',
        ];

        if ($request->hasFile('cover_image')) {
            if (!file_exists(public_path('covers'))) {
                @mkdir(public_path('covers'), 0775, true);
            }
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('cover_image')->getClientOriginalExtension();
            $request->file('cover_image')->move(public_path('covers'), $filename);
            $bookData['cover_image'] = 'covers/' . $filename;
        }

        if ($request->hasFile('ebook_file')) {
            if (!file_exists(public_path('ebooks'))) {
                @mkdir(public_path('ebooks'), 0775, true);
            }
            $pdfFilename = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $request->file('ebook_file')->move(public_path('ebooks'), $pdfFilename);
            $bookData['ebook_file'] = 'ebooks/' . $pdfFilename;
        }

        $book = Book::create($bookData);
        $book->categories()->sync($validated['categories']);

        return redirect()->route('admin.books.index')->with('success', 'নতুন বই সফলভাবে যোগ করা হয়েছে।');
    }

    public function edit(Book $book)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $book->id,
            'author_name' => 'required|string|max:255',
            'publisher_name' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'story_behind' => 'nullable|string',
            'publication_year' => 'nullable|string|max:50',
            'page_count' => 'nullable|integer|min:1',
            'price_hardcopy' => 'required|numeric|min:0',
            'price_ebook' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'preview_pages' => 'required|integer|min:1|max:50',
            'is_featured' => 'nullable|boolean',
            'is_latest' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'is_upcoming' => 'nullable|boolean',
            'expected_date' => 'nullable|string|max:100',
            'pen_picture' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'cover_image' => 'nullable|image|max:3072',
            'ebook_file' => 'nullable|mimes:pdf|max:51200',
            'video_url' => 'nullable|string|max:500',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $bookData = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'author_name' => $validated['author_name'],
            'publisher_name' => $request->filled('publisher_name') ? trim($request->publisher_name) : null,
            'summary' => $validated['summary'] ?? null,
            'story_behind' => $validated['story_behind'] ?? null,
            'publication_year' => $validated['publication_year'] ?? null,
            'page_count' => $validated['page_count'] ?? null,
            'price_hardcopy' => $validated['price_hardcopy'],
            'price_ebook' => $validated['price_ebook'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'stock_status' => $validated['stock_status'],
            'preview_pages' => $validated['preview_pages'],
            'is_featured' => $request->has('is_featured'),
            'is_latest' => $request->has('is_latest'),
            'is_popular' => $request->has('is_popular'),
            'is_upcoming' => $request->has('is_upcoming'),
            'expected_date' => $validated['expected_date'] ?? null,
            'pen_picture' => $validated['pen_picture'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
        ];

        if ($request->hasFile('cover_image')) {
            if (!file_exists(public_path('covers'))) {
                @mkdir(public_path('covers'), 0775, true);
            }
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('cover_image')->getClientOriginalExtension();
            $request->file('cover_image')->move(public_path('covers'), $filename);
            $bookData['cover_image'] = 'covers/' . $filename;
        }

        if ($request->hasFile('ebook_file')) {
            if (!file_exists(public_path('ebooks'))) {
                @mkdir(public_path('ebooks'), 0775, true);
            }
            $pdfFilename = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $request->file('ebook_file')->move(public_path('ebooks'), $pdfFilename);
            $bookData['ebook_file'] = 'ebooks/' . $pdfFilename;
        }

        $book->update($bookData);
        $book->categories()->sync($validated['categories']);

        return redirect()->route('admin.books.index')->with('success', 'বইয়ের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'বইটি তালিকা থেকে মুছে ফেলা হয়েছে।');
    }
}
