<?php

namespace halestar\DiCmsBlogger\Providers;

use Illuminate\Support\ServiceProvider;

class DiCmsBloggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blogger.php', 'dicms');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);


        $this->loadViewsFrom(__DIR__.'/../views', 'dicms-blog');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'dicms-blog');
    }
}
