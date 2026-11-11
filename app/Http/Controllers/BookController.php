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
        $query = Book::with(['categories', 'approvedReviews'])->approved();

        $searchTerm = trim($request->input('search') ?: $request->input('q', ''));
        if ($searchTerm !== '') {
            $terms = [$searchTerm];
            // Bengali inflection handling (e.g. আলোর -> আলো)
            if (mb_substr($searchTerm, -1) === 'র') {
                $trimmed = mb_substr($searchTerm, 0, -1);
                if (mb_substr($trimmed, -1) === 'ে') {
                    $trimmed = mb_substr($trimmed, 0, -1);
                }
                if (mb_strlen($trimmed) >= 2) {
                    $terms[] = $trimmed;
                }
            }

            $query->where(function ($q) use ($terms) {
                foreach ($terms as $t) {
                    $q->orWhere('title', 'like', "%{$t}%")
                      ->orWhere('author_name', 'like', "%{$t}%")
                      ->orWhere('publisher_name', 'like', "%{$t}%");
                }
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
                    $query->orderByRaw('(price_hardcopy * (1.0 - (discount_percent / 100.0))) ASC');
                    break;
                case 'price_high':
                    $query->orderByRaw('(price_hardcopy * (1.0 - (discount_percent / 100.0))) DESC');
                    break;
                case 'name_asc':
                case 'name':
                    $query->orderBy('title', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('is_popular', 'desc')->latest();
                    break;
                case 'featured':
                    $query->orderBy('is_featured', 'desc')->latest();
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $books = $query->paginate(16)->withQueryString();
        $categories = Category::where('is_active', true)
            ->withCount(['books' => function ($q) {
                $q->where('is_published', true);
            }])
            ->orderBy('sort_order')
            ->get();
        $totalBooksCount = Book::approved()->count();
        $selectedCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('books.index', compact('books', 'categories', 'selectedCategory', 'totalBooksCount', 'searchTerm'));
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
        $hasPurchased = false;

        if (Auth::check()) {
            $userId = Auth::id();
            $inWishlist = Wishlist::where('user_id', $userId)->where('book_id', $book->id)->exists();
            $hasEbook = Auth::user()->isAdmin() || EbookLibrary::where('user_id', $userId)->where('book_id', $book->id)->exists();
            
            // Check if user has purchased this book (Item 8)
            $hasPurchased = Auth::user()->isAdmin() 
                || \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                    $q->where('user_id', $userId)->whereIn('order_status', ['delivered', 'payment_verified', 'processing', 'completed']);
                })->where('book_id', $book->id)->exists()
                || \App\Models\EbookLibrary::where('user_id', $userId)->where('book_id', $book->id)->exists();
        }

        return view('books.show', compact('book', 'relatedBooks', 'inWishlist', 'hasEbook', 'hasPurchased'));
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
        if (!Auth::check()) {
            return back()->with('review_error', 'রিভিউ প্রদানের জন্য অনুগ্রহ করে প্রথমে আপনার অ্যাকাউন্টে লগইন করুন।');
        }

        $book = Book::where('slug', $slug)->firstOrFail();
        $userId = Auth::id();

        // Enforce verified purchase only (Item 8)
        $hasPurchased = Auth::user()->isAdmin()
            || \App\Models\OrderItem::whereHas('order', function ($q) use ($userId) {
                $q->where('user_id', $userId)->whereIn('order_status', ['delivered', 'payment_verified', 'processing', 'completed']);
            })->where('book_id', $book->id)->exists()
            || \App\Models\EbookLibrary::where('user_id', $userId)->where('book_id', $book->id)->exists();

        if (!$hasPurchased) {
            return back()->with('review_error', 'দুঃখিত, শুধুমাত্র এই বইটি ক্রয়কারী ভেরিফায়েড পাঠকরাই রিভিউ ও মতামত প্রদান করতে পারবেন।');
        }

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'customer_name' => $validated['customer_name'] ?: Auth::user()->name,
            'customer_email' => Auth::user()->email,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => true,
            'status' => 'approved',
        ]);

        return back()->with('review_success', 'আপনার মূল্যবান পর্যালোচনার জন্য ধন্যবাদ! আপনার রিভিউটি প্রকাশিত হয়েছে।');
    }
}
