<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Models\Scopes\OrderByNameScope;
use halestar\LaravelDropInCms\Traits\BackUpable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([OrderByNameScope::class])]
class Blog extends Model
{
	use BackUpable;

	protected static function getTablesToBackup(): array { return [ config('dicms.table_prefix') . "blogs" ]; }

	protected $fillable = ['name', 'description', 'slug', 'index_id', 'post_id'];

	public function __construct(array $attributes = [])
	{
		$this->table = config('dicms.table_prefix') . "blogs";
		parent::__construct($attributes);
	}

	public function indexPage(): BelongsTo
	{
		return $this->belongsTo(Page::class, 'index_id', 'id');
	}

	public function postPage(): BelongsTo
	{
		return $this->belongsTo(Page::class, 'post_id', 'id');
	}

	public function blogPosts(): HasMany
	{
		return $this->hasMany(BlogPost::class, 'blog_id', 'id');
	}
}
