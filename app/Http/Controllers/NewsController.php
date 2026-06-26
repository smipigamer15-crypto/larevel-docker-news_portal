<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Models\NewsView;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function category($category)
    {
        $news = News::where('category', $category)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        return view('news.category', compact('news', 'category'));
    }

    public function index()
    {
        $news = News::latest()->paginate(20);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
        }

        $news = News::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $path,
            'category' => $request->category,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('news.index');
    }

    public function show(News $news)
    {
        $user = Auth::user();
        
        if ($user) {
            $news->addView($user->id);
        } else {
            $news->addView();
        }
        
        $comments = $news->comments()->with('user')->get();
        $likesCount = $news->likes_count ?? 0;
        $isSaved = $user ? $user->savedNews()->where('news_id', $news->id)->exists() : false;
        
        return view('news.show', [
            'news' => $news,
            'comments' => $comments,
            'likesCount' => $likesCount,
            'isSaved' => $isSaved,
        ]);
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ];

        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('news.index');
    }

    public function save(Request $request, $id)
    {
        $news = News::findOrFail($id);
        
        if ($request->input('_method') === 'DELETE') {
            Auth::user()->savedNews()->detach([$id]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'saved' => false,
                    'message' => 'Article removed from saved items'
                ]);
            }
            
            return back()->with('success', 'Article removed from saved items');
        }
        
        $exists = Auth::user()->savedNews()->where('news_id', $id)->exists();
        
        if ($exists) {
            Auth::user()->savedNews()->detach([$id]);
            $saved = false;
            $message = 'Article removed from saved items';
        } else {
            Auth::user()->savedNews()->attach([$id]);
            $saved = true;
            $message = 'Article saved!';
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'saved' => $saved,
                'message' => $message
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function unsave($id)
    {
        try {
            $news = News::findOrFail($id);
            Auth::user()->savedNews()->detach([$id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Article deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error:' . $e->getMessage()
            ], 500);
        }
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:3|max:5000'
        ]);
        
        Comment::create([
            'user_id' => Auth::id(),
            'news_id' => $id,
            'content' => $request->content
        ]);
        
        return back()->with('success', 'Comment added!');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index');
    }
}