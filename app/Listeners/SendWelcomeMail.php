<?php

namespace App\Listeners;

use App\Events\NewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Email;

class SendWelcomeMail
{
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
     * @param  WelcomeMail  $event
     * @return void
     */
    public function handle(NewUser $event){
        // Get user from event
        $user = $event->user;

        dispatch(function () use($user) {
            // Email class
            $email = new Email;
            // Get email template
            $template = $email->template('account/welcome_email', ['user' => $user]);
            // Email array
            $mail = [
                'to' => $user->email,
                'subject' => __('Welcome on board, :user_name', ['user_name' => $user->name, 'website' => config('app.name')]),
                'body' => $template
            ];
            // Send Email
            $email->send($mail);
        });

        // Log activity
        logActivity($user->email, 'email', __('Welcome email sent successfully to :email', ['email' => $user->email]));
    }
}
