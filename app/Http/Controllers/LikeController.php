<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in'
            ], 401);
        }
        
        if ($user->hasLiked($news->id)) {
            $user->likes()->detach($news->id);
            $liked = false;
            $news->decrement('likes_count');
        } else {
            $user->likes()->attach($news->id);
            $liked = true;
            $news->increment('likes_count');
        }
        
        $news->refresh();
        
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $news->likes_count
        ]);
    }
}