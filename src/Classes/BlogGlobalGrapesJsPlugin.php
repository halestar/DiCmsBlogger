<?php

namespace halestar\DiCmsBlogger\Classes;

use halestar\DiCmsBlogger\Models\Blog;
use halestar\LaravelDropInCms\Classes\GrapesJsEditableItem;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Plugins\DiCmsGrapesJsPlugin;

class BlogGlobalGrapesJsPlugin extends DiCmsGrapesJsPlugin
{

    public string $name = 'dicmsGlobalBlog';
	/**
	 * @inheritDoc
	 */
	public function getPluginName(): string
	{
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function shouldInclude(GrapesJsEditableItem $objEditing): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigView(GrapesJsEditableItem $objEditing): string
	{
        $searchPage = Blog::searchPage();
        if( $searchPage)
            $url = DiCMS::dicmsPublicRoute() . "/" . $searchPage->url;
        else
            $url = "#";
        return view('dicms-blog::editor.global-config', ['url' => $url, 'plugin' => $this])->render();
	}
}
