<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        $subscribers = NewsletterSubscriber::latest()->take(20)->get();
        return view('admin.contacts.index', compact('messages', 'subscribers'));
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'বার্তাটি পঠিত হিসেবে চিহ্নিত করা হয়েছে।');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'বার্তাটি মুছে ফেলা হয়েছে।');
    }
}
