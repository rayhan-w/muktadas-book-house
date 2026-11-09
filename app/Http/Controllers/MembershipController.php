<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::where('is_active', true)->orderBy('price')->get();
        $bkash = SiteSetting::get('bkash_number', '01700-112233');
        $nagad = SiteSetting::get('nagad_number', '01800-445566');

        return view('membership.index', compact('memberships', 'bkash', 'nagad'));
    }
}
