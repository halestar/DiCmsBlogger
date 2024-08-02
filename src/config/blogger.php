<?php
return
    [
        'policies' =>
            [
                \halestar\DiCmsBlogger\Model\BlogPost::class => \halestar\DiCmsBlogger\Policies\BlogPostPolicy::class,
            ],

        'plugins' =>
            [
                \halestar\DiCmsBlogger\DiCmsBlogger::class,
            ]
    ];
