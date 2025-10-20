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







}
