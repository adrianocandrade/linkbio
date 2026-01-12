<?php

namespace App\Listeners\PlanEmails;

use App\Events\PlanEmails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Email;

class AdminNotification
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
     * @param  PlanEmails  $event
     * @return void
     */
    public function handle(PlanEmails $event){
        // Get user from event
        $user = $event->user;
        $plan_id = $event->plan_id;

        if (!settings("notification.plan")) {
            return false;
        }

        // Emails
        $emails = settings('notification.emails');
        $emails = explode(',', $emails);
        $emails = str_replace(' ', '', $emails);

        // Email class
        $email = new Email;
        // Get email template
        $template = $email->template('admin/plan_activation', ['user' => $user, 'plan' => $plan_id]);
        // Email array
        $mail = [
            'to' => $emails,
            'subject' => __('New Plan Purchase!', ['website' => config('app.name')]),
            'body' => $template
        ];

        // Send Email
        $email->send($mail);
    }
}
