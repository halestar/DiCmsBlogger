<?php

namespace halestar\DiCmsBlogger\View\Components;

use Closure;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\Tag;
use halestar\LaravelDropInCms\DiCMS;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TagView extends Component
{
    public Collection $tags;
    public string $urlBase;
    /**
     * Create a new component instance.
     */
    public function __construct(Collection $tags = null)
    {
        if($tags)
            $this->tags = $tags;
        else
            $this->tags = Tag::all();
        $searchPage = Blog::searchPage();
        if($searchPage)
            $this->urlBase = DiCMS::dicmsPublicRoute() . "/" . $searchPage->url;
        else
            $this->urlBase = '#';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dicms-blog::components.tag-view');
    }
}
