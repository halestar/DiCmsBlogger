<div class="related-posts">
    @forelse($post->relatedPosts as $related)
        <a href="{{ $related->url }}" class="related-post-link">
            <span class="related-post-title">{{ $related->full_title }}</span>
        </a>
    @empty
        <span class="no-related-posts">{{ __('dicms-blog::blogger.related.posts.no') }}</span>
    @endforelse
</div>
