<div>
    <h2 class="highlighted-title">{{ __('dicms-blog::blogger.widgets.highlighted') }}</h2>
    @foreach (['1','2','3'] as $postNum)
        <div class="highlighted-post">
            <a href="#" class="highlighted-post-link">
                <span class="highlighted-post-title">{{ __('dicms-blog::blogger.widgets.highlighted') }} {{ $postNum }}</span>
            </a>
        </div>
    @endforeach
</div>
