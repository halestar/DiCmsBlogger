<?php

namespace halestar\DiCmsBlogger;

use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Policies\BlogPostPolicy;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Plugins\DiCmsPluginHome;

class DiCmsBloggerHome implements DiCmsPluginHome
{

	/**
	 * @inheritDoc
	 */
	public function getAdminUrl(): string
	{
		return DiCMS::dicmsRoute('admin.blog.posts.index');
	}

	/**
	 * @inheritDoc
	 */
	public function getPluginMenuName(): string
	{
		return __('dicms-blog::blogger.blog');
	}

	/**
	 * @inheritDoc
	 */
	public function getPolicyModel(): string
	{
		return BlogPost::class;
	}

	/**
	 * @inheritDoc
	 */
	public function getRoutePrefix(): string
	{
		return "blog";
	}
}
