<div class="tag-view">
    @foreach($tags as $tag)
        <a href="{{ $urlBase }}?search_tag={{ urlencode($tag->name) }}" class="tag">{{ $tag->name }}</a>
    @endforeach
</div>
