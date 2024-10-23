@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
    <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.settings.update') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-5 me-3">
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="override_css"
                            id="override_css_0"
                            value="0"
                            @if(!$customFiles->includeSiteCss()) checked @endif
                        />
                        <label class="form-check-label" for="override_css_0">{{ __('dicms::pages.css.include') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="override_css"
                            id="override_css_1"
                            value="1"
                            @if($customFiles->includeSiteCss()) checked @endif
                        >
                        <label class="form-check-label" for="override_css_1">{{ __('dicms::pages.css.exclude') }}</label>
                    </div>
                </div>
                @livewire('css-sheet-manager', ['container' => $customFiles, 'siteId' => $activeSite->id])

                <div class="mt-5 mb-3">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="override_js"
                            id="override_js_0"
                            value="0"
                            @if(!$customFiles->includeSiteJs()) checked @endif
                        />
                        <label class="form-check-label" for="override_js_0">{{ __('dicms::pages.js.include') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="override_js"
                            id="override_js_1"
                            value="1"
                            @if($customFiles->includeSiteJs()) checked @endif
                        >
                        <label class="form-check-label" for="override_js_1">{{ __('dicms::pages.js.exclude') }}</label>
                    </div>
                </div>
                @livewire('js-script-manager', ['container' => $customFiles, 'siteId' => $activeSite->id])

                <div class="mb-3 mt-5">
                    <h3 class="border-bottom">{{ __('dicms-blog::blogger.settings.blogs.header') }}</h3>
                    <div class="input-group" aria-describedby="headerHelp">
                        <div class="input-group-text">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="override_header"
                                id="override_header_0"
                                value="0"
                                @if(!$customFiles->getHeader()) checked @endif
                            />
                        </div>
                        <label class="input-group-text" for="override_header_0">{{ __('dicms::pages.headers.use') }}</label>
                    </div>
                    <div class="input-group" aria-describedby="headerHelp">
                        <div class="input-group-text">
                            <input
                                class="form-check-input mt-0"
                                type="radio"
                                name="override_header"
                                id="override_header_1"
                                value="1"
                                @if($customFiles->getHeader()) checked @endif
                            />
                        </div>
                        <label for="override_header_1"
                               class="input-group-text">{{ __('dicms::pages.override.headers') }}</label>
                        <select name="header_id" id="header_id" class="form-select">
                            @foreach($activeSite->headers as $header)
                                <option value="{{ $header->id }}"
                                        @if($customFiles->getHeader() && $header->id == $customFiles->getHeader()->id) selected @endif>{{ $header->name }}</option>
                            @endforeach
                        </select>
                        @can('viewAny', \halestar\LaravelDropInCms\Models\Header::class)
                            <a
                                href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.headers.index') }}"
                                class="btn btn-outline-secondary"
                            ><i class="fa-solid fa-bars-progress"></i></a>
                        @endcan
                    </div>
                    <div id="headerHelp"
                         class="form-text mb-3">{{ __('dicms::sites.select_default_header_help') }}</div>
                </div>

                <div class="mb-3">
                    <h3 class="border-bottom">{{ __('dicms-blog::blogger.settings.blogs.footer') }}</h3>
                    <div class="input-group" aria-describedby="headerHelp">
                        <div class="input-group-text">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="override_footer"
                                id="override_footer_0"
                                value="0"
                                @if(!$customFiles->getFooter()) checked @endif
                            />
                        </div>
                        <label class="input-group-text" for="override_footer_0">{{ __('dicms::pages.footer.use') }}</label>
                    </div>
                    <div class="input-group" aria-describedby="footerHelp">
                        <div class="input-group-text">
                            <input
                                class="form-check-input mt-0"
                                type="radio"
                                name="override_footer"
                                id="override_footer_1"
                                value="1"
                                @if($customFiles->getFooter()) checked @endif
                            />
                        </div>
                        <label for="override_footer_1"
                               class="input-group-text">{{ __('dicms::pages.override.footers') }}</label>
                        <select name="footer_id" id="footer_id" class="form-select">
                            @foreach($activeSite->footers as $footer)
                                <option value="{{ $footer->id }}"
                                        @if($customFiles->getFooter() && $footer->id == $customFiles->getFooter()->id) selected @endif>{{ $footer->name }}</option>
                            @endforeach
                        </select>
                        @can('viewAny', \halestar\LaravelDropInCms\Models\Footer::class)
                            <a href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.footers.index') }}"
                               class="btn btn-outline-secondary"><i class="fa-solid fa-bars-progress"></i></a>
                        @endcan
                    </div>
                    <div id="footerHelp"
                         class="form-text mb-3">{{ __('dicms::sites.select_default_footer_help') }}</div>
                </div>

            </div>
            <div class="col">
                <h3 class="border-bottom">{{ __('dicms-blog::blogger.settings.posts.container') }}</h3>

                <x-tag-selector
                    name="blog_wrapper"
                    :tags="\halestar\DiCmsBlogger\Enums\BlogListWrapperEnum::names()"
                    :has-tag="(bool)$settings::get('blogs.blog_wrapper_tag', null)"
                    :selected-tag="$settings::get('blogs.blog_wrapper_tag', null)"
                    :options="$settings::get('blogs.blog_wrapper_options', null)"
                    :help-msg="__('dicms-blog::blogger.settings.posts.container.help')"
                >
                    <x-tag-selector
                        name="blog_list"
                        :tags="\halestar\DiCmsBlogger\Enums\BlogListEnum::names()"
                        :has-tag="(bool)$settings::get('blogs.blog_list_tag', null)"
                        :selected-tag="$settings::get('blogs.blog_list_tag', null)"
                        :options="$settings::get('blogs.blog_list_options', null)"
                        :help-msg="__('dicms-blog::blogger.settings.posts.ul.help')"
                    >

                        <h4 class="border-bottom mt-2">{{ __('dicms-blog::blogger.settings.structure.preview') }}</h4>
                        <x-tag-selector
                            name="blog_list_item"
                            :tags="\halestar\DiCmsBlogger\Enums\BlogListItemEnum::names()"
                            :has-tag="(bool)$settings::get('blogs.blog_list_item_tag', null)"
                            :selected-tag="$settings::get('blogs.blog_list_item_tag', null)"
                            :options="$settings::get('blogs.blog_list_item_options', null)"
                            :help-msg="__('dicms-blog::blogger.settings.posts.li.help')"
                        >

                            <div class="input-group">
                                <label for="link_options" class="input-group-text">&lt;A</label>
                                <input
                                    type="text"
                                    name="link_options"
                                    id="link_options"
                                    aria-describedby="link_optionsHelp"
                                    class="form-control"
                                    value="{{ $settings::get('blogs.link_options', null) }}"
                                />
                                <label for="link_options" class="input-group-text">&gt;</label>
                            </div>
                            <div id="link_optionsHelp" class="form-text">{{ __('dicms-blog::blogger.settings.posts.container.help') }}</div>
                            <div class="ps-5 mt-2">
                                <x-tag-selector
                                    name="post_wrapper"
                                    :tags="\halestar\DiCmsBlogger\Enums\BlogPostWrapperEnum::names()"
                                    :has-tag="(bool)$settings::get('blogs.post_wrapper_tag', null)"
                                    :selected-tag="$settings::get('blogs.post_wrapper_tag', null)"
                                    :options="$settings::get('blogs.post_wrapper_options', null)"
                                    :help-msg="__('dicms-blog::blogger.settings.posts.wrapper.help')"
                                >

                                    <x-single-line-tag-selector
                                        name="post_title"
                                        :tags="\halestar\DiCmsBlogger\Enums\HeaderTagsEnum::names()"
                                        :selected-tag="$settings::get('blogs.post_title_tag', 'H1')"
                                        :options="$settings::get('blogs.post_title_options', null)"
                                        :help-msg="__('dicms-blog::blogger.settings.posts.title.help')"
                                        :text="strtoupper(__('dicms-blog::blogger.post.title'))"
                                    />

                                    <x-single-line-tag-selector
                                        name="post_subtitle"
                                        :tags="\halestar\DiCmsBlogger\Enums\HeaderTagsEnum::names()"
                                        :selected-tag="$settings::get('blogs.post_subtitle_tag', 'H2')"
                                        :options="$settings::get('blogs.post_subtitle_options', null)"
                                        :help-msg="__('dicms-blog::blogger.settings.posts.subtitle.help')"
                                        :text="strtoupper(__('dicms-blog::blogger.post.subtitle'))"
                                    />

                                </x-tag-selector>

                                <x-single-line-tag-selector
                                    name="post_byline"
                                    :tags="\halestar\DiCmsBlogger\Enums\HeaderTagsEnum::names()"
                                    :selected-tag="$settings::get('blogs.post_byline_tag', 'SPAN')"
                                    :options="$settings::get('blogs.post_byline_options', null)"
                                    :help-msg="__('dicms-blog::blogger.settings.posts.byline.help')"
                                    :text="strtoupper(__('dicms-blog::blogger.front.post.byline'))"
                                    class="mt-2"
                                />

                                <x-single-line-tag-selector
                                    name="post_lead"
                                    :tags="\halestar\DiCmsBlogger\Enums\HeaderTagsEnum::names()"
                                    :selected-tag="$settings::get('blogs.post_lead_tag', 'DIV')"
                                    :options="$settings::get('blogs.post_lead_options', null)"
                                    :help-msg="__('dicms-blog::blogger.settings.posts.lead.help')"
                                    :text="strtoupper(__('dicms-blog::blogger.front.post.lead'))"
                                />

                            </div>
                            <div class="input-group mt-2">
                                <label for="container-tag" class="input-group-text">&lt;/A&gt;</label>
                            </div>
                        </x-tag-selector>
                        <hr />
                    </x-tag-selector>
                </x-tag-selector>
            </div>
        </div>

        <div class="row mt-3">
            <button type="submit" class="btn btn-primary mx-2 col">{{ __('dicms-blog::blogger.settings.update') }}</button>
        </div>
    </form>
@endsection
