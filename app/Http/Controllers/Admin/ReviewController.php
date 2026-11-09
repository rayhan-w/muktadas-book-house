<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('book')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $status = $request->input('status');
        if (in_array($status, ['approved', 'rejected'])) {
            $review->status = $status;
            $review->save();
            return back()->with('success', 'রিভিউ স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।');
        }
        return back()->with('error', 'অবৈধ অনুরোধ।');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'রিভিউটি মুছে ফেলা হয়েছে।');
    }
}
