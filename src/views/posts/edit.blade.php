@extends("dicms::layouts.admin.index", ['template' => $template])
@push('head_scripts')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endpush
@section('index_content')
    <div class="row border-end border-start border-bottom rounded-bottom p-1 collapse advanced_options" id="advanced_options">
        <form method="POST" action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.posts.update', ['post' => $post->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-check form-switch mb-3">
                <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    id="published"
                    name="published"
                    value="1"
                    @if($post->published) checked @endif
                >
                <label class="form-check-label" for="published">{{ __('dicms-blog::blogger.post.publish') }}</label>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('dicms-blog::blogger.post.title') }}</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    aria-describedby="titleHelp"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ $post->title }}"
                />
                <x-error-display key="title">{{ $errors->first('title') }}</x-error-display>
                <div id="titleHelp" class="form-text">{{ __('dicms-blog::blogger.post.title.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">{{ __('dicms-blog::blogger.post.subtitle') }}</label>
                <input
                    type="text"
                    name="subtitle"
                    id="subtitle"
                    aria-describedby="subtitleHelp"
                    class="form-control"
                    value="{{ $post->subtitle }}"
                />
                <div id="subtitleHelp" class="form-text">{{ __('dicms-blog::blogger.post.subtitle.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">{{ __('dicms-blog::blogger.post.slug') }}</label>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    aria-describedby="slugHelp"
                    class="form-control @error('slug') is-invalid @enderror"
                    value="{{ $post->slug }}"
                    onkeyup="cleanSlug()"
                    onchange="cleanSlug()"
                />
                <x-error-display key="slug">{{ $errors->first('slug') }}</x-error-display>
                <div id="slugHelp" class="form-text">{{ __('dicms-blog::blogger.post.slug.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="posted_by" class="form-label">{{ __('dicms-blog::blogger.post.by') }}</label>
                <input
                    type="text"
                    name="posted_by"
                    id="posted_by"
                    aria-describedby="posted_byHelp"
                    class="form-control @error('posted_by') is-invalid @enderror"
                    value="{{ $post->posted_by }}"
                />
                <x-error-display key="posted_by">{{ $errors->first('posted_by') }}</x-error-display>
                <div id="posted_byHelp" class="form-text">{{ __('dicms-blog::blogger.post.by.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">{{ __('dicms-blog::blogger.post.image') }}</label>
                <input
                    type="url"
                    name="image"
                    id="image"
                    aria-describedby="imageHelp"
                    class="form-control"
                    value="{{ $post->image }}"
                />
                <div id="imageHelp" class="form-text">{{ __('dicms-blog::blogger.post.image.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('dicms-blog::blogger.post.description') }}</label>
                <textarea
                    type="url"
                    name="description"
                    id="description"
                    aria-describedby="descriptionHelp"
                    class="form-control"
                >{{ $post->description }}</textarea>
                <div id="descriptionHelp" class="form-text">{{ __('dicms-blog::blogger.post.description.help') }}</div>
            </div>

            <div class="row justify-content-center mb-3">
                <div class="col col-auto">
                    <h5 class="alert-heading">{{ __('dicms-blog::blogger.post.url') }}</h5>
                    <div class="row">
                        <div class="col col-auto text-end pe-0 me-0">
                            <div
                                class="bg-dark-subtle ps-2 rounded-start border-bottom border-start border-top border-dark py-2 h3 fw-bold">{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() }}
                                /
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms::pages.front_url') }}</div>
                        </div>
                        <div class="col col-auto text-center px-0 mx-0" id="path_display_container">
                            <div class="bg-secondary-subtle border-bottom border-top border-secondary py-2 h3 fw-bold"
                                 id="path_display">blog/
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.post.url.path') }}</div>
                        </div>
                        <div class="col col-auto text-start ps-0 ms-0" id="slug_display_container">
                            <div
                                class="bg-primary-subtle rounded-end border-bottom border-top border-end border-primary pe-2 py-2 h3 fw-bold"
                                id="slug_display">{{ $post->slug }}
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.post.slug') }}</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row py-2">
                <button type="submit" class="btn btn-primary col">{{ __('dicms::headers.settings.advanced.update') }}</button>
            </div>
        </form>
    </div>
    <div class="row mt-0 justify-content-center">
        <div class="col col-auto border-end border-bottom border-start rounded-bottom p-2">
            <a href="#" data-bs-toggle="collapse" data-bs-target=".advanced_options">
                <i class="fa-solid fa-angles-down advanced_options collapse show" ></i>
                <i class="fa-solid fa-angles-up advanced_options collapse" ></i>
                {{ __('dicms::pages.settings.advanced') }}
            </a>
        </div>
    </div>
    <livewire:dicms-blogger.text-editor :post="$post" />

@endsection
@push('scripts')
    <script>
        function cleanSlug(event)
        {
            $('#slug').val($('#slug').val().replace(/[^a-zA-Z0-9_-]/g, '-').toLowerCase());
            let slug = $('#slug').val();
            if(slug) {
                $('#slug_display_container').removeClass('d-none');
                $('#slug_display').html(slug);
            }
            else
            {
                $('#slug_display_container').addClass('d-none');
                $('#slug_display').html('&nbsp;');
            }
        }

        function insertImage(url)
        {
            window.editor.execute('insertImage', { source: url });
        }
    </script>
@endpush
