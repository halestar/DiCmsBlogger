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

            <div class="row justify-content-center mb-4">
                <div class="col col-auto">
                    <h5 class="alert-heading">{{ __('dicms-blog::blogger.blogs.url') }}</h5>
                    <div class="row">
                        <div class="col col-auto text-end pe-0 me-0">
                            <div
                                class="bg-dark-subtle ps-2 rounded-start border-bottom border-start border-top border-dark py-2 h3 fw-bold">{{ \halestar\LaravelDropInCms\DiCMS::dicmsPublicRoute() }}
                                /
                            </div>
                            <div class="form-text mx-3 text-center">{{ __('dicms-blog::blogger.blog.url.front') }}</div>
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
                <div class="col-md-6">
                    <h4>{{ __('dicms-blog::blogger.settings') }}</h4>
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input
                                class="form-check-input mt-0"
                                type="checkbox"
                                name="auto_archive"
                                id="auto_archive"
                                @if($blog->auto_archive) checked @endif
                                value="1"
                            />
                        </div>
                        <label for="auto_archive" class="input-group-text">{{ __('dicms-blog::blogger.blogs.archive.auto') }}</label>
                        <input
                            type="number"
                            name="archive_after"
                            id="archive_after"
                            min="1"
                            max="100"
                            class="form-control @error('archive_after') is-invalid @enderror"
                            value="{{ $blog->archive_after }}"
                        />
                        <label for="archive_after" class="input-group-text">{{ trans_choice('dicms-blog::blogger.post', 2) }}</label>
                    </div>
                    <x-error-display key="name">{{ $errors->first('archive_after') }}</x-error-display>

                    <div class="mb-3">
                        <label for="image" class="form-label">{{ __('dicms-blog::blogger.blogs.image') }}</label>
                        <input
                            type="url"
                            name="image"
                            id="image"
                            aria-describedby="imageHelp"
                            class="form-control"
                            value="{{ $blog->image }}"
                        />
                        <div id="imageHelp" class="form-text">{{ __('dicms-blog::blogger.blogs.image.help') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>{{ __('dicms-blog::blogger.social.sharing') }}</h4>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="form-check me-2">
                            <input
                                class="form-check-input mt-2"
                                type="checkbox"
                                value="facebook"
                                id="social_media_facebook"
                                @if(in_array('facebook', $blog->social_media??[])) checked @endif
                                name="social_media[]"
                            />
                            <label class="form-check-label p-2 border rounded" style="background-color: #8b9dc3;" for="social_media_facebook">
                                <i class="fa-brands fa-square-facebook"></i> {{ __('dicms-blog::blogger.social.facebook') }}
                            </label>
                        </div>
                        <div class="form-check me-2">
                            <input
                                class="form-check-input mt-2"
                                type="checkbox"
                                value="reddit"
                                id="social_media_reddit"
                                @if(in_array('reddit', $blog->social_media??[])) checked @endif
                                name="social_media[]"
                            />
                            <label class="form-check-label p-2 border rounded" style="background-color: #ff5700;" for="social_media_reddit">
                                <i class="fa-brands fa-square-reddit"></i> {{ __('dicms-blog::blogger.social.reddit') }}
                            </label>
                        </div>
                        <div class="form-check me-2">
                            <input
                                class="form-check-input mt-2"
                                type="checkbox"
                                value="linkedIn"
                                id="social_media_linkedIn"
                                @if(in_array('linkedIn', $blog->social_media??[])) checked @endif
                                name="social_media[]"
                            />
                            <label class="form-check-label p-2 border rounded" style="background-color: #0077b5;" for="social_media_linkedIn">
                                <i class="fa-brands fa-linkedin"></i> {{ __('dicms-blog::blogger.social.linkedin') }}
                            </label>
                        </div>
                        <div class="form-check me-2">
                            <input
                                class="form-check-input mt-2"
                                type="checkbox"
                                value="bluesky"
                                id="social_media_bluesky"
                                @if(in_array('bluesky', $blog->social_media??[])) checked @endif
                                name="social_media[]"
                            />
                            <label class="form-check-label p-2 border rounded" style="background-color: #25c5df;" for="social_media_bluesky">
                                <i class="fa-brands fa-square-bluesky"></i> {{ __('dicms-blog::blogger.social.bluesky') }}
                            </label>
                        </div>
                    </div>

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
