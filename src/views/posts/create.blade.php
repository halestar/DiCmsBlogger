@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
        <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.posts.store', ['blog' => $blog->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">{{ __('dicms-blog::blogger.post.title') }}</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    aria-describedby="titleHelp"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
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
                    value="{{ old('subtitle') }}"
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
                    value="{{ old('slug') }}"
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
                    value="{{ old('posted_by') }}"
                />
                <x-error-display key="posted_by">{{ $errors->first('posted_by') }}</x-error-display>
                <div id="titleHelp" class="form-text">{{ __('dicms-blog::blogger.post.by.help') }}</div>
            </div>

            <div class="row justify-content-center">
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
                        <div class="col col-auto text-start ps-0 ms-0 d-none" id="slug_display_container">
                            <div
                                class="bg-primary-subtle rounded-end border-bottom border-top border-end border-primary pe-2 py-2 h3 fw-bold"
                                id="slug_display">&nbsp;
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.post.slug') }}</div>
                        </div>
                    </div>
                    @error('url')
                    <div class="alert alert-danger">{{ $errors->first('url') }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <button class="btn btn-primary col-md m-1" type="submit">Create Post</button>
            </div>
        </form>
@endsection
@push('scripts')
    <script>
        var editor;
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

    </script>
@endpush

