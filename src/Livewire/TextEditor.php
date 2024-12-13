<?php

namespace halestar\DiCmsBlogger\Livewire;

use halestar\DiCmsBlogger\Models\BlogPost;
use Livewire\Component;

class TextEditor extends Component
{
    public BlogPost $post;

    public function mount(BlogPost $post)
    {
        $this->post = $post;
    }

    public function save(string $body)
    {
        $this->post->body = $body;
        $this->post->save();
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('dicms-blog::livewire.text-editor');
    }
}
