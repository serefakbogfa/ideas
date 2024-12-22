<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdeaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
            ],
            'comments_count' => $this->comments_count ?? $this->comments->count(),
            'likes_count' => $this->likes_count ?? 0,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
