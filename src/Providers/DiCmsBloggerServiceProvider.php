<?php

namespace halestar\DiCmsBlogger\Providers;

use halestar\DiCmsBlogger\Models\CustomFiles;
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
        Livewire::propertySynthesizer(CustomFiles::class);
    }
}
