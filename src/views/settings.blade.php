@extends('dicms::layouts.admin')

@section('content')
    <div class="container">
        <div class="border-bottom display-4 text-primary mb-5">{{ __('dicms-blog::blogger.settings.blog') }}</div>

            <div class="row">
                <div class="col">
                    @livewire('css-sheet-manager', ['container' => $customFiles, 'siteId' => $defaultSite->id])
                    @livewire('js-script-manager', ['container' => $customFiles, 'siteId' => $defaultSite->id])
                    <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.settings.content') }}" method="POST">
                        @csrf
                        <div class="input-group mt-5" aria-describedby="headerHelp">
                            <label for="header_id"
                                   class="input-group-text">{{ __('dicms::sites.default_header') }}</label>
                            <select name="header_id" id="header_id" class="form-select">
                                <option value="">{{ __('dicms::sites.select_default_header') }}</option>
                                @foreach(\halestar\LaravelDropInCms\Models\Header::where('site_id', $defaultSite->id)->get() as $header)
                                    <option value="{{ $header->id }}"
                                            @if($customFiles->getHeader() && $header->id == $customFiles->getHeader()->id) selected @endif>{{ $header->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-outline-primary">{{ __('dicms::admin.update') }}</button>
                            @can('viewAny', \halestar\LaravelDropInCms\Models\Header::class)
                                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.sites.headers.index', ['site' => $defaultSite->id]) }}"
                                   class="btn btn-outline-secondary">{{ __('dicms::admin.manage_headers') }}</a>
                            @endcan
                        </div>
                        <div id="headerHelp"
                             class="form-text mb-3">{{ __('dicms::sites.select_default_header_help') }}</div>

                        <div class="input-group" aria-describedby="footerHelp">
                            <label for="footer_id" class="input-group-text">{{ __('dicms::sites.default_footer') }}</label>
                            <select name="footer_id" id="footer_id" class="form-select">
                                <option value="">{{ __('dicms::sites.select_default_footer') }}</option>
                                @foreach(\halestar\LaravelDropInCms\Models\Footer::where('site_id', $defaultSite->id)->get() as $footer)
                                    <option value="{{ $footer->id }}"
                                            @if($customFiles->getFooter() && $footer->id == $customFiles->getFooter()->id) selected @endif>{{ $footer->name }}</option>
                                @endforeach
                            </select>
                            @can('viewAny', \halestar\LaravelDropInCms\Models\Footer::class)
                                <button type="submit" class="btn btn-outline-primary">{{ __('dicms::admin.update') }}</button>
                                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.sites.footers.index', ['site' => $defaultSite->id]) }}"
                                   class="btn btn-outline-secondary">{{ __('dicms::admin.manage_footers') }}</a>
                            @endcan
                        </div>
                        <div id="footerHelp"
                             class="form-text mb-3">{{ __('dicms::sites.select_default_footer_help') }}</div>
                    </form>
                </div>

                <div class="col">
                    <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.settings.update') }}" method="POST" id="update_form">
                        @csrf

                        <div class="mb-3">
                            <label for="posts_container" class="form-label">{{ __('dicms-blog::blogger.settings.posts.container') }}</label>
                            <input
                                type="text"
                                name="posts_container"
                                id="posts_container"
                                aria-describedby="posts_containerHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.posts_container', '') }}"
                            />
                            <div id="posts_containerHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.container.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="posts_ul" class="form-label">{{ __('dicms-blog::blogger.settings.posts.ul') }}</label>
                            <input
                                type="text"
                                name="posts_ul"
                                id="posts_ul"
                                aria-describedby="posts_ulHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.posts_ul', '') }}"
                            />
                            <div id="posts_ulHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.ul.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="posts_li" class="form-label">{{ __('dicms-blog::blogger.settings.posts.li') }}</label>
                            <input
                                type="text"
                                name="posts_li"
                                id="posts_li"
                                aria-describedby="posts_liHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.posts_li', '') }}"
                            />
                            <div id="posts_liHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.li.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="posts_link" class="form-label">{{ __('dicms-blog::blogger.settings.posts.link') }}</label>
                            <input
                                type="text"
                                name="posts_link"
                                id="posts_link"
                                aria-describedby="posts_linkHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.posts_link', '') }}"
                            />
                            <div id="posts_linkHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.link.help') }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="post_article" class="form-label">{{ __('dicms-blog::blogger.settings.post.article') }}</label>
                            <input
                                type="text"
                                name="post_article"
                                id="post_article"
                                aria-describedby="post_articleHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_article', '') }}"
                            />
                            <div id="post_articleHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.article.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_head" class="form-label">{{ __('dicms-blog::blogger.settings.post.head') }}</label>
                            <input
                                type="text"
                                name="post_head"
                                id="post_head"
                                aria-describedby="post_headHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_head', '') }}"
                            />
                            <div id="post_headHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.head.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_title" class="form-label">{{ __('dicms-blog::blogger.settings.post.title') }}</label>
                            <input
                                type="text"
                                name="post_title"
                                id="post_title"
                                aria-describedby="post_titleHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_title', '') }}"
                            />
                            <div id="post_titleHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.title.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_subtitle" class="form-label">{{ __('dicms-blog::blogger.settings.post.subtitle') }}</label>
                            <input
                                type="text"
                                name="post_subtitle"
                                id="post_subtitle"
                                aria-describedby="post_subtitleHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_subtitle', '') }}"
                            />
                            <div id="post_subtitleHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.subtitle.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_by" class="form-label">{{ __('dicms-blog::blogger.settings.post.by') }}</label>
                            <input
                                type="text"
                                name="post_by"
                                id="post_by"
                                aria-describedby="post_byHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_by', '') }}"
                            />
                            <div id="post_byHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.by.help') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="post_body" class="form-label">{{ __('dicms-blog::blogger.settings.post.body') }}</label>
                            <input
                                type="text"
                                name="post_body"
                                id="post_body"
                                aria-describedby="post_bodyHelp"
                                class="form-control"
                                value="{{ $settings::get('blogs.post_body', '') }}"
                            />
                            <div id="post_bodyHelp" class="form-text">{{ __('dicms-blog::blogger.settings.post.body.help') }}</div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <button type="button" onclick="$('#update_form').submit()" class="btn btn-primary mx-2 col">{{ __('dicms-blog::blogger.settings.update') }}</button>
                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.index') }}" class="btn btn-secondary mx-2 col">{{ __('dicms-blog::blogger.cancel') }}</a>
            </div>
    </div>
@endsection
