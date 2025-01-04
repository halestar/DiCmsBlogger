<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\DiCmsBlogger\DiCmsBlogger;
use halestar\DiCmsBlogger\Models\Scopes\OrderRevChronoScope;
use halestar\LaravelDropInCms\Classes\MetadataEntry;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Traits\BackUpable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[ScopedBy([OrderRevChronoScope::class])]
class BlogPost extends Model
{

    use BackUpable;

    protected static function getTablesToBackup(): array { return [ config('dicms.table_prefix') . "blog_posts" ]; }
    protected $fillable = ['title', 'subtitle', 'slug', 'posted_by', 'body', 'description', 'image', 'social_media'];
    public function casts()
    {
        return
            [
                'social_media' => 'array',
                'published' => 'datetime: m/d/Y h:i A',
                'created_at' => 'datetime: m/d/Y h:i A',
                'updated_at' => 'datetime: m/d/Y h:i A',
            ];
    }

    public function __construct(array $attributes = [])
    {
        $this->table = config('dicms.table_prefix') . "blog_posts";
        parent::__construct($attributes);
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published')->orderBy('created_at', 'desc');
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    protected function byLine(): Attribute
    {
        return Attribute::make(
            get: fn () => __('dicms-blog::blogger.front.post.byline',
                [
                    'name' => $this->posted_by,
                    'date' => ($this->published? $this->published->format(config('dicms.datetime_format')): "TBD"),
                ])
        );
    }

    protected function lead(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->description?? Str::of($this->body)->stripTags()->words(25, '...')
        );
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => DiCMS::dicmsPublicRoute() . "/" . DiCmsBlogger::getRoutePrefix() . "/" .
                $this->blog->slug . "/" . $this->slug
        );
    }

    protected function nextLink(): Attribute
    {
        return Attribute::make
        (
            get: function ()
            {
                $nextPost = BlogPost::where('blog_id', $this->blog_id)->where('published', '>', $this->published)
                    ->orderBy('published', 'asc')->first();
                if($nextPost)
                    return $nextPost->url;
                return "";
            }
        );
    }

    protected function prevLink(): Attribute
    {
        return Attribute::make
        (
            get: function ()
            {
                $prevPost = BlogPost::where('blog_id', $this->blog_id)->where('published', '<', $this->published)
                    ->orderBy('published', 'desc')->first();
                if($prevPost)
                    return $prevPost->url;
                return "";
            }
        );
    }

    protected function fullTitle(): Attribute
    {
        return Attribute::make
        (
            get: fn() => $this->title . ($this->subtitle? ": " . $this->subtitle: "")
        );
    }

    public function getMetadata(): array
    {
        $metadata = [];
        $metadata[] = new MetadataEntry('author', $this->posted_by?? '');
        $metadata[] = new MetadataEntry('description', $this->description?? $this->blog->description?? '');
        $metadata[] = new MetadataEntry('title', $this->fullTitle?? '');
        $metadata[] = new MetadataEntry('twitter:card', "summary_large_image");
        $metadata[] = new MetadataEntry('twitter:title', $this->fullTitle?? '');
        $metadata[] = new MetadataEntry('twitter:description', $this->description?? '');
        $metadata[] = new MetadataEntry('twitter:image', $this->image?? '');
        $metadata[] = new MetadataEntry('og:type', "article");
        $metadata[] = new MetadataEntry('og:title', $this->fullTitle?? '');
        $metadata[] = new MetadataEntry('og:description', $this->description?? '');
        $metadata[] = new MetadataEntry('og:image', $this->image?? '');
        $metadata[] = new MetadataEntry('og:url', $this->url?? '');

        return $metadata;
    }

    public static function highlighted(): Collection
    {
        return BlogPost::whereNotNull('highlighted')->orderBy('highlighted')->get();
    }
}
