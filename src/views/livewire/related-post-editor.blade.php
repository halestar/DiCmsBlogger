<div>
    <h3 class="border-bottom br-3">{{ trans_choice('dicms-blog::blogger.related.posts',2) }}</h3>
    <div class="mb-3 input-group">
        <label class="input-group-text" for="related_blogs">{{ __('dicms-blog::blogger.related.posts.add') }}</label>
        <select id="related_blogs" class="form-select" wire:model="blogId" wire:change="setBlog()">
            @foreach(\halestar\DiCmsBlogger\Models\Blog::all() as $blog)
                <option value="{{ $blog->id }}" @selected($blog->id == $blogId)>{{ $blog->name }}</option>
            @endforeach
        </select>
        <select id="related_post" class="form-select" wire:model="postId">
            <option value="">{{ __('dicms-blog::blogger.related.posts.select') }}</option>
            @foreach($postList as $postOption)
                <option value="{{ $postOption->id }}">{{ $postOption->full_title }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary" wire:click="addRelatedPost()">{{ __('dicms::admin.add') }}</button>
    </div>
    @if($relatedPosts->count() > 0)
    <ul class="list-group">
        @foreach($relatedPosts as $relatedPost)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $relatedPost->full_title }}
                <button type="button" class="btn btn-danger btn-sm" wire:click="removeRelatedPost({{ $relatedPost->id }})"><i class="fa fa-times"></i></button>
            </li>
        @endforeach
    </ul>
    @else
    <div class="alert alert-info text-center">{{ __('dicms-blog::blogger.related.posts.no') }}</div>
    @endif
</div>
