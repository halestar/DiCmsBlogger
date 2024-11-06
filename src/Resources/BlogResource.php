<?php

namespace halestar\DiCmsBlogger\Resources;

use halestar\LaravelDropInCms\Resources\PageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'indexPage' => new PageResource($this->indexPage),
            'postPage' => new PageResource($this->postPage),
            'archivePage' => new PageResource($this->archivePage),
            'blogPosts' => BlogPostResource::collection($this->blogPosts),
            'auto_archive' => $this->auto_archive,
            'archive_after' => $this->archive_after,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
