# DiCMS Blogger

## A plugin for the [Laravel Drop-In Content Management System](https://github.com/halestar/LaravelDropInCms)

This is the first plugin for DiCMS (Laravel's Drop-In Content Management System) which serves to show how plugins are created and to provide a versy simple blogger add on that will let users create and update blog posts.  This is not meant to be a full-featured blogging system, but rather a simple project to show how plugings are handled in DiCMS.

# Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Building a Plugin](#building)
- [Roadmap to 1.0](#roadmap)

<a id="installation"></a>
## Installation

Installation assumes that you: 
 - Have an existing Laravel project that you're using,
 - Have DiCMS installed in your project.

Once those requirements are met, you may install the plugin by executing:

    composer require halestar/dicms-blogger

We next publish the vendor files by doing:

    php artisan vendor:publish --provider=halestar\DiCmsBlogger\Providers\DiCmsBloggerServiceProvider

Which will publish the migration files and the config files. Before you run the migration, open the config file and look at the initial config. The only thing you may want to change at this time is the `table_prefix` option, if you would like to customize the table names for the CMS tables. Once you're happy, run:

    php artisan migrate

Finally, head over to your `config/dicms.php` file and add the following policy to your list of policies:

    'policies' =>
    [
        ...
        \halestar\DiCmsBlogger\Model\BlogPost::class => \halestar\DiCmsBlogger\Policies\BlogPostPolicy::class,
    ],

And enable the plugin by adding the entry to the plugins section:

    'plugins' =>
    [
        \halestar\DiCmsBlogger\DiCmsBlogger::class,
    ]

That's it! Once that is done, the "Blog" menu item will appear in your DiCMS admin console.

<a id="configuration"></a>
## Configuration

<a id="building"></a>
## Building a Plugin

<a id="roadmap"></a>
## Roadmap to 1.0

