<?php

namespace halestar\DiCmsBlogger\Models;

use halestar\LaravelDropInCms\Interfaces\ContainsCssSheets;
use halestar\LaravelDropInCms\Interfaces\ContainsJsScripts;
use halestar\LaravelDropInCms\Models\CssSheet;
use halestar\LaravelDropInCms\Models\Footer;
use halestar\LaravelDropInCms\Models\Header;
use halestar\LaravelDropInCms\Models\JsScript;
use Illuminate\Support\Collection;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class CustomFiles extends Synth implements ContainsCssSheets, ContainsJsScripts
{
    public const CSS_KEY = "blogs.css_sheets";
    public const JS_KEY = "blogs.js_scripts";
    public const HEADER_KEY = "blogs.header";
    public const FOOTER_KEY = "blogs.footer";
    public Collection $cssFiles;
    public Collection $jsScripts;

    public static $key = 'blogger_custom_files';

    public function __construct()
    {
        $settings = config('dicms.settings_class');
        $cssFileIds = $settings::get(CustomFiles::CSS_KEY, []);
        $this->cssFiles = new Collection();
        foreach ($cssFileIds as $cssFileId)
            $this->cssFiles->push(CssSheet::find($cssFileId));
        $jsScriptIds = $settings::get(CustomFiles::JS_KEY, []);
        $this->jsScripts = new Collection();
        foreach ($jsScriptIds as $jsScriptId)
            $this->jsScripts->push(JsScript::find($jsScriptId));
    }

    public function getCssSheets(): Collection
	{
        return $this->cssFiles;
	}

	public function addCssSheet(CssSheet $cssSheet)
	{
        $this->cssFiles->push($cssSheet);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::CSS_KEY, $this->cssFiles->pluck('id')->toArray());
	}

	public function removeCssSheet(CssSheet $cssSheet)
	{
        $idx = $this->cssFiles->search(function (CssSheet $item) use ($cssSheet)
        {
            return $cssSheet->id == $item->id;
        });
        $this->cssFiles->splice($idx, 1);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::CSS_KEY, $this->cssFiles->pluck('id')->toArray());
	}

	public function setCssSheetOrder(CssSheet $cssSheet, int $order)
	{
        $idx = $this->cssFiles->search(function (CssSheet $item) use ($cssSheet)
        {
            return $cssSheet->id == $item->id;
        });
        $this->cssFiles->splice($idx, 1);
        $this->cssFiles->splice($order, 0, [$cssSheet]);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::CSS_KEY, $this->cssFiles->pluck('id')->toArray());
	}

    public function getJsScripts(): Collection
    {
        return $this->jsScripts;
    }

    public function addJsScript(JsScript $script)
    {
        $this->jsScripts->push($script);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::JS_KEY, $this->jsScripts->pluck('id')->toArray());
    }

    public function removeJsScript(JsScript $script)
    {
        $idx = $this->jsScripts->search(function (JsScript $item) use ($script)
        {
            return $script->id == $item->id;
        });
        $this->jsScripts->splice($idx, 1);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::JS_KEY, $this->jsScripts->pluck('id')->toArray());
    }

    public function setJsScriptOrder(JsScript $script, int $order)
    {
        $idx = $this->jsScripts->search(function (JsScript $item) use ($script)
        {
            return $script->id == $item->id;
        });
        $this->jsScripts->splice($idx, 1);
        $this->jsScripts->splice($order, 0, [$script]);
        $settings = config('dicms.settings_class');
        $settings::set(CustomFiles::JS_KEY, $this->jsScripts->pluck('id')->toArray());
    }


    static function match($target)
    {
        return $target instanceof CustomFiles;
    }

    public function dehydrate($target)
    {
        return [[], []];
    }

    public function hydrate($value)
    {
        return new CustomFiles();
    }

    public function getHeader(): ?Header
    {
        $settings = config('dicms.settings_class');
        $headerId = $settings::get(CustomFiles::HEADER_KEY, null);
        if(!$headerId)
            return null;
        return Header::find($headerId);
    }

    public function setHeader(Header $header = null)
    {
        $settings = config('dicms.settings_class');
        if(!$header)
            $settings::set(CustomFiles::HEADER_KEY, null);
        else
            $settings::set(CustomFiles::HEADER_KEY, $header->id);
    }

    public function getFooter(): ?Footer
    {
        $settings = config('dicms.settings_class');
        $footerId = $settings::get(CustomFiles::FOOTER_KEY, null);
        if(!$footerId)
            return null;
        return Footer::find($footerId);
    }

    public function setFooter(Footer $footer = null)
    {
        $settings = config('dicms.settings_class');
        if(!$footer)
            $settings::set(CustomFiles::FOOTER_KEY, null);
        else
            $settings::set(CustomFiles::FOOTER_KEY, $footer->id);
    }
}
