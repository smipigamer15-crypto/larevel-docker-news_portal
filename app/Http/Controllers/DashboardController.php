<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $comments = $user->comments()->with('news')->latest()->get();

        $history = collect();
        $viewedArticles = 0;
        
        if (method_exists($user, 'viewedNews')) {
            $history = $user->viewedNews()->orderBy('viewed_at', 'desc')->get();
            $viewedArticles = $history->count();
        }
        
        $saved = collect();
        $savedArticles = 0;
        
        if (method_exists($user, 'savedNews')) {
            $saved = $user->savedNews()->latest()->get();
            $savedArticles = $saved->count();
        }
        
    
        $likedNews = $user->likes()->latest()->get();
        $likedCount = $likedNews->count();
        
        return view('dashboard', [
            'myComments' => $comments->count(),
            'savedArticles' => $savedArticles,
            'viewedArticles' => $viewedArticles,
            'comments' => $comments,
            'saved' => $saved,
            'history' => $history,
            'likedNews' => $likedNews,
            'likedCount' => $likedCount,
        ]);
    }
    
    public function clearHistory()
    {
        try {
            auth()->user()->viewedNews()->detach();
            
            return response()->json([
                'success' => true,
                'message' => 'History cleared successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing history: ' . $e->getMessage()
            ], 500);
        }
    }
}