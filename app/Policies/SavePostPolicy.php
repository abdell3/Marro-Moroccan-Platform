<?php

namespace App\Policies;

use App\Models\SavePost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SavePostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SavePost $savePost): bool
    {
        return $user->id === $savePost->user_id || $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SavePost $savePost): bool
    {
        return $user->id === $savePost->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SavePost $savePost): bool
    {
        return $user->id === $savePost->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SavePost $savePost): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SavePost $savePost): bool
    {
        return $user->isAdmin();
    }
}
