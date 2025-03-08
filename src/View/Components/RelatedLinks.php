<?php

namespace halestar\DiCmsBlogger\View\Components;

use Closure;
use halestar\DiCmsBlogger\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RelatedLinks extends Component
{
    public BlogPost $post;
    /**
     * Create a new component instance.
     */
    public function __construct(BlogPost $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dicms-blog::components.related-links');
    }
}
