@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
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
