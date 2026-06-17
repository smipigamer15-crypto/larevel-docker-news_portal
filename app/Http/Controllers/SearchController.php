<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class SearchController extends Controller
{
   public function live(Request $request)
    {
        $query = $request->q;

        $news = News::where('title', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json($news);
    }

    public function index(Request $request)
    {
        $query = $request->q;

        $news = News::where('title', 'like', "%{$query}%")
            ->paginate(20);

        return view('search.index', compact('news', 'query'));
    }
}
