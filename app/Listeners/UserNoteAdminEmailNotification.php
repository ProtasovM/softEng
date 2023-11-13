<?php

namespace App\Listeners;

use App\Events\UserNoteCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class UserNoteAdminEmailNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(UserNoteCreated $event): void
    {
        //Mail::send('view', $data);
    }
}
