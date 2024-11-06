<?php

namespace halestar\DiCmsBlogger\Classes;

use halestar\LaravelDropInCms\Classes\GrapesJsEditableItem;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Plugins\DiCmsGrapesJsPlugin;
use Illuminate\Support\Str;

class BlogArchiveGrapesJsPlugin extends DiCmsGrapesJsPlugin
{
    public string $name = 'dicmsBlogArchive';

    public function getPluginName(): string
    {
        return $this->name;
    }

    public function shouldInclude(GrapesJsEditableItem $objEditing): bool
    {
        return ($objEditing instanceof Page && $objEditing->plugin_page &&
            $objEditing->plugin == 'halestar\DiCmsBlogger\DiCmsBlogger' &&
            Str::of($objEditing->name)->endsWith('Archive'));
    }

    public function getConfigView(GrapesJsEditableItem $objEditing): string
    {
        return view('dicms-blog::editor.archive-config', ['page' => $objEditing, 'plugin' => $this])->render();
    }
}
