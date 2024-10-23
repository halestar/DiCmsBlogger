<?php

namespace halestar\DiCmsBlogger\Policies;


use halestar\DiCmsBlogger\Models\Blog;

class BlogPolicy
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
    public function view($user = null, Blog $blog = null): bool
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
    public function update($user = null, Blog $blog = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function delete($user = null, Blog $blog = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can see and edit settings
     */
    public function settings($user = null, ): bool
    {
        return true;
    }
}
