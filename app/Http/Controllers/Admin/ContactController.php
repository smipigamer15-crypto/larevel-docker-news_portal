<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::with('user')->latest()->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $contact->id,
                'user_name' => $contact->user->name,
                'user_email' => $contact->user->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'topic_label' => $contact->topic_label,
                'status' => $contact->status,
                'status_label' => $contact->status_label,
                'created_at' => $contact->created_at->format('d.m.Y H:i')
            ]);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied'
        ]);

        $contact->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Status updated');
    }

    public function markAsRead(Contact $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        
        return response()->json([
            'success' => true,
            'status_label' => $contact->status_label
        ]);
    }
}