<?php

namespace halestar\DiCmsBlogger\Controllers;

use App\Http\Controllers\Controller;
use halestar\DiCmsBlogger\Models\Blog;
use halestar\LaravelDropInCms\DiCMS;
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
                'archive_after' => 'Auto-Archive must be a number greater than 0 and less than 100',
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
        //create all pages
        $blog->createIndexPage();
        $blog->createPostsPage();
        $blog->createArchivePage();
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
                'auto_archive' => 'nullable|boolean',
                'archive_after' => 'exclude_unless:auto_archive,1|required|numeric|min:1|max:100',
            ], $this->errors());
        $data['auto_archive'] = $request->input('auto_archive', '0');
        $blog->fill($data);
        $blog->save();
        return redirect(DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]))
            ->with('success-status', __('dicms-blog::blogger.blogs.success.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        Gate::authorize('delete', Blog::class);
        $blog->delete();
        return redirect()->back()
            ->with('success-status', __('dicms-blog::blogger.blogs.success.deleted'));
    }

    public function createIndexPage(Request $request, Blog $blog)
    {
        Gate::authorize('update', $blog);
        if(!$blog->indexPage)
            $blog->createIndexPage();
        return redirect(DiCMS::dicmsRoute('admin.pages.show', ['page' => $blog->indexPage->id]))
            ->with('success-status', __('dicms-blog::blogger.blogs.success.updated'));
    }

    public function createPostPage(Request $request, Blog $blog)
    {
        Gate::authorize('update', $blog);
        if(!$blog->postPage)
            $blog->createPostsPage();
        return redirect(DiCMS::dicmsRoute('admin.pages.show', ['page' => $blog->postPage->id]))
            ->with('success-status', __('dicms-blog::blogger.blogs.success.updated'));
    }

    public  function createArchivePage(Request $request, Blog $blog)
    {
        Gate::authorize('update', $blog);
        if(!$blog->archivePage)
            $blog->createArchivePage();
        return redirect(DiCMS::dicmsRoute('admin.pages.show', ['page' => $blog->archivePage->id]))
            ->with('success-status', __('dicms-blog::blogger.blogs.success.updated'));
    }
}
