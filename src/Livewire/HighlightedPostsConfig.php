<?php

namespace halestar\DiCmsBlogger\Livewire;

use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\BlogPost;
use Illuminate\Support\Collection;
use Livewire\Component;

class HighlightedPostsConfig extends Component
{
    public Blog $selectedBlog;
    public int $blogId;
    public Collection $blogs;
    public Collection $posts;
    public int $postId;

    public Collection $highlightedPosts;
    public function mount()
    {
        $this->blogs = Blog::all();
        $this->selectedBlog = $this->blogs->first();
        $this->blogId = $this->selectedBlog->id;
        $this->posts = $this->selectedBlog->blogPosts;
        $this->postId = $this->posts->first()->id;
        $this->highlightedPosts = BlogPost::highlighted();
    }

    public function updateBlog()
    {
        $this->selectedBlog = Blog::find($this->blogId);
        $this->posts = $this->selectedBlog->blogPosts;
        $this->postId = $this->posts->first()->id;
    }

    public function highlightPost()
    {
        $post = BlogPost::find($this->postId);
        if($post)
        {
            $post->highlighted = BlogPost::highlighted()->count();
            $post->save();
        }
        $this->highlightedPosts = BlogPost::highlighted();
    }

    public function unHighlightPost(BlogPost $post)
    {
        $post->highlighted = null;
        $post->save();
        $this->highlightedPosts = BlogPost::highlighted();
    }

    public function updateOrder($posts)
    {
        foreach ($posts as $post)
        {
            $blogPost = BlogPost::find($post['value']);
            if($blogPost)
            {
                $blogPost->highlighted = $post['order'];
                $blogPost->save();
            }
        }
        $this->highlightedPosts = BlogPost::highlighted();
    }
    public function render()
    {
        return view('dicms-blog::livewire.highlighted-posts-config');
    }
}
