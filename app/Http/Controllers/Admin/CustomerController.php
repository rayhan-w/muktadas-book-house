<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['orders', 'library']);

        if ($request->filled('role') && in_array($request->role, ['customer', 'publisher', 'admin'])) {
            $query->where('role', $request->role);
        } else {
            // Default show customers, or all if specified
            if ($request->get('role') !== 'all') {
                $query->where('role', 'customer');
            }
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        $customers = $query->latest()->paginate(15)->withQueryString();
        $counts = [
            'all' => User::count(),
            'customer' => User::where('role', 'customer')->count(),
            'publisher' => User::where('role', 'publisher')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        return view('admin.customers.index', compact('customers', 'counts'));
    }

    public function edit(User $user)
    {
        return view('admin.customers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'role' => 'required|in:customer,publisher,admin',
            'membership_plan' => 'nullable|string|max:100',
            'membership_expires_at' => 'nullable|date',
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'পাঠকের নাম আবশ্যক।',
            'email.required' => 'ইমেইল অ্যাড্রেস আবশ্যক।',
            'email.unique' => 'এই ইমেইল দিয়ে অন্য একাউন্ট রয়েছে।',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->role = $validated['role'];
        $user->membership_plan = $validated['membership_plan'] ?? null;
        $user->membership_expires_at = $validated['membership_expires_at'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.customers.index')->with('success', 'পাঠক/ব্যবহারকারীর তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'আপনি নিজের অ্যাডমিন অ্যাকাউন্ট মুছে ফেলতে পারবেন না!');
        }

        $user->delete();

        return redirect()->route('admin.customers.index')->with('success', 'ব্যবহারকারীর অ্যাকাউন্টটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
