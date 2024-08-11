<?php

namespace halestar\DiCmsBlogger;

use halestar\DiCmsBlogger\Controllers\BlogPostController;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Models\CustomFiles;
use halestar\LaravelDropInCms\Models\CssSheet;
use halestar\LaravelDropInCms\Models\Footer;
use halestar\LaravelDropInCms\Models\Header;
use halestar\LaravelDropInCms\Models\JsScript;
use halestar\LaravelDropInCms\Plugins\DiCmsPlugin;
use halestar\LaravelDropInCms\Plugins\DiCmsPluginPage;
use Illuminate\Support\Collection;
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
                Route::post('/settings/content', [BlogPostController::class, 'updateContent'])->name('settings.content');
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

    public static function getCssFiles($path): ?Collection
    {
        $settings = config('dicms.settings_class');
        $cssFileIds = $settings::get(CustomFiles::CSS_KEY, []);
        $cssFiles = new Collection();
        foreach ($cssFileIds as $cssFileId)
            $cssFiles->push(CssSheet::find($cssFileId));
        if($cssFiles->count() == 0)
            return null;
        return $cssFiles;
    }

    public static function getJsFiles($path): ?Collection
    {
        $settings = config('dicms.settings_class');
        $jsScriptIds = $settings::get(CustomFiles::JS_KEY, []);
        $jsScripts = new Collection();
        foreach ($jsScriptIds as $jsScriptId)
            $jsScripts->push(JsScript::find($jsScriptId));
        if($jsScripts->count() == 0)
            return null;
        return $jsScripts;
    }

    public static function getHeader($path): ?Header
    {
        $customFiles = new CustomFiles();
        return $customFiles->getHeader();
    }

    public static function getFooter($path): ?Footer
    {
        $customFiles = new CustomFiles();
        return $customFiles->getFooter();
    }
}
