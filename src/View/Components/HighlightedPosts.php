<?php

namespace halestar\DiCmsBlogger\View\Components;

use Closure;
use halestar\DiCmsBlogger\Classes\SocialMedia;
use halestar\DiCmsBlogger\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class HighlightedPosts extends Component
{

    public Collection $posts;

    public function __construct()
    {
        $this->posts = BlogPost::highlighted();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dicms-blog::components.highlighted-posts');
    }
}
