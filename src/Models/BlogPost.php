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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

#[ScopedBy([OrderRevChronoScope::class])]
class BlogPost extends Model
{

    use BackUpable, Searchable;

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
        $metadata = $this->blog->getMetadata();
        $metadata['author'] = new MetadataEntry('author', $this->posted_by?? '');
        $metadata['description'] = new MetadataEntry('description', $this->description?? $this->blog->description?? '');
        $metadata['title'] = new MetadataEntry('title', $this->fullTitle?? '');
        $metadata['twitter:card'] = new MetadataEntry('twitter:card', "summary_large_image");
        $metadata['twitter:title'] = new MetadataEntry('twitter:title', $this->fullTitle?? '');
        $metadata['twitter:description'] = new MetadataEntry('twitter:description', $this->description?? '');
        $metadata['twitter:image'] = new MetadataEntry('twitter:image', $this->image?? $this->blog->image?? '');
        $metadata['og:type'] = new MetadataEntry('og:type', "article");
        $metadata['og:title'] = new MetadataEntry('og:title', $this->fullTitle?? '');
        $metadata['og:description'] = new MetadataEntry('og:description', $this->description?? '');
        $metadata['og:image'] = new MetadataEntry('og:image', $this->image?? $this->blog->image?? '');
        $metadata['og:url'] = new MetadataEntry('og:url', $this->url?? '');

        return $metadata;
    }

    public static function highlighted(): Collection
    {
        return BlogPost::whereNotNull('highlighted')->orderBy('highlighted')->get();
    }

    public function relatedPosts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class,
            config('dicms.table_prefix') . 'related_posts', 'post_id', 'related_post_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,
            config('dicms.table_prefix') . 'posts_tags', 'post_id', 'tag_id');
    }

    public function shouldBeSearchable(): bool
    {
        return $this->published != null;
    }

    #[SearchUsingFullText(['title','subtitle','description','posted_by','body'])]
    public function toSearchableArray():array
    {
        return
        [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'posted_by' => $this->posted_by,
            'description' => $this->description,
            'body' => $this->body,
        ];
    }
}
