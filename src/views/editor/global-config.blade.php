<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;


        /*****************************
         * Add models for the components here
         **/
        Components.addType('blade-variable',
            {
                model:
                    {
                        defaults:
                            {
                                tagName: '',
                                name: 'Blade Variable',
                                draggable: true,
                                droppable: false,
                                removable: true,
                                badgable: true,
                                stylable: false,
                                highlightable: true,
                                copyable: true,
                                resizable: false,
                                editable: false,
                                layerable: true,
                                selectable: true,
                            },
                    },
                view:
                    {
                        tagName: 'span',
                        onRender({el})
                        {
                            $(el).css('padding', '1em')
                        }
                    }
            });

        /**
         *  Search
         */
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
                                        value: "@{{$search_term??''}}"
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

        /**
         *  Tags
         */
        Components.addType('blade-variable-tag-name',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                content: '{{ trans_choice('dicms-blog::blogger.tag', 1) }}',
                                name: '{{ trans_choice('dicms-blog::blogger.tag', 1) }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$tag->name}}";
                        },
                    },

            });

        Components.addType('tag-link',
            {
                extend: 'blade-variable',
                isComponent(el)
                {
                    return el.tagName === "A" && el.attributes.type === 'TLINK'
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'a',
                                droppable: true,
                                name: '{{ __('dicms-blog::blogger.tag.link') }}',
                                attributes:
                                    {
                                        href: '@{{$tag->url()}}',
                                        type: 'TLINK',
                                    },
                                traits:
                                    [
                                        'title'
                                    ],
                            }
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
                isComponent(el)
                {
                    return el.data === "@@foreach(halestar\DiCmsBlogger\Models\Tag::all() as $tag)\n" ||
                        el.data === ("\n" + "@@endforeach")
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'atags',
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
                                            type: 'tag-link',
                                            components:
                                                [
                                                    { type: 'blade-variable-tag-name' },
                                                ]
                                        },
                                    ]
                            },
                        toHTML: function()
                        {
                            let open = "@@foreach(halestar\\DiCmsBlogger\\Models\\Tag::all() as $tag)" + "\n";
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

        /**
         *  Highlighted Posts
         */
        Components.addType('blade-variable-highlighted-title',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                content: '{{ __('dicms-blog::blogger.highlighted.title') }}',
                                name: '{{ __('dicms-blog::blogger.highlighted.title') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$highlighted->title}}";
                        },
                    },

            });

        Components.addType('blade-variable-highlighted-subtitle',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.highlighted.subtitle') }}',
                                content: '{{ __('dicms-blog::blogger.highlighted.subtitle') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$highlighted->subtitle}}";
                        },
                    },

            });

        Components.addType('blade-variable-highlighted-byline',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                content: '{{ __('dicms-blog::blogger.highlighted.byline') }}',
                                name: '{{ __('dicms-blog::blogger.highlighted.byline') }}',
                                removable: true,
                            },
                        toHTML: function()
                        {
                            return "@{{$highlighted->byline}}";
                        },
                    },

            });

        Components.addType('blade-variable-highlighted-posted-by',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.highlighted.by') }}',
                                content: '{{ __('dicms-blog::blogger.highlighted.by') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$highlighted->posted_by!!}";
                        },
                    },

            });

        Components.addType('blade-variable-highlighted-published',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.highlighted.publish.date') }}',
                                content: '{{ __('dicms-blog::blogger.highlighted.publish.date') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$highlighted->published->format(config('dicms.datetime_format'))}}";
                        },
                    },

            });

        Components.addType('blade-variable-highlighted-text',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.highlighted.content') }}',
                                content: '{{ __('dicms-blog::blogger.highlighted.content') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$highlighted->body!!}";
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

        Components.addType('highlighted-img',
            {
                isComponent(el)
                {
                    return el.tagName === "IMG";
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'img',
                                stylable: true,
                                name: '{{ __('dicms-blog::blogger.highlighted.image') }}',
                                attributes:
                                    {
                                        src: '@{{$highlighted->image}}',
                                    },
                                traits:
                                    [
                                        'title',
                                        'alt',
                                    ],
                            }
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

        Components.addType('blade-variable-highlighted-lead',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.highlighted.lead') }}',
                                content: '{{ __('dicms-blog::blogger.highlighted.lead.desc') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$highlighted->lead!!}";
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

        Components.addType('highlighted-link',
            {
                extend: 'blade-variable',
                isComponent(el)
                {
                    return el.tagName === "A" && el.attributes.type === 'ALINK'
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'a',
                                droppable: true,
                                name: '{{ __('dicms-blog::blogger.highlighted.link') }}',
                                attributes:
                                    {
                                        href: '@{{$highlighted->url}}',
                                        type: 'ALINK',
                                    },
                                traits:
                                    [
                                        'title'
                                    ],
                            }
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

        Components.addType('highlighted-posts',
            {
                isComponent(el)
                {
                    return el.data === "@@foreach(halestar\DiCmsBlogger\Models\BlogPost::highlighted() as $highlighted)\n" ||
                        el.data === ("\n" + "@@endforeach")
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'atags',
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
                                            type: 'highlighted-link',
                                            components:
                                                [
                                                    { type: 'blade-variable-highlighted-title' },
                                                ]
                                        },
                                    ]
                            },
                        toHTML: function()
                        {
                            let open = "@@foreach(halestar\\DiCmsBlogger\\Models\\BlogPost::highlighted() as $highlighted)" + "\n";
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


        /********************************************************
         * Blocks
         */

        /**
         *  Search
         */

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

        /**
         *  Tags
         */

        Blocks.add('TagName',
            {
                select: true,
                category: "{{ trans_choice('dicms-blog::blogger.tag', 2) }}",
                label: "{{ trans_choice('dicms-blog::blogger.tag', 1) }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 80L0 229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7L48 32C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>`,
                content:
                    {
                        type: "blade-variable-tag-name",
                    },
            });

        Blocks.add('TagLink',
            {
                select: true,
                category: "{{ trans_choice('dicms-blog::blogger.tag', 2) }}",
                label: "{{ __('dicms-blog::blogger.tag.link') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>`,
                content:
                    {
                        type: "tag-link",
                    },
            });

        Blocks.add('AllTags',
            {
                select: true,
                category: "{{ trans_choice('dicms-blog::blogger.tag', 2) }}",
                label: "{{ __('dicms-blog::blogger.tag.all') }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5L0 80C0 53.5 21.5 32 48 32l149.5 0c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>`,
                content:
                    {
                        type: "all-tags",
                    },
            });

        /**
         * Highlighted Posts
         */
        Blocks.add('HighlightedPostTitle', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.title') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-title",
                },
        });

        Blocks.add('HighlightedPostSubtitle', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.subtitle') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-subtitle",
                },
        });

        Blocks.add('HighlightedPostByLine', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.byline') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-byline",
                },
        });

        Blocks.add('HighlightedPostPostedBy', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.by') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-posted-by",
                },
        });

        Blocks.add('HighlightedPostPublished', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.publish.date') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-published",
                },
        });

        Blocks.add('HighlightedPostText', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.content') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-text",
                },
        });

        Blocks.add('HighlightedPostLead', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.lead') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-highlighted-lead",
                },
        });

        Blocks.add('HighlightedLink', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.link') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>`,
            content:
                {
                    type: "highlighted-link",
                },
        });


        Blocks.add('HighlightedPostImg', {
            select: true,
            category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
            label: "{{ __('dicms-blog::blogger.highlighted.image') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6l96 0 32 0 208 0c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg>`,
            content:
                {
                    type: "highlighted-img",
                },
        });

        Blocks.add('HighlightedSummary',
            {
                select: true,
                category: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
                label: "{{ trans_choice('dicms-blog::blogger.highlighted', 2) }}",
                media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M168 80c-13.3 0-24 10.7-24 24l0 304c0 8.4-1.4 16.5-4.1 24L440 432c13.3 0 24-10.7 24-24l0-304c0-13.3-10.7-24-24-24L168 80zM72 480c-39.8 0-72-32.2-72-72L0 112C0 98.7 10.7 88 24 88s24 10.7 24 24l0 296c0 13.3 10.7 24 24 24s24-10.7 24-24l0-304c0-39.8 32.2-72 72-72l272 0c39.8 0 72 32.2 72 72l0 304c0 39.8-32.2 72-72 72L72 480zM176 136c0-13.3 10.7-24 24-24l96 0c13.3 0 24 10.7 24 24l0 80c0 13.3-10.7 24-24 24l-96 0c-13.3 0-24-10.7-24-24l0-80zm200-24l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l32 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-32 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80l208 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-208 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"/></svg>`,
                content:
                    {
                        type: "highlighted-posts",
                    },
            });
    };
</script>
