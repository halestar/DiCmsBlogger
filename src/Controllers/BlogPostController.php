<?php

namespace halestar\DiCmsBlogger\Controllers;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Models\CssFiles;
use halestar\LaravelDropInCms\DiCMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class BlogPostController
{
    private function errors(): array
    {
        return
            [
                'title' => __('dicms-blog::blogger.errors.blog.title'),
                'slug' => __('dicms-blog::blogger.errors.blog.slug'),
                'posted_by' => __('dicms-blog::blogger.errors.blog.posted_by'),
            ];
    }

    public function create(Blog $blog)
    {
        Gate::authorize('create', BlogPost::class);
        $template =
            [
                'title' => __('dicms-blog::blogger.blog.new'),
                'suppress_site_name' => true,
                'buttons' =>
                    [
                        'back' =>
                            [
                                'link' => DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]),
                                'text' => '<i class="fa-solid fa-rotate-left"></i>',
                                'classes' => 'text-secondary',
                                'title' => __('dicms::admin.back'),
                            ]
                    ]
            ];
        return view('dicms-blog::posts.create', compact('template', 'blog'));
    }

    public function store(Request $request, Blog $blog)
    {
        Gate::authorize('create', BlogPost::class);
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'slug' => 'required|max:255|unique:' . config('dicms.table_prefix') . 'blog_posts,slug',
            'posted_by' => 'required',
        ], $this->errors());
        $post = new BlogPost();
        $post->fill($data);
        $blog->blogPosts()->save($post);
        return redirect(DiCMS::dicmsRoute('admin.posts.edit', ['post' => $post->id]))
            ->with('success-status', __('dicms-blog::blogger.posts.success.created'));
    }

    public function edit(BlogPost $post)
    {
        Gate::authorize('update', BlogPost::class);
        $template =
            [
                'title' => __('dicms-blog::blogger.blog.update'),
                'suppress_site_name' => true,
                'asset_action' => "insertImage",
                'buttons' =>
                    [
                        'back' =>
                            [
                                'link' => DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $post->blog_id]),
                                'text' => '<i class="fa-solid fa-rotate-left"></i>',
                                'classes' => 'text-secondary',
                                'title' => __('dicms::admin.back'),
                            ]
                    ]
            ];
        return view('dicms-blog::posts.edit', compact('post', 'template'));
    }

    public function update(Request $request, BlogPost $post)
    {
        Gate::authorize('update', $post);
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'slug' => ['required', 'max:255', Rule::unique(config('dicms.table_prefix') . 'blog_posts')->ignore($post)],
            'posted_by' => 'required',
            'published' => 'nullable|boolean',
        ], $this->errors());
        $post->fill($data);
        if(isset($data['published']) && $data['published'] && !$post->published)
            $post->published = date('Y-m-d H:i:s');
        elseif(!isset($data['published']) || !$data['published'])
            $post->published = null;
        $post->save();
        return redirect(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $post->blog_id]))
            ->with('success-status', __('dicms-blog::blogger.posts.success.updated'));
    }

    public function updatePostContent(Request $request, BlogPost $post)
    {
        Gate::authorize('update', BlogPost::class);
        $post->body = $request->input('body', null);
        $post->update();
        return redirect()->back()
            ->with('success-status', __('dicms-blog::blogger.posts.success.updated'));
    }

    public function destroy(BlogPost $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $post->blog_id]))
            ->with('success-status', __('dicms-blog::blogger.posts.success.deleted'));
    }

}
