<?php

namespace App\Listeners;

use App\Events\SendMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SendMail $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $user = User::find($event->userId)->toArray();
        $request = $event->request;

        Mail::send('emails.mailEvent', ['user' => $user, 'request' => $request], function ($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Revision Terminada');
        });
    }
}
