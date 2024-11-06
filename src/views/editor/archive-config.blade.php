<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;

        Components.addType('article-archive',
            {
                isComponent(el)
                {
                    return el.data === "@@foreach($archivedPosts as $post)\n" ||
                        el.data === ("\n" + "@@endforeach")
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'aarchived',
                                draggable: true,
                                droppable: true,
                                removable: true,
                                badgable: true,
                                stylable: false,
                                highlightable: true,
                                copyable: false,
                                resizable: false,
                                editable: false,
                                layerable: true,
                                selectable: true,
                                components:
                                    [
                                        {
                                            type: 'article-link',
                                            components:
                                                [
                                                    { type: 'blade-variable-post-title' },
                                                    { type: 'blade-variable-post-subtitle' },
                                                    { type: 'blade-variable-post-byline' },
                                                    { type: 'blade-variable-post-lead' },
                                                ]
                                        },
                                    ]
                            },
                        toHTML: function()
                        {
                            let open = "@@foreach($archivedPosts as $post)" + "\n";
                            let close = "\n" + "@@endforeach";
                            return open + this.getInnerHTML() + close;
                        },
                    },
                view:
                    {
                        tagName: 'div',
                        onRender({el})
                        {
                            $(el).css('padding', '1em').css('width', '100%').addClass('article-summary');
                        }
                    }
            });

        Blocks.add('ArticleArchive',
            {
                select: true,
                category: "{{ __('dicms-blog::blogger.blog') }}",
                label: "Archive",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M32 32l448 0c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96L0 64C0 46.3 14.3 32 32 32zm0 128l448 0 0 256c0 35.3-28.7 64-64 64L96 480c-35.3 0-64-28.7-64-64l0-256zm128 80c0 8.8 7.2 16 16 16l160 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-160 0c-8.8 0-16 7.2-16 16z"/></svg>`,
                content:
                    {
                        type: "article-archive",
                    },
            });

    };
</script>
