<?php

namespace halestar\DiCmsBlogger\Livewire;

use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Models\Tag;
use Illuminate\Support\Collection;
use Livewire\Component;

class TagEditor extends Component
{
    public BlogPost $post;
    public Collection $tags;
    public string $tagName;

    private function updateTags()
    {
        $this->tags = $this->post->tags;
        $this->tagName = '';
    }
    public function mount(BlogPost $post)
    {
        $this->post = $post;
        $this->updateTags();
    }

    public function addTag()
    {
        //see if the tag exists
        $tag = Tag::where('name', $this->tagName)->first();
        if($tag)
            $this->post->tags()->attach($tag->id);
        else
        {
            //make the tag
            $tag = new Tag();
            $tag->name = $this->tagName;
            $tag->save();
            $this->post->tags()->attach($tag->id);
        }

        $this->updateTags();
    }

    public function removeTag(int $tagId)
    {
        $this->post->tags()->detach($tagId);
        $this->updateTags();
    }

    public function render()
    {
        return view('dicms-blog::livewire.tag-editor');
    }
}
