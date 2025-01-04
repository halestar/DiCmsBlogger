<div  {{ $attributes }}>
    @if(in_array('facebook', $socialMedia))
    <a href="http://www.facebook.com/sharer.php?u={{ $url }}" class="share-btn facebook" target="_new">
        {!! $facebookSvg !!} Facebook
    </a>
    @endif
    @if(in_array('reddit', $socialMedia))
    <a href="https://reddit.com/submit?url={{ $url }}&title={{ $title }}" class="share-btn reddit" target="_new">
        {!! $redditSvg !!} Reddit
    </a>
    @endif
    @if(in_array('linkedIn', $socialMedia))
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}" class="share-btn linkedin" target="_new">
        {!! $linkedinSvg !!} LinkedIn
    </a>
    @endif
    @if(in_array('bluesky', $socialMedia))
    <a href="https://bsky.app/intent/compose?text={{ $url }}" class="share-btn bluesky" target="_new">
        {!! $blueskySvg !!} BlueSky
    </a>
    @endif
</div>
