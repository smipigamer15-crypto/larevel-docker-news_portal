<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Models\NewsView;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class NewsController extends Controller
{

 public function category($category)
    {
    $news = News::where('category', $category)
        ->latest()
        ->get();

    return view('news.category', compact(
        'news',
        'category'
    ));
    }
   

    public function index()
    {
        $news = News::all();
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

    News::create([
        'title' => $request->title,
        'content' => $request->content,
        'image' => $path,
        'category' => $request->category,
    ]);

    return redirect()->route('news.create');
    }

   

  public function show(News $news)
{
    
    $news->increment('views');
 
    if (Auth::check()) {
        DB::table('news_views')->updateOrInsert(
            [
                'user_id' => Auth::id(),
                'news_id' => $news->id
            ],
            [
                'viewed_at' => now()
            ]
        );
    }
    
    $isSaved = false;
    if (Auth::check()) {
        $isSaved = Auth::user()->savedNews()->where('news_id', $news->id)->exists();
    }

    $latestNews = News::latest()
        ->where('id', '!=', $news->id)
        ->take(4)
        ->get();


    $comments = $news->comments()->with('user')->latest()->get();

    return view('news.show', compact('news', 'latestNews', 'isSaved', 'comments'));
    
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

    if ($request->hasFile('image')) {

       
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

       
        $data['image'] = $request->file('image')
            ->store('news', 'public');
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

    // comment
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

    // destroy
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index');
    }
}
