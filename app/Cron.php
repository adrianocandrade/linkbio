<?php

namespace App;

use Illuminate\Support\ServiceProvider;
use App\Email;

class Cron{
    public static function cron(){
        // Get ALl User Plans
        $plan_user_model = new \App\Models\PlansUser;

        // Loop All

        foreach ($plan_user_model->get() as $item) {
            // Get Plan
            $plan = GetPlan('', $item->plan_id);
            // Get Due date here!
            $due_date = $item->plan_due;
            $now = \Carbon\Carbon::now(settings('others.timezone'));
            $week = \Carbon\Carbon::now(settings('others.timezone'))->addWeek();
            $settings = $item->settings;

            // Plan User to update setting
            $plan_user = \App\Models\PlansUser::find($item->id);

            // Check if is not a free plan
            if (ao($plan, 'price_type') !== 'free') {
                // Do The action here!
                $due_date = \Carbon\Carbon::parse($due_date);
                // Check if is past 7 days
                if ($due_date < $week) {
                    // Check if it has send an expiry before
                   if (!ao($settings, 'sent_a_week')) {
                        // Email class
                        $email = new Email;
                        // Get email template
                        $template = $email->template('account/plan_expiry', ['user' => \App\User::find($item->user_id), 'plan' => $item->plan_id]);
                        // Email array
                        $mail = [
                            'to' => user('email', $item->user_id),
                            'subject' => __('Leaving already?', ['website' => config('app.name')]),
                            'body' => $template
                        ];
                        // Send Email
                        $email->send($mail);


                        $settings['sent_a_week'] = true;
                        $plan_user->settings = $settings;
                        $plan_user->save();
                   }
                }

                // Expired
                if (\Carbon\Carbon::parse($now)->isAfter($due_date)) {
                    // Send expired Email
                   if (!ao($settings, 'sent_expired')) {
                        // Email class
                        $email = new Email;
                        // Get email template
                        $template = $email->template('account/plan_expired', ['user' => \App\User::find($item->user_id), 'plan' => $item->plan_id]);
                        // Email array
                        $mail = [
                            'to' => user('email', $item->user_id),
                            'subject' => __('Sad to see you leave!', ['website' => config('app.name')]),
                            'body' => $template
                        ];
                        // Send Email
                        $email->send($mail);


                        $settings['sent_expired'] = true;
                        $plan_user->settings = $settings;
                        $plan_user->save();

                        $plan_user->delete();
                    }
                }
            }
            // Return false here
        }
    }
}
