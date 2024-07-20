<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserRegistered;
use App\Events\SiteCreatedOnSignup;
use App\Listeners\StoreStripeCard;
use App\Listeners\CreateTrialSubscription;

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

        // Webstarts Signup
        UserRegistered::class => [
            StoreStripeCard::class,
            //SendWelcomeEmail::class,
            //SendNotification::class,
        ],

        // Whens site is created on signup
        SiteCreatedOnSignup::class => [
            CreateTrialSubscription::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
