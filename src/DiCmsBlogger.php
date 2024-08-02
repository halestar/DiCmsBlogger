<?php

namespace halestar\DiCmsBlogger;

use halestar\DiCmsBlogger\Controllers\BlogPostController;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Plugins\DiCmsPlugin;
use halestar\LaravelDropInCms\Plugins\DiCmsPluginPage;
use Illuminate\Support\Facades\Route;

class DiCmsBlogger implements DiCmsPlugin
{

	/**
	 * @inheritDoc
	 */
	public static function adminRoutes(): void
	{
		Route::prefix('blog')
            ->name('blog.')
            ->group(function ()
            {
                Route::get('/settings', [BlogPostController::class, 'settings'])->name('settings');
                Route::post('/settings', [BlogPostController::class, 'updateSettings'])->name('settings.update');
                Route::resource('posts', BlogPostController::class)->except('show');
            });
	}

	/**
	 * @inheritDoc
	 */
	public static function hasPublicRoute($path): bool
	{
		if($path == "blog" || $path == "blog/")
            return true;
        $matches = [];
        if(preg_match("/^blog\/(.+)/", $path, $matches))
            return BlogPost::where('slug', '=', $matches[1])->exists();
        return false;
	}

	/**
	 * @inheritDoc
	 */
	public static function getPublicContent($path): string
	{
        $settings = config('dicms.settings_class');
        if($path == "blog" || $path == "blog/")
            return view('dicms-blog::index', compact('settings'))->render();
        if(preg_match("/^blog\/(.+)/", $path, $matches))
        {
            $post = BlogPost::where('slug', '=', $matches[1])->first();
            return view('dicms-blog::post', compact('post', 'settings'))->render();
        }
        abort(404);
	}

	/**
	 * @inheritDoc
	 */
	public static function getPublicPages(): array
	{
		return
            [
                new DiCmsPluginPage( __('dicms-blog::blogger.blogs'), "blog"),
            ];

	}

	/**
	 * @inheritDoc
	 */
	public static function getEntryPoint(): \halestar\LaravelDropInCms\Plugins\DiCmsPluginHome
	{
		return new DiCmsBloggerHome();
	}

	/**
	 * @inheritDoc
	 */
	public static function getBackUpableTables(): array
	{
		return [ BlogPost::class ];
	}
}
