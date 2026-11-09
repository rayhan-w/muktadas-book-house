<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();
        $members = User::whereNotNull('membership_plan')->latest()->get();
        return view('admin.memberships.index', compact('memberships', 'members'));
    }

    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'free_ebooks_count' => 'required|integer|min:0',
            'benefits' => 'nullable|string',
        ]);

        $membership->update($validated);

        return back()->with('success', 'মেম্বারশিপ প্যাকেজ সফলভাবে আপডেট করা হয়েছে।');
    }
}
