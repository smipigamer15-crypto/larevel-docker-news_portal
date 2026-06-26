<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar', 
        'refresh_token',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function viewedNews()
    {
        return $this->belongsToMany(News::class, 'news_views')
                    ->withPivot('viewed_at')
                    ->withTimestamps();
    }
    
    public function savedNews()
    {
        return $this->belongsToMany(News::class, 'saved_news')
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }


    public function likes()
    {
        return $this->belongsToMany(News::class, 'likes')->withTimestamps();
    }


    public function hasLiked($newsId)
    {
        return $this->likes()->where('news_id', $newsId)->exists();
    }

    public function generateTokens()
    {
        $accessToken = $this->createToken('access_token')->plainTextToken;
        $refreshToken = Str::random(60);
        
        $this->refresh_token = $refreshToken;
        $this->save();
        
        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 60 * 15, 
        ];
    }

    public function refreshAccessToken()
    {
        $accessToken = $this->createToken('access_token')->plainTextToken;
        
        return [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => 60 * 15,
        ];
    }
}