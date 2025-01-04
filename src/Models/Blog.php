<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\DiCmsBlogger\DiCmsBlogger;
use halestar\LaravelDropInCms\Classes\MetadataEntry;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Interfaces\ContainsMetadata;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Models\Scopes\OrderByNameScope;
use halestar\LaravelDropInCms\Traits\BackUpable;
use halestar\LaravelDropInCms\Traits\HasMetadata;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[ScopedBy([OrderByNameScope::class])]
class Blog extends Model implements ContainsMetadata
{
	use BackUpable, HasMetadata;

	protected static function getTablesToBackup(): array { return [ config('dicms.table_prefix') . "blogs" ]; }

	protected $fillable = ['name', 'description', 'slug', 'index_id', 'post_id', 'auto_archive', 'archive_after', 'image', 'social_media'];

    public function casts()
    {
        return
            [
                'auto_archive' => 'boolean',
                'social_media' => 'array',
            ];
    }

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

    public function archivePage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'archive_id', 'id');
    }

	public function blogPosts(): HasMany
	{
		return $this->hasMany(BlogPost::class, 'blog_id', 'id');
	}

    public function archivedBlogPosts(): Collection
    {
        $query = $this->blogPosts();
        if($this->auto_archive)
            $query->take(100000)->skip($this->archive_after);
        return $query->get();
    }

    public function unArchivedBlogPosts(): Collection
    {
        $query = $this->blogPosts();
        if($this->auto_archive)
            $query->take($this->archive_after);
        return $query->get();
    }

    public function createIndexPage(): Page
    {
        $indexPage = new Page();
        $indexPage->plugin_page = true;
        $indexPage->plugin = DiCmsBlogger::class;
        $indexPage->name = $this->name .  ' Index';
        $indexPage->slug = $this->slug;
        $indexPage->path = DiCmsBlogger::getRoutePrefix();
        $indexPage->url = DiCmsBlogger::getRoutePrefix() . "/" . $this->slug;
        $indexPage->save();
        $this->indexPage()->associate($indexPage);
        $this->save();
        return $indexPage;
    }

    public function createPostsPage(): Page
    {
        $postsPage = new Page();
        $postsPage->plugin_page = true;
        $postsPage->plugin = DiCmsBlogger::class;
        $postsPage->name = $this->name . " Posts";
        $postsPage->slug = "post-slug";
        $postsPage->path = DiCmsBlogger::getRoutePrefix() . "/" . $this->slug;
        $postsPage->url = $postsPage->path . "/" . $postsPage->slug;
        $postsPage->save();
        $this->postPage()->associate($postsPage);
        $this->save();
        return $postsPage;
    }

    public function createArchivePage(): Page
    {
        $archivePage = new Page();
        $archivePage->plugin_page = true;
        $archivePage->plugin = DiCmsBlogger::class;
        $archivePage->name = $this->name . " Archive";
        $archivePage->slug = "archive";
        $archivePage->path = DiCmsBlogger::getRoutePrefix() . "/" . $this->slug;
        $archivePage->url = $archivePage->path . "/" . $archivePage->slug;
        $archivePage->save();
        $this->archivePage()->associate($archivePage);
        $this->save();
        return $archivePage;
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => DiCMS::dicmsPublicRoute() . "/" . DiCmsBlogger::getRoutePrefix() . "/" .
                $this->slug
        );
    }

    public function getMetadata(): array
    {
        $metadata = $this->metadata;
        if(!$metadata || count($metadata) == 0)
        {
            $metadata = [];
            $metadata[] = new MetadataEntry('author', $this->name?? '');
            $metadata[] = new MetadataEntry('description', $this->description?? '');
            $metadata[] = new MetadataEntry('title', $this->name?? '');
            $metadata[] = new MetadataEntry('twitter:card', "summary_large_image");
            $metadata[] = new MetadataEntry('twitter:title', $this->name?? '');
            $metadata[] = new MetadataEntry('twitter:description', $this->description?? '');
            $metadata[] = new MetadataEntry('twitter:image', $this->image?? '');
            $metadata[] = new MetadataEntry('og:type', "article");
            $metadata[] = new MetadataEntry('og:title', $this->name?? '');
            $metadata[] = new MetadataEntry('og:description', $this->description?? '');
            $metadata[] = new MetadataEntry('og:image', $this->image?? '');
            $metadata[] = new MetadataEntry('og:url', $this->url?? '');
        }
        return $metadata;
    }
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        $this->save();
    }
}
