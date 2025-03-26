<div id="livewire-editor">
    <div id="editor-container" class="mb-3 position-relative" wire:ignore>
        <div id="saved-alert" class="alert alert-success position-absolute top-0 end-0 z-3 fw-bolder m-2 d-none">{{ __('dicms-blog::blogger.saved') }}</div>
        <div id="editor">{!! $post->body !!}</div>
    </div>
    <div class="row mt-3">
        <button class="btn btn-primary col mx-1" wire:click="save(window.editor.getData())">Update Post</button>
    </div>
</div>

@assets
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>
<style>
    .ck-editor__editable_inline {
        height: 500px;
    }
    #editor-container
    {
        max-height: 600px;
        height: 600px;
    }
</style>
<script type="module">
    import {
        Alignment,
        AutoImage,
        AutoLink,
        Autosave,
        BlockQuote,
        Bold,
        ButtonView,
        ClassicEditor,
        Code,
        CodeBlock,
        Essentials,
        FindAndReplace,
        Font,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        Image,
        ImageCaption,
        ImageInsert,
        ImageResize,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        MediaEmbed,
        Paragraph,
        Plugin,
        SimpleUploadAdapter,
        SourceEditing,
        SpecialCharacters,
        SpecialCharactersEssentials,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        Underline
    } from 'ckeditor5';

    class FullScreen extends Plugin
    {
        init()
        {
            const editor = this.editor;
            editor.ui.componentFactory.add( 'fullscreen', () =>
            {
                const button = new ButtonView();
                button.set(
                    {
                        label: 'Full Screen',
                        icon: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M200 32L56 32C42.7 32 32 42.7 32 56l0 144c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l40-40 79 79-79 79L73 295c-6.9-6.9-17.2-8.9-26.2-5.2S32 302.3 32 312l0 144c0 13.3 10.7 24 24 24l144 0c9.7 0 18.5-5.8 22.2-14.8s1.7-19.3-5.2-26.2l-40-40 79-79 79 79-40 40c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8l144 0c13.3 0 24-10.7 24-24l0-144c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2l-40 40-79-79 79-79 40 40c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2l0-144c0-13.3-10.7-24-24-24L312 32c-9.7 0-18.5 5.8-22.2 14.8s-1.7 19.3 5.2 26.2l40 40-79 79-79-79 40-40c6.9-6.9 8.9-17.2 5.2-26.2S209.7 32 200 32z"/></svg>',
                        tooltip: true,
                    });
                button.on( 'execute', () =>
                {
                    const el = document.getElementById('livewire-editor');
                    if(document.fullscreenElement)
                    {
                        document.exitFullscreen();
                        $('#editor-container').css('height', '600px');
                        $('.ck-editor__editable_inline').css('height', '500px');
                    }
                    else
                    {
                        el.requestFullscreen();
                        $('#editor-container').css('height', '100%');
                        $('.ck-editor__editable_inline').css('height', '100%');
                    }
                });
                document.addEventListener('fullscreenchange', () =>
                {
                    if(!document.fullscreenElement)
                    {
                        $('#editor-container').css('height', '600px');
                        $('.ck-editor__editable_inline').css('height', '500px');
                    }
                });
                return button;
            });
        }
    }

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            plugins: [
                ClassicEditor,
                Essentials,
                Bold,
                Italic, Strikethrough, Subscript, Superscript, Underline, Code,
                Font,
                Paragraph,
                SourceEditing,
                Indent, IndentBlock,
                GeneralHtmlSupport,
                SimpleUploadAdapter,
                Image,
                ImageCaption,
                ImageResize,
                ImageStyle,
                ImageToolbar,
                ImageUpload,
                LinkImage,
                ImageInsert,
                AutoImage,
                List,
                TextTransformation,
                BlockQuote,
                CodeBlock,
                FindAndReplace,
                Heading, Alignment,
                Highlight, AutoLink, Link, MediaEmbed, SpecialCharacters, SpecialCharactersEssentials,
                Table, TableToolbar, TableColumnResize,
                TableCellProperties, TableProperties,
                FullScreen, Autosave
            ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikethrough', 'code', 'subscript','superscript', '|',
                    'heading', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', 'blockQuote', 'codeBlock',  '|', 'alignment', 'bulletedList', 'numberedList',
                    'outdent', 'indent', 'sourceEditing', '|', 'insertImage', 'findAndReplace', 'link', 'mediaEmbed', 'specialCharacters', 'insertTable',
                    'fullscreen'
                ],
                shouldNotGroupWhenFull: true
            },
            image: {
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'toggleImageCaption',
                    'imageTextAlternative',
                    '|',
                    'imageStyle:wrapText',
                    'imageStyle:breakText',
                    '|',
                    'linkImage'
                ],
                insert: {
                    integrations: [ 'url' ]
                }
            },
            table:
                {
                    contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells',
                        'tableProperties', 'tableCellProperties' ]
                },
            autosave: {
                waitingTime: 60000,
                save( editor )
                {
                    window.autosave(editor.getData());
                }
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ],
                disallow: [
                    {
                        name: 'heading'
                    },
                    {
                        name: 'img',
                        styles: ['width', 'height'],
                    }
                ]
            }
        } )
        .then( newEditor => { window.editor = newEditor; } )
        .catch(  error => { console.error( error ); } );
</script>
@endassets
@script
<script>
    window.autosave = function(data)
    {
        $wire.save(data);
    };

    $wire.on('saved', () =>
    {
        $('#saved-alert').removeClass('d-none');
        setTimeout(() => {
            $('#saved-alert').addClass('d-none');
        }, 3000);
    });
</script>
@endscript
