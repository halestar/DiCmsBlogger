# Changelog

All notable changes to `DiCmsBlogger` will be documented in this file

## 0.6.2

Fixes the reddit icon to conform to the other icons.

## 0.6.1

Fixes the share bar component.

## 0.6.0

Blogger's first milestone! This is a major update that add a lot of functionality, 
which necessitated a new revision bump. It will also need to be used with the new
`DiCMS` version 0.6.1, which adds support for metadata.

* Adds official blog images to the blogs.
  * Users can provide a url to an image (usually uploaded through the image manager)
to serve as the blog's main image
  * This image can be used in any of the blog pages as a widget through GrapesJs
* Adds official images to blog posts
  * Same as blog images but for each individual post.
  * Appears in any page where the $post variable is accessible.
* Adds a description to the post
  * This is mainly for metadata
  * Replaces the old lead
* Adds metadata options!
  * Uses DiCMS metadata system to customize it for each blog and post.
  * Each post can now be tagged with metadata
  * Each blog can now be tagged with metadata
  * Post takes priority, defaults to blog, then to page.
* Adds share bar to the posts!
  * This is a "bar" with a bunch of social media places to share your post to
  * Contents of the bar (which social media are available) are configured at the blog level
  * Current support for Facebook, Reddit, LinkedIn and BlueSky.
  * I don't support twitter/X so you're on your own if you like that cesspool
* Adds widgets!
  * Widget support is now enabled
  * First widget, highlighted posts, is available
  * Highlighted Posts lets the user select posts to highlight and display them in any page.
* Adds extra options to the post page
  * Adds a "full title"
  * Adds the image
  * Updates the lead



## 0.5.5

Not a major update, but an important one:

* Moves the text editor from DiCMS to here, as it is only used in one page
  * Editor is now in a Livewire widget
  * Editor now autosaves every minute
  * New plugin was created for fullscreen.

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
