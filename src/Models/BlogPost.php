<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\LaravelDropInCms\Traits\BackUpable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
}
