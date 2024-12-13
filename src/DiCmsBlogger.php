<?php

namespace halestar\DiCmsBlogger;

use halestar\DiCmsBlogger\Classes\BlogArchiveGrapesJsPlugin;
use halestar\DiCmsBlogger\Classes\BlogContentGrapesJsPlugin;
use halestar\DiCmsBlogger\Classes\BlogIndexGrapesJsPlugin;
use halestar\DiCmsBlogger\Controllers\API\BlogApiController;
use halestar\DiCmsBlogger\Controllers\API\BlogPostApiController;
use halestar\DiCmsBlogger\Controllers\BlogController;
use halestar\DiCmsBlogger\Controllers\BlogPostController;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Plugins\DiCmsPlugin;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class DiCmsBlogger implements DiCmsPlugin
{

	/**
	 * @inheritDoc
	 */
	public static function adminRoutes(): void
	{
        Route::put('/blogs/posts/{post}/content', [BlogPostController::class, 'updatePostContent'])
            ->name('blogs.posts.update.content');


        //create pages
        Route::controller(BlogController::class)
            ->prefix('blogs/{blog}/pages')
            ->name('blogs.pages.')
            ->group(function ()
            {
                Route::get('/index/create', 'createIndexPage')->name('index.create');
                Route::get('/posts/create', 'createPostPage')->name('posts.create');
                Route::get('/archive/create', 'createArchivePage')->name('archive.create');
            });

        Route::resource('blogs', BlogController::class);
        Route::resource('blogs.posts', BlogPostController::class)
            ->shallow()
            ->except(['show', 'index']);
	}

    /**
     * @inheritDoc
     */
    public static function getAdminUrl(): string
    {
        return DiCMS::dicmsRoute('admin.blogs.index');
    }

    /**
     * @inheritDoc
     */
    public static function getPluginMenuName(): string
    {
        return __('dicms-blog::blogger.blog');
    }

    /**
     * @inheritDoc
     */
    public static function getPolicyModel(): string
    {
        return Blog::class;
    }

    /**
     * @inheritDoc
     */
    public static function getRoutePrefix(): string
    {
        return "blogs";
    }

	/**
	 * @inheritDoc
	 */
	public static function getPublicPages(): array
	{
        $pages = [];
        foreach(Blog::all() as $blog)
        {
            if($blog->indexPage)
                $pages[] = $blog->indexPage;
            if($blog->archivePage)
            $pages[] = $blog->archivePage;
        }
		return $pages;

	}

	/**
	 * @inheritDoc
	 */
	public static function getBackUpableTables(): array
	{
		return [ Blog::class, BlogPost::class ];
	}

    public static function getGrapesJsPlugins(): array
    {
        return
            [
                new BlogContentGrapesJsPlugin(),
                new BlogIndexGrapesJsPlugin() ,
                new BlogArchiveGrapesJsPlugin(),
            ];
    }

    public static function projectCss(Page $page): string
    {
        //no matter the type of page, we leave the CSS untouched.
        return $page->css;
    }

    public static function projectHtml(Page $page): string
    {
        //we will need the page slug.
        //which page is this?
        if(Str::of($page->name)->endsWith('Index'))
        {
            //based on the slug, load the blog.
            $slug = basename($page->url);
            $blog = Blog::where('slug', $slug)->first();
            //we have the index, so it's the easy option.
            if($blog)
                return Blade::render($page->html, ['posts' => $blog->unArchivedBlogPosts(), 'page' => $page]);
            //since we did not find a blog, we abort
            abort(404);
        }
        elseif(Str::of($page->name)->endsWith('Archive'))
        {
            //based on the slug, load the blog.
            $slug = Request::segment(count(Request::segments()) - 1);
            $blog = Blog::where('slug', $slug)->first();
            if($blog)
                return Blade::render($page->html, ['archivedPosts' => $blog->archivedBlogPosts(), 'page' => $page]);
            //since we did not find a blog, we abort
            abort(404);
        }
        else
        {
            $slug = basename(url()->current());
            //if we get a default "post-slug", then make up a random post
            if($slug == "post-slug")
            {
                $blogSlug = Request::segment(count(Request::segments()) - 1);
                $blog = Blog::where('slug', $blogSlug)->first();
                if($blog)
                {
                    $blogPost = $blog->blogPosts()->published()->inRandomOrder()->first();
                    if($blogPost)
                        return Blade::render($page->html, ['post' => $blogPost, 'page' => $page]);
                }
                $blogPost = BlogPost::published()->inRandomOrder()->first();
                if($blogPost)
                    return Blade::render($page->html, ['post' => $blogPost, 'page' => $page]);
                abort(404);
            }
            //in this case, it's a blog
            $blogPost = BlogPost::published()->where('slug', $slug)->first();
            if($blogPost)
                return Blade::render($page->html, ['post' => $blogPost, 'page' => $page]);
            abort(404);
        }
    }

    public static function hasPublicRoute(?string $path): ?Page
    {
        $matches = [];
        $search = '/' . DiCmsBlogger::getRoutePrefix() . '\/([a-zA-Z0-9_-]+)\/([a-zA-Z0-9_-]+)$/';
        if(preg_match($search, $path, $matches))
        {
            //search for a blog
            $blog = Blog::where('slug', $matches[1])->first();
            if($blog)
                return $blog->postPage;
            //if not, try to match a post
            $blogPost = BlogPost::where('slug', $matches[2])->first();
            if($blogPost)
                return $blogPost->blog->postPage;
        }
        return null;
    }

    public static function apiRoutes(): void
    {
        Route::prefix(DiCmsBlogger::getRoutePrefix())
            ->name(DiCmsBlogger::getRoutePrefix() . ".")
            ->group(function()
            {
                Route::apiResource('blogs', BlogApiController::class);
                Route::apiResource('blogs.posts', BlogPostApiController::class)->shallow();
            });
    }

    public static function widgets(): array
    {
        return [];
    }
}
