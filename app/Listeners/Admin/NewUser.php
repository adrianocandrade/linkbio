<?php

namespace App\Listeners\Admin;

use App\Events\NewUser as NewUserEvt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Email;

class NewUser{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUserEvt $event){
        // Get user from event
        $user = $event->user;

        if (!settings("notification.user")) {
            return false;
        }

        dispatch(function () use($user) {
            // Emails
            $emails = settings('notification.emails');
            $emails = explode(',', $emails);
            $emails = str_replace(' ', '', $emails);

            // Email class
            $email = new Email;
            // Get email template
            $template = $email->template('admin/new_user', ['user' => $user]);
            // Email array
            $mail = [
                'to' => $emails,
                'subject' => __('New user registration!', ['website' => config('app.name')]),
                'body' => $template
            ];
            // Send Email
            $email->send($mail);
        });
    }
}
