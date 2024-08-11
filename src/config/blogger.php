<?php
return
    [
        'policies' =>
            [
                \halestar\DiCmsBlogger\Models\BlogPost::class => \halestar\DiCmsBlogger\Policies\BlogPostPolicy::class,
            ],

        'plugins' =>
            [
                \halestar\DiCmsBlogger\DiCmsBlogger::class,
            ]
    ];
