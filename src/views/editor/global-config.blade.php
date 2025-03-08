<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;


        /*****************************
         * Add models for the components here
         **/
        Components.addType('search-input',
            {
                isComponent(el)
                {
                    return el.tagName === "input" && el.type === "text";
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'input',
                                draggable: true,
                                droppable: false,
                                removable: false,
                                badgable: true,
                                stylable: true,
                                highlightable: true,
                                copyable: false,
                                resizable: true,
                                editable: true,
                                layerable: true,
                                selectable: true,
                                name: '{{ __('dicms-blog::blogger.search.input') }}',
                                traits:
                                [
                                    'placeholder',
                                ],
                                attributes:
                                    {
                                        type: 'text',
                                        name: 'search_term',
                                        id: 'search_term',
                                    }
                            },
                    },
            });

        Components.addType('search-button',
            {
                isComponent(el)
                {
                    return el.tagName === "button" && el.type === "submit";
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'button',
                                draggable: true,
                                droppable: true,
                                removable: false,
                                badgable: true,
                                stylable: true,
                                highlightable: true,
                                copyable: false,
                                resizable: true,
                                editable: true,
                                layerable: true,
                                selectable: true,
                                name: '{{ __('dicms-blog::blogger.search.button') }}',
                                attributes:
                                    {
                                        type: 'submit',
                                    }
                            },
                    },
                view:
                    {
                        onRender({el})
                        {
                            $(el).css('min-width', '50px').css('min-height', '36px')
                        }
                    }
            });

        Components.addType('search-bar',
            {
                isComponent(el)
                {
                    return el.tagName === "form" && el.action === '{{ $url }}'
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'form',
                                draggable: true,
                                droppable: true,
                                removable: true,
                                badgable: true,
                                stylable: true,
                                highlightable: true,
                                copyable: false,
                                resizable: false,
                                editable: true,
                                layerable: true,
                                selectable: true,
                                components:
                                    [
                                        {
                                            type: 'search-input',
                                        },
                                        {
                                            type: 'search-button',
                                        },
                                    ],
                                attributes:
                                    {
                                        action: '{{ $url }}',
                                        method: 'get',
                                    }
                            },
                    },
                view:
                    {
                        tagName: 'div',
                        onRender({el})
                        {
                            $(el).css('padding', '1em').css('width', '100%')
                        }
                    }
            });

        Components.addType('all-tags',
            {
                extend: 'blade-variable',
                isComponent(el)
                {
                    return el.tagName === "tags"
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'tags',
                                stylable: false,
                                content: '<tags class="tag-view">' +
                                    '<a href="#" class="tag">tag1</a>' +
                                    '<a href="#" class="tag">tag2</a>' +
                                    '<a href="#" class="tag">tag3</a>' +
                                    '</tags>',
                            },
                        toHTML: function()
                        {
                            @verbatim
                                return "<x-dicms-blogger.tag-view />";
                            @endverbatim
                        },
                    },
                view:
                    {
                        tagName: 'div',
                        onRender({el})
                        {
                            $(el).css('padding', '1em').css('width', '100%')
                        }
                    }

            });

        Blocks.add('SearchBar',
            {
                select: true,
                category: "{{ __('dicms-blog::blogger.blog') }}",
                label: "{{ __('dicms-blog::blogger.search.bar') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>`,
                content:
                    {
                        type: "search-bar",
                    },
            });

        Blocks.add('AllTags',
            {
                select: true,
                category: "{{ __('dicms-blog::blogger.blog') }}",
                label: "{{ __('dicms-blog::blogger.tag.all') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5L0 80C0 53.5 21.5 32 48 32l149.5 0c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>`,
                content:
                    {
                        type: "all-tags",
                    },
            });
    };
</script>
