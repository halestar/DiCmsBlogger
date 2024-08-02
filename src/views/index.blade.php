<div {!! $settings::get('blogs.posts_container', '') !!}>
    <ul {!! $settings::get('blogs.posts_ul', '') !!}>
        @foreach(\halestar\DiCmsBlogger\Models\BlogPost::published()->get() as $post)
            <!-- Post preview-->
            <li {!! $settings::get('blogs.posts_li', '') !!}>
                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/blog/" . $post->slug }}" {!! $settings::get('blogs.posts_link', '') !!}>
                    <h2>{!! $post->title !!}</h2>
                    @if($post->subtitle)
                    <h3>{!! $post->subtitle !!}</h3>
                    @endif
                </a>
                <span {!! $settings::get('blogs.posts_by', '') !!}>
                    {{ __('dicms-blog::blogger.front.posts.by') }}
                    {!! $post->posted_by !!}
                    {{ __('dicms-blog::blogger.front.posts.on') }}
                    {{ $post->created_at->format('m/d/y h:i A') }}
                </span>
            </li>
      @endforeach
    </ul>
</div>
