<div>
    <h5 class="border-bottom mb-3">{{ __('dicms-blog::blogger.widgets.highlighted') }}</h5>
    <ul class="list-group" wire:sortable="updateOrder">
        @forelse($highlightedPosts as $post)
            <li
                class="list-group-item d-flex justify-content-between align-items-center"
                wire:key="{{ $post->id }}"
                wire:sortable.item="{{ $post->id }}"
            >
                <div>
                    <span class="ms-1 me-2" wire:sortable.handle><i class="fa-solid fa-grip-lines-vertical"></i></span>
                    {{ $post->fullTitle }}
                </div>
                <button type="button" class="btn btn-danger" wire:click="unHighlightPost({{ $post->id }})"><i class="fa fa-times"></i></button>
            </li>
        @empty
            <div class="alert alert-info">
                {{ __('dicms-blog::blogger.widgets.highlighted.no') }}
            </div>
        @endforelse
    </ul>
    @if(\halestar\DiCmsBlogger\Models\BlogPost::count() > 0)
    <div class="mt-3 alert alert-secondary">
        <div class="input-group">
            <label for="blog_id"
                   class="input-group-text">{{ __('dicms-blog::blogger.widgets.highlighted.from.blog') }}</label>
            <select id="blog_id" class="form-select" wire:model="blogId" wire:change="updateBlog()">
                @foreach($blogs as $blog)
                    <option value="{{ $blog->id }}">{{ $blog->name }}</option>
                @endforeach
            </select>
            <select id="post_id" class="form-select" wire:model="postId">
                @foreach($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->fullTitle }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-outline-primary" wire:click="highlightPost()">
                {{ __('dicms-blog::blogger.widgets.highlight') }}
            </button>
        </div>
    </div>
    @endif
</div>
