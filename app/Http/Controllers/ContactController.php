<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts');
    }


    public function store(Request $request)
    {
       
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to send a message.');
        }

  
        $validated = $request->validate([
            'subject' => 'required|string|min:3|max:255',
            'topic' => 'required|in:general,advertising,cooperation,bug,other',
            'message' => 'required|string|min:10|max:5000',
        ]);

    
        Contact::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'topic' => $validated['topic'],
            'message' => $validated['message'],
            'status' => 'new'
        ]);

        return redirect()->route('contacts.index')
            ->with('success', 'Thank you! Your message has been sent successfully.');
    }

    public function adminIndex()
    {
        $contacts = Contact::with('user')->latest()->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        return view('admin.contacts.show', compact('contact'));
    }
}
