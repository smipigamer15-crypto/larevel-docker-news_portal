<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Contact; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasicController extends Controller
{
    public function index()
    {
        $heroNews = News::latest()->first();
        
        $news = News::orderBy('views', 'desc')->take(30)->get();
        
        $categories = News::select('category')->distinct()->pluck('category');
        
        return view('navbar.home', compact('heroNews', 'news', 'categories'));
    }

    public function about()
    {
        return view('navbar.about');
    }

    public function contact()
    {
        return view('navbar.contact',['hideSidebar' => true]);
    }

    public function contactStore(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to send a message.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|min:3|max:255',
            'topic' => 'required|in:general,advertising,cooperation,news_tip,bug,other',
            'message' => 'required|string|min:10|max:5000',
        ]);

        Contact::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'topic' => $validated['topic'],
            'message' => $validated['message'],
            'status' => 'new'
        ]);

        return redirect()->route('contact')
            ->with('success', 'Thank you! Your message has been sent successfully.');
    }
}