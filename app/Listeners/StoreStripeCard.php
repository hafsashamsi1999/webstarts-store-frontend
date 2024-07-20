<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;
use App\Services\StripeService;
use Illuminate\Support\Facades\Log;

class StoreStripeCard implements ShouldQueue
{
    protected $stripeService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        Log::debug($event->params);
        if ( !isset($event->params) || empty($event->params['stripecardtoken']) ) {
            // bail out if no token
            return;
        }
        

        $card = $this->stripeService->storeCardByToken([
            'user' => $event->user,
            'stripecardtoken' => $event->params['stripecardtoken'],
        ]);

    }
}
