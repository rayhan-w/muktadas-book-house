<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublisherController extends Controller
{
    /**
     * Show registration form for publisher.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->isPublisher()) {
                return redirect()->route('publisher.dashboard');
            }
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('publisher.register');
    }

    /**
     * Handle publisher registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'publisher_company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:500',
            'publisher_bio' => 'nullable|string|max:2000',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'publisher_company.required' => 'প্রকাশনীর নাম আবশ্যক।',
            'name.required' => 'দায়িত্বপ্রাপ্ত ব্যক্তির নাম আবশ্যক।',
            'email.required' => 'ইমেইল অ্যাড্রেস আবশ্যক।',
            'email.unique' => 'এই ইমেইল দিয়ে আগেই অ্যাকাউন্ট খোলা হয়েছে।',
            'phone.required' => 'মোবাইল নম্বর আবশ্যক।',
            'password.required' => 'পাসওয়ার্ড আবশ্যক।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'role' => 'publisher',
            'publisher_company' => $validated['publisher_company'],
            'publisher_status' => 'pending',
            'publisher_bio' => $validated['publisher_bio'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('publisher.dashboard')->with('success', 'আপনার প্রকাশনী অ্যাকাউন্টটি সফলভাবে তৈরি হয়েছে! অ্যাকাউন্টটি পর্যালোচনার জন্য অ্যাডমিনের কাছে পাঠানো হয়েছে। অনুমোদন পাওয়ার পর আপনি বই যুক্ত করতে পারবেন।');
    }

    /**
     * Publisher Dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $totalBooks = $user->publisherBooks()->count();
        $approvedBooks = $user->publisherBooks()->where('approval_status', 'approved')->count();
        $pendingBooks = $user->publisherBooks()->where('approval_status', 'pending')->count();
        $rejectedBooks = $user->publisherBooks()->where('approval_status', 'rejected')->count();
        $recentBooks = $user->publisherBooks()->with('categories')->latest()->take(6)->get();

        return view('publisher.dashboard', compact('user', 'totalBooks', 'approvedBooks', 'pendingBooks', 'rejectedBooks', 'recentBooks'));
    }

    /**
     * List publisher's books.
     */
    public function books(Request $request)
    {
        $user = Auth::user();
        $query = $user->publisherBooks()->with('categories');

        if ($request->filled('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
            $query->where('approval_status', $request->status);
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('author_name', 'like', "%{$term}%");
            });
        }

        $books = $query->latest()->paginate(10)->withQueryString();

        $counts = [
            'all' => $user->publisherBooks()->count(),
            'approved' => $user->publisherBooks()->where('approval_status', 'approved')->count(),
            'pending' => $user->publisherBooks()->where('approval_status', 'pending')->count(),
            'rejected' => $user->publisherBooks()->where('approval_status', 'rejected')->count(),
        ];

        return view('publisher.books.index', compact('books', 'counts', 'user'));
    }

    /**
     * Show create book form.
     */
    public function createBook()
    {
        $user = Auth::user();

        if (!$user->isApprovedPublisher()) {
            return redirect()->route('publisher.dashboard')->with('error', 'আপনার প্রকাশনী অ্যাকাউন্টটি এখনও অনুমোদিত নয়। অ্যাডমিনের অনুমোদনের পর আপনি বই যোগ করতে পারবেন।');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('publisher.books.create', compact('categories', 'user'));
    }

    /**
     * Store submitted book.
     */
    public function storeBook(Request $request)
    {
        $user = Auth::user();

        if (!$user->isApprovedPublisher()) {
            return redirect()->route('publisher.dashboard')->with('error', 'আপনার প্রকাশনী অ্যাকাউন্টটি এখনও অনুমোদিত নয়।');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'price_hardcopy' => 'required|numeric|min:0',
            'price_ebook' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'preview_pages' => 'required|integer|min:1|max:50',
            'publication_year' => 'nullable|string|max:50',
            'page_count' => 'nullable|integer|min:1',
            'summary' => 'nullable|string',
            'story_behind' => 'nullable|string',
            'pen_picture' => 'nullable|string',
            'cover_image' => 'required|image|max:4096',
            'ebook_file' => 'nullable|mimes:pdf|max:51200',
        ], [
            'title.required' => 'বইয়ের শিরোনাম আবশ্যক।',
            'author_name.required' => 'লেখকের নাম আবশ্যক।',
            'categories.required' => 'অন্তত একটি ক্যাটাগরি নির্বাচন করুন।',
            'price_hardcopy.required' => 'হার্ডকপি মূল্য আবশ্যক।',
            'price_ebook.required' => 'ই-বুক মূল্য আবশ্যক।',
            'cover_image.required' => 'বইয়ের কভার ছবি আপলোড করা আবশ্যক।',
            'cover_image.image' => 'কভার ফাইলটি অবশ্যই ছবি ফরম্যাটে হতে হবে।',
        ]);

        $slug = Str::slug($validated['title']);
        if (Book::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(100, 999);
        }

        $bookData = [
            'user_id' => $user->id,
            'publisher_name' => $user->publisher_company ?: $user->name,
            'title' => $validated['title'],
            'slug' => $slug,
            'author_name' => $validated['author_name'],
            'summary' => $validated['summary'] ?? null,
            'story_behind' => $validated['story_behind'] ?? null,
            'publication_year' => $validated['publication_year'] ?? null,
            'page_count' => $validated['page_count'] ?? null,
            'price_hardcopy' => $validated['price_hardcopy'],
            'price_ebook' => $validated['price_ebook'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'stock_quantity' => $validated['stock_quantity'] ?? 50,
            'stock_status' => $validated['stock_status'],
            'preview_pages' => $validated['preview_pages'],
            'pen_picture' => $validated['pen_picture'] ?? null,
            // SECURITY: Submitted books are hidden and pending approval
            'approval_status' => 'pending',
            'is_published' => false,
            'rejection_reason' => null,
        ];

        // Ensure directories exist
        if (!file_exists(public_path('covers'))) {
            mkdir(public_path('covers'), 0755, true);
        }
        if (!file_exists(public_path('ebooks'))) {
            mkdir(public_path('ebooks'), 0755, true);
        }

        if ($request->hasFile('cover_image')) {
            $coverName = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('cover_image')->getClientOriginalExtension();
            $request->file('cover_image')->move(public_path('covers'), $coverName);
            $bookData['cover_image'] = 'covers/' . $coverName;
        }

        if ($request->hasFile('ebook_file')) {
            $ebookName = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $request->file('ebook_file')->move(public_path('ebooks'), $ebookName);
            $bookData['ebook_file'] = 'ebooks/' . $ebookName;
        }

        $book = Book::create($bookData);
        $book->categories()->sync($validated['categories']);

        return redirect()->route('publisher.books.index')->with('success', 'বইটি সফলভাবে জমা দেওয়া হয়েছে! অ্যাডমিন পর্যালোচনার পর এটি ওয়েবসাইটে লাইভ করা হবে।');
    }

    /**
     * Show edit book form.
     */
    public function editBook($id)
    {
        $user = Auth::user();
        $book = Book::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('publisher.books.edit', compact('book', 'categories', 'user'));
    }

    /**
     * Update book by publisher.
     * STRICT SECURITY RULE: Any edit sets approval_status to 'pending' and unpublishes until admin re-approves.
     */
    public function updateBook(Request $request, $id)
    {
        $user = Auth::user();
        $book = Book::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'price_hardcopy' => 'required|numeric|min:0',
            'price_ebook' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,low_stock,out_of_stock',
            'preview_pages' => 'required|integer|min:1|max:50',
            'publication_year' => 'nullable|string|max:50',
            'page_count' => 'nullable|integer|min:1',
            'summary' => 'nullable|string',
            'story_behind' => 'nullable|string',
            'pen_picture' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'ebook_file' => 'nullable|mimes:pdf|max:51200',
        ], [
            'title.required' => 'বইয়ের শিরোনাম আবশ্যক।',
            'author_name.required' => 'লেখকের নাম আবশ্যক।',
            'categories.required' => 'অন্তত একটি ক্যাটাগরি নির্বাচন করুন।',
            'price_hardcopy.required' => 'হার্ডকপি মূল্য আবশ্যক।',
            'price_ebook.required' => 'ই-বুক মূল্য আবশ্যক।',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
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
            'pen_picture' => $validated['pen_picture'] ?? null,
            // CRITICAL VOICE RULE: Reverts to pending and unpublished upon edit
            'approval_status' => 'pending',
            'is_published' => false,
            'rejection_reason' => null,
        ];

        if ($request->hasFile('cover_image')) {
            $coverName = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('cover_image')->getClientOriginalExtension();
            $request->file('cover_image')->move(public_path('covers'), $coverName);
            $updateData['cover_image'] = 'covers/' . $coverName;
        }

        if ($request->hasFile('ebook_file')) {
            $ebookName = time() . '_' . Str::slug($validated['title']) . '.' . $request->file('ebook_file')->getClientOriginalExtension();
            $request->file('ebook_file')->move(public_path('ebooks'), $ebookName);
            $updateData['ebook_file'] = 'ebooks/' . $ebookName;
        }

        $book->update($updateData);
        $book->categories()->sync($validated['categories']);

        return redirect()->route('publisher.books.index')->with('success', '⚠️ বইয়ের তথ্য সফলভাবে আপডেট হয়েছে! কন্টেন্টের নিরাপত্তা ও যাচাইয়ের স্বার্থে বইটি সাময়িকভাবে অপ্রকাশিত রাখা হয়েছে এবং অ্যাডমিনের পুনঃঅনুমোদনের (Re-approval) পর এটি আবার ওয়েবসাইটে প্রকাশিত হবে।');
    }

    /**
     * Delete pending or rejected book.
     */
    public function destroyBook($id)
    {
        $user = Auth::user();
        $book = Book::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // If approved book, verify if publisher can delete or soft delete
        $book->delete();

        return redirect()->route('publisher.books.index')->with('success', 'বইটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
