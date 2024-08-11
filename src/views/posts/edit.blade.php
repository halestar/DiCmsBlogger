@extends('dicms::layouts.admin', ['include_text_editor' => ['editor' => '#editor']])

@section('content')
    <div class="container">
        <div class="border-bottom display-4 text-primary mb-5">{{ __('dicms-blog::blogger.blog.update') }}</div>
        <form action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.update', ['post' => $post->id]) }}" method="POST" onsubmit="saveData()">
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
                <div id="titleHelp" class="form-text">{{ __('dicms-blog::blogger.post.by.help') }}</div>
            </div>

            <div id="editor-container">
                <div class="row row-cols">
                    <button type="button" onclick="makeBig()" class="btn btn-primary" id="fs-btn">{{ __('dicms-blog::blogger.editor.fullscreen') }}</button>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <label for="body" class="form-label">{{ __('dicms-blog::blogger.post.content') }}</label>
                        <div id="editor">{!! $post->body !!}</div>
                        <div id="titleHelp" class="form-text">{{ __('dicms-blog::blogger.post.content.help') }}</div>
                        <input type="hidden" name="body" id="body" />
                    </div>
                    <div class="col">
                        <livewire:asset-manager :mini="true" selectAction="insertImage" />
                    </div>
                </div>
            </div>

            <div class="row">
                <button class="btn btn-primary col-md m-1" type="submit">Update Post</button>
                <button
                    class="btn btn-danger col-md m-1"
                    type="button"
                    onclick="confirmDelete('{{ __('dicms-blog::blogger.post.delete.confirm') }}', '{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.destroy', ['post' => $post->id]) }}')"
                >{{ __('dicms-blog::blogger.post.delete') }}</button>
                <a class="btn btn-secondary col-md m-1" role="button" href="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blog.posts.store') }}">{{ __('common.cancel') }}</a>
            </div>
        </form>
    </div>
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

        function saveData()
        {
            $('#body').val(editor.getData());
        }

        function insertImage(url)
        {
            editor.execute('insertImage', { source: url });
        }

        function makeBig()
        {
            $('#editor-container').addClass('position-fixed top-0 start-0 w-100 h-100 bg-white');
            $('.ck-editor__editable_inline').css('height', '80vh');
            $('.asset-manager-mini').css('height', '80vh');
            $('#fs-btn').html('{{ __('dicms-blog::blogger.editor.fullscreen.exit') }}');
            $('#fs-btn').attr('onclick', 'makeSmall()');

        }

        function makeSmall()
        {
            $('#editor-container').removeClass('position-fixed top-0 start-0 w-100 h-100 bg-white');
            $('.ck-editor__editable_inline').css('height', '');
            $('.asset-manager-mini').css('height', '');
            $('#fs-btn').html('{{ __('dicms-blog::blogger.editor.fullscreen') }}');
            $('#fs-btn').attr('onclick', 'makeBig()');
        }

    </script>
@endpush
