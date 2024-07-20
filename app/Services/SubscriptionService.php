<?php

namespace App\Services;

use App\Models\User;
use App\Models\Sites;
use App\Models\Product;

class SubscriptionService
{
    //protected $planid;
    
    public function __construct()
    {
        //
    }

    public function createTrialSubscriptionForUser(User $user, string $planid)
    {
        // Create a trial subscription for the user
    }

    public function createTrialSubscriptionForSite(Sites $site, string $planid)
    {
        $product = Product::where('pcode', $planid)->first();
        // Create a trial subscription for the site
        $order = $site->orders()->create([
            'customer_id' => $site->userid,
            'amount' => $product->price,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'paid' => 1,
            'auto_pay' => 1,
            'sent' => 1,
            'status' => 1,
            'display' => 1,
            'processor' => 'stripe',
            'trial_days' => $product->trial_days,
        ]);

        $order->orderDetails()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'description' => $product->description,
            'setup_price' => $product->setup_price,
            'unit_price' => $product->price,
            'next_price' => $product->next_price,
            'quantity' => 1,
            'tax_applied' => 0,
            'recurring' => $product->recursion,
            'status' => 1,
            'display' => 1,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'next_billing' => now()->addDays($product->trial_days),
            'notes' => 'Trial subscription purchased.',
        ]);

        return $order;
    }
}