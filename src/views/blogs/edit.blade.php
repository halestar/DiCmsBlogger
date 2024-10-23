@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
        <form method="POST" action="{{ \halestar\LaravelDropInCms\DiCMS::dicmsRoute('admin.blogs.update', ['blog' => $blog->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('dicms-blog::blogger.blogs.name') }}</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    aria-describedby="nameHelp"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ $blog->name }}"
                />
                <x-error-display key="name">{{ $errors->first('name') }}</x-error-display>
                <div id="nameHelp" class="form-text">{{ __('dicms-blog::blogger.blogs.name.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label ">{{ __('dicms-blog::blogger.blogs.description') }}</label>
                <textarea
                    name="description"
                    id="description"
                    aria-describedby="descriptionHelp"
                    class="form-control"
                >{{ $blog->description }}</textarea>
                <div id="descriptionHelp" class="form-text">{{ __('dicms-blog::blogger.blogs.description.help') }}</div>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">{{ __('dicms-blog::blogger.blogs.slug') }}</label>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    aria-describedby="slugHelp"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ $blog->slug }}"
                    onkeyup="cleanSlug()"
                    onchange="cleanSlug()"
                />
                <x-error-display key="slug">{{ $errors->first('slug') }}</x-error-display>
                <div id="slugHelp" class="form-text">{{ __('dicms-blog::blogger.blogs.slug.help') }}</div>
            </div>

            <div class="row justify-content-center">
                <div class="col col-auto">
                    <h5 class="alert-heading">{{ __('dicms-blog::blogger.blogs.url') }}</h5>
                    <div class="row">
                        <div class="col col-auto text-end pe-0 me-0">
                            <div
                                class="bg-dark-subtle ps-2 rounded-start border-bottom border-start border-top border-dark py-2 h3 fw-bold">{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() }}
                                /
                            </div>
                            <div class="form-text mx-3 text-center">The URL to your front page</div>
                        </div>
                        <div class="col col-auto text-center px-0 mx-0" id="path_display_container">
                            <div class="bg-secondary-subtle border-bottom border-top border-secondary py-2 h3 fw-bold"
                                 id="path_display">{{ \halestar\DiCmsBlogger\DiCmsBlogger::getRoutePrefix() }}/
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.blogs.path') }}</div>
                        </div>
                        <div class="col col-auto text-start ps-0 ms-0" id="slug_display_container">
                            <div
                                class="bg-primary-subtle rounded-end border-bottom border-top border-end border-primary pe-2 py-2 h3 fw-bold"
                                id="slug_display">{{ $blog->slug }}
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.blogs.slug') }}</div>
                        </div>
                    </div>
                    @error('url')
                    <div class="alert alert-danger">{{ $errors->first('url') }}</div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <button type="submit" class="btn btn-primary col m-2">{{ __('dicms::admin.update') }}</button>
            </div>
        </form>
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
    </script>
@endpush
