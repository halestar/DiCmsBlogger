<?php

namespace halestar\DiCmsBlogger\Classes;

use halestar\LaravelDropInCms\Classes\GrapesJsEditableItem;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Plugins\DiCmsGrapesJsPlugin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogIndexGrapesJsPlugin extends DiCmsGrapesJsPlugin
{
    public string $name = 'dicmsBlogIndex';

    public function getPluginName(): string
    {
        return $this->name;
    }

    public function shouldInclude(GrapesJsEditableItem $objEditing): bool
    {
        Log::debug("in should include");
        Log::debug("objEditing instance of Page: " . ($objEditing instanceof Page));
        Log::debug("plugin: " . $objEditing->plugin);
        Log::debug("name is " . $objEditing->name);
        return ($objEditing instanceof Page && $objEditing->plugin_page &&
            $objEditing->plugin == 'halestar\DiCmsBlogger\DiCmsBlogger' &&
            Str::of($objEditing->name)->endsWith('Index'));
    }

    public function getConfigView(GrapesJsEditableItem $objEditing): string
    {
        return view('dicms-blog::editor.index-config', ['page' => $objEditing, 'plugin' => $this])->render();
    }
}
