<?php

namespace App\Listeners\PlanEmails;

use App\Events\PlanEmails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Email;

class UserEmail{
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
     * @param  PlanEmails  $event
     * @return void
     */
    public function handle(PlanEmails $event){
        // Get user from event
        $user = $event->user;
        $plan_id = $event->plan_id;

        // Email class
        $email = new Email;
        // Get email template
        $template = $email->template('account/plan_activation', ['user' => $user, 'plan' => $plan_id]);
        // Email array
        $mail = [
            'to' => $user->email,
            'subject' => __(':user_name, You Rock!', ['user_name' => $user->name]),
            'body' => $template
        ];
        
        // Send Email
        $email->send($mail);
    }
}
