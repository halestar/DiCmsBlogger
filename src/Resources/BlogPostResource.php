<?php

namespace halestar\DiCmsBlogger\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'id' => $this->id,
            'blog' => new BlogResource($this->blog),
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'slug' => $this->slug,
            'posted_by' => $this->posted_by,
            'body' => $this->body,
            'published' => $this->published,
            'byLine' => $this->byLine,
            'lead' => $this->lead,
            'url' => $this->url,
            'nextLink' => $this->nextLink,
            'prevLink' => $this->prevLink,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
