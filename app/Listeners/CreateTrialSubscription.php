<?php

namespace App\Listeners;

use App\Events\SiteCreatedOnSignup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SubscriptionService;

class CreateTrialSubscription
{
    protected $subscription;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubscriptionService $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SiteCreatedOnSignup  $event
     * @return void
     */
    public function handle(SiteCreatedOnSignup $event)
    {
        if ( !isset($event->params) || empty($event->params['trialplanid']) ) {
            // bail out if no trial plan was selected
            return;
        }

        //$subscription = new SubscriptionService();
        $this->subscription->createTrialSubscriptionForSite($event->site, $event->params['trialplanid']);
        return true;
    }
}
