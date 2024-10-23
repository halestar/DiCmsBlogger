<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;

        Components.addType('article-summary',
            {
                isComponent(el)
                {
                    return el.data === "@@foreach($posts as $post)\n" ||
                        el.data === ("\n" + "@@endforeach")
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'asummary',
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
                            let open = "@@foreach($posts as $post)" + "\n";
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

        Blocks.add('ArticleSummary',
            {
                select: true,
                category: "{{ __('dicms-blog::blogger.blog') }}",
                label: "{{ __('dicms-blog::blogger.post.list') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M168 80c-13.3 0-24 10.7-24 24l0 304c0 8.4-1.4 16.5-4.1 24L440 432c13.3 0 24-10.7 24-24l0-304c0-13.3-10.7-24-24-24L168 80zM72 480c-39.8 0-72-32.2-72-72L0 112C0 98.7 10.7 88 24 88s24 10.7 24 24l0 296c0 13.3 10.7 24 24 24s24-10.7 24-24l0-304c0-39.8 32.2-72 72-72l272 0c39.8 0 72 32.2 72 72l0 304c0 39.8-32.2 72-72 72L72 480zM176 136c0-13.3 10.7-24 24-24l96 0c13.3 0 24 10.7 24 24l0 80c0 13.3-10.7 24-24 24l-96 0c-13.3 0-24-10.7-24-24l0-80zm200-24l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/></svg>`,
                content:
                    {
                        type: "article-summary",
                    },
            });

    };
</script>
