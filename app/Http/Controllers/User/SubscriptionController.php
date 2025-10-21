<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function SubscriptionsIndex(){

        $subscriptions = auth()->user()
            ->subscriptions()
            ->latest()
            ->paginate(10);

        return view('client.backend.subscriptions.index_page',compact('subscriptions'));

    }
    // End Method 

    public function SubscriptionsCreate(){

        $plans = [
            'pro' => [
                'name' => 'Pro Plan',
                'price' => 9.99,
                'duration' => '30 days',
                'limit' => 10
            ],
            'essential' => [
                'name' => 'Essential Plan',
                'price' => 19.99,
                'duration' => '30 days',
                'limit' => 20
            ],
        ];

        return view('client.backend.subscriptions.create_page',compact('plans'));

    }
    // End Method 







}
