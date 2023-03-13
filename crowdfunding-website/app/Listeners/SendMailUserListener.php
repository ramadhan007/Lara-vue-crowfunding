<?php

namespace App\Listeners;

use App\Events\UserRegiteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\UserRegisteredMail;
class SendMailUserListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegiteredEvent  $event
     * @return void
     */
    public function handle(UserRegiteredEvent $event)
    {
      Mail::to($event->user)->send(new UserRegisteredMail($event->user));
    }
}
