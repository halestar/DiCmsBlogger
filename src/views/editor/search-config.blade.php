<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;


        /*****************************
         * Add models for the components here
         **/

        Components.addType('search-results',
            {
                isComponent(el)
                {
                    return el.data === "@@foreach($searchResults as $post)\n" ||
                        el.data === ("\n" + "@@endforeach")
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'sresults',
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
                            let open = "@@foreach($searchResults as $post)" + "\n";
                            let close = "\n" + "@@endforeach";
                            return open + this.getInnerHTML() + close;
                        },
                    },
                view:
                    {
                        tagName: 'div',
                        onRender({el})
                        {
                            $(el).css('padding', '1em').css('width', '100%');
                        }
                    }
            });

        Blocks.add('SearchResults',
            {
                select: true,
                category: "{{ __('dicms-blog::blogger.blog') }}",
                label: "{{ __('dicms-blog::blogger.search.results') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm64 192c17.7 0 32 14.3 32 32l0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96c0-17.7 14.3-32 32-32zm64-64c0-17.7 14.3-32 32-32s32 14.3 32 32l0 192c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-192zM320 288c17.7 0 32 14.3 32 32l0 32c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-32c0-17.7 14.3-32 32-32z"/></svg>`,
                content:
                    {
                        type: "search-results",
                    },
            });
    };
</script>
