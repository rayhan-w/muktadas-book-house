<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPublisherController extends Controller
{
    /**
     * List all registered publishers.
     */
    public function publishers(Request $request)
    {
        $query = User::where('role', 'publisher')->withCount('publisherBooks');

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('publisher_status', $request->status);
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('publisher_company', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        $publishers = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => User::where('role', 'publisher')->count(),
            'pending' => User::where('role', 'publisher')->where('publisher_status', 'pending')->count(),
            'approved' => User::where('role', 'publisher')->where('publisher_status', 'approved')->count(),
            'rejected' => User::where('role', 'publisher')->where('publisher_status', 'rejected')->count(),
        ];

        return view('admin.publishers.index', compact('publishers', 'counts'));
    }

    /**
     * Approve publisher account.
     */
    public function approvePublisher($id)
    {
        $publisher = User::where('role', 'publisher')->findOrFail($id);
        $publisher->update([
            'publisher_status' => 'approved',
            'publisher_rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', "প্রকাশনী '{$publisher->publisher_company}' সফলভাবে অনুমোদন করা হয়েছে। তারা এখন বই জমা দিতে পারবে।");
    }

    /**
     * Reject publisher account.
     */
    public function rejectPublisher(Request $request, $id)
    {
        $publisher = User::where('role', 'publisher')->findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ], [
            'rejection_reason.required' => 'বাতিলকরণের কারণ উল্লেখ করা আবশ্যক।',
        ]);

        $publisher->update([
            'publisher_status' => 'rejected',
            'publisher_rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', "প্রকাশনী '{$publisher->publisher_company}' বাতিল করা হয়েছে।");
    }

    /**
     * List all submitted books by publishers.
     */
    public function books(Request $request)
    {
        $query = Book::whereNotNull('user_id')->with(['user', 'categories']);

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('approval_status', $request->status);
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('author_name', 'like', "%{$term}%")
                  ->orWhere('publisher_name', 'like', "%{$term}%");
            });
        }

        $books = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => Book::whereNotNull('user_id')->count(),
            'pending' => Book::whereNotNull('user_id')->where('approval_status', 'pending')->count(),
            'approved' => Book::whereNotNull('user_id')->where('approval_status', 'approved')->count(),
            'rejected' => Book::whereNotNull('user_id')->where('approval_status', 'rejected')->count(),
        ];

        return view('admin.publishers.books', compact('books', 'counts'));
    }

    /**
     * Approve publisher's book submission or updated edit.
     */
    public function approveBook($id)
    {
        $book = Book::whereNotNull('user_id')->findOrFail($id);

        $book->update([
            'approval_status' => 'approved',
            'is_published' => true,
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', "বইটি ('{$book->title}') সফলভাবে অনুমোদন করা হয়েছে এবং ওয়েবসাইটে প্রকাশিত হয়েছে।");
    }

    /**
     * Reject publisher's book submission.
     */
    public function rejectBook(Request $request, $id)
    {
        $book = Book::whereNotNull('user_id')->findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ], [
            'rejection_reason.required' => 'বাতিল করার কারণ উল্লেখ করা আবশ্যক।',
        ]);

        $book->update([
            'approval_status' => 'rejected',
            'is_published' => false,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', "বইটি ('{$book->title}') বাতিল করা হয়েছে। কারণ প্রকাশকের ড্যাশবোর্ডে প্রদর্শিত হবে।");
    }
}
