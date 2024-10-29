<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\DiCmsBlogger\DiCmsBlogger;
use halestar\DiCmsBlogger\Models\Scopes\OrderRevChronoScope;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Traits\BackUpable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

#[ScopedBy([OrderRevChronoScope::class])]
class BlogPost extends Model
{

    use BackUpable;

    protected static function getTablesToBackup(): array { return [ config('dicms.table_prefix') . "blog_posts" ]; }
    protected $fillable = ['title', 'subtitle', 'slug', 'posted_by', 'body'];
    public function casts()
    {
        return
            [
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
            get: fn () => Str::of($this->body)->stripTags()->words(25, '...')
        );
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => DiCMS::dicmsPublicRoute() . "/" . DiCmsBlogger::getRoutePrefix() . "/" .
                $this->blog->slug . "/" . $this->slug
        );
    }
}
