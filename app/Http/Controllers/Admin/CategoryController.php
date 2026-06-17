<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
{
        $categories = News::select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->get();
        
        return view('admin.categories', compact('categories'));

}
}
