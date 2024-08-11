@extends('dicms::layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <h4 class="card-header bg-primary-subtle d-flex justify-content-between align-items-center">
                <span class="card-title">{{ __('dicms-blog::blogger.blogs') }}</span>
                <div class="settings-controls">
                    <a class="btn btn-primary" href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.create') }}">{{ __('dicms-blog::blogger.blog.new') }}</a>
                    <a class="btn btn-secondary" href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.settings') }}">{{ __('dicms-blog::blogger.settings') }}</a>
                </div>
            </h4>
            <div class="card=body">
                <div class="list-group">
                    @foreach(\halestar\DiCmsBlogger\Models\BlogPost::orderBy('created_at', 'desc')->get() as $post)
                        <a
                            href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.edit', ['post' => $post->id]) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        >
                            <div class="post-name">{{ $post->title }}</div>
                            <div>
                                created: {{ $post->created_at->format(config('dicms.datetime_format')) }}
                                @if($post->published)
                                    <span class="badge bg-primary ms-3">{{ strtolower(__('dicms-blog::blogger.published')) }}</span>
                                @else
                                    <span class="badge bg-danger ms-3">{{ strtolower(__('dicms-blog::blogger.unpublished')) }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
