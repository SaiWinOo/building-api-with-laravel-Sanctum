<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->created_at->format('d M Y'),
            'time' => $this->created_at->format('h:i'),
            'featured_image' => asset(Storage::url($this->featured_image)),
            'category' => new CategoryResource($this->category),
            'owner' => new UserResource($this->user),
            'comments' => CommentResource::collection($this->comments ),
        ];
    }
}
