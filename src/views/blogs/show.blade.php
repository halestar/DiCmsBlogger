@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')

    <div class="row">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text fw-bolder ms-auto">Blog Index Page:</span>
                <a class="input-group-text">
                    {{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/" . $blog->indexPage->url }}
                </a>
                <a
                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.pages.show', ['page' => $blog->index_id]) }}"
                    class="btn btn-outline-primary"
                    type="button"
                >
                    <i class="fa fa-edit"></i>
                </a>
                <a
                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.preview.home', ['path' => $blog->indexPage->url]) }}"
                    class="btn btn-outline-info me-auto"
                    type="button"
                >
                    <i class="fa fa-eye"></i>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <span class="input-group-text fw-bolder ms-auto">Blog Post Page:</span>
                <a class="input-group-text">
                    {{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/" . $blog->postPage->url }}
                </a>
                <a
                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.pages.show', ['page' => $blog->post_id]) }}"
                    class="input-group-text btn btn-outline-primary"
                    type="button"
                >
                    <i class="fa fa-edit"></i>
                </a>
                <a
                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.preview.home', ['path' => $blog->postPage->url]) }}"
                    class="btn btn-outline-info me-auto"
                    type="button"
                >
                    <i class="fa fa-eye"></i>
                </a>
            </div>
        </div>
    </div>

    <h5 class="border-bottom d-flex justify-content-between align-items-end mb-3 mt-5">
        {{ __('dicms-blog::blogger.posts') }}
        <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.posts.create', ['blog' => $blog->id]) }}" class="text-primary mx-2 h1">
            <i class='fa-solid fa-plus-square'></i>
        </a>
    </h5>
    @if(\halestar\DiCmsBlogger\Models\BlogPost::all()->count() > 0)
        <div class="ms-1 row">
            <div class="col-3">{{ __('dicms-blog::blogger.post.title') }}</div>
            <div class="col-3">{{ __('dicms-blog::blogger.post.subtitle') }}</div>
            <div class="col-3">{{ __('dicms-blog::blogger.post.url') }}</div>
            <div class="col-2">{{ __('dicms-blog::blogger.published') }}</div>
        </div>

        <ul class="list-group">
            @foreach($blog->blogPosts as $post)
                <li class="list-group-item list-group-item-action">
                    <div class="row">
                        <div class="col-3">{{ $post->title }}</div>
                        <div class="col-3">{{ $post->subtitle }}</div>
                        <div class="col-3 text-muted small">{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/blog/" . $post->slug }}</div>
                        <div class="col-2">
                            @if($post->published)
                                <span class="badge bg-primary ms-3">{{ $post->published->format(config('dicms.date_format')) }}</span>
                            @else
                                <span class="badge bg-danger ms-3">{{ strtolower(__('dicms-blog::blogger.unpublished')) }}</span>
                            @endif
                        </div>
                        <div class="col-1 text-end">
                            @can('update', $post)
                                <a
                                    href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.posts.edit', ['post' => $post->id]) }}"
                                    role="button"
                                    class="btn btn-primary btn-sm"
                                    title="{{ __('dicms::pages.edit') }}"
                                ><i class="fa-solid fa-edit"></i></a>
                            @endcan
                            @if(!$post->published)

                                <button
                                    type="button"
                                    onclick="confirmDelete('{{ __('dicms-blog::blogger.post.delete.confirm') }}', '{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.posts.destroy', ['post' => $post->id]) }}')"
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
