<?php

namespace halestar\LaravelDropInCms\Tests\Feature;

use halestar\DiCmsBlogger\Models\Blog;
use halestar\LaravelDropInCms\DiCMS;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BloggerViewRoutesTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic test example.
     */
    public function test_blogs_index(): void
    {
        $response = $this->get(DiCMS::dicmsRoute('admin.blogs.index'));

        $response->assertStatus(200);
    }

    public function test_blogs_create(): void
    {
        $response = $this->get(DiCMS::dicmsRoute('admin.blogs.create'));

        $response->assertStatus(200);
    }

    public function test_blogs_show(): void
    {
        $blog = Blog::first();
        $response = $this->get(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog]));

        $response->assertStatus(200);
    }

    public function test_blogs_edit(): void
    {
        $blog = Blog::first();
        $response = $this->get(DiCMS::dicmsRoute('admin.blogs.edit', ['blog' => $blog]));

        $response->assertStatus(200);
    }

    public function test_posts_create(): void
    {
        $blog = Blog::first();
        $response = $this->get(DiCMS::dicmsRoute('admin.blogs.posts.create', ['blog' => $blog->id]));

        $response->assertStatus(200);
    }

    public function test_posts_edit(): void
    {
        $blog = Blog::first();
        $blogPost = $blog->blogPosts()->first();
        $response = $this->get(DiCMS::dicmsRoute('admin.posts.edit', ['post' => $blogPost]));

        $response->assertStatus(200);
    }



}
