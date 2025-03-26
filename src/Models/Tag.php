<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Models\Scopes\OrderByNameScope;
use halestar\LaravelDropInCms\Traits\BackUpable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy([OrderByNameScope::class])]
class Tag extends Model
{
	use BackUpable;
    public $timestamps = false;

	protected static function getTablesToBackup(): array
    {
        return
            [
                config('dicms.table_prefix') . "tags",
                config('dicms.table_prefix') . "posts_tags",
            ];
    }

	protected $fillable = ['name'];


	public function __construct(array $attributes = [])
	{
		$this->table = config('dicms.table_prefix') . "tags";
		parent::__construct($attributes);
	}

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class,
            config('dicms.table_prefix') . 'posts_tags', 'tag_id', 'post_id');
    }

    public function url(): string
    {
        $searchPage = Blog::searchPage();
        if($searchPage)
            return DiCMS::dicmsPublicRoute() . "/" . $searchPage->url . "?search_tag=" . urlencode($this->name);
        return '#';
    }
}
