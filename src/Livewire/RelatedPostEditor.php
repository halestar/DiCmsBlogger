<?php

namespace halestar\DiCmsBlogger\Livewire;

use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\BlogPost;
use Illuminate\Support\Collection;
use Livewire\Component;

class RelatedPostEditor extends Component
{
    public BlogPost $post;
    public int $blogId;
    public Blog $selectedBlog;
    public int $postId;
    public Collection $relatedPosts;
    public Collection $postList;

    private function updatePostList()
    {
        $this->relatedPosts = $this->post->relatedPosts;

        $postList = $this->selectedBlog->blogPosts();
        if($this->relatedPosts->count() > 0)
            $postList->whereNotIn('id', $this->relatedPosts->pluck('id')->toArray());
        $postList->where('id', '<>', $this->post->id);
        $this->postList = $postList->get();
    }

    public function mount(BlogPost $post)
    {
        $this->post = $post;
        $this->selectedBlog = Blog::first();
        $this->blogId = $this->selectedBlog->id;
        $this->updatePostList();
    }

    public function setBlog()
    {
        $this->selectedBlog = Blog::find($this->blogId);
        $this->updatePostList();
    }

    public function addRelatedPost()
    {
        $this->post->relatedPosts()->attach($this->postId);
        $this->post->save();
        $this->updatePostList();
    }

    public function removeRelatedPost(int $postId)
    {
        $this->post->relatedPosts()->detach($postId);
        $this->post->save();
        $this->updatePostList();
    }
    public function render()
    {
        return view('dicms-blog::livewire.related-post-editor');
    }
}
