@extends("dicms::layouts.admin.index", ['template' => $template])

@section('index_content')
    <div class="alert alert-warning">
        {{ __('dicms-blog::blogger.metadata.warning') }}
    </div>
    <livewire:metadata-editor :container="$obj" />
@endsection
