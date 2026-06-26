<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'views',
        'category',
        'user_id',
        'likes_count',
        'slug'
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function viewStats()
    {
        return $this->hasMany(NewsView::class);
    }

    public function viewedBy()
    {
        return $this->belongsToMany(User::class, 'news_views')
            ->withPivot('viewed_at')
            ->withTimestamps();
    }

    public function addView($userId = null)
    {
        $sessionKey = 'viewed_news_' . $this->id;
        
        if ($userId) {
            $exists = $this->viewedBy()
                ->where('user_id', $userId)
                ->exists();
            
            if (!$exists) {
                $this->increment('views');
                $this->viewedBy()->attach($userId, ['viewed_at' => now()]);
                return true;
            }
            return false;
        }
        
        if (!session()->has($sessionKey)) {
            $this->increment('views');
            session()->put($sessionKey, true);
            return true;
        }
        
        return false;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function usersWhoLiked()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function getLikesCountAttribute()
    {
        return $this->attributes['likes_count'] ?? $this->usersWhoLiked()->count();
    }
}