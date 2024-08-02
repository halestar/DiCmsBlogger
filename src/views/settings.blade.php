@extends('dicms::layouts.admin')

@section('content')
    <div class="container">
        <div class="border-bottom display-4 text-primary mb-5">{{ __('dicms-blog::blogger.settings.blog') }}</div>
        <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.settings.update') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
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
                        <label for="posts_by" class="form-label">{{ __('dicms-blog::blogger.settings.posts.by') }}</label>
                        <input
                            type="text"
                            name="posts_by"
                            id="posts_by"
                            aria-describedby="posts_byHelp"
                            class="form-control"
                            value="{{ $settings::get('blogs.posts_by', '') }}"
                        />
                        <div id="posts_byHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.by.help') }}</div>
                    </div>
                </div>

                <div class="col">
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
                </div>
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary mx-2 col">{{ __('dicms-blog::blogger.settings.update') }}</button>
                <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.index') }}" class="btn btn-secondary mx-2 col">{{ __('dicms-blog::blogger.cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
