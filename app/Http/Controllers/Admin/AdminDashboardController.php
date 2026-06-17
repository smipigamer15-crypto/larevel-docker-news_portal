<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $postsCount = News::count();
        $viewsCount = News::sum('views');
        $usersCount = User::count();
        $messagesCount = Contact::count();
        $commentsCount = Comment::count();
        
        $users = User::all();
        $latestNews = News::latest()->take(10)->get();
        
        $labels = [];
        $viewsData = [];

        $days = [
    'Mon' => 'Mon',
    'Tue' => 'Tue',
    'Wed' => 'Wed',
    'Thu' => 'Thu',
    'Fri' => 'Fri',
    'Sat' => 'Sat',
    'Sun' => 'Sun'
];

for ($i = 6; $i >= 0; $i--) {
    $date = now()->subDays($i);
    $dateString = $date->toDateString();
    
    $engDay = $date->format('D');
    $labels[] = $days[$engDay];
    
    $viewsData[] = DB::table('news_views')
        ->whereDate('viewed_at', $dateString)
        ->count();
}
        
        return view('admin.dashboard', compact(
            'postsCount',
            'viewsCount', 
            'usersCount',
            'messagesCount',
            'commentsCount',
            'users',
            'latestNews',
            'labels',
            'viewsData'
        ));
    }
}