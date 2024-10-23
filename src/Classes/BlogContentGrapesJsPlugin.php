<?php

namespace halestar\DiCmsBlogger\Classes;

use halestar\LaravelDropInCms\Classes\GrapesJsEditableItem;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Plugins\DiCmsGrapesJsPlugin;

class BlogContentGrapesJsPlugin extends DiCmsGrapesJsPlugin
{
    public string $name = 'dicmsBlogContent';

    public function getPluginName(): string
    {
        return $this->name;
    }

    public function shouldInclude(GrapesJsEditableItem $objEditing): bool
    {
        return ($objEditing instanceof Page && $objEditing->plugin_page &&
            $objEditing->plugin == 'halestar\DiCmsBlogger\DiCmsBlogger');
    }

    public function getConfigView(GrapesJsEditableItem $objEditing): string
    {
        return view('dicms-blog::editor.post-config', ['page' => $objEditing, 'plugin' => $this])->render();
    }
}
