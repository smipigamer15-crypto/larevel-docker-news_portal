<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'views',
        'category',
        'user_id'
    ];

    public function viewStats()
    {
    return $this->hasMany(NewsView::class);
    }

    public function viewedBy()
    {
        return $this->belongsToMany(User::class, 'news_views')->withPivot('viewed_at')
        ->withTimestamps();
    }


     public function addView($userId)
    {
        
        $this->increment('views');
        $this->viewedBy()->syncWithoutDetaching([
            $userId => ['viewed_at' => now()]
        ]);
    }

    public function comments()
    {
    return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
}
