<?php

namespace halestar\DiCmsBlogger\Controllers;

use App\Http\Controllers\Controller;
use halestar\DiCmsBlogger\DiCmsBlogger;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\LaravelDropInCms\DiCMS;
use halestar\LaravelDropInCms\Models\Page;
use halestar\LaravelDropInCms\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{

    private function errors(): array
    {
        return
            [
                'name' => __('dicms-blog::blogger.blogs.name.error'),
                'slug' => __('dicms-blog::blogger.blogs.slug.error'),
            ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Blog::class);
        $template =
            [
                'title' => __('dicms-blog::blogger.blogs.available'),
                'buttons' => []
            ];
        if(Gate::allows('create', Blog::class))
        {
            $template['buttons']['create']  =
                [
                    'link' => DiCMS::dicmsRoute('admin.blogs.create'),
                    'text' => "<i class='fa-solid fa-plus-square'></i>",
                    'classes' => 'text-primary',
                    'title' => __('dicms-blog::blogger.blogs.new'),
                ];
        }
        return view('dicms-blog::blogs.index', compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Blog::class);
        $currentSite = Site::currentSite();
        $template =
            [
                'title' => __('dicms-blog::blogger.blogs.create'),
                'buttons' => []
            ];
        if($currentSite)
        {
            $template['buttons']['back']  =
                [
                    'link' => DiCMS::dicmsRoute('admin.blogs.index'),
                    'text' => '<i class="fa-solid fa-rotate-left"></i>',
                    'classes' => 'text-secondary',
                    'title' => __('dicms::admin.back'),
                ];
        }
        return view('dicms-blog::blogs.create', compact('template'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Blog::class);
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'description' => 'nullable',
                'slug' => 'required|max:255',
            ], $this->errors());
        $blog = new Blog();
        $blog->fill($data);
        //create index page
        $indexPage = new Page();
        $indexPage->plugin_page = true;
        $indexPage->plugin = DiCmsBlogger::class;
        $indexPage->name = $blog->name .  ' Index';
        $indexPage->slug = $blog->slug;
        $indexPage->path = DiCmsBlogger::getRoutePrefix();
        $indexPage->url = DiCmsBlogger::getRoutePrefix() . "/" . $blog->slug;
        $indexPage->save();
        $blog->indexPage()->associate($indexPage);
        //create posts page
        $postsPage = new Page();
        $postsPage->plugin_page = true;
        $postsPage->plugin = DiCmsBlogger::class;
        $postsPage->name = $blog->name . " Posts";
        $postsPage->slug = "post-slug";
        $postsPage->path = DiCmsBlogger::getRoutePrefix() . "/" . $blog->slug;
        $postsPage->url = $postsPage->path . "/" . $postsPage->slug;
        $postsPage->save();
        $blog->postPage()->associate($postsPage);
        $blog->save();

        return redirect(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]))
            ->with('success-status', __('dicms-blog::blogger.blogs.success.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        Gate::authorize('view', Blog::class);
        $template =
            [
                'title' => __('dicms-blog::blogger.blog') . ": " . $blog->name,
                'suppress_site_name' => true,
                'buttons' => []
            ];
        if(Gate::allows('update', $blog))
        {
            $template['buttons']['edit']  =
                [
                    'link' => DiCMS::dicmsRoute('admin.blogs.edit', ['blog' => $blog->id]),
                    'text' => "<i class='fa-solid fa-gear'></i>",
                    'classes' => 'text-primary',
                    'title' => __('dicms::sites.edit_site'),
                ];
        }
        return view('dicms-blog::blogs.show', compact('blog', 'template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        Gate::authorize('update', Blog::class);
        $currentSite = Site::currentSite();
        $template =
            [
                'title' => __('dicms-blog::blogger.blogs.update'),
                'buttons' => []
            ];
        if($currentSite)
        {
            $template['buttons']['back']  =
                [
                    'link' => DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]),
                    'text' => '<i class="fa-solid fa-rotate-left"></i>',
                    'classes' => 'text-secondary',
                    'title' => __('dicms::admin.back'),
                ];
        }
        return view('dicms-blog::blogs.edit', compact('template', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        Gate::authorize('update', $blog);
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'description' => 'nullable',
                'slug' => 'required|max:255',
            ], $this->errors());
        $blog->fill($data);
        $blog->save();
        return redirect(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]))
            ->with('success-status', __('dicms::footers.success.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Gate::authorize('delete', Blog::class);
        $blog->delete();
        return redirect()->back()
            ->with('success-status', __('dicms::footers.success.deleted'));
    }
}
