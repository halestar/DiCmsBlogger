<div>
    <h3 class="border-bottom br-3">{{ trans_choice('dicms-blog::blogger.tag',2) }}</h3>
    <div class="input-group">
        <label for="tag" class="input-group-text">{{ __('dicms-blog::blogger.tag.add') }}</label>
        <input
            type="text"
            id="tag"
            class="form-control"
            wire:model="tagName"
            wire:keydown.enter.prevent="addTag()"
        />
        <button type="button" class="btn btn-primary" wire:click="addTag()">{{ __('dicms::admin.add') }}</button>
    </div>
    <div class="mt-3 flex flex-wrap">
        @foreach ($tags as $tag)
            <span class="badge bg-primary text-white mr-1 mb-1">
                {{ $tag->name }}
                <a href="#" class="ms-1 ps-1 border-start text-center" wire:click.prevent="removeTag({{ $tag->id }})"><i class="text-danger fa fa-times"></i></a>
            </span>
        @endforeach
    </div>
</div>
