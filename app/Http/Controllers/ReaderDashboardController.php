<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EbookLibrary;
use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReaderDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $libraryCount = EbookLibrary::where('user_id', $user->id)->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $totalOrders = Order::where('user_id', $user->id)->count();

        return view('reader.dashboard', compact('user', 'recentOrders', 'libraryCount', 'wishlistCount', 'totalOrders'));
    }

    public function library()
    {
        $user = Auth::user();
        $ebooks = EbookLibrary::with('book')->where('user_id', $user->id)->latest()->get();

        return view('reader.library', compact('user', 'ebooks'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::with('items.book')->where('user_id', $user->id)->latest()->paginate(10);

        return view('reader.orders', compact('user', 'orders'));
    }

    public function invoice($orderNumber)
    {
        $order = Order::with(['items.book', 'user'])->where('order_number', $orderNumber)->firstOrFail();

        // If not admin and not the order owner
        if (Auth::check() && !Auth::user()->isAdmin() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reader.invoice', compact('order'));
    }

    public function wishlist()
    {
        $user = Auth::user();
        $wishlists = Wishlist::with('book')->where('user_id', $user->id)->latest()->get();

        return view('reader.wishlist', compact('user', 'wishlists'));
    }

    public function toggleWishlist($bookId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'উইশলিস্টে যুক্ত করতে প্রথমে লগইন করুন।');
        }

        $userId = Auth::id();
        $existing = Wishlist::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($existing) {
            $existing->delete();
            $message = 'বইটি উইশলিস্ট থেকে সরানো হয়েছে।';
        } else {
            Wishlist::create(['user_id' => $userId, 'book_id' => $bookId]);
            $message = 'বইটি আপনার উইশলিস্টে সংরক্ষিত হয়েছে!';
        }

        return back()->with('success', $message);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:300',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->with('error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।');
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'আপনার প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
    }
}
