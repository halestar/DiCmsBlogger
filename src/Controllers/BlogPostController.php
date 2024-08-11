<?php

namespace halestar\DiCmsBlogger\Controllers;
use halestar\DiCmsBlogger\Models\BlogPost;
use halestar\DiCmsBlogger\Models\CssFiles;
use halestar\DiCmsBlogger\Models\CustomFiles;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Models\Footer;
use halestar\LaravelDropInCms\Models\Header;
use halestar\LaravelDropInCms\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BlogPostController
{
    private function errors(): array
    {
        return
            [
                'name' => __('dicms::errors.sheets.name'),
            ];
    }

    public function index()
    {
        Gate::authorize('viewAny', BlogPost::class);
        return view('dicms-blog::posts.index');
    }


    public function create()
    {
        Gate::authorize('create', BlogPost::class);
        return view('dicms-blog::posts.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', BlogPost::class);
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'slug' => 'required',
            'posted_by' => 'required',
            'body' => 'nullable',
        ]);
        $post = new BlogPost();
        $post->fill($data);
        $post->save();
        return redirect(DiCMS::dicmsRoute('admin.blog.posts.index'));
    }

    public function edit(Request $request, BlogPost $post)
    {
        Gate::authorize('update', BlogPost::class);
        return view('dicms-blog::posts.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        Gate::authorize('update', BlogPost::class);
        $data = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'slug' => 'required',
            'posted_by' => 'required',
            'body' => 'nullable',
            'published' => 'nullable|boolean',
        ]);
        $post->fill($data);
        if(isset($data['published']) && $data['published'] && !$post->published)
            $post->published = date('Y-m-d H:i:s');
        $post->save();
        return redirect(DiCMS::dicmsRoute('admin.blog.posts.index'));
    }

    public function destroy(BlogPost $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();
        return redirect(DiCMS::dicmsRoute('admin.blog.posts.index'));
    }

    public function settings()
    {
        Gate::authorize('settings', BlogPost::class);
        $settings = config('dicms.settings_class');
        $customFiles = new CustomFiles();
        $defaultSite = Site::defaultSite();
        return view('dicms-blog::settings', compact('settings', 'customFiles', 'defaultSite'));
    }

    public function updateSettings(Request $request)
    {
        Gate::authorize('settings', BlogPost::class);
        $settings = config('dicms.settings_class');
        $settings::set('blogs.posts_container', $request->input('posts_container', ''));
        $settings::set('blogs.posts_ul', $request->input('posts_ul', ''));
        $settings::set('blogs.posts_li', $request->input('posts_li', ''));
        $settings::set('blogs.posts_link', $request->input('posts_link', ''));
        $settings::set('blogs.post_article', $request->input('post_article', ''));
        $settings::set('blogs.post_head', $request->input('post_head', ''));
        $settings::set('blogs.post_title', $request->input('post_title', ''));
        $settings::set('blogs.post_subtitle', $request->input('post_subtitle', ''));
        $settings::set('blogs.post_by', $request->input('post_by', ''));
        $settings::set('blogs.post_body', $request->input('post_body', ''));
        return redirect(DiCMS::dicmsRoute('admin.blog.posts.index'));
    }

    public function updateContent(Request $request)
    {
        $customFiles = new CustomFiles();

        $header_id = $request->input('header_id', null);
        if($header_id)
        {
            $header = Header::find($header_id);
            if($header)
                $customFiles->setHeader($header);
            else
                $customFiles->setHeader(null);
        }
        else
            $customFiles->setHeader(null);

        $footer_id = $request->input('footer_id', null);
        if($footer_id)
        {
            $footer = Footer::find($footer_id);
            if($footer)
                $customFiles->setFooter($footer);
            else
                $customFiles->setFooter(null);
        }
        else
            $customFiles->setFooter(null);

        return redirect()->back();
    }

}
