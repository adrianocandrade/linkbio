<?php

namespace App;
use Illuminate\Support\Facades\Mail;

class Email{
    public $dir;
    public function __construct(){
        $this->dir = resource_path('email');
    }

    public function app($content){
        $path = "$this->dir/app.php";

        if (!file_exists($path)) {
            return false;
        }

        $replacers = [
            '[LOGO]' => logo('light'),
            '[CONTENT]' => $content,
            '[WEBSITE_NAME]' => config('app.name')
        ];

        ob_start();
        include($path);
        $layout = ob_get_clean();

        
        $layout = str_replace(array_keys($replacers), array_values($replacers), $layout);

        
        return $layout;
    }

    public static function send($mail = []){
        try {
            $send = Mail::send([], [], function ($message) use ($mail) {
                !empty(ao($mail, 'from')) ? $message->from(ao($mail, 'from')) : '';
                
                $message->to(ao($mail, 'to'));
                $message->subject(ao($mail, 'subject'));
                $message->setBody(ao($mail, 'body'), 'text/html');
            });

            return $send;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function template($template, $variables = []){
        if (file_exists($path = "$this->dir/template/$template.php")) {
            foreach ($variables as $key => $value) {
                ${$key} = $value;
            }

            ob_start();
                include($path);
            $template = ob_get_clean();

            return $this->app($template);
        }


        return $this->app('');
    }

    public static function notify_admin($subject, $template, $extra = []){
        // Emails
        $emails = settings('notification.emails');
        $emails = explode(',', $emails);
        $emails = str_replace(' ', '', $emails);

        // Email class
        $email = new \App\Email;
        // Get email template
        $template = $email->template($template, $extra);
        // Email array
        $mail = [
            'to' => $emails,
            'subject' => $subject,
            'body' => $template
        ];

        // Send Email
        return $email->send($mail);
    }
}
