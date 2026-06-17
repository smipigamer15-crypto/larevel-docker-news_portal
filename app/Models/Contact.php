<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'topic',
        'message',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getTopicLabelAttribute()
    {
         return [
        'general' => 'General question',
        'advertising' => 'Advertising and partnership',
        'cooperation' => 'Cooperation',
        'news_tip' => 'News or advice',
        'bug' => 'Website error',
        'other' => 'Other'
        ][$this->topic] ?? $this->topic;
    }

    public function getStatusLabelAttribute()
    {
        return [
            'new' => 'New',
            'read' => 'Read',
            'replied' => 'Answered'
        ][$this->status] ?? $this->status;
    }
}
