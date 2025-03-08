<?php

namespace halestar\DiCmsBlogger\Classes;

use halestar\LaravelDropInCms\Classes\GrapesJsEditableItem;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Plugins\DiCmsGrapesJsPlugin;

class BlogSearchGrapesJsPlugin extends DiCmsGrapesJsPlugin
{
    public string $name = 'dicmsBlogSearch';

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
        return ($objEditing instanceof Page && $objEditing->plugin_page &&
            $objEditing->plugin == 'halestar\DiCmsBlogger\DiCmsBlogger' &&
            $objEditing->name = "BlogSearch");
	}

	/**
	 * @inheritDoc
	 */
	public function getConfigView(GrapesJsEditableItem $objEditing): string
	{
        return view('dicms-blog::editor.search-config', ['page' => $objEditing, 'plugin' => $this])->render();
	}
}
