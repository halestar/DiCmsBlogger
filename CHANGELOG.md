# Changelog

All notable changes to `DiCmsBlogger` will be documented in this file

## 0.7.5.4

* Removes some log items that were bugging me.
* Updates the changelog.

## 0.7.5.3

Persists the search term in the search page.

## 0.7.5.2

removes widgets. Seriously thinking about removing widgets alltogether.
Changes Highlightable Posts, related posts and tags, and moved them completely to their own GrapesJs plugin. This allows
for complete customization of all the moving pieces and allowing all the customization to happen through grapes js.
Cleaned up the editor CSS, it no looks better an the full screen plugin works much better too.
Moves highlightable posts to it's own section itn eh blogs.

## 0.7.5.1

Updates the license in composer.
Fixes a bug in preview.

## 0.7.5

This updates deals with the major 0.7.5 update in DiCMS. The numbering is synched to it to make the versions work nice
with the new design update.

Read the DiCMS 0.7.5 notes for more info.

## 0.7.3

Bug fix in blog post update.

## 0.7.2

Updated composer to the right nomeclature.

## 0.7.1

Updates the license to the MIT License

## 0.7.0

Full release with all new goodies!

* New Blog Search Page.
    * You can now create a search page to search all blogs.
    * Search will search by keyword and tag
    * You can also add the search bar in any pages.
    * Laravel scout is now used for searching.
* Blogs Posts can now be tagged
    * In advanced settings for a blog post you can add tags to your post
    * There are new widgets for tags that will either display all tags or that post's tags.
    * Tags tie in to the search system.
* Blog posts can now be added as "related to" other blog posts.
    * A new widget will appear to shot in the post's page.

## 0.6.4

Adds some more options for images in the text editor.

## 0.6.3

Changes the way metadata is handled on blogs, so it will inherit all metadata 
from blogs and overwrite what needs to be overwritten.


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
