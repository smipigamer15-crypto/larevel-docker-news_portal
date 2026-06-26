<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'views' => $this->views,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'comments_count' => $this->comments->count(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}