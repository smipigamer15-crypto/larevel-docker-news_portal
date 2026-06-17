<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment
     */
    public function store(Request $request, $newsId)
{
    try {
        $request->validate([
            'content' => 'required|string|max:5000'
        ]);
        
        $comment = Comment::create([
            'news_id' => $newsId,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);
        
        // Load user relationship for response
        $comment->load('user');
        
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'name' => $comment->user->name,
                    'avatar' => strtoupper(substr($comment->user->name, 0, 1))
                ],
                'created_at' => $comment->created_at->diffForHumans()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
    
    /**
     * Update the specified comment
     */
    public function update(Request $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            
    
            if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
                return response()->json(['success' => false, 'message' => 'No rights to edit'], 403);
            }
            
            $request->validate([
                'content' => 'required|string|max:5000'
            ]);
            
            $comment->update([
                'content' => $request->content
            ]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Remove the specified comment
     */

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            
            if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
                return response()->json(['success' => false, 'message' => 'No rights to delete'], 403);
            }
            
            $comment->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}