@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
    @can('create', \halestar\DiCmsBlogger\Models\Blog::class)
    <div class="input-group mb-3">
        <span class="input-group-text fw-bolder">{{ __('dicms-blog::blogger.blog.page.search') }}</span>
        @if($searchPage)
            <a class="input-group-text">
                {{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/" . $searchPage->url }}
            </a>
            <a
                href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.pages.show', ['page' => $searchPage->id]) }}"
                class="btn btn-outline-primary"
                type="button"
                title="Edit Page"
            >
                <i class="fa fa-edit"></i>
            </a>
            <a
                href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.preview.home', ['path' => $searchPage->url]) }}"
                class="btn btn-outline-info me-auto"
                type="button"
                title="Preview Page"
            >
                <i class="fa fa-eye"></i>
            </a>
        @else
            <span class="input-group-text text-bg-danger">{{ __('dicms-blog::blogger.blog.page.no') }}</span>
            <a
                href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.pages.search.create') }}"
                class="input-group-text btn btn-outline-primary"
                type="button"
                title="Create Page"
            >
                <i class="fa fa-plus"></i>
            </a>
        @endif
    </div>
    @endcan
    @if(\halestar\DiCmsBlogger\Models\Blog::count() > 0)
        <div class="ms-1 row">
            <div class="col-2">{{ __('dicms::admin.name') }}</div>
            <div class="col-6">{{ __('dicms::admin.description') }}</div>
            <div class="col-1">{{ __('dicms-blog::blogger.posts.number') }}</div>
        </div>
        <ul class="list-group">
            @foreach(\halestar\DiCmsBlogger\Models\Blog::all() as $blog)
                <li class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-2">{{ $blog->name }}</div>
                        <div class="col-6 text-muted small">{{ $blog->description }}</div>
                        <div class="col-1 text-center">{{ $blog->blogPosts()->count() }}</div>
                        <div class="col-3 text-end">
                            @can('update', $blog)
                                <a
                                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.show', ['blog' => $blog->id]) }}"
                                    role="button"
                                    class="btn btn-primary btn-sm"
                                    title="{{ __('dicms-blog::blogs.view') }}"
                                ><i class="fa-solid fa-eye"></i></a>
                            @endcan
                            @if($blog->blogPosts()->count() == 0)
                            <button
                                type="button"
                                onclick="confirmDelete('{{ __('dicms-blog::blogger.blogs.delete.confirm') }}', '{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.destroy', ['blog' => $blog->id]) }}')"
                                class="btn btn-danger btn-sm"
                                title="{{ __('dicms::admin.delete') }}"
                            ><i class="fa fa-trash"></i></button>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-info">
            {{ __('dicms-blog::blogger.blogs.none') }}
        </div>
    @endif
@endsection
