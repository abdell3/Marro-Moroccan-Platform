<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->auteur_id || $user->isAdmin() || $user->isModerator();;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->auteur_id || $user->isAdmin() || $user->isModerator();
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function reply(User $user, Comment $comment): bool
    {
        return true; 
    }
}
