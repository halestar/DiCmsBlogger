@if($settings::get('blogs.blog_wrapper_tag', null))
<{{ $settings::get('blogs.blog_wrapper_tag', "DIV") }} {!! $settings::get('blogs.blog_wrapper_options', '') !!}>
@endif
    @if($settings::get('blogs.blog_list_tag', null))
        <{{ $settings::get('blogs.blog_list_tag', "DIV") }} {!! $settings::get('blogs.blog_list_options', '') !!}>
    @endif
        @foreach(\halestar\DiCmsBlogger\Models\BlogPost::published()->get() as $post)
            <!-- Post preview-->
            @if($settings::get('blogs.blog_list_item_tag', null))
                <{{ $settings::get('blogs.blog_list_item_tag', "DIV") }} {!! $settings::get('blogs.blog_list_item_options', '') !!}>
            @endif
                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() . "/blog/" . $post->slug }}" {!! $settings::get('blogs.link_options', '') !!}>
                    @if($settings::get('blogs.post_wrapper_tag', null))
                        <{{ $settings::get('blogs.post_wrapper_tag', "DIV") }} {!! $settings::get('blogs.post_wrapper_options', '') !!}>
                    @endif
                        <{{ $settings::get('blogs.post_title_tag', 'H1') }} {!! $settings::get('blogs.post_title_options', null) !!}>
                            {!! $post->title !!}
                        </{{ $settings::get('blogs.post_title_tag', 'H1') }}>

                        @if($post->subtitle)
                            <{{ $settings::get('blogs.post_subtitle_tag', 'H2') }} {!! $settings::get('blogs.post_subtitle_options', '') !!}>
                                {!! $post->subtitle !!}
                            </{{ $settings::get('blogs.post_subtitle_tag', 'H2') }}>
                        @endif
                    @if($settings::get('blogs.post_wrapper_tag', null))
                        </{{ $settings::get('blogs.post_wrapper_tag', "DIV") }}>
                    @endif
                    <{{ $settings::get('blogs.post_byline_tag', 'SPAN') }} {!! $settings::get('blogs.post_byline_options', null) !!}>
                    {{ __('dicms-blog::blogger.front.post.byline', ['name' => $post->posted_by, 'date' => $post->published->format(config('dicms.datetime_format'))]) }}
                    </{{ $settings::get('blogs.post_byline_tag', 'SPAN') }}>

                    <{{ $settings::get('blogs.post_lead_tag', 'DIV') }} {!! $settings::get('blogs.post_lead_options', null) !!}>
                    {{ Str::words(strip_tags($post->body), 100, '...')}}
                    </{{ $settings::get('blogs.post_lead_tag', 'DIV') }}>
                </a>
            @if($settings::get('blogs.blog_list_item_tag', null))
                </{{ $settings::get('blogs.blog_list_item_tag', "DIV") }}>
            @endif
        @endforeach
    @if($settings::get('blogs.blog_list_tag', null))
        </{{ $settings::get('blogs.blog_list_tag', "DIV") }}>
    @endif
@if($settings::get('blogs.blog_wrapper_tag', null))
    </{{ $settings::get('blogs.blog_wrapper_tag', "DIV") }}>
@endif
