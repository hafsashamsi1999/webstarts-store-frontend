<?php

namespace App\Services;

use Stripe\StripeClient;
use App\Models\UserStripe;
use Illuminate\Support\Facades\Log;
 
class StripeService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function storeCardByToken(array $params): object
    {
        $user = $params['user'];
        $token = $params['stripecardtoken'];

        $live = env('USERSTRIPE_LIVE', true); // Live or Test Mode card

        $userstripe = UserStripe::where('userid', $user->id)->where('live', $live)->first();
        
        // Create a new customer if one doesn't exist
        if( !empty($userstripe) ) {
            $stripe_customer = $this->stripe->customers->retrieve($userstripe->stripe_id, []);
			$source = ['source' => $token];

            // Create a new card for the customer
            try {
                $card = $this->stripe->customers->createSource($userstripe->stripe_id, $source);
            } catch(\Stripe\Exception\ApiErrorException $e) {
                Log::error('Stripe existing UserStripe customer::createSource failed: ' . $e->getMessage());
            }

            UserStripe::create([
                'userid' => $user->id,
                'stripe_id' => $stripe_customer->id,
                'last_four' => $card->last4,
                'live' => $live,
            ]);

        } else {

            $stripe_customer = $this->stripe->customers->create([
                'email' => $user->getEmail(),
                "source" => $token,
            ]);
            
            $tokobj = $this->stripe->tokens->retrieve($token, []);
            //Log::info('this->stripe->tokens->retrieve: ' . json_encode($tokobj));
            
            // Create a new card for the customer
            //$source = ['source' => 'tok_visa']; // Taken from https://docs.stripe.com/api/cards/create
            /* $source = ['source' => $token];
            try {
                $card = $this->stripe->customers->createSource($userstripe->stripe_id, $source);
            } catch(\Stripe\Exception\ApiErrorException $e) {
                Log::error('Stripe customer::createSource failed: ' . $e->getMessage());
            } */
            

            $userstripe = UserStripe::create([
                'userid' => $user->id,
                'stripe_id' => $stripe_customer->id,
                'last_four' => $tokobj->card->last4,
                'live' => $live,
            ]);
        } 

        //return $card;
        return $userstripe;
    }
 
}