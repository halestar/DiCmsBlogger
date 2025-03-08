<div class="blog-search-container">
    <div class="input-group">
        <input
            type="text"
            placeholder="{{ $placeholder }}"
            class="form-control blog-search-input"
            wire:model="search"
            wire:keydown.enter.prevent="searchBlogs()"
        />
        <button type="button" for="blog-search-input" class="btn btn-primary" wire:click="searchBlogs()"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    @if($modal)
    @teleport('body')
    <div class="modal fade" id="class-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
    @endif
                    <div class="search-results-container">
                        @if ($searchResults->count() > 0)
                            <ul class="search-results">
                                @foreach ($searchResults as $result)
                                    <li class="search-results-item">
                                        <a href="{{ route('blog.show', $result->id) }}" class="search-results-link">
                                            <span class="search-results-title">{{ $result->full_title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="blog-search-no-results">{{ __('dicms-blog::blogger.search.no') }}</div>
                        @endif
                    </div>
    @if($modal)
                </div>
            </div>
        </div>
    </div>
    @endteleport
    @endif




</div>
