<?php

namespace halestar\DiCmsBlogger\Policies;

use App\Models\User;
use halestar\DiCmsBlogger\Model\BlogPost;

class BlogPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can archive or unarchive the model.
     */
    public function publish(User $user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function delete(User $user = null, BlogPost $blogPost = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can see and edit settings
     */
    public function settings(User $user = null): bool
    {
        return true;
    }
}
