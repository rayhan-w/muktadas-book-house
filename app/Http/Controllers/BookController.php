<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\EbookLibrary;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('categories')->approved();

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('author_name', 'like', "%{$term}%")
                  ->orWhere('publisher_name', 'like', "%{$term}%")
                  ->orWhere('summary', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category')) {
            $catSlug = $request->category;
            $query->whereHas('categories', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price_hardcopy', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price_hardcopy', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('is_popular', 'desc')->latest();
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $selectedCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('books.index', compact('books', 'categories', 'selectedCategory'));
    }

    public function show($slug)
    {
        $book = Book::with(['categories', 'approvedReviews'])->where('slug', $slug)->firstOrFail();

        // If the book is pending or rejected, only Admin or the Publisher who owns it can view it
        if (!$book->isApproved()) {
            if (!Auth::check() || (!Auth::user()->isAdmin() && Auth::id() !== $book->user_id)) {
                abort(404);
            }
        }

        $relatedBooks = Book::approved()
            ->where('id', '!=', $book->id)
            ->whereHas('categories', function ($q) use ($book) {
                $q->whereIn('categories.id', $book->categories->pluck('id'));
            })
            ->take(4)
            ->get();

        $inWishlist = false;
        $hasEbook = false;

        if (Auth::check()) {
            $inWishlist = Wishlist::where('user_id', Auth::id())->where('book_id', $book->id)->exists();
            $hasEbook = Auth::user()->isAdmin() || EbookLibrary::where('user_id', Auth::id())->where('book_id', $book->id)->exists();
        }

        return view('books.show', compact('book', 'relatedBooks', 'inWishlist', 'hasEbook'));
    }

    public function preview($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        if (!$book->isApproved()) {
            if (!Auth::check() || (!Auth::user()->isAdmin() && Auth::id() !== $book->user_id)) {
                abort(404);
            }
        }

        return view('books.preview', compact('book'));
    }

    public function read($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ই-বুক পড়ার জন্য দয়া করে আপনার অ্যাকাউন্টে লগইন করুন।');
        }

        $book = Book::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check if user owns the ebook or is admin
        $entitlement = EbookLibrary::where('user_id', $user->id)->where('book_id', $book->id)->first();

        if (!$entitlement && !$user->isAdmin()) {
            return redirect()->route('books.show', $slug)->with('error', 'এই ই-বুকটি পড়ার জন্য প্রথমে বইটি সংগ্রহ করতে হবে।');
        }

        $lastReadPage = $entitlement ? $entitlement->last_read_page : 1;

        return view('books.reader', compact('book', 'user', 'lastReadPage'));
    }

    public function saveReadingProgress(Request $request, $slug)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $book = Book::where('slug', $slug)->firstOrFail();
        $page = max(1, (int) $request->input('page', 1));

        EbookLibrary::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id],
            ['last_read_page' => $page]
        );

        return response()->json(['success' => true, 'page' => $page]);
    }

    public function submitReview(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'nullable|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $isVerified = false;
        $userId = Auth::id();

        if ($userId) {
            // Check if user purchased this book
            $isVerified = \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)->whereIn('order_status', ['delivered', 'payment_verified', 'processing']);
            })->where('book_id', $book->id)->exists();
        }

        Review::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? (Auth::user()?->email),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => $isVerified,
            'status' => 'pending', // Requires admin approval
        ]);

        return back()->with('review_success', 'আপনার রিভিউটির জন্য ধন্যবাদ! অ্যাডমিন যাচাই করার পর এটি ওয়েবসাইটে প্রকাশিত হবে।');
    }
}
