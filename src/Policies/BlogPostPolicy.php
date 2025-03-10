<?php

namespace halestar\DiCmsBlogger\Policies;
use halestar\DiCmsBlogger\Models\BlogPost;

class BlogPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can archive or unarchive the model.
     */
    public function publish($user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function delete($user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

}
