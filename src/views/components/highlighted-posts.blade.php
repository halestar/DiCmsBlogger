<div  {{ $attributes }}>
    <h2 class="highlighted-title">{{ __('dicms-blog::blogger.widgets.highlighted') }}</h2>
    @foreach ($posts as $post)
        <div class="highlighted-post">
            <a href="{{ $post->url }}" class="highlighted-post-link">
                <span class="highlighted-post-title">{{ $post->fullTitle }}</span>
            </a>
        </div>
    @endforeach
</div>
