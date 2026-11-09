<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::whereIn('order_status', ['payment_verified', 'processing', 'shipped', 'delivered'])->sum('total');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalBooks = Book::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingReviews = Review::where('status', 'pending')->count();
        $totalPublishers = User::where('role', 'publisher')->count();
        $pendingPublishers = User::where('role', 'publisher')->where('publisher_status', 'pending')->count();
        $pendingPublisherBooks = Book::whereNotNull('user_id')->where('approval_status', 'pending')->count();

        // Recent Orders
        $recentOrders = Order::latest()->take(6)->get();

        // Format breakdown
        $ebookSales = OrderItem::where('format', 'ebook')
            ->whereHas('order', function ($q) {
                $q->whereIn('order_status', ['payment_verified', 'processing', 'shipped', 'delivered']);
            })->sum('total');

        $hardcopySales = OrderItem::where('format', 'hardcopy')
            ->whereHas('order', function ($q) {
                $q->whereIn('order_status', ['payment_verified', 'processing', 'shipped', 'delivered']);
            })->sum('total');

        // Most Sold Books
        $topBooks = Book::withCount('categories')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'totalBooks',
            'totalCustomers',
            'pendingReviews',
            'recentOrders',
            'ebookSales',
            'hardcopySales',
            'topBooks',
            'totalPublishers',
            'pendingPublishers',
            'pendingPublisherBooks'
        ));
    }
}
