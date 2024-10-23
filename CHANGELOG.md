# Changelog

All notable changes to `LaravelDropInCMS` will be documented in this file

## 0.5.0

Large enough update to bump it to the next revision.
The major features of this release are:

* New architecture for plugins!
  * Blogger now provides 2 pages for customizations
  * Index Page for the user to customize how the list of blog entries page looks like
  * Post page to customize the way an individual post looks like.
* Blogs are its own thing now
  * You can now create multiple Blogs with their own posts
  * You can detail how each blog looks like individually.
* New GrapesJS Plugins
* All posts variables are accessed through blocks 

## 0.4.0

A major upgrade mainly due to the new DiCMS System. New features related to this system:

* Published field is no longer a boolean, but rather datetime field.
  * It shows up as the published date for the article.
  * If the updated_at date is later, it will show the updated date.
  * Not sure if you should be allowed to up-post, but I'm going to go with yes.
* Integrated the new editor and asset manager into the system.
  * Not much to this, since it came from the other projects, but a lot of the updates
  were done because of this plugin.
* Added custom headers/footers/css/js  information for the blogging system.

## 0.3.0

The official documentation of this project with a full release of the Blogger plugin is
included in this update.

## 0.1.0

Initial release
