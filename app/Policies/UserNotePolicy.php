<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserNote;
use Illuminate\Auth\Access\Response;

class UserNotePolicy
{
    public function before(): bool
    {
        return false;//todo admin
    }

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
    public function view(User $user, UserNote $userNote): bool
    {
        return $userNote->user_id === $user->id;
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
    public function update(User $user, UserNote $userNote): bool
    {
        return $userNote->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserNote $userNote): bool
    {
        return $userNote->user_id === $user->id;
    }
}
