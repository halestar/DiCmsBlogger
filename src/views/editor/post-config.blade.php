<script>
    const {{ $plugin->getPluginName() }} = editor => {
        const { Components, Blocks } = editor;


        /**
         *  Defaults here.
        */

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

        //containers
        Components.addType('blade-variable-post-title',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                content: '{{ __('dicms-blog::blogger.post.title') }}',
                                name: '{{ __('dicms-blog::blogger.post.title') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$post->title}}";
                        },
                    },

            });

        Components.addType('blade-variable-post-subtitle',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.post.subtitle') }}',
                                content: '{{ __('dicms-blog::blogger.post.subtitle') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$post->subtitle}}";
                        },
                    },

            });

        Components.addType('blade-variable-post-byline',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                content: '{{ __('dicms-blog::blogger.post.byline') }}',
                                name: '{{ __('dicms-blog::blogger.post.byline') }}',
                                removable: true,
                            },
                        toHTML: function()
                        {
                            return "@{{$post->byline}}";
                        },
                    },

            });

        Components.addType('blade-variable-post-posted-by',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.post.by') }}',
                                content: '{{ __('dicms-blog::blogger.post.by') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$post->posted_by!!}";
                        },
                    },

            });

        Components.addType('blade-variable-post-published',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.publish.date') }}',
                                content: '{{ __('dicms-blog::blogger.publish.date') }}',
                            },
                        toHTML: function()
                        {
                            return "@{{$post->published->format(config('dicms.datetime_format'))}}";
                        },
                    },

            });

        Components.addType('blade-variable-post-text',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.post.content') }}',
                                content: '{{ __('dicms-blog::blogger.post.content') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$post->body!!}";
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

        Components.addType('blade-variable-post-lead',
            {
                extend: 'blade-variable',
                model:
                    {
                        defaults:
                            {
                                name: '{{ __('dicms-blog::blogger.post.lead') }}',
                                content: '{{ __('dicms-blog::blogger.post.lead.desc') }}',
                            },
                        toHTML: function()
                        {
                            return "@{!!$post->lead!!}";
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

        Components.addType('article-link',
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
                                name: '{{ __('dicms-blog::blogger.post.link') }}',
                                attributes:
                                    {
                                        href: '@{{$post->url}}',
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

        Components.addType('next-link',
            {
                extend: 'blade-variable',
                isComponent(el)
                {
                    return el.tagName === "A" && el.attributes.type === 'NLINK'
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'a',
                                droppable: true,
                                name: 'Next Post Link',
                                attributes:
                                    {
                                        href: '@{{$post->next_link}}',
                                        type: 'NLINK',
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

        Components.addType('prev-link',
            {
                extend: 'blade-variable',
                isComponent(el)
                {
                    return el.tagName === "A" && el.attributes.type === 'PLINK'
                },
                model:
                    {
                        defaults:
                            {
                                tagName: 'a',
                                droppable: true,
                                name: 'Prev Post Link',
                                attributes:
                                    {
                                        href: '@{{$post->prev_link}}',
                                        type: 'PLINK',
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

        Blocks.add('PostTitle', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.title') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-title",
                },
        });

        Blocks.add('PostSubtitle', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.subtitle') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-subtitle",
                },
        });

        Blocks.add('PostByLine', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.byline') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-byline",
                },
        });

        Blocks.add('PostPostedBy', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.by') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-posted-by",
                },
        });

        Blocks.add('PostPublished', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.publish.date') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-published",
                },
        });

        Blocks.add('PostText', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.content') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-text",
                },
        });

        Blocks.add('PostLead', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.lead') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 112 224 0 0-112-16 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l48 0 48 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-16 0 0 144 0 176 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-144-224 0 0 144 16 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-48 0-48 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l16 0 0-176L48 96 32 96C14.3 96 0 81.7 0 64z"/></svg>`,
            content:
                {
                    type: "blade-variable-post-lead",
                },
        });

        Blocks.add('ArticleLink', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "{{ __('dicms-blog::blogger.post.link') }}",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>`,
            content:
                {
                    type: "blade-variable-article-link",
                },
        });

        Blocks.add('PrevLink', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "Previous Post",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM271 135c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-87 87 87 87c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L167 273c-9.4-9.4-9.4-24.6 0-33.9L271 135z"/></svg>`,
            content:
                {
                    type: "prev-link",
                },
        });

        Blocks.add('NextLink', {
            select: true,
            category: "{{ __('dicms-blog::blogger.blog') }}",
            label: "Next Post",
            media: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM241 377c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l87-87-87-87c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L345 239c9.4 9.4 9.4 24.6 0 33.9L241 377z"/></svg>`,
            content:
                {
                    type: "next-link",
                },
        });
    };
</script>
