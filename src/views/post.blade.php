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
            {{ $post->created_at->format('m/d/y h:i A') }}
        </span>
    </div>
    <div {!! $settings::get('blogs.post_body', '') !!}>
        {!! $post->body !!}
    </div>
</article>
