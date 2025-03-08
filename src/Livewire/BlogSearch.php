<?php

namespace halestar\DiCmsBlogger\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class BlogSearch extends Component
{
    public string $search = '';
    public string $placeholder;
    public bool $modal;
    public Collection $searchResults;

    public function mount($placeholder = 'Search Blogs', $modal = false)
    {
        $this->placeholder = $placeholder;
        $this->modal = $modal;
        $this->searchResults = new Collection();
    }

    public function searchBlogs()
    {

    }

    public function render()
    {
        return view('dicms-blog::livewire.blog-search');
    }
}
