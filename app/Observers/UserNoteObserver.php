<?php

namespace App\Observers;

use App\Events\UserNoteCreated;
use App\Models\UserNote;

class UserNoteObserver
{
    /**
     * Handle the UserNote "created" event.
     */
    public function created(UserNote $userNote): void
    {
        event(new UserNoteCreated($userNote));
    }
}
