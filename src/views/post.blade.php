<article {!! $settings::get('blogs.post_article', '') !!}>
    <div {!! $settings::get('blogs.post_head', '') !!}>
        <h1 {!! $settings::get('blogs.post_title', '') !!}>{!! $post->title !!}</h1>
        @if($post->subtitle)
            <h2 {!! $settings::get('blogs.post_subtitle', '') !!}>{!! $post->subtitle !!}</h2>
        @endif
        <span {!! $settings::get('blogs.post_by', '') !!}>
            {{ __('dicms-blog::blogger.front.posts.by') }}
            {!! $post->posted_by !!}
            {{ __('dicms-blog::blogger.front.posts.on') }}
            {{ $post->published->format(config('dicms.datetime_format')) }}.
            @if($post->updated_at > $post->published)
                {{ __('dicms-blog::blogger.front.updated') }} {{ $post->updated_at->format(config('dicms.datetime_format')) }}
            @endif

        </span>
    </div>
    <div {!! $settings::get('blogs.post_body', '') !!}>
        {!! $post->body !!}
    </div>
</article>
