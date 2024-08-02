# DiCMS Blogger

## A plugin for the [Laravel Drop-In Content Management System](https://github.com/halestar/LaravelDropInCms)

This is the first plugin for DiCMS (Laravel's Drop-In Content Management System) which serves to show how plugins are created and to provide a versy simple blogger add on that will let users create and update blog posts.  This is not meant to be a full-featured blogging system, but rather a simple project to show how plugings are handled in DiCMS.

# Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Building a Plugin](#building)
  - [The Plugin Interfaces](#building-interfaces)
  - [The Service Container](#building-service)
  - [Models and Migrations](#building-models)
  - [Your Admin Area](#building-admin)
  - [Backing Things Up](#building-backup)
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
        \halestar\DiCmsBlogger\Models\BlogPost::class => \halestar\DiCmsBlogger\Policies\BlogPostPolicy::class,
    ],

And enable the plugin by adding the entry to the plugins section:

    'plugins' =>
    [
        \halestar\DiCmsBlogger\DiCmsBlogger::class,
    ]

That's it! Once that is done, the "Blog" menu item will appear in your DiCMS admin console.

<a id="configuration"></a>
## Configuration

Configuration of Blogger is all done through the Settings options found in the menu item "Blog". You'll note that all these settings are simply html that is attached directly to the element in the display template. The idea is to make it as simple as possible.

There is also a single Policy item, `\halestar\DiCmsBlogger\Policies\BlogPostPolicy::class` that defines all the permissions needed for the entire plugin. You can extend this for better permissions.

<a id="building"></a>
## Building a Plugin

This section will explain how I built this plugin to hopefully give you ideas on how to build your own plugin.  This 'tutorial' assumes that you are somewhat familiar with [Laravel Package Development](https://laravel.com/docs/11.x/packages). If you're not, I highly suggest reading up on [this amazing tutorial by Farhan Hasin Chowdhury](https://adevait.com/laravel/how-to-create-a-custom-package-for-laravel) which is how I learned a lot of it.

<a id="building-interfaces"></a>
### The Plugin Interfaces

Building a plugin consists of implementing two interfaces: `halestar\LaravelDropInCms\Plugins\DiCmsPlugin` and `halestar\LaravelDropInCms\Plugins\DiCmsPluginHome`. Those are the only two requirements imposed by DiCMS. You may add anything else you want including migrations, controllers, policies, views, resources, etc. DiCMS will only care about those 2 classes implementing the interfaces.

Let's take a look at these interfaces and how we can create our own plugin. For this example I will be creating this plugin, DiCmsBlogger.
The main plugin definition is made by implementing the interface `halestar\LaravelDropInCms\Plugins\DiCmsPlugin`. So let's look at this interface.

    interface DiCmsPlugin
    {
        public static function adminRoutes(): void;
        public static function hasPublicRoute($path): bool;
        public static function getPublicContent($path): string;
        public static function getPublicPages(): array;
        public static function getEntryPoint(): DiCmsPluginHome;
        public static function getBackUpableTables(): array;
    }

You should read up on this file to see the documentation on it, but we will go over some basic ones.

`public static function adminRoutes(): void;` is probably the first one you will build, as
it contains all the admin routes that you want to define in your plugin. I **highly** recommend that
you wrap all your admin routes in a prefix and a name, to differentiate from the rest of
the cms or other plugins that people may use.  You can do this by wrapping all routes like 
this:

    Route::prefix('blog')
            ->name('blog.')
            ->group(function ()
            {
                //your routes go here
            });

Next, lets look at the methods `public static function hasPublicRoute($path): bool`
 and `public static function getPublicContent($path): string` since they both do something similar
both of these methods will be called by the FrontController, which is charge of serving up 
the CMS content. This controller will first find the active site, and will then see if the path given to it
matches any of the internal pages.  If it does not then it will cycle through all the 
plugins and pass the whole path (minus the starting '/') to the method `public static function hasPublicRoute($path): bool`
 which will return true if the path matches an internal path the plugin uses or false if it does not.

In my plugin's case, I check if the user is trying to reach */blogs* or */blogs/* 
and redirect them to the list of all the blog posts. If there's more after that, I check 
if any of the slugs for the posts match whatever comes after blog. If I find one I return 
true, else false, and the next plugin is called.

If the previous method returns true, then the method `public static function getPublicContent($path): string`
is called with the same path. The string returned is pasted directly in the front template.  There is
a special template called for plugins. Currently, it fills the header and footer from the 
default of the site. But it will eventually allow for the plugin to do the same.

Next up is `public static function getPublicPages(): array`, **which is actually an 
array of `halestar\LaravelDropInCms\Plugins\DiCmsPluginPage` objects**. The 
`DiCmsPluginPage` object is a *very* simple object that takes a name and a URL. The purpose of 
this method is to provide DiCms a list of pages that are available through the plugin.

For example, I would like to list the page */blog* as the list of all the blog posts I have.
This page should be named "Blog". So I return an array containing a single `DiCmsPluginPage`
object that has "Blog" as the name and "blog" (note the lack of a leading slash!) as the url ("blog/" would also work).
Now, There will be a "Plugin Page" called "Blog" that you can set as the site's homepage
or add to the menu.

I will cover `public static function getBackUpableTables(): array;` later under Backups, which leaves 
the last method, `public static function getEntryPoint(): DiCmsPluginHome`. This method simply returns
an instance of the other class we have to create, which implements `halestar\LaravelDropInCms\Plugins\DiCmsPluginHome`.
Let's look at this interface:

    interface DiCmsPluginHome
    {
        public function getAdminUrl(): string;
        public function getPluginMenuName(): string;
        public function getPolicyModel(): string;
        public function getRoutePrefix(): string;
    }

The idea behind this class is to establish an "entry point" to your plugin. You should 
read the official code documentation for each of the methods, but they're very
simple.

Your plugin will get a single menu item at the top. The name of this menu item is
the string returned by the `public function getPluginMenuName(): string` method and
it is a link to the url string provided by the `public function getAdminUrl(): string`
method. 

The menu item knows it is active (it is in your plugin's content) when the current 
url has a base that matches the string returned by 'public function getRoutePrefix(): string'
 and the actual menu item is surrounded by a `@can('view any', $plugin::getPolicyModel())`
which means that the method `public function getPolicyModel(): string` returns the 
**model** that the permission is checked against. 

*Note that this is not the policy object, but the model attached to the policy object.*

So your plugin might have multiple Models and multiple Policies for those Models. The method
returns the model that is checked before access to your plugin is given.

<a id="building-service"></a>
### The Service Container

<a id="building-models"></a>
### Models and Migrations

<a id="building-admin"></a>
### Your Admin Area

<a id="building-backup"></a>
### Backing Things Up

<a id="roadmap"></a>
## Roadmap to 1.0

At the time of writing this, this package is not what I consider "released".
My plan is officially release as a v1.0 once all the features are built.
This space here is meant to detail what features and upgrades I consider
essential to release a v1.0

These requirements are subject (and in fact, most likely) to change and
I will cross them out (probably) as I build things.  I plan on keeping
stable releases as odd versions and using even versions as dev, unstable
releases.  For example, the first release (considered stable, I know) is
v0.1.0 and the latest is set to v0.1.3. Once all these new instructions are
written up and released, I will create a v0.3.0 release for both DiCms and
the Blogger Plugin.

The following features need to be implemented in order to release v1.0:

- The interface needs to be cleaned up
- Posts need to be archivable
- The dates should probably be when published, not created.
- Better asset management.
- Ability to add custom css/js scripts, headers and footers
- Preview system
- Finish the creating the plugin documentation

Other things may be added to this list, or taken away.
