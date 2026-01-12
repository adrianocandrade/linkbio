<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\NewUser::class => [
            \App\Listeners\SendWelcomeMail::class,
            \App\Listeners\Admin\NewUser::class,
            \App\Listeners\User\NewUserWallet::class
        ],

        \App\Events\PlanEmails::class => [
            \App\Listeners\PlanEmails\AdminNotification::class,
            \App\Listeners\PlanEmails\UserEmail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
