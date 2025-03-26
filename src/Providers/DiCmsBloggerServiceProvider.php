<?php

namespace halestar\DiCmsBlogger\Providers;

use halestar\DiCmsBlogger\Livewire\BlogSearch;
use halestar\DiCmsBlogger\Livewire\HighlightedPostsConfig;
use halestar\DiCmsBlogger\Livewire\RelatedPostEditor;
use halestar\DiCmsBlogger\Livewire\TagEditor;
use halestar\DiCmsBlogger\Livewire\TextEditor;
use halestar\DiCmsBlogger\View\Components\HighlightedPosts;
use halestar\DiCmsBlogger\View\Components\PostShareBar;
use halestar\DiCmsBlogger\View\Components\RelatedLinks;
use halestar\DiCmsBlogger\View\Components\TagView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DiCmsBloggerServiceProvider extends ServiceProvider
{

    protected $defer = false;
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blogger.php', 'dicms-blogger');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'dicms-blogger');

        $this->publishes(
            [
                __DIR__.'/../Policies' => app_path('Policies/DiCms')
            ], 'dicms-blogger-policies'
        );

        $this->loadViewsFrom(__DIR__.'/../views', 'dicms-blog');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'dicms-blog');
        Livewire::component('dicms-blogger.text-editor', TextEditor::class);
        Livewire::component('dicms-blogger.highlighted-posts-config', HighlightedPostsConfig::class);
        Livewire::component('dicms-blogger.related-post-editor', RelatedPostEditor::class);
        Livewire::component('dicms-blogger.tag-editor', TagEditor::class);

        Blade::component('dicms-blogger.post-share-bar', PostShareBar::class);
    }
}
